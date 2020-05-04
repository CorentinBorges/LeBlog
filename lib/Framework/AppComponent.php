<?php

namespace Framework;

abstract Class AppComponent
{
	protected $app;

	public function __construct(Application $app)
	{
		$this->app=$app;
	}

}

