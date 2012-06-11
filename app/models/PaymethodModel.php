<?php
//use Nette\Environment, Nette\Debug;

class PaymethodModel extends BaseModel {

    static function insert($values) {
        return self::$notORM->paymethod()->insert($values);
    }

    static function update($id,$values) {
        $unit = self::$notORM->{'paymethod'}[$id];
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
