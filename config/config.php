<?php
error_reporting(0);

include 'libs/rb-sqlite.php';

R::setup( 'sqlite:' . dirname(__DIR__) . '/config/data.db' );
if ( !R::testConnection()) {
	exit();
}

R::freeze(true);