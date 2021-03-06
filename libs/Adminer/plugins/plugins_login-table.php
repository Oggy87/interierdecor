<?php
/* Requires this table:
CREATE TABLE login (
	id int NOT NULL AUTO_INCREMENT, -- optional
	login varchar(30) NOT NULL, -- any length
	password_sha1 char(40) NOT NULL,
	UNIQUE (login),
	PRIMARY KEY (id)
);
*/

/** Authenticate a user from the login table
* @author Jakub Vrana, http://www.vrana.cz/
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerLoginTable {
	var $database;
	
	function AdminerLoginTable() {
		Environment::loadConfig(dirname(__FILE__) .'/../../../app/config.ini');
                $this->database = Environment::getConfig('database');
	}
	
	function login($login, $password) {
		$connection = connection();
		return (bool) $connection->result($q = "SELECT COUNT(*) FROM " . idf_escape($this->database['database']) . ".login WHERE login = " . $connection->quote($login) . " AND password_sha1 = " . $connection->quote(sha1($password)));
	}
	
}
