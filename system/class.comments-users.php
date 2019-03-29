<?php
/*
 |  Snicker     A small Comment System 4 Bludit
 |  @file       ./system/class.comments-users.php
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.1.0 [0.1.0] - Alpha
 |
 |  @website    https://github.com/pytesNET/snicker
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
    if(!defined("BLUDIT")){ die("Go directly to Jail. Do not pass Go. Do not collect 200 Cookies!"); }

    class CommentsUsers extends dbJSON{
        /*
         |  DATABASE FIELDS
         */
        protected $dbFields = array(
            "username"      => "",          // Username
            "email"         => "",          // User eMail Address
            "hash"          => "",          // Hashed IP + User Agent
            "blocked"       => false,       // Blocked?
            "comments"      => array()      // Page UIDs => array(CommentUIDs)
        );

        /*
         |  CONSTRUCTOR
         |  @since  0.1.0
         */
        public function __construct(){
            parent::__construct(DB_SNICKER_USERS);
            if(!file_exists(DB_SNICKER_USERS)){
                $this->db = array();
                $this->save();
            }
        }

        /*
         |  EXISTS
         |  @since   0.1.0
         */
        public function exists($uid){
            return isset($this->db[$uid]);
        }

        /*
         |  ADD / GET USER
         |  @since  0.1.0
         */
        public function user($username, $email){
            global $security;

            // Validate Username
            $username = Sanitize::html(strip_tags(trim($username)));
            if(empty($username) || strlen($username) > 25){
                return false;
            }

            // Validate eMail
            $email = Sanitize::email(trim($email));
            if(empty($email) || !Valid::email($email)){
                return false;
            }

            // Check User
            foreach($this->db AS $uuid => $field){
                if(strtolower($field["username"]) !== strtolower($username)){
                    continue;
                }
                if(strtolower($field["email"]) !== strtolower($email)){
                    continue;
                }
                if($field["blocked"] === true){
                    return false;
                }
                return $uuid;
            }

            // Create UUID
            $uuid = md5($email . $username . time());
            if(isset($this->db[$uuid])){
                return false;
            }

            // Add User
            $this->db[$uuid] = array(
                "username"      => $username,
                "email"         => $email,
                "hash"          => md5($security->getUserIp() . $_SERVER["HTTP_USER_AGENT"]),
                "blocked"       => false,
                "comments"      => array()
            );
            if(!$this->save()){
                return false;
            }
            return $uuid;
        }
        public function add($username, $email){
            return $this->user($username, $email);
        }
    }
