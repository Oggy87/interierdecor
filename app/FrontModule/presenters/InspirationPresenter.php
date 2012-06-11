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
class Front_InspirationPresenter extends Front_BasePresenter
{
   
    /** @persistent */
    public $category_id;
    /** @persistent */
    public $tagGroup_id;
    /** @persistent */
    public $tag_id;
    
    private $category;
    private $tagGroup;
    private $tag;

    
    protected function startup() {
        parent::startup();
        
        if($this->getParam('category_id')) {
            try {
                $this->category = $this->fetchRow('category', $this->getParam('category_id'));
            } catch (BadRequestException $exc) {
                throw new InvalidArgumentException("Kategorie neexistuje.");
            }
            if($this->getParam('tagGroup_id')) {
                try {
                    $this->tagGroup = $this->category->category_tagGroup()->where("tagGroup_id",$this->getParam('tagGroup_id'))->fetch()->tagGroup;
                } catch (BadRequestException $exc) {
                    throw new InvalidArgumentException("Skupina štítků neexistuje.");
                }
                if($this->getParam('tag_id')) {
                    try {
                        $this->tag = $this->tagGroup->tag()->where("id",$this->getParam('tag_id'))->fetch();
                    } catch (BadRequestException $exc) {
                        throw new InvalidArgumentException("Štítek neexistuje.");
                    }
                }
            }
        }
        if(!$this->category_id AND ($this->tagGroup_id OR $this->tag_id)) {
            $this->redirect('this',array('tagGroup_id'=>NULL,'tag_id'=>NULL));
        }
        elseif(!$this->tagGroup_id AND $this->tag_id) {
            $this->redirect('this',array('tag_id'=>NULL));
        } 
    }
    
    public function handleDetail($image_id) {
        $this->template->image = $this->fetchRow('image', $image_id);
       
        
        $this->invalidateControl('detail');
    }

    public function renderDefault() {
        $tagGroup_ids = BaseModel::fetchAll("image_tag")->select('tag.tagGroup_id')->group("tagGroup_id");
        
        $this->template->categories_tagGroup = BaseModel::fetchAll("category_tagGroup")->where("tagGroup_id",$tagGroup_ids)->where("category.active",1)->order('category.sort')->group('category.id');
        if($this->category_id)
            $this->template->category_tagGroups = BaseModel::fetchAll("category_tagGroup")->where("tagGroup_id",$tagGroup_ids)->where("category.active",1)->order("category_tagGroup.sort");
        if($this->tagGroup_id)
            $this->template->category_tagGroup = $this->fetchRow('category_tagGroup', array("category_id"=>$this->category['id'],"tagGroup_id"=>$this->tagGroup['id']));
            $this->template->image_tags = BaseModel::fetchAll("image_tag")->where('tag.tagGroup_id',$this->tagGroup['id'])->group("tag_id");
        
        $this->template->category = $this->category;
        $this->template->tagGroup = $this->tagGroup;
        $this->template->tag = $this->tag;
    } 
}
