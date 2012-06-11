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
class Front_VisualisationPresenter extends Front_BasePresenter
{
    /** @persistent */
    public $id;
    
    public function handleCleanVisualisation() {
        $visualisation = Environment::getSession('visualisation');
        
        $visualisation->remove();
        
        $this->invalidateControl('visualisation');
    }
    
    public function handleClear($wall) {
        $visualisation = Environment::getSession('visualisation');
        
        unset($visualisation->$wall);
        $this->redirect('this#choose');
    }
    
    public function renderDefault() {
        /*$this->template->collections = BaseModel::fetchAll('tag')
                                            ->where("tagGroup_id",Front_BasePresenter::TAG_KOLEKCE_ID)
                                            ->order("value");*/
        $ids = BaseModel::fetchAll("product_tag")
                                            ->where("tag.tagGroup_id",Front_BasePresenter::TAG_KOLEKCE_ID)
                                            ->where("product.active",1)->select("tag_id");
        $this->template->collections = BaseModel::fetchAll('tag')
                                            ->where("id",$ids)
                                            ->order("value");
        
        if($this->getParam('id')) {
            $this->template->products = BaseModel::fetchAll('product')->where("category_id", Front_BasePresenter::TAPETY_ID);

            $this->template->products->where("id", BaseModel::fetchAll('product_tag')->where("tag_id", $this->getParam('id'))->select("product_id"));
        }
    }

    /*public function handleCollection($id) {
        $this->template->products = BaseModel::fetchAll('product')->where("category_id", Front_BasePresenter::TAPETY_ID);

        $this->template->products->where("id", BaseModel::fetchAll('product_tag')->where("tag_id", $id)->select("product_id"));

        $this->invalidateControl('choose');
    }*/

    

}
