<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MiniBlog;

/**
 * Description of MiniBlog
 *
 * @author liviu
 */
class MiniBlog extends AbstractBlog {

    public function __construct($connection) {
        $this->init($connection);
    }
    
    public function init($connection) {
        
    }
}
