<?php
//use Nette\Environment, Nette\Debug;

class ProductModel extends BaseModel {
    


    static function getIdByUrl($url) {
        $product = self::$notORM->product("url_slug", $url)->fetch();
        return $product['id'];
    }

    static function getUrlById($id) {
        $product = self::$notORM->{'product'}[$id];
        return $product['url_slug'];
    }
    
    static function editProduct($values) {

        $product = self::fetchRow('product', $values['product']['id']);
        
        //ukladani souboru
        $file = $values['product']['file_path'];
        if($file) {
            if($file->isOk()) {
                $path = WWW_DIR . '/static/files/'.$file->getName();
                $file->move($path );
                $values['product']['file_path'] = $path;
                @unlink(WWW_DIR.$product['file_path']);
            }
        }
        else {
            unset($values['product']['file_path']);
            unset($values['product']['file_name']);
        }
        
        foreach ($values['product'] as $key => $value) {
            if($value == '') $value = NULL;
            $product[$key] = $value;
        }
        
        // vymazat všechny vztahy product_tag, aby bylio nahrazeny novými
        $product->product_tag()->delete();

        //rozsekat taggroupy a tagy
        $tagarray = array();
        foreach ($values['tags'][$values['product']['category_id']] as $tagGroup => $tags) {
            if (($tags === '') OR ($tags == 'NULL')) $tags = NULL;
            $rawtags = explode(',', $tags);
                
            foreach ($rawtags as $key => &$tag) {
                $tag = TemplateHelpers::strip($tag);
                if($tag == '') unset($rawtags[$key]);
                else $tagarray[$tagGroup][] = $tag;
            }
        }

        //najit tagy pripadne je vytvorit
        foreach(array_keys($tagarray) as $tagGroup_id) {
            $tags_rows = self::$notORM->tag()->where('value',$tagarray[$tagGroup_id])->where("tagGroup_id",$tagGroup_id)->fetchPairs('id','value');

            $newtags = array_diff($tagarray[$tagGroup_id], $tags_rows);
            $tags_rows = array_keys($tags_rows);
            if($newtags) {
                    foreach ($newtags as $tag) {
                        $tag_id = self::$notORM->tag()->insert(array('value' => String::trim($tag),'url_slug' => String::webalize($tag), 'tagGroup_id' => $tagGroup_id));
                        array_push($tags_rows, $tag_id['id']);
                       /* Environment::getCache()->clean(array(
                            Cache::TAGS => array("tag")
                        ));*/
                    }
            }
            if ($tags_rows) {
                   foreach($tags_rows as $tag) {
                        $product->product_tag()->insert(array('tag_id' => $tag));
                    }
            }
        }
        //je nahran obrazek?
        if($values['productPhoto']['name']) {
            $image_path = NULL;
            if($values['productPhoto']['tmpname'] != '' AND $values['productPhoto']['tmpname'] != NULL) {
                $image_path = Helpers::uploadFile('product-photo/', $values['productPhoto']['name'], $values['productPhoto']['tmpname']);
            }

            // jestlize produkt ma obrazek
            if ($product['productPhoto_id']) {
                //ulozeni produktoveho fota ..smazani stareho
                if($values['productPhoto']['tmpname'] != '' AND $values['productPhoto']['tmpname'] != $product->productPhoto['image_path']) {
                    //smazat stavajici obrazek
                    @unlink(WWW_DIR.'/static/'.$product->productPhoto['image_path']);
                    // Remove old  photos files
                    Helpers::removeTempImages($product->productPhoto['image_path']);
                    //nahrat novy obrazek
                    $product->productPhoto->delete();
                    if($image_path) {
                        $productPhoto = $product->productPhoto()->insert(array('image_path' => $image_path));
                        $product['productPhoto_id'] = $productPhoto['id'];
                        $product->update();
                    }        
                    else {
                         $this->flashMessage('Nepodařilo se nahrát foto.', 'error');
                    }  
                }
            }
            //jestlize nema obrazek ulozit novy a priradit k produktu
            else {
                if($values['productPhoto']['tmpname'] != '') {
                    if($image_path) {
                        $productPhoto = self::$notORM->productPhoto()->insert(array('image_path' => $image_path, 'product_id' => $product['id']));
                        $product['productPhoto_id'] = $productPhoto['id'];
                    }        
                    else {
                         $this->flashMessage('Nepodařilo se nahrát foto.', 'error');
                    }  
                }
            }

        }
        
        $product->update();
    }
    
