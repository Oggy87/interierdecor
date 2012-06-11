<?php
//use Nette\Environment, Nette\Debug;

class TagGroupModel extends BaseModel {
    
    static function getIdByUrl($url) {
        $tagGroup = self::$notORM->tagGroup("url_slug", $url)->fetch();
        return $tagGroup['id'];
    }

    static function getUrlById($id) {
        $tagGroup = self::$notORM->{'tagGroup'}[$id];
        return $tagGroup['url_slug'];
    }

  static function newTagGroup($tagGroup,$category_tagGroup) {
       try {
            self::$notORM->transaction = "BEGIN";
            $group= self::$notORM->tagGroup()->insert($tagGroup);
            $cat_group = $group->category_tagGroup()->insert($category_tagGroup);
            self::$notORM->transaction = "COMMIT";
        } catch (PDOException $exc) {
            self::$notORM->transaction = "ROLLBACK";
            throw $exc;
        }
        return $group;
  }
  
  static function editTagGroup($tagGroup,$category_tagGroup) {
      
       try {
            self::$notORM->transaction = "BEGIN";
            $group= self::fetchRow('tagGroup', $tagGroup['id']);
            $group->update((array)$tagGroup);
            
            $group->category_tagGroup()->delete();
            $cat_group = $group->category_tagGroup()->insert($category_tagGroup);
            self::$notORM->transaction = "COMMIT";
        } catch (PDOException $exc) {
            self::$notORM->transaction = "ROLLBACK";
            throw $exc;
        }
        return $group;
  }
}
