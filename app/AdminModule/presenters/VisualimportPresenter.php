<?php

/**
 * Description of BasePresenter
 *
 * @author oggy
 */
class Admin_VisualimportPresenter extends Admin_BasePresenter {

    public function actionDelete() {
        foreach(BaseModel::fetchAll('product') as $product) {
            $product['visualisation_path'] = NULL;
            $product->update();
        }
        
        $this->terminate();
    }
    
    public function actionDefault() {
        $this->template->updates = array();
        //->where("id",  BaseModel::fetchAll("product_tag")->where("tag_id",252)->select("product_id"))
        foreach(BaseModel::fetchAll('product') as $product) {
            if(!$product['visualisation_path']) {

                preg_match("([0-9]{6})", $product['name'],$number);
                if(isset($number[0])) {

                $url = 'http://img.tapetenshop.de/common/img/items/map/'.$number[0].'.jpg';
               /* if (!self::url_exists($url)) {
                    $url = 'http://img.tapetenshop.de/common/img/items/map/'.$number[0].'.png';
                }*/
                if (self::url_exists($url)) {

                    $image = Image::fromFile($url);
                    if($image) {

                        $static = 'static/';
                        $staticUri = WWW_DIR.'/'.$static;
                        $file = 'visualisation-images/'.$number[0].'.jpg';
                        
                        $image->save($staticUri.'/'.$file, 100);
                        
                        $product['visualisation_path'] = $file;
                        $product->update();

                        array_push($this->template->updates, $product);
                        /*Environment::getCache()->clean(array(
                                Cache::TAGS => array("product/$product[id]")
                        ));*/
    
                    }

                }
                
                }
            }
            
            if($product['visualisation_path']) {
                preg_match("([0-9]{6})", $product['name'],$number);
                if(isset($number[0])) {
                $url = 'http://img.tapetenshop.de/common/img/items/map/'.$number[0].'.jpg';
                /*if (!self::url_exists($url)) {
                    $url = 'http://img.tapetenshop.de/common/img/items/map/'.$number[0].'.png';
                }*/
                 if (!self::url_exists($url)) {
                    $product['visualisation_path'] = NULL;
                    $product['visualisation_width'] = NULL;
                    $product['visualisation_height'] = NULL;
                    $product->update();
                    
                  /*  Environment::getCache()->clean(array(
                            Cache::TAGS => array("product/$product[id]")
                    ));*/
                }
                }
            }

        }
        /*Environment::getCache()->clean(array(
                Cache::TAGS => array("products")
        ));*/
    }
    
    private function url_exists($url) {
        $check = @fopen($url,"r"); // we are opening url with fopen  
        if($check)  
         return true;  

        return false;  

    }

}