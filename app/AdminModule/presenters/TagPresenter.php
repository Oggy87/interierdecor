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
class Admin_TagPresenter extends Admin_BasePresenter
{

    /** @persistent */
    public $tagGroup_id;
    
    public function  startup() {
        parent::startup();

        $config = Environment::getConfig();
        dibi::connect($config->database);
        
        $this->tagGroup_id = $this->getParam('tagGroup_id');
        /*if(!$this->tagGroup_id) {
            $this->flashMessage("Vyberte z které skupiny štítků chcete štítky editovat.", "error");
            $this->redirect('TagGroup:');
        }*/
        
    }
    
     public function handleTagThumb($tmpname) {
        
        $file = Helpers::thumb('/../temp/plupload/'.$tmpname, NULL, 67);
        
        $this->template->image = $file;

        $this->invalidateControl('image');
    }
    
    public function handleDeleteImage($id) {
        $tag = $this->fetchRow("tag", $id);

        try {            
            //smazat stavajici obrazek
            @unlink(WWW_DIR.'/static/'.$tag['picture_path']);
            // Remove old  photos files
            Helpers::removeTempImages($tag['picture_path']);
            $tag['picture_path'] = NULL;
            $tag->update();
            
            /*Environment::getCache()->clean(array(
                Cache::TAGS => array("tag", "products")
            ));*/
        } catch (PDOException $e) {
            $this->flashMessage('Nepodařilo se obrázek smazat.', 'error');
            Debug::log($e, Debug::ERROR);
        }
        
        $this->redirect('this');
    }
    
    public function renderDefault() {
        if($this->getParam('tagGroup_id'))
            $this->template->tagGroup = $this->fetchRow('tagGroup', $this->tagGroup_id);
    }
    
    public function renderNew() {
        $this->template->tagGroup = $this->fetchRow('tagGroup', $this->tagGroup_id);
        
        $this->template->form = $this['newTag'];
    }
    
     public function renderEdit($id) {
        $this->template->form = $this['editTag'];
        
        try {
            $this->template->tag = $this->fetchRow('tag', $id);
        }
        catch (BadRequestException $exc) {
            throw new InvalidArgumentException("Štítek neexistuje.");
        }

        //thumb product
        if(!isset($this->template->image) AND $this->template->tag['picture_path']) {
            $this->template->form['image']['tmpname']->setDefaultValue($this->template->tag['picture_path']);

            $file = Helpers::thumb('/static/'.$this->template->tag['picture_path'], NULL, 67);
            
            $this->template->image = $file;
        }
        
    }
    
    protected function createComponentNewTag($name) {
        $form = new AppForm($this,$name);

        $tag = $form->addContainer('tag');
        $tag ->addHidden('tagGroup_id')->setValue($this->getParam('tagGroup_id'));

        $tag ->addText('value', 'Hodnota:')
                ->setRequired('Vyplňte název.');
        $tag ->addText('url_slug', 'url:')
                ->setRequired("Vyplňte url.");

        $image = $form->addContainer('image');
        $image->addHidden('name');
        $image->addHidden('tmpname');
        
        $form->addSubmit('send', 'Uložit')
                ->onClick[] = array($this, 'newTagSubmit');
        $form->addSubmit('sendNext', 'Uložit a vytvořit další')
                ->onClick[] = array($this, 'newTagSubmit');
        
        return $form;
    }
    
    protected function createComponentUpload($name) {
        $multiUpload = new MultiUpload();

        return $multiUpload;
    }
    
     public function newTagSubmit($button) {
        $form = $button->getForm();
        $values = $form->getValues();
        try {
            $tag = TagModel::save($values);
           /* Environment::getCache()->clean(array(
                Cache::TAGS => array("tag")
            ));*/
            $this->flashMessage('Štítek úspěšně uložen', 'success');
  
            if ($form['send']->isSubmittedBy()){
                $this->redirect('default');
            }
            elseif ($form['sendNext']->isSubmittedBy()) {
                $this->redirect('new');
            }
            
        } catch (PDOException $e) {
            if($e->errorInfo[1] == 1062) {
                if (strpos($e->getMessage(), $values['tag']['url_slug'])) {
                    $form->addError("Štítek s touto URL již existuje, musíte zvolit jinou url. Je také možné že tento štítek již v databázi máte.");
                    //TODO odkaz na hledání toho starého produktu !
                }
            }
            else {
                $form->addError('Nastala chyba při ukládání do databáze.');
            }
            $this->invalidateControl('formerrors');
            Debug::log($e, Debug::ERROR);
        }

    }
    
    public function createComponentEditTag($name) {

        $tag = $this->fetchRow('tag', $this->getParam('id'));

        $form = $this->createComponentNewTag($name);
        $form['tag']->addHidden('id');

        $form['tag']->setDefaults($tag);       

        $form->removeComponent($form['sendNext']);
        $form->removeComponent($form['send']);
        
        $form->addSubmit('send', 'Uložit');
        $form->onSubmit[] = array($this, 'editSubmit');

        return $form;
    }
    
    public function editSubmit($form) {

        $values = $form->getValues();

        try {
            TagModel::edit($values);

           /* Environment::getCache()->clean(array(
                Cache::TAGS => array("products", "tag")
            ));*/
            $this->flashMessage('Změny byly uloženy.', 'success');
  
            $this->redirect('this');
            
        } catch (PDOException $e) {
            if($e->errorInfo[1] == 1062) {
                if (strpos($e->getMessage(), $values['tag']['url_slug'])) {
                    $form->addError("Štítek s touto URL již existuje, musíte zvolit jinou url.");
                    //TODO odkaz na hledání toho starého produktu !
                }
            }
            else {
                $form->addError('Nastala chyba při ukládání do databáze.');
            }
            $this->invalidateControl('formerrors');
            Debug::log($e, Debug::ERROR);
        }

    }
    
