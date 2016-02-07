<?php
include 'src/Framework/lib/Console/Colors.php';
include 'src/Framework/lib/Console/Cli.php';

use src\Framework\lib\Terminal\Cli;
use src\Framework\lib\Terminal\Colors;

$cli = new Cli();

$cli->drawLine(40);
$cli->coloredOutput(' Welkom bij de onderhoudstool ' . PHP_EOL, 'yellow', 'blue');

start:
$cli->output(PHP_EOL . 'Typ een opdracht: ');

$cmd = readline();

if(explode(' ', $cmd)[0] == 'interface') {
    
    $name = explode(' ', $cmd)[1];
    $cli->output(PHP_EOL . 'created interface ' . $name);
}

if($cmd == 'exit') {
    exit;
}

goto start;