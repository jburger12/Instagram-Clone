<?php
	include_once('db.php');
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	class Escape
	{
		public static function bdd($string)
		{
			if(ctype_digit($string))
				$string = intval($string);
			else
				$string = addcslashes($string, '%_');
			return $string;
		}
		public static function html($string)
		{
			return htmlentities($string);
		}
	}
?>
