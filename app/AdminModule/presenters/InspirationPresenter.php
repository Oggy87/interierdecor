<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */



/**
 * Sign in/out presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class Admin_InspirationPresenter extends Admin_BasePresenter
{

    public function actionDetail($id) {
        try {
            $this->template->image = $this->fetchRow("image", $id);
        } catch (BadRequestException $exc) {
            throw new InvalidArgumentException("Obrázek neexistuje.");
        }
    }
    
    public function handleDelete($id) {
        $image = $this->fetchRow("image", $id);

        try {
            $image_path = $image['image_path'];
            
            /*Environment::getCache()->clean(array(
                Cache::TAGS => array("images")
            ));*/
            foreach($image->image_product() as $image_product) {
               /* Environment::getCache()->clean(array(
                    Cache::TAGS => array("product/$image_product[product_id]")
                ));*/
            }
            
            $image->delete();
            //smazat stavajici obrazek
            @unlink(WWW_DIR.'/static/'.$image_path);
            // Remove old  photos files
            Helpers::removeTempImages($image_path);
            //nahrat novy obrazek
        } catch (PDOException $e) {
            $this->flashMessage('Nepodařilo se obrázek smazat.', 'error');
            Debug::log($e, Debug::ERROR);
        }
        
        $this->redirect('default');
    }
    
    public function handleAddTag($tag_id) {
        try {
            $this->template->image->image_tag()->insert(array('tag_id'=>$tag_id));
            $this->flashMessage("Štítek přidán", 'success');
           /* Environment::getCache()->clean(array(
                Cache::TAGS => array("images")
            ));*/
        } catch(PDOException $exc) {
             if($exc->errorInfo[1] == 1062) {
                $this->flashMessage("Obrázek již tento štítek má", 'info');
            }
            else {
                $this->flashMessage("Nepodařilo se štítek přidat", 'error');
                Debug::log($exc, Debug::ERROR);
            }
            
        }
        if(!$this->isAjax()) 
            $this->redirect ('this');
        
        $this->invalidateControl('tags');
    }
    
    public function handleRemoveTag($tag_id) {
        try {
            $image_tag = $this->template->image->image_tag()->where('tag_id',$tag_id);
            $image_tag->delete();
            /*Environment::getCache()->clean(array(
                Cache::TAGS => array("images")
            ));*/
            $this->flashMessage("Štítek odebrán", 'success');
        } catch(PDOException $exc) {
            
            $this->flashMessage("Nepodařilo se štítek odebrat", 'error');
            Debug::log($exc, Debug::ERROR);
        }
        if(!$this->isAjax()) 
            $this->redirect ('this');
        
        $this->invalidateControl('tags');
    }
    
    public function handleAddProduct($product_id) {
        try {
            $this->template->image->image_product()->insert(array('product_id'=>$product_id));
            $this->flashMessage("Produkt přidán", 'success');
           /* Environment::getCache()->clean(array(
                Cache::TAGS => array("images","product/".$product_id)
            ));*/
        } catch(PDOException $exc) {
             if($exc->errorInfo[1] == 1062) {
                $this->flashMessage("Obrázek již tento produkt má", 'info');
            }
            else {
                $this->flashMessage("Nepodařilo se produtk přidat", 'error');
                Debug::log($exc, Debug::ERROR);
            }
            
        }
        if(!$this->isAjax()) 
            $this->redirect ('this');
        
        $this->invalidateControl('products');
    }
    
    public function handleRemoveProduct($product_id) {
        try {
            $image_product = $this->template->image->image_product()->where('product_id',$product_id);
            $image_product->delete();
            /*Environment::getCache()->clean(array(
                Cache::TAGS => array("images","product/".$product_id)
            ));*/
            $this->flashMessage("Produkt odebrán", 'success');
        } catch(PDOException $exc) {
            
            $this->flashMessage("Nepodařilo se produkt odebrat", 'error');
            Debug::log($exc, Debug::ERROR);
        }
        if(!$this->isAjax()) 
            $this->redirect ('this');
        
        $this->invalidateControl('products');
    }
    
    public function renderDefault() {
        $this->template->images = BaseModel::fetchAll('image');
        if($this->getParam('tag_id')) {
            if($this->getParam('tag_id') != 'without') {
                $ids = BaseModel::fetchAll('image_tag')->where('tag_id',$this->getParam('tag_id'))->select('image_id');
                $this->template->images->where('id',$ids);

                $this->template->tag = $this->fetchRow('tag', $this->getParam('tag_id'));
            }
            else {
                $ids = BaseModel::fetchAll('image_tag')->select('image_id');
                $this->template->images->where('NOT id',$ids);
            }
        }
        
        $paginator = $this['stranka']->getPaginator();
        $paginator->itemCount = $this->template->images->count('*');
        $this->template->images->limit($paginator->itemsPerPage, $paginator->offset);            
    }
    
    public function renderDetail($id) {
        $this->template->tagGroup_ids = BaseModel::fetchAll('image_tag')->where('image_id',$id)->group('tag.tagGroup_id')->select('tag.tagGroup_id');
        $this->template->category_tagGroups = BaseModel::fetchAll("category_tagGroup")->where('tagGroup_id',$this->template->tagGroup_ids)->group('category_id');
        
        
        $this->template->image_tags = BaseModel::fetchAll('image_tag')->where('image_id',$id);
    }
    
    public function renderUpload() {
        $this->template->form = $this['images'];
    }
    
    protected function createComponentImages($name) {
        $form = new AppForm($this, $name);
        
        $form->addSubmit('send', 'Uložit');
        $form->onSubmit[] = array($this, 'imagesSubmit');

        return $form;
    }
    
    public function imagesSubmit($form) {
        $values = $form->getValues();
        if(isset($_POST['flash_uploader']))
            $values['flash_uploader'] = $_POST['flash_uploader'];

        try {
            ImageModel::insert($values);

            $this->flashMessage('Obrázky uloženy.', 'success');
  
            $this->redirect('default',array('tag_id'=>'without'));
            
        } catch (PDOException $e) {

            $form->addError('Nastala chyba při ukládání do databáze.');
            
            $this->invalidateControl('formerrors');
            Debug::log($e, Debug::ERROR);
        }

    }

    protected function createComponentSearchForm() {
        $form = new AppForm($this,'searchForm');
        
        $form->addText('text')
                ->addRule(AppForm::FILLED,"Zadejte co chcete hledat.");

        $form->addSubmit("search","hledat v produktech");
        $form->onSubmit[] = array($this, 'searchFormSubmitted');
        
        $form->getElementPrototype()->class('ajax');
        return $form;
    }
    
    public function searchFormSubmitted($form) {
        $values = $form->getValues();
        $this->template->products = BaseModel::fetchAll('product')->where("active",1)
                                                ->where("LOWER(name) LIKE LOWER(?)",'%'.$values['text'].'%');
        
        $this->invalidateControl('search');
    }
    

    protected function createComponentStranka($name) {
        $vp = new VisualPaginator();
        $vp->paginator->itemsPerPage = 35;

        return $vp;
    }
    
    protected function createComponentUpload($name) {
        $multiUpload = new MultiUpload();

        return $multiUpload;
    }
    
}
