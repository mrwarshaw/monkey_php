<?php

class Monkey_BrowserDebugger implements Monkey_Debugger
{
	public function write($message)
	{
		print('<pre>' . $this->_entitize($message) . '</pre>');
	}

	public function writeLine($message)
	{
		$this->write($message);
		print("\n");
	}

	protected function _entitize($message)
	{
		return htmlentities($message);
	}
}
