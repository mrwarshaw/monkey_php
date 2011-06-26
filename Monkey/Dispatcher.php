<?php

class Monkey_Dispatcher
{
	protected $_router;

	public function __construct()
	{
		$routerClass = Monkey::$routerClass;

		$this->_router = new $routerClass();
		$this->_router->configureRoutes();
	}

	public function handle($uri)
	{
		$route = $this->_router->getMatchingRoute($uri);

		if (isset($route))
		{
			$presets = $route->getPresets();
			$vars = $route->parseUri($uri);

			foreach ($presets as $key => $val)
			{
				$_REQUEST[$key] = $val;
			}

			foreach ($vars as $key => $val)
			{
				$_REQUEST[$key] = $val;
			}


			if (array_key_exists('controller', $_REQUEST))
			{
				$controller = $_REQUEST['controller'];
			}
			else
			{
				throw new Monkey_Exception('404');
			}

			if (array_key_exists('action', $_REQUEST))
			{
				$action = $_REQUEST['action'];
			}
			else
			{
				$action = 'index';
			}

			try
			{
				$controller = ucfirst($controller) . 'Controller';
				$controller = new $controller();

				$controller->$action();
			}
			catch (Exception $ex)
			{
			}

		}
		else
		{
			throw new Monkey_Exception('404');
		}
	}
}
