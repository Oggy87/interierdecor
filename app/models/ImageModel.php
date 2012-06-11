<?php
//use Nette\Environment, Nette\Debug;

class ImageModel extends BaseModel {

    static function insert($values) {
        //další produktové obrázky
        if(isset($values['flash_uploader'])) {
            foreach ($values['flash_uploader'] as $image) {
                $image_path = Helpers::uploadFile('image-photo/', $image['name'], $image['tmpname']);
                if($image_path) {
                    $image = self::$notORM->image()->insert(array('image_path' => $image_path));
                }        
                else {
                     $this->flashMessage('Nepodařilo se nahrát foto '.$image['name'].'.', 'error');
                }
            }
        }
    }
}
