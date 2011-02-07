<?php

class NotORM_RowLang extends NotORM_Row {
	
	// za koncové podtržítko přidáme identifikátor jazyka
	
	function offsetExists($key) {
		return parent::offsetExists(preg_replace('~_$~', '_' . LANG, $key));
	}
	
	function offsetGet($key) {
		return parent::offsetGet(preg_replace('~_$~', '_' . LANG, $key));
	}
	
	function offsetSet($key, $value) {
		return parent::offsetSet(preg_replace('~_$~', '_' . LANG, $key), $value);
	}
	
	function offsetUnset($key) {
		return parent::offsetUnset(preg_replace('~_$~', '_' . LANG, $key));
	}
	
}
