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
class Admin_TagGroupPresenter extends Admin_BasePresenter
{

    /** @persistent */
    public $category_id;
    
    public function  startup() {
        parent::startup();

        $config = Environment::getConfig();
        dibi::connect($config->database);
        
        $this->category_id = $this->getParam('category_id');
        
    }
    
    public function actionEdit($id) {

        $tagGroup = $this->fetchRow('tagGroup', $id);
        if (!$tagGroup)
            throw new InvalidArgumentException("Skupina s id '$id' neexistuje.");

        if (!$this->category_id)
            throw new InvalidArgumentException("Je potřeba být v kategorii");
        
        $this->template->tagGroup = $tagGroup;
    }
    
    public function renderDefault() {
        if($this->getParam('category_id'))
            $this->template->category = $this->fetchRow('category', $this->category_id);
    }
    
    public function renderNew() {
       
        $this->template->form = $this['newTagGroup'];
    }
    
    public function renderEdit($id,$category_id) {
        $this->template->tagGroup = $this->fetchRow('tagGroup', $id);
        $this->template->category = $this->fetchRow('category', $category_id);
        $this->template->form = $this['editTagGroup'];
    }
    
    protected function createComponentNewTagGroup($name) {
        $form = new AppForm($this,$name);
        
        $categories = BaseModel::fetchPairs("category", "name");
        
        $category_tagGroup = $form->addContainer('category_tagGroup');
        $category_tagGroup->addSelect('category_id', 'Kategorie', $categories)
                ->skipFirst('Zvolte kategorii')
                ->setRequired("Vyberte kategorii.")
                ->setDefaultValue($this->getParam('category_id'));
        $category_tagGroup->addCheckbox('hp', 'Zobrazovat na úvodní straně kategorie?');
        $category_tagGroup->addText('sort', 'Pořadí:')
                ->addCondition(Form::FILLED)
                    ->addRule(Form::INTEGER,'Pořadí musí být číslo');
        
        $tagGroup = $form->addContainer('tagGroup');
        $tagGroup->addText('name', 'Název:')
                ->setRequired('Vyplňte název.');
        $tagGroup->addText('url_slug', 'url:')
                ->setRequired("Vyplňte url.");
        $tagGroup->addCheckbox('filter', 'Filtrovat podle této skupiny?');
        $tagGroup->addCheckbox('images', 'V detailu produktu jsou štítky z této skupiny vypisovány obrázky?');
        
        $form->addSubmit('send', 'Uložit')
                ->onClick[] = array($this, 'newTagGroupSubmit');
        $form->addSubmit('sendNext', 'Uložit a vytvořit další')
                ->onClick[] = array($this, 'newTagGroupSubmit');
        
        return $form;
    }
    
