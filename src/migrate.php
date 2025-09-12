<?php

require_once("./autoload.php");

use migrations\Migration1;
use migrations\Migration2;
use migrations\Migration3;
use migrations\Migration4;

$migrations = [
     new Migration1(),
     new Migration2(),
     new Migration3(),
     new Migration4()
 ];

 $method = 'up';
 if(count($argv) > 1 && $argv[1] == 'down'){
    $method = 'down';
    $migrations = array_reverse($migrations);
}

 foreach($migrations as $migration){
    $migration->$method();
 }