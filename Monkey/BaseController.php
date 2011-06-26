<?php

class Monkey_BaseController
{
	protected $_rendererClass;
	protected $_renderer;

	public function __construct()
	{
		if (isset($this->_rendererClass))
		{
			$rendererClass = $this->_rendererClass;
		}
		else
		{
			$rendererClass = Monkey::$defaultRenderer;
		}

		$this->_renderer = new $rendererClass();
	}

	protected function _doRender($options = null)
	{
		if (!isset($action))
		{
			if (!array_key_exists('action', $_REQUEST))
			{
				$action = 'index';
			}
			else
			{
				$action = $_REQUEST['action'];
			}
		}

		if (!isset($options))
		{
			$options = array();
		}

		if (!array_key_exists('template', $options))
		{
			$options['template'] = "{$_REQUEST['controller']}/$action";
		}

		$this->_renderer->render(
			$options
		);
	}
}
