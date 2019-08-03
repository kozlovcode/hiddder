<?php
require dirname(__DIR__).'/config/config.php';
require 'controllers/controller.php';

switch ($url) {
    case '':
        require_once('modules/main.php');
        break;
    case 'cleaning':
        require_once('modules/cleaning.php');
        break;
    default:
        require_once ('modules/redirect.php');
        break;
}