<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use MiniBlog\Articles;

$request = $_SERVER['REQUEST_URI'];
$exploded = explode('/', $request);

$id = end($exploded);

$articles = new Articles();

$articles->deleteById($id);