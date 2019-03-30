<?php
/*
 |  Snicker     A small Comment System 4 Bludit
 |  @file       ./system/class.comments-index.php
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.1.0 [0.1.0] - Alpha
 |
 |  @website    https://github.com/pytesNET/snicker
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
    if(!defined("BLUDIT")){ die("Go directly to Jail. Do not pass Go. Do not collect 200 Cookies!"); }

    class CommentsIndex extends dbJSON{
        /*
         |  DATABASE FIELDS
         */
        protected $dbFields = array(
            "title"         => "",          // Comment Title
            "excerpt"       => "",          // Comment Excerpt (142)
            "status"        => "",          // Comment Status
            "page_uuid"     => "",          // Comment Page UUID
            "parent_uid"    => "",          // Comment Parent UID
            "author"        => "",          // Comment Author (bludt::username or guest::uuid)
            "date"          => ""           // Comment Date
        );

        /*
         |  CONSTRUCTOR
         |  @since  0.1.0
         */
        public function __construct(){
            parent::__construct(DB_SNICKER_INDEX);
            if(!file_exists(DB_SNICKER_INDEX)){
                $this->db = $this->dbFields;
                $this->save();
            }
        }

        /*
         |  OVERWRITE :: EXISTS
         |  @since  0.1.0
         */
        public function exists($uid){
            return array_key_exists($uid, $this->db);
        }

        /*
         |  DATA :: GET PENDING INDEX
         |  @since  0.1.0
         |
         |  @param  bool    TRUE to just return the keys, FALSE to return the complete array.
         |
         |  @return array   All pending comments with basic comment data as ARRAY.
         */
        public function getPending($keys = false){
            $db = array();
            foreach($this->db AS $key => $value){
            if(!isset($value["status"]) || empty($value["status"])) continue;
                if($value["status"] === "pending"){
                    $db[$key] = $value;
                }
            }
            if($keys){
                return array_keys($db);
            }
            return $db;
        }

        /*
         |  DATA :: GET APPROVED INDEX
         |  @since  0.1.0
         |
         |  @param  bool    TRUE to just return the keys, FALSE to return the complete array.
         |
         |  @return array   All approved comments with basic comment data as ARRAY.
         */
        public function getApproved($keys = false){
            $db = array();
            foreach($this->db AS $key => $value){
            if(!isset($value["status"]) || empty($value["status"])) continue;
                if($value["status"] === "approved"){
                    $db[$key] = $value;
                }
            }
            if($keys){
                return array_keys($db);
            }
            return $db;
        }

        /*
         |  DATA :: GET REJECTED INDEX
         |  @since  0.1.0
         |
         |  @param  bool    TRUE to just return the keys, FALSE to return the complete array.
         |
         |  @return array   All rejected comments with basic comment data as ARRAY.
         */
        public function getRejected($keys = false){
            $db = array();
            foreach($this->db AS $key => $value){
            if(!isset($value["status"]) || empty($value["status"])) continue;
                if($value["status"] === "rejected"){
                    $db[$key] = $value;
                }
            }
            if($keys){
                return array_keys($db);
            }
            return $db;
        }

        /*
         |  DATA :: GET SPAM INDEX
         |  @since  0.1.0
         |
         |  @param  bool    TRUE to just return the keys, FALSE to return the complete array.
         |
         |  @return array   All spam comments with basic comment data as ARRAY.
         */
        public function getSpam($keys = false){
            $db = array();
            foreach($this->db AS $key => $value){
            if(!isset($value["status"]) || empty($value["status"])) continue;
                if($value["status"] === "spam"){
                    $db[$key] = $value;
                }
            }
            if($keys){
                return array_keys($db);
            }
            return $db;
        }

        /*
         |  DATA :: COUNT COMMENTS
         |  @since  0.1.0
         |
         |  @param  multi   A single comment status as STRING, multiple as ARRAY.
         |                  Use `null` to count all comments.
         |
         |  @return int     The number of comments of the respective index.
         */
        public function count($status = array("approved")){
            if($status === null){
                return count($this->db);
            }
            if(!is_array($status)){
                $status = array($status);
            }

            $count = 0;
            foreach($this->db AS $key => $value){
            if(!isset($value["status"]) || empty($value["status"])) continue;
                if(in_array($value["status"], $status)){
                    $count++;
                }
            }
            return $count;
        }

        /*
         |  DATA :: GET COMMENT
         |  @since  0.1.0
         |
         |  @param  string  The desired comment UID.
         |
         |  @return multi   The comment index array on success, FALSE on failure
         */
        public function getComment($uid){
            return array_key_exists($uid, $this->db)? $this->db[$uid]: false;
        }

        /*
         |  DATA :: LIST COMMENTS
         |  @since  0.1.0
         |
         |  @param  multi   A single comment status as STRING, multiple as ARRAY.
         |  @param  int     The current comment page number, starting with 1.
         |  @param  int     The number of comments to be shown per page.
         |
         |  @return array   The respective unique comment IDs as ARRAY, FALSE on failure.
         */
        public function getList($status = array("approved"), $page = 1, $limit = -1){
            if($status === null){
                return count($this->db);
            }
            if(!is_array($status)){
                $status = array($status);
            }

            // Get List
            $list = array();
            foreach($this->db AS $key => $value){
            if(!isset($value["status"]) || empty($value["status"])) continue;
                if(in_array($value["status"], $status)){
                    $list[] = $key;
                }
            }

            // Limit
            if($limit == -1){
                return $list;
            }

            // Offset
            $offset = $limit * (max($page, 1) - 1);
            $count  = min(($offset + $limit - 1), count($list));
            if($offset < 0 || $offset > $count){
                return false;
            }
            return array_slice($list, $offset, $limit, true);
        }


        /*
         |  HANDLE :: ADD COMMENT
         |  @since  0.1.0
         |
         |  @param  string  The unique comment ID.
         |  @param  array   The comment array.
         |
         |  @return bool    TRUE if everything is fluffy, FALSE if not.
         */
        public function add($uid, $comment){
            $row = array();
            foreach($this->dbFields AS $field => $value){
                if(isset($comment[$field])){
                    $final = is_string($comment[$field])? Sanitize::html($comment[$field]): $comment[$field];
                } else {
                    $final = $value;
                }
                settype($final, gettype($value));
                $row[$field] = $final;
            }

            // Format Excerpt
            $row["excerpt"] = strip_tags($comment["comment"]);
            if(strlen($row["excerpt"]) > 102){
                $row["excerpt"] = substr($row["excerpt"], 0, 99) . "...";
            }

            // Insert and Return
            $this->db[$uid] = $row;
            $this->sortBy();
            if($this->save() !== true){
                Log::set(__METHOD__, "error-update-db");
                return false;
            }
            return true;
        }

        /*
         |  HANDLE :: UPDATE COMMENT
         |  @since  0.1.0
         |
         |  @param  string  The unique comment ID.
         |  @param  array   The comment array.
         |
         |  @return bool    TRUE if everything is fluffy, FALSE if not.
         */
        public function edit($uid, $comment){
            if(!$this->exists($uid)){
                $this->log(__METHOD__, "error-comment-uid", array($uid));
                return false;
            }
            $data = $this->db[$uid];

            // Loop Fields
            $row = array();
            foreach($this->dbFields AS $field => $value){
                if(isset($comment[$field])){
                    $final = is_string($comment[$field])? Sanitize::html($comment[$field]): $comments[$field];
                } else {
                    $final = $data[$field];
                }
                settype($final, gettype($value));
                $row[$field] = $final;
            }

            // Format Excerpt
            $row["excerpt"] = strip_tags($comment["comment"]);
            if(strlen($row["excerpt"]) > 102){
                $row["excerpt"] = substr($row["excerpt"], 0, 99) . "...";
            }

            // Update and Return
            $this->db[$uid] = $row;
            if($this->save() !== true){
                Log::set(__METHOD__, "error-update-db");
                return false;
            }
            return true;
        }

        /*
         |  HANDLE :: DELETE COMMENT
         |  @since  0.1.0
         |
         |  @param  string  The unique comment ID.
         |
         |  @return bool    TRUE if everything is fluffy, FALSE if not.
         */
        public function delete($uid){
            if(!$this->exists($uid)){
                return false;
            }
            unset($this->db[$uid]);
            if($this->save() !== true){
                Log::set(__METHOD__, "error-update-db");
                return false;
            }
            return true;
        }

        /*
         |  INTERNAL :: SORT COMMENTS
         |  @since  0.1.0
         |
         |  @return bool    TRUE
         */
        public function sortBy(){
            global $SnickerPlugin;

            if($SnickerPlugin->getValue("frontend_order") === "date_asc"){
                uasort($this->db, function($a, $b){
                    return $a["date"] > $b["date"];
                });
            } else if($SnickerPlugin->getValue("frontend_order") === "date_desc"){
                uasort($this->db, function($a, $b){
                    return $a["date"] < $b["date"];
                });
            }
            return true;
        }
    }
