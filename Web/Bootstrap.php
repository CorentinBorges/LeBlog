<?php
require(__DIR__.'/../lib/Framework/SplClassLoader.php');
require(__DIR__.'/../lib/vendors/autoload.php');

const APP_DEFAULT='Frontend';

$loader= new SplClassLoader();
$loader->addNamespace('Framework',__DIR__.'/../lib/Framework/');
$loader->addNamespace('App',__DIR__.'/../App');
$loader->addNamespace('Models',__DIR__.'/../lib/vendors/Models/');
$loader->addNamespace('Entity',__DIR__.'/../lib/vendors/Entity/');

$loader->register();


if(!isset($_GET['app']) || empty($_GET['app']))
{
	$_GET['app']=APP_DEFAULT;
}




$app='App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';
$appClass=new $app;
$appClass->run();