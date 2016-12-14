<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use Jimm\lib\App;

define ('DS', DIRECTORY_SEPARATOR);
define ('ROOT', __DIR__ . '/..');
define ('VIEWS_PATH', ROOT . '/views');
define ('IMAGES_PATH', '/uploads');
define ('IMAGES_PREVIEW_PATH', '/uploads/thumbs');

require_once(ROOT . '/vendor/autoload.php');
require_once(ROOT . '/config/config-param.php');

session_start();

App::run($_SERVER['REQUEST_URI']);