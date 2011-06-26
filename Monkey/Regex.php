<?php

class Monkey_Regex
{
	const DELIMITER = '|';

	private $_expression;

	public function __construct($expression)
	{
		$this->_expression = self::DELIMITER
							. str_replace(self::DELIMITER, '\\'	. self::DELIMITER,
										$expression)
										. self::DELIMITER;
	}

	public function isMatch($subject)
	{
		return preg_match($this->_expression, $subject);
	}

	public function getMatch($subject)
	{
		$matches = array();
		preg_match($this->_expression, $subject, $matches);

		return new Monkey_RegexMatch($matches);
	}

	public function getMatches($subject)
	{
		$matches = array();
		preg_match_all($this->_expression, $subject,
						$matches, PREG_SET_ORDER);

		if (count($matches) > 0)
		{
			$matchArray = array();

			foreach ($matches as $match)
			{
				$matchArray[] = new Monkey_RegexMatch($match);
			}

			return $matchArray;
		}

		return null;
	}

	public function replace($subject, $replacement)
	{
		return preg_replace($this->_expression, $replacement, $subject);
	}
}

class Monkey_RegexMatch
{
	protected $_fullMatch;
	protected $_subpatterns;

	public function __construct($matchArray)
	{
		$this->_subpatterns = array();

		foreach ($matchArray as $key => $val)
		{
			if (!isset($this->_fullMatch))
			{
				$this->_fullMatch = $val;
			}
			else
			{
				$this->_subpatterns[$key] = $val;
			}
		}
	}

	public function getFullMatch()
	{
		return $this->_fullMatch;
	}

	public function getSubpattern($key)
	{
		return $this->_subpatterns[$key];
	}

	public function getSubpatterns()
	{
		return $this->_subpatterns;
	}
}
