<?php
//use Nette\Environment, Nette\Debug;

class CategoryModel extends BaseModel {

    static function fetch() {
        return self::$notORM->category()->order("sort");
    }

    static function getIdByUrl($url) {
        $category = self::$notORM->category("url_slug", $url)->fetch();
        return $category['id'];
    }

    static function getUrlById($id) {
        $category = self::$notORM->{'category'}[$id];
        return $category['url_slug'];
    }

    static function insert($values) {
        return self::$notORM->category()->insert($values);
    }

    static function update($id,$values) {
        $category = self::$notORM->{'category'}[$id];
        return $category->update($values);
    }
}
