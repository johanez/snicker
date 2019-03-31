<?php   
/*
 |  Snicker     A small Comment System 4 Bludit
 |  @file       ./includes/autoload.php
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.1.0 [0.1.0] - Alpha
 |
 |  @website    https://github.com/pytesNET/snicker
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */

    spl_autoload_register(function($class){
        if(strpos($class, "Gregwar") === 0 || strpos($class, "Identicon") === 0){
            require_once $class . ".php";
        }
        return false;
    });
