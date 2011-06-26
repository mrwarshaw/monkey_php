<?php

class Monkey_DataAccess_BaseWarehouse implements Monkey_Warehouse
{
	protected $_broker;
	protected $_fieldDictionary;
	protected $_tableName;
	protected $_primaryKeyField;

	public function __construct($broker)
	{
		$this->_broker = $broker;
	}

	public function load($id)
	{

	}

	public function save($object)
	{

	}

	public function destroy($object)
	{

	}

	public function query($queryString, $params = array())
	{

	}
}
