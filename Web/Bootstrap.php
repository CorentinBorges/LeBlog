<?php
require(__DIR__.'/../vendor/autoload.php');
const APP_DEFAULT='Frontend';


if(!isset($_GET['app']) || empty($_GET['app']))
{
	$_GET['app']=APP_DEFAULT;
}

$app='App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';
$appClass=new $app;
$appClass->run();