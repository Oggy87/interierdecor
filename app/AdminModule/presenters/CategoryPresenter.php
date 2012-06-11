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
class Admin_CategoryPresenter extends Admin_BasePresenter
{
    /** @persistent */
    public $tags;
    /** @persistent */
    public $id;
    /** @persistent */
    public $razeni;
    private $category;

    /**
     * Get persistent parameters
     *
     * @return array persistents
    */
    public static function getPersistentParams() {
        return array('id','tags','razeni');
    }

    protected function  startup() {
        parent::startup();
        
        //docasne
        $onemonthago = new DateTime('31 days ago');
        $this->template->onemonthago = $onemonthago->format("Y-m-d");
        
        $this->template->visualisation = Environment::getSession('visualisation');
        
        $this->tags = $this->getParam('tags');
        try {
            $this->category = $this->fetchRow("category", $this->getParam('id'));
        } catch (BadRequestException $exc) {
            throw new InvalidArgumentException("Kategorie neexistuje.");
        }

        $this->razeni = $this->getParam('razeni');
        
        $this->template->tags = BaseModel::fetchAll('tag')->where("id",explode('+', $this->tags))->order("url_slug");

        $tags = clone $this->template->tags;
        $this->template->tagGroupes = BaseModel::fetchAll('tagGroup')->where("id",$tags->select("tagGroup_id"))->group("id");
        
        $this->template->products = BaseModel::fetchAll('product');
        if($this->category) $this->template->products->where("category_id", $this->category['id']);

        foreach ($this->template->tagGroupes as $tagGroup) {
            $tags = clone $this->template->tags;
            $tags->where("tagGroup_id",$tagGroup['id']);

            $this->template->products->where("id", BaseModel::fetchAll('product_tag')->where("tag_id", $tags)->select("product_id"));
        }
//JINA VARIANTA NEMAZAT
      /*  $this->template->products = BaseModel::fetchAll('product');
        if($this->category) $this->template->products->where("category_id", $this->category['id']);
        foreach ($this->template->tags as $tag) {
            $this->template->products->where("id", BaseModel::fetchAll('product_tag')->where("tag_id", $tag['id'])->select("product_id"));

        }
        //2.varianta
        /*$products = BaseModel::fetchAll('product')->where("id", BaseModel::fetchAll('product_tag')->where("tag_id", $this->template->tags)
                ->group("product_id", "COUNT(*) = " . count($this->template->tags))
                ->select("product_id")
        );*/

    }

    public function  beforeRender() {
        parent::beforeRender();

        $this->template->category = $this->category;
        
    }

    public function renderDefault() {
        $this->template->category_tagGroupes = BaseModel::fetchAll("category_tagGroup")->where("category_id",$this->category)->where("tagGroup.filter",1)->order("sort");
        $this->template->maxprice = BaseModel::fetchAll('product')->where("category_id", $this->category['id'])->max("price");
        if(!$this->tags) {
        
            $this->template->category_hptagGroupes = clone $this->template->category_tagGroupes;
            $this->template->category_hptagGroupes->where("hp",1);
            
            $this->template->recommended =  clone $this->template->products;
            $this->template->recommended->where("recommended",1)->order("RAND()")->limit("3");
            
            $this->template->discount =  clone $this->template->products;
            $this->template->discount->where("newprice IS NOT NULL")->order("RAND()")->limit("3");
            
            $this->template->new =  clone $this->template->products;
            $this->template->new->where("saved >= DATE_SUB(NOW(), INTERVAL 1 MONTH)")->order("RAND()")->limit("3");
        }
        
        $paginator = $this['stranka']->getPaginator();
        $paginator->itemCount = $this->template->products->count('*');
        $this->template->products->limit($paginator->itemsPerPage, $paginator->offset);
    }
    
    public function renderRecommended() {
        $this->template->category_tagGroupes = BaseModel::fetchAll("category_tagGroup")->where("category_id",$this->category)->where("tagGroup.filter",1)->order("sort");
        $this->template->maxprice = BaseModel::fetchAll('product')->where("category_id", $this->category['id'])->where("recommended",1)->max("price");

        $this->template->products->where("recommended",1);
        
        
        $paginator = $this['stranka']->getPaginator();
        $paginator->itemCount = $this->template->products->count('*');
        $this->template->products->limit($paginator->itemsPerPage, $paginator->offset);
    }
    
    public function renderAction() {
        $this->template->category_tagGroupes = BaseModel::fetchAll("category_tagGroup")->where("category_id",$this->category)->where("tagGroup.filter",1)->order("sort");
        $this->template->maxprice = BaseModel::fetchAll('product')->where("category_id", $this->category['id'])->where("newprice IS NOT NULL")->max("price");

        $this->template->products->where("newprice IS NOT NULL");
        
        
        $paginator = $this['stranka']->getPaginator();
        $paginator->itemCount = $this->template->products->count('*');
        $this->template->products->limit($paginator->itemsPerPage, $paginator->offset);
    }
    
    public function renderNew() {
        $this->template->category_tagGroupes = BaseModel::fetchAll("category_tagGroup")->where("category_id",$this->category)->where("tagGroup.filter",1)->order("sort");
        $this->template->maxprice = BaseModel::fetchAll('product')->where("category_id", $this->category['id'])->where("saved >= DATE_SUB(NOW(), INTERVAL 1 MONTH)")->max("price");

        $this->template->products->where("saved >= DATE_SUB(NOW(), INTERVAL 1 MONTH)")->order("name");
        
        
        $paginator = $this['stranka']->getPaginator();
        $paginator->itemCount = $this->template->products->count('*');
        $this->template->products->limit($paginator->itemsPerPage, $paginator->offset);
    }
    
    public function afterRender() {
        parent::afterRender();

            switch ($this->razeni) {
                case 'od-nejlevnejsich':
                    $this->template->products->order("CASE 
                                                        WHEN newprice IS NOT NULL THEN newprice 
                                                        WHEN newprice IS NULL THEN price
                                                    END ASC");
                    break;
                case 'od-nejdrazsich':
                    $this->template->products->order("CASE 
                                                        WHEN newprice IS NOT NULL THEN newprice 
                                                        WHEN newprice IS NULL THEN price
                                                    END DESC");
                    break;
                default:
                    $this->template->products->order("name");
                    break;
            }

    }

    public function handlePriceRange($from,$to) {
        $this->template->products->where("price BETWEEN ? AND ?",$from,$to);

        $this->invalidateControl('filtercount');
        $this->invalidateControl('products');
    }

    protected function createComponentStranka($name) {
        $vp = new VisualPaginator();
        $vp->paginator->itemsPerPage = 12;

        return $vp;
    }
    

}
