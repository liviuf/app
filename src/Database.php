<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MiniBlog;

/**
 * Description of Connection
 *
 * @author liviu
 */
class Database extends AbstractBlog {

    /**
     * The database name
     * @var type 
     */
    private static $dbName;
    
    /**
     * The username
     * @var type 
     */
    private static $username;
    
    /**
     * The password
     * @var type 
     */
    private static $password; 
    
    /**
     * The hostname
     * @var type 
     */
    private static $hostname;
    
    /**
     * The connection to the db
     * @var object
     */
    public static $connection;
    
    public function __construct($host, $name, $user, $pass) {
        
        static::$hostname = $host;
        static::$dbName = $name;
        static::$username = $user;
        static::$password = $pass;

        $this->connect();
    }
    
    public static function connect() {
        
        $dsn= "mysql:host=" . static::$hostname . ";dbname=" . static::$dbName . "";
        
        
        try {
            
            static::$connection = new \PDO($dsn, static::$username, static::$password);
            
            if (static::$connection) {
//                echo "Connected to the <strong>". static::$dbName. "</strong> database successfully!";
            }
        } catch(PDOException $exc) {
            throw new $exc;
        }
        
        return static::$connection;
    }
    
    public function getConnection()
    {
        return static::$connection;
    }
    
}
