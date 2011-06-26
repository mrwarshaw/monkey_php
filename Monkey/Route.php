<?php

class Monkey_Route
{
	protected $_routeString;
	protected $_presets;

	public function __construct($routeString, $presets = null)
	{
		$this->_routeString = $routeString;

		if (isset($presets))
		{
			$this->_presets = $presets;
		}
		else
		{
			$this->_presets = array();
		}
	}

	public function matchesRequestUri($requestUri)
	{
		$regex = $this->_getRouteRegex();

		return $regex->isMatch($requestUri);
	}

	public function getPresets()
	{
		return $this->_presets;
	}

	public function getRouteString()
	{
		return $this->_routeString;
	}

	public function parseUri($uri)
	{
		$regex = $this->_getRouteRegex();

		$vars = array();

		$match = $regex->getMatch($uri);

		foreach ($match->getSubpatterns() as $key => $val)
		{
			$vars[$key] = $val;
		}

		return $vars;
	}

	// non-public members
	
	protected function _getRouteRegex()
	{
		$routeRegexString;
		$routeRegex;
		$prepRegex = new Monkey_Regex('\{([a-zA-Z0-9]+)\}');
		
		$routeRegexString = $prepRegex->replace($this->_routeString,
												"(?<$1>[A-Za-z0-9_-]+)");
		return new Monkey_Regex($routeRegexString);
	}
}
