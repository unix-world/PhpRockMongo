<?php
/**
 * RockMongo startup
 *
 * In here we define some default settings and start the configuration files
 * @package rockmongo
 */

/**
* Defining version number and enabling error reporting
*/
define('ROCK_MONGO_VERSION', '1.1.9-uxm20190418');

error_reporting(E_ALL);

if(!file_exists("vendor/autoload.php")){
    exit("First it's necessary that install composer.");
}else{
    require "vendor/autoload.php";
}
/**
* Environment detection
*/
if(!version_compare(PHP_VERSION, "5.6", ">=")) {
	exit("To make things right, you must install PHP 5.6 or later");
}
if(version_compare(PHP_VERSION, "7.0", ">=")) {
	if(!class_exists("\\MongoDB\\Client")) {
		exit("To make things right, you must install php_mongodb module");
	}
	if(!class_exists("MongoClient")) {
		exit("To make things right, you must install the PHP Alcaeus Mongo Adapter");
	}
} elseif(!class_exists("Mongo") && !class_exists("MongoClient")) {
    exit("To make things right, you must install php_mongo module");
}


// enforce Mongo support for int64 data type (Kyryl Bilokurov <kyryl.bilokurov@gmail.com>)
if (PHP_INT_SIZE == 8) {
	ini_set("mongo.native_long", 1);
	ini_set("mongo.long_as_object", 1);
}

/**
* Initializing configuration files and RockMongo
*/
if (file_exists("config.php")) {
    require "config.php";
} else {
    require "config-sample.php";
}
require "rock.php";
rock_check_version();
rock_init_lang();
rock_init_plugins();
Rock::start();
