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
class AdminerCredentials {
	var $database;
	
	function AdminerCredentials() {
            Environment::loadConfig(dirname(__FILE__) .'/../../../app/config.ini');
            $this->database = Environment::getConfig('database');
	}

        /** Identifier of selected database
        * @return string
        */
        function database() {
            // should be used everywhere instead of DB
            return $this->database['database'];
        }
	
	function credentials() {
		return array($this->database['server'],$this->database['login'] , $this->database['password']);
	}
	
}
