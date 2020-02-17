<?php
  
require "vendor/autoload.php";

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH',
              realpath(dirname(__FILE__) . '/'));



$config = new MiniBlog\Config();

$database = new MiniBlog\Database($config->config['db_hostname'], 
        $config->config['db_name'], 
        $config->config['db_user'], 
        $config->config['db_password']
        );

$miniBlog = new \MiniBlog\MiniBlog($database);

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require_once __DIR__ . '/views/index.php';
        break;
    case '' :
        require_once __DIR__ . '/views/index.php';
        break;
    case '/articles' :
        require_once __DIR__ . '/views/index.php';
        break;
    case '/articles/' :
        require_once __DIR__ . '/views/index.php';
        break;
    case preg_match('/articles\?page=[0-9]/', $request) ? true : false :
        require_once __DIR__ . '/views/index.php';
        break;
    case preg_match('/articles\/category\/[0-9]\/\?page=[0-9]/', $request) ? true : false :
        require_once __DIR__ . '/views/category.php';
        break;

    case '/articles/create' :
        require_once __DIR__ . '/views/create.php';
        break;
    case '/articles/create/' :
        require_once __DIR__ . '/views/create.php';
        break;
    case preg_match('/articles\/delete\/[0-9]/', $request) ? true : false :
        require_once __DIR__ . '/views/delete.php';
        break;
    case '/articles/category': 
        require_once __DIR__ . '/views/category.php';
        break;
    case '/articles/category/':
        require_once __DIR__ . '/views/category.php';
        break;
    case preg_match('/articles\/category\/[0-9]/', $request) ? true : false:
        require_once __DIR__ . '/views/category.php';
        break;
    case preg_match('/articles\/update\/[0-9]/', $request) ? true : false:
        require_once  __DIR__ . '/views/update.php';
        break;
    case preg_match('/articles\/view\/[0-9]/', $request) ? true : false:
        require_once __DIR__ . '/views/view.php';
        break;
    default:
        http_response_code(404);
        require_once __DIR__ . '/views/404.php';
        break;
}