    protected function createComponentTagsGrid($name) {
        $grid = new DataGrid($this,$name);
        
        $translator = new GettextTranslator(Environment::expand(APP_DIR.'/templates/grid.cs.mo'));
        $grid->setTranslator($translator);
     
        $grid->bindDataTable(dibi::dataSource('SELECT *
                        FROM tag
                        WHERE tagGroup_id = %i',  $this->getParam('tagGroup_id')));
        
        //nastaveni
        $grid->displayedItems = array(10, 20, 50);

        //sloupce
        $grid->addColumn('value', 'hodnota');
        
        $grid->addColumn('picture_path', 'obrázek');


        $grid['picture_path']->formatCallback[] = 'Helpers::tagImage';
        //filtry

        $grid['value']->addFilter();

         //vychozi razeni
        $grid['value']->addDefaultSorting('asc');
        // povolí ukládání stavů komponenty do session
        $grid->rememberState = TRUE;

        // nastavíme klíč pro akce (a také i pro operace, o těch později)
        $grid->keyName = 'id';

        // přidáme sloupec pro akce (sloupců může být i více)
        $grid->addActionColumn('Akce');
        
        // a naplníme datagrid akcemi pomocí továrničky
        $grid->addAction('editovat', 'edit', Html::el('span')->class('btn info')->setText("editovat"), $useAjax = FALSE,'id');
        $grid->addAction('smazat', 'confirmForm:confirmDelete!', Html::el('span')->class('btn danger')->setText("smazat"), $useAjax = TRUE);
        
        // nadefinujeme si operace, tyto hodnoty je možno nechat překládat translatorem
        $operations = array('delete' => 'smazat');

        // poté callback(y), které mají operaci zpracovat
        $callback = array($this, 'gridOperationHandler'); // $this je presenter

        // povolíme operace
        $grid->allowOperations($operations, $callback);
        
        return $grid;
    }
    
    public function gridOperationHandler(SubmitButton $button)
    {
        $form = $button->getParent();
        $grid = $this->getComponent('tagsGrid');
        $values = $form->getValues();

        // ... provedeme zpracování operace
        // název operace získáme z $values['operations']
        // a zda-li byl checkbox zaškrtnut zjistíme přes $values['checker'][123] => bool(TRUE)
        $keys = array();
        foreach($values['checker'] as $key => $value) {
            if($value) {
                array_push($keys, $key);    
            }
        }
        
        switch ($values['operations']) {
            case 'delete':
                foreach($keys as $id) {
                    $tag = $this->fetchRow('tag', $id);
                
                    $this->deleteTag($tag);
                    
                }
                
                break;
           
            default:
                break;
        }

        $this->invalidateControl('grid');

        // $this může být v kontextu komponenta i presenter
        if (!Environment::getHttpRequest()->isAjax()) $this->redirect('this');
    
    }
    
    //CONFIRMATION DIALOG
    public function createComponentConfirmForm()
    {
        $form = new ConfirmationDialog();
        //$form->getFormElementPrototype()->addClass('ajax');

        $form->getFormButton('yes')->caption = 'Ano';
        $form->getFormButton('no')->caption = 'Ne';
        
        $form->getFormButton('yes')->getControlPrototype()->class('btn primary');
        $form->getFormButton('no')->getControlPrototype()->class('btn');

        $form->addConfirmer(
                'delete',
                array($this, 'delete'),
                array($this, 'questionDelete')

        );

        return $form;
    }
    
    public function questionDelete($dialog, $params) {
        $tag = $this->fetchRow('tag', $params['id']);
        return sprintf('Chcete opravdu smazat štítek \'%s\'?', $tag['value']);
    }
    
    public function delete($id) {
         $tag = $this->fetchRow('tag', $id);
         $this->deleteTag($tag);
         if(!$this->isAjax())$this->redirect('default');
    }
    
    private function deleteTag($tag) {
        try {
            
            //smazat temp perex obrazky
            $temp = WWW_DIR.'/static/temp/';
            if($tag['picture_path']) {
                list($name, $suffix) = explode('.',$tag['picture_path'],2);
                foreach (Finder::findFiles(basename($name).'_*.*')->in($temp) as $key => $file) {
                        @unlink($key);
                }
            }
            
            $delete = $tag->delete();
            
             if ($delete) {
                if($tag['picture_path']) @unlink( WWW_DIR.'/static/'.$tag['picture_path']);
                //jestlise nezmazeDebug::log('Je potřeba smazat ručně obrázek '.$tag['picture_path'], Debug::WARNING);
            }
            
            $this->flashMessage("Štítek:".$tag['value']." smazán.", 'success');
            
           /* Environment::getCache()->clean(array(
                Cache::TAGS => array("tagGroups","tag")
            ));*/
            return true;
        } catch (PDOException $exc) {
            $this->flashMessage('Ajaj, nepovedlo se štítek ' . $tag['value'] . ' smazat.', 'error');
            Debug::log($exc, Debug::ERROR);
            
            return false;
            //if (!$this->isAjax()) $this->redirect('this');
        }
    }
    
    
}
