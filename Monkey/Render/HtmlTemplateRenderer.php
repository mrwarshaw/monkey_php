<?php

class Monkey_Render_HtmlTemplateRenderer
{
	const EXTENSION = '.html';

	public function render($options)
	{
		if (!array_key_exists('frame', $options))
		{
			$frame = Monkey::$defaultFrame;
		}
		else
		{
			$frame = $options['frame'];
		}

		if (array_key_exists('template', $options))
		{
			$template = $options['template'];
		}

		$framePath = Monkey::$applicationDirectory .
			Monkey::$viewRoot . $frame . self::EXTENSION;
		$templatePath = Monkey::$applicationDirectory .
			Monkey::$viewRoot . $template . self::EXTENSION;

		foreach ($options as $key => $val)
		{
			$$key = $val;
		}

		include_once($framePath);
	}
}
