<?php
//use Nette\Environment, Nette\Debug;

class UnitModel extends BaseModel {

    static function insert($values) {
        return self::$notORM->unit()->insert($values);
    }

    static function update($id,$values) {
        $unit = self::$notORM->{'unit'}[$id];
        return $unit->update($values);
    }
    
    static function save($values) {
        if(isset($values['id'])) {
            self::update($values['id'], $values);
        }
        else {
            self::insert($values);
        }
    }
}
