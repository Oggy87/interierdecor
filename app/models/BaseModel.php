<?php
//use Nette\Environment, Nette\Debug;

abstract class BaseModel {
	static protected $notORM;
	
	static function initialize() {
		$database = Environment::getConfig('database');
		$pdo = new PDO("mysql:host=$database[server];dbname=$database[database]", $database['login'], $database['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$pdo->query("SET time_zone = " . $pdo->quote(ini_get("date.timezone")));
		self::$notORM = new NotORM($pdo, null, new NotORM_Cache_File(TEMP_DIR . "/notorm.cache"));
		self::$notORM->rowClass = 'NotORM_RowLang';
		if (!Debug::$productionMode) {
			$panel = new NotORMPanel;
			self::$notORM->debug = array($panel, 'addQuery');
			Debug::addPanel($panel);
		}
	}
	
	static function fetchRow($table, $id) {
		return self::$notORM->{$table}[$id];
	}
	
	static function fetchPairs($table, $column) {
		return self::$notORM->$table()->fetchPairs("id", $column);
	}

        static function fetchAll($table) {
            return self::$notORM->{$table};
        }
}