    static function newProduct($values) {

        foreach ($values['product'] as $key => &$value) {
            if($value == '' AND $key != 'recommended') {
                $value = NULL;
            }
        }
        
        //ukladani souboru
        $file = $values['product']['file_path'];
        if($file) {

            if($file->isOk()) {
                $path = WWW_DIR . '/static/files/'.$file->getName();
                $file->move($path );
                $values['product']['file_path'] = $path;
            }
        }

        //ukládání nového produktu
        $values['product']['saved'] = new DateTime;
        $product = self::$notORM->product()->insert($values['product']);

        //rozsekat taggroupy a tagy
        $tagarray = array();
        foreach ($values['tags'][$values['product']['category_id']] as $tagGroup => $tags) {
            if (($tags === '') OR ($tags == 'NULL')) $tags = NULL;
            $rawtags = explode(',', $tags);
                
            foreach ($rawtags as $key => &$tag) {
                $tag = TemplateHelpers::strip($tag);
                if($tag == '') unset($rawtags[$key]);
                else $tagarray[$tagGroup][] = $tag;
            }
        }

        //najit tagy pripadne je vytvorit
        foreach(array_keys($tagarray) as $tagGroup_id) {
            $tags_rows = self::$notORM->tag()->where('value',$tagarray[$tagGroup_id])->where("tagGroup_id",$tagGroup_id)->fetchPairs('id','value');

            $newtags = array_diff($tagarray[$tagGroup_id], $tags_rows);
            $tags_rows = array_keys($tags_rows);
            if($newtags) {
                    foreach ($newtags as $tag) {
                        $tag_id = self::$notORM->tag()->insert(array('value' => String::trim($tag),'url_slug' => String::webalize($tag), 'tagGroup_id' => $tagGroup_id));
                        array_push($tags_rows, $tag_id['id']);
                    }
            }
            if ($tags_rows) {
                   foreach($tags_rows as $tag) {
                        $product->product_tag()->insert(array('tag_id' => $tag));
                    }
            }
        }
        
        //ulozeni produktoveho fota 
        $image_path = NULL;
        if($values['productPhoto']['tmpname'] != '' AND $values['productPhoto']['tmpname'] != NULL) {
                $image_path = Helpers::uploadFile('product-photo/', $values['productPhoto']['name'], $values['productPhoto']['tmpname']);
        }
        if($image_path) {
            $productPhoto = self::$notORM->productPhoto()->insert(array('image_path' => $image_path, 'product_id' => $product['id']));
            $product['productPhoto_id'] = $productPhoto['id'];
        }        
        else {
             $this->flashMessage('Nepodařilo se nahrát foto.', 'error');
        }  

        $product->update();
        
        return $product;
    }
    
    static function saveVisualisation($product,$values) {
        
        //je nahran obrazek?
        if($values['name']) {
            $image_path = NULL;
            if($values['tmpname'] != '' AND $values['tmpname'] != NULL) {
                $image_path = Helpers::uploadFile('visualisation-images/', $values['name'], $values['tmpname']);
            }

            
            //ulozeni produktoveho fota ..smazani stareho
            if ($values['tmpname'] != '' AND $values['tmpname'] != $product['visualisation_path']) {
                // jestlize produkt ma obrazek
                if ($product['visualisation_path'] != NULL) {
                    //smazat stavajici obrazek
                    @unlink(WWW_DIR . '/static/' . $product['visualisation_path']);
                    // Remove old  photos files
                    Helpers::removeTempImages($product['visualisation_path']);
                }

                if ($image_path) {
                    $product['visualisation_path'] = $image_path;
                } else {
                    $this->flashMessage('Nepodařilo se nahrát foto.', 'error');
                }
            }
        } 
        
        $product['visualisation_width'] = $values['visualisation_width'];
        $product['visualisation_height'] = $values['visualisation_height'];

        $product->update();        
        
    }
    
    static function saveImages($product,$values) {
        //další produktové obrázky
        if(isset($values['flash_uploader'])) {
            foreach ($values['flash_uploader'] as $image) {
                $image_path = Helpers::uploadFile('product-photo/', $image['name'], $image['tmpname']);
                if($image_path) {
                    $productPhoto = self::$notORM->productPhoto()->insert(array('image_path' => $image_path, 'product_id' => $product['id']));
                }        
                else {
                     $this->flashMessage('Nepodařilo se nahrát foto '.$image['name'].'.', 'error');
                }
            }
        }
    }
    
   
}
