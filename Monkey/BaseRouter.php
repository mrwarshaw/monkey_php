<?php

class Monkey_BaseRouter
{
	protected $_routes;

	public function __construct()
	{
		$this->_routes = array();
	}

	public function configureRoutes()
	{
		$this->_addRoute(
			'{controller}/{action}/{id}'
		);

		$this->_addRoute(
			'{controller}/{action}'
		);

		$this->_addRoute(
			'{controller}',
			array(
				'action' => 'index'
			)
		);

		$this->_addRoute(
			'',
			array(
				'controller' => 'home',
				'action' => 'index'
			)
		);
	}

	public function getMatchingRoute($uri)
	{
		foreach ($this->_routes as $route)
		{
			if ($route->matchesRequestUri($uri))
			{
				return $route;
			}
		}

		return null;
	}

	// non-public members

	protected function _addRoute($routeString, $presets = null)
	{
		$this->_routes[] = new Monkey_Route($routeString, $presets);
	}
}
