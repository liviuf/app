<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MiniBlog;

/**
 * Description of Config
 *
 * @author liviu
 */
class Config {
    
    /**
     * The config file
     * @var array 
     */
    public $config = []; 
    
    public function __construct() {
        try {
            $this->config = parse_ini_file(APPLICATION_PATH . '/config/config.ini');
        } catch(\Exception $exc) {
            throw new $exc;
        }
    }
    
}
