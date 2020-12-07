<?php
// Starting session
session_start();

require_once("..\\vendor\\autoload.php");
require_once("..\\app\\config\\global.php");

use app\core\Router;
(new Router());
