<?php

namespace App;

session_start();
if(!isset($_SESSION)){$_SESSION['role']==0;}

require_once 'core'.DIRECTORY_SEPARATOR.'config.php';
require_once dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
require_once 'data'.DIRECTORY_SEPARATOR.'DB.php';

core\Route::start();