<?php

interface Monkey_Warehouse
{
	function load($id);
	function save($object);
	function destroy($object);
	function query($queryString, $params = array());
}
