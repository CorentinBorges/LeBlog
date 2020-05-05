<?php
namespace Framework;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Page extends AppComponent
{
	protected 	$contentFile,
				$vars=[],
				$viewLoader;

	public function __construct(Application $app)
	{
		parent::__construct($app);
		$this->viewLoader= new Environment(new FilesystemLoader(__DIR__.'/../../'),['cache' => false]);
	}
				

	public function setContent($contentFile)
	{
		if(!file_exists(__DIR__.'/../../'.$contentFile))
		{
			throw new \InvalidArgumentException("la vue demandée n'existe pas");
		}
		$this->contentFile=$contentFile;
	}

	public function addVar($key,$value)
	{
		if(!isset($this->vars[$key]) || $this->vars[$key]!==$value)
		{
			$this->vars[$key]=$value;
		}
	}

	public function getGeneratedPage()
	{
		echo $this->viewLoader->render($this->contentFile,$this->vars);
	}

}