     public function newTagGroupSubmit($button) {
        $form = $button->getForm();
        $values = $form->getValues();
        try {
            $tagGroup = TagGroupModel::newTagGroup($values['tagGroup'],$values['category_tagGroup']);
           /* Environment::getCache()->clean(array(
                Cache::TAGS => array("tagGroups")
            ));*/
            $this->flashMessage('Skupina úspěšně uložena', 'success');
  
            if ($form['send']->isSubmittedBy()){

                    $this->redirect('default');

            }
            elseif ($form['sendNext']->isSubmittedBy()) {
                    $this->redirect('new');

            }
            
        } catch (PDOException $e) {
            if($e->errorInfo[1] == 1062) {
                if (strpos($e->getMessage(), $values['tagGroup']['url_slug'])) {
                    $form->addError("Skupina s touto URL již existuje, musíte zvolit jinou url. Je také možné že tuto skupinu již v databázi máte, editujte ji.");
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
    
    public function createComponentEditTagGroup($name) {

        $tagGroup = $this->fetchRow('tagGroup', $this->getParam('id'));

        $form = $this->createComponentNewTagGroup($name);
        $form['tagGroup']->addHidden('id');

        $form['tagGroup']->setDefaults($tagGroup);

        $form['category_tagGroup']->setDefaults($tagGroup->category_tagGroup()->where('category_id',$this->getParam('category_id'))->fetch());
       
        $form['category_tagGroup']['category_id']->controlPrototype->readonly = 'readonly';


        $form->removeComponent($form['sendNext']);
        $form->removeComponent($form['send']);
        
        $form->addSubmit('send', 'Uložit');
        $form->onSubmit[] = array($this, 'editSubmit');

        return $form;
    }
    
    public function editSubmit($button) {
        $form = $button->getForm();
        $values = $form->getValues();
        try {
            $tagGroup = TagGroupModel::editTagGroup($values['tagGroup'],$values['category_tagGroup']);
           /* Environment::getCache()->clean(array(
                Cache::TAGS => array("tagGroups")
            ));*/
            $this->flashMessage('Skupina úspěšně uložena', 'success');
  
            if ($form['send']->isSubmittedBy()){

                    $this->redirect('default');

            }
            elseif ($form['sendNext']->isSubmittedBy()) {
                    $this->redirect('new');

            }
            
        } catch (PDOException $e) {
            if($e->errorInfo[1] == 1062) {
                if (strpos($e->getMessage(), $values['tagGroup']['url_slug'])) {
                    $form->addError("Skupina s touto URL již existuje, musíte zvolit jinou url. Je také možné že tuto skupinu již v databázi máte, editujte ji.");
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
    
    protected function createComponentTagGroupesGrid($name) {
        $grid = new DataGrid($this,$name);
        
        $translator = new GettextTranslator(Environment::expand(APP_DIR.'/templates/grid.cs.mo'));
        $grid->setTranslator($translator);
     
        $grid->bindDataTable(dibi::dataSource('SELECT tagGroup.*,category_tagGroup.category_id, category_tagGroup.sort, category_tagGroup.hp
                        FROM tagGroup
                        LEFT JOIN category_tagGroup ON (tagGroup.id = category_tagGroup.tagGroup_id)
                        WHERE category_tagGroup.category_id = %i',  $this->getParam('category_id')));
        
        //nastaveni
        $grid->displayedItems = array(10, 20, 50);

        //sloupce
        $grid->addColumn('name', 'název');
        $grid->addColumn('sort', 'pořadí');
        
        $grid->addColumn('filter', 'filtrovat podle této skupiny?');
        $grid->addColumn('images', 'je obrázková?');

        $grid->addColumn('hp', 'na úvodní stránce kategorie?');
        //filtry

        $grid['name']->addFilter();
        $grid['sort']->addFilter();
        $grid['hp']->addSelectboxFilter(array( '0' => "Ne", '1' => "Ano"), TRUE);
        $grid['filter']->addSelectboxFilter(array( '0' => "Ne", '1' => "Ano"), TRUE);
        $grid['images']->addSelectboxFilter(array( '0' => "Ne", '1' => "Ano"), TRUE);

         //vychozi razeni
        $grid['sort']->addDefaultSorting('asc');
        // povolí ukládání stavů komponenty do session
        $grid->rememberState = TRUE;

        // nastavíme klíč pro akce (a také i pro operace, o těch později)
        $grid->keyName = 'id';

        // přidáme sloupec pro akce (sloupců může být i více)
        $grid->addActionColumn('Akce');
        
        // a naplníme datagrid akcemi pomocí továrničky
        $grid->addAction('štítky', 'Tag:', Html::el('span')->class('btn')->setText("štítky"), $useAjax = FALSE,'tagGroup_id');

        $grid->addAction('editovat', 'edit', Html::el('span')->class('btn info')->setText("editovat"), $useAjax = FALSE,'id');
        $grid->addAction('smazat', 'confirmForm:confirmDelete!', Html::el('span')->class('btn danger')->setText("smazat"), $useAjax = TRUE);
        
        // nadefinujeme si operace, tyto hodnoty je možno nechat překládat translatorem
        $operations = array('delete' => 'smazat',"filtrovat"=>array( 'filter0' => "Ne", 'filter1' => "Ano"),"obrázkový"=>array( 'images0' => "Ne", 'images1' => "Ano"));

        // poté callback(y), které mají operaci zpracovat
        $callback = array($this, 'gridOperationHandler'); // $this je presenter

        // povolíme operace
        $grid->allowOperations($operations, $callback);
        
        //replacement
        $el = Html::el('span');
        $grid['filter']->replacement['1'] = clone $el->class("ui-icon ui-icon-check")->title("Ano");
        $grid['filter']->replacement['0'] = clone $el->class("ui-icon ui-icon-closethick")->title("Ne");
        $grid['images']->replacement['1'] = clone $el->class("ui-icon ui-icon-check")->title("Ano");
        $grid['images']->replacement['0'] = clone $el->class("ui-icon ui-icon-closethick")->title("Ne");
        $grid['hp']->replacement['1'] = clone $el->class("ui-icon ui-icon-check")->title("Ano");
        $grid['hp']->replacement['0'] = clone $el->class("ui-icon ui-icon-closethick")->title("Ne");
        
        //styly
        $grid['filter']->getHeaderPrototype()->style('width: 120px');
        $grid['images']->getHeaderPrototype()->style('width: 120px');
        $grid['hp']->getHeaderPrototype()->style('width: 120px');
        
        return $grid;
    }
    
    public function gridOperationHandler(SubmitButton $button)
    {
        $form = $button->getParent();
        $grid = $this->getComponent('tagGroupesGrid');
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
                    $tagGroup = $this->fetchRow('tagGroup', $id);
                
                    $this->deleteTagGroup($tagGroup);
                    
                }
                
                break;
            case 'filter0':
                foreach($keys as $id) {
                    $this->filterTagGroup($id, 0);
                    
                }
                
                break;
           case 'filter1':
                foreach($keys as $id) {
                    $this->filterTagGroup($id, 1);
                    
                }
                
                break;
            case 'images0':
                foreach($keys as $id) {
                    $this->imagesTagGroup($id, 0);
                    
                }
                
                break;
           case 'images1':
                foreach($keys as $id) {
                    $this->imagesTagGroup($id, 1);
                    
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
        $tagGroup = $this->fetchRow('tagGroup', $params['id']);
        return sprintf('Chcete opravdu smazat skupinu \'%s\' a všechny její štítky?', $tagGroup['name']);
    }
    
    public function delete($id) {
         $tagGroup = $this->fetchRow('tagGroup', $id);
         $this->deleteTagGroup($tagGroup);
         if(!$this->isAjax())$this->redirect('default');
    }
    
    private function deleteTagGroup($tagGroup) {
        try {
           
            $tagGroup->delete();
            $this->flashMessage("Skupina štítků:".$tagGroup['name']." smazána.", 'success');
           /* Environment::getCache()->clean(array(
                Cache::TAGS => array("tagGroups")
            ));*/
            return true;
        } catch (PDOException $exc) {
            $this->flashMessage('Ajaj, nepovedlo se skupinu ' . $tagGroup['name'] . ' smazat.', 'error');
            Debug::log($exc, Debug::ERROR);
            
            return false;
            //if (!$this->isAjax()) $this->redirect('this');
        }
    }
    
    private function filterTagGroup($id,$filter) {
         try {
             $tagGroup = $this->fetchRow('tagGroup ', $id);
             $tagGroup['filter'] = $filter;
             
             $tagGroup->update();
            /* Environment::getCache()->clean(array(
                Cache::TAGS => array("tagGroups")
            ));*/
             
             $this->flashMessage('Změna filtrování podle skupiny '.$tagGroup['name'].' provedena','success');
         } catch (PDOException $exc) {
            $this->flashMessage('Ajaj, nepovedlo se.','error');
            Debug::log($exc, Debug::ERROR);
        }
    }
    
     private function imagesTagGroup($id,$images) {
         try {
             $tagGroup = $this->fetchRow('tagGroup ', $id);
             $tagGroup['images'] = $images;
             
             $tagGroup->update();
             /*Environment::getCache()->clean(array(
                Cache::TAGS => array("tagGroups")
            ));*/
             
             $this->flashMessage('Změna zobrazovaní obrázků skupiny '.$tagGroup['name'].' provedena','success');
         } catch (PDOException $exc) {
            $this->flashMessage('Ajaj, nepovedlo se.','error');
            Debug::log($exc, Debug::ERROR);
        }
    }
}
