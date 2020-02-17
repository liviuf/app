<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MiniBlog;


use MiniBlog\Config;
//use MiniBlog\Database;


/**
 * Description of AbstractBlog
 *
 * @author liviu
 */
abstract class AbstractBlog {
   
    public $config;
    
    public static $connection;


    public function __construct() {
        $this->config = new Config();
        
//        static::$connection = Database::connect();
    }
    public function getConfig() {
        return $this->config;
    }
    
}
