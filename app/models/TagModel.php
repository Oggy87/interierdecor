<?php
//use Nette\Environment, Nette\Debug;

class TagModel extends BaseModel {

    static function save($values) {
        try {
            self::$notORM->transaction = "BEGIN";
            $tag =  self::$notORM->tag()->insert($values['tag']);
            //ulozeni produktoveho fota 
            $image_path = NULL;
            if($values['image']['tmpname'] != '' AND $values['image']['tmpname'] != NULL) {
                    $image_path = Helpers::uploadFile('tag-images/', $values['image']['name'], $values['image']['tmpname']);
            }
            if($image_path) {
                $tag['picture_path'] = $image_path;
                $tag->update();
            }        

            self::$notORM->transaction = "COMMIT";
        } catch (PDOException $exc) {
            self::$notORM->transaction = "ROLLBACK";
            throw $exc;
        }
        
        return $tag;
    }
    
    static function edit($values) {

        $tag = self::fetchRow('tag', $values['tag']['id']);
        
                
        foreach ($values['tag'] as $key => $value) {
            if($value == '') $value = NULL;
            $tag[$key] = $value;
        }

        //je nahran obrazek?
        if($values['image']['name']) {
            $image_path = NULL;
            if($values['image']['tmpname'] != '' AND $values['image']['tmpname'] != NULL) {
                $image_path = Helpers::uploadFile('tag-images/', $values['image']['name'], $values['image']['tmpname']);
            }
            
            //ulozeni produktoveho fota ..smazani stareho
            if ($values['image']['tmpname'] != '' AND $values['image']['tmpname'] != $tag['picture_path']) {
                // jestlize produkt ma obrazek
                if ($tag['picture_path'] != NULL) {
                    //smazat stavajici obrazek
                    @unlink(WWW_DIR . '/static/' . $tag['picture_path']);
                    // Remove old  photos files
                    Helpers::removeTempImages($tag['picture_path']);
                }

                if ($image_path) {
                    $tag['picture_path'] = $image_path;
                } else {
                    $this->flashMessage('Nepodařilo se nahrát obrázek.', 'error');
                }
            }
        } 
        
        $tag->update();        
    }
    
    static function getIdByUrl($url) {
        $tag = self::$notORM->tag("url_slug", $url)->fetch();
        return $tag['id'];
    }

    static function getUrlById($id) {
        $tag = self::$notORM->{'tag'}[$id];
        return $tag['url_slug'];
    }
    
    static function getIdsByUrl($url) {
        $groups = explode('/',$url);
        $return = NULL;
        foreach($groups as $group) {
            if(strpos($group, ':') !== false) {
                list($grp,$tagsfield) = explode(':',$group);
                $field = explode('+', $tagsfield);
                $tags = self::$notORM->tag("tag.url_slug",$field)->where("tagGroup.url_slug",$grp)->order("tag.url_slug");
                foreach ($tags as $tag) {
                    if($return) $return .= '+';
                    $return .= $tag['id'];
                }
            }
        }
        
        /*
        $field = explode('+', $url);
        $tags = self::$notORM->tag("url_slug",$field)->order("url_slug");
        $return = NULL;
        foreach ($tags as $tag) {
            if($return) $return .= '+';
            $return .= $tag['id'];
        }
        */
        return $return;
    }

    static function getUrlsById($string) {
        $field = explode('+', $string);
        $tags = self::$notORM->tag("id",$field)->order("url_slug");
        $return = NULL;
        $tgs = array();
        foreach($tags as $tag) {
            $tgs[$tag['tagGroup_id']][] = $tag['url_slug'];
        }
        $tagGroups = self::$notORM->tagGroup("id",  array_keys($tgs))->order("name");

        foreach($tagGroups as $tagGroup) {
            if($return) $return .= '/';
            $return .= $tagGroup['url_slug'].':';
            foreach($tgs[$tagGroup['id']] as $tags) {
                if(substr($return, -1) != ':') $return .= '+';
                $return .= $tags;
            }
        }

        /*
        foreach ($tags as $tag) {
            if($return) $return .= '+';
            $return .= $tag['url_slug'];
        }
*/
        return $return;
    }
}
