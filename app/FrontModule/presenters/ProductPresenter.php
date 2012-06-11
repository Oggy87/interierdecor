<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */



/**
 * Homepage presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class Front_ProductPresenter extends Front_BasePresenter
{

    /** @persistent */
    public $id;
    private $product;

    /**
     * Get persistent parameters
     *
     * @return array persistents
    */
    public static function getPersistentParams() {
        return array('id');

    }

    protected function  startup() {
        parent::startup();

        try {
            //$this->product = $this->fetchRow('product', $this->getParam('id'));
            $this->product = BaseModel::fetchAll("product")->where("id", $this->getParam('id'))->where("active",1)->fetch();
            if(!$this->product) throw new BadRequestException ();
        }
        catch (BadRequestException $exc) {
            throw new InvalidArgumentException("Produkt neexistuje nebo je neaktivní.");
        }
    }
    
    public function actionDefault() {
        try {
            $this->product->update(array('views' => new NotORM_Literal("views + 1")));
        } catch(PDOException $exc) {
            Debug::log($exc, Debug::ERROR);
        }
        
    }

    public function  beforeRender() {
        parent::beforeRender();

        $this->template->product = $this->product;

    }

    public function renderDefault() {
        $this->template->category_tagGroupes = BaseModel::fetchAll("category_tagGroup")->where("category_id",$this->product['category_id'])->order("sort");

        $this->template->productPhotos = $this->product->productPhoto("id != ?",  $this->product['productPhoto_id']);
        $this->template->image_products = BaseModel::fetchAll("image_product")->where("product_id",$this->product['id']);

        //$this->template->similar = array();
        $products = BaseModel::fetchAll('product')->where("category_id", $this->product["category_id"]);
        $tag_ids = BaseModel::fetchAll("product_tag")->where("product_id",  $this->product["id"])->select("tag_id");

        $similiarity = floor((count($tag_ids) * 85)/100);
        
        $this->template->similar = BaseModel::fetchAll("product_tag")->where("tag_id",$tag_ids)->where("product.active",1)->where("product_id != ?",$this->product["id"])->select("product_id,COUNT(tag_id) AS similiarity")->order("similiarity DESC")->group("product_id","similiarity >= $similiarity")->limit("8");
        
        //$this->template->inspirations = BaseModel::fetchAll("image_tag")->where("tag_id",$tag_ids)->group('image_id');
        
        if($this->product['productType_id']) {
            $this->template->productTypes = BaseModel::fetchAll("product")->where("active",1)->where("productType_id",$this->product['productType_id'])->where("NOT id",$this->product['id']);
            ////$this->product->product()->via('productType_id');
            $this->template->similar->where("product.productType_id != ?",$this->product['productType_id']);
        }
    }

    

}
