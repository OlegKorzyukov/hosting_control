<?php 

use Inc\Hosting; 
use Inc\Connect;

if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}


if(class_exists('Inc\Hosting')){
	$getHosting = new Hosting();
}else {
	die('Class not exists');
}

 ?>