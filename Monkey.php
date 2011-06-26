<?php

class Monkey
{
	// configurable options
	public static $baseUri = '/';
	public static $routerClass = 'Router';
	public static $applicationDirectory;
	public static $defaultRenderer = 'Monkey_Render_HtmlTemplateRenderer';
	public static $defaultFrame = 'frames/public';
	public static $viewRoot = 'src/views/';

	// constants
	const PATH_SEPARATOR = '/';
	const NAMESPACE_SEPARATOR = '_';
	const MEMBER_FILE_EXTENSION = '.php';

	private static $_shouldDebug;
	private static $_debuggers;
	private static $_loggers;

	public static function _do()
	{
		$session = Monkey_Session::getSession();
		$session->setValueForKey("wubbler", "tyler");
		$regex = new Monkey_Regex('^' . self::$baseUri);
		$uri = $regex->replace($_SERVER['REQUEST_URI'], '');
		$dispatcher = new Monkey_Dispatcher();
		$dispatcher->handle($uri);
	}

	public static function loadApplicationMember($memberName)
	{
		$ctrlsPath = self::$applicationDirectory .
				"/src/controllers/$memberName" . self::MEMBER_FILE_EXTENSION;
		$modelPath = self::$applicationDirectory .
				"/src/models/$memberName" . self::MEMBER_FILE_EXTENSION;
		$utilsPath = self::$applicationDirectory .
				"/src/utils/$memberName" . self::MEMBER_FILE_EXTENSION;
		$confgPath = self::$applicationDirectory .
				"/config/$memberName" . self::MEMBER_FILE_EXTENSION;

		if (file_exists($ctrlsPath))
		{
			include_once($ctrlsPath);
		}
		else if (file_exists($modelPath))
		{
			include_once($modelPath);
		}
		else if (file_exists($utilsPath))
		{
			include_once($utilsPath);
		}
		else if (file_exists($confgPath))
		{
			include_once($confgPath);
		}
	}

	public static function loadFrameworkMember($memberName)
	{
		$path = str_replace(self::NAMESPACE_SEPARATOR,
				self::PATH_SEPARATOR, $memberName);
		$path = dirname(__FILE__) . self::PATH_SEPARATOR . $path
				. self::MEMBER_FILE_EXTENSION;

		if (file_exists($path))
		{
			require_once($path);
		}
	}

	public static function debug($shouldDebug = null)
	{
		if (!isset($shouldDebug))
		{
			return self::$_shouldDebug;
		}
		else
		{
			self::$_shouldDebug = $shouldDebug;
		}
	}

	public static function log($message)
	{
		$trace = debug_backtrace();
		$message = $trace[1]['class'] . '#' . $trace[1]['function'] . ' : ' . $message;
		
		if (self::debug())
		{
			if (isset(self::$_debuggers))
			{
				foreach (self::$_debuggers as $debugger)
				{
					$debugger->writeLine($message);
				}
			}
		}


		if (isset(self::$_loggers))
		{
			foreach (self::$_loggers as $logger)
			{
				$logger->writeLine($message);
			}
		}
	}

	public static function attachDebugger(Monkey_Debugger $debugger)
	{
		if (!(isset(self::$_debuggers)))
		{
			self::$_debuggers = array();
		}

		if (!in_array($debugger, self::$_debuggers))
		{
			self::$_debuggers[] = $debugger;
		}
	}

	public static function attachLogger(Monkey_Logger $logger)
	{
		if (!(isset(self::$_loggers)))
		{
			self::$_loggers = array();
		}

		if (!in_array($logger, self::$_loggers))
		{
			self::$_loggers[] = $logger;
		}
	}
}
