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
class Admin_CategoriesPresenter extends Admin_BasePresenter
{

    public function  startup() {
        parent::startup();

        $config = Environment::getConfig();
        dibi::connect($config->database);
    }
        public function actionEdit($id) {

            $category = $this->fetchRow('category', $id);
            if(!$category) throw new InvalidArgumentException("Kategorie s id '$id' neexistuje.");

            $this->template->category = $category;

        }

        public function handleSort($items) {

            parse_str($items, $items);

            foreach($items['item'] as $position => $id) {
                CategoryModel::update($id, array('sort' => $position));
            }
           /* Environment::getCache()->clean(array(
                    Cache::TAGS => array("categories")
            ));*/

        }
        
        public function handleEdit($id) {
            $category = $this->fetchRow('category', $id);
            $this['editCategoryForm']->setDefaults($category);
            $this['editCategoryForm']['id']->setValue($category['id']);
            $this->invalidateControl('edit');
        }
        
        public function renderDefault() {
            $this->template->newForm = $this['newCategoryForm'];
            $this->template->editForm = $this['editCategoryForm'];
        }

        protected function createComponentNewCategoryForm($name) {
            $form = new AppForm($this, $name);

            $form->addText('name', 'Název kategorie:')
                    ->setRequired();
            $form->addText('url_slug','URL adresa:')
                    ->addRule(Form::MAX_LENGTH,'Maximální délka url je %d znaků',  60)
                    ->setRequired();
            
             $form->addText('sort', 'Pořadí:')
                ->addCondition(Form::FILLED)
                    ->addRule(Form::INTEGER,'Pořadí musí být číslo');
             
            $form->addCheckbox('active', 'Je tato kategorie aktivní?');
            
            $form['sort']->setDefaultValue(BaseModel::fetchAll("category")->max("sort") + 1);

            $form->addSubmit('save', 'Přidat novou')->onClick[] = array($this, 'saveClicked');

            $form->getElementPrototype()->class[] = "ajax form-stacked";

            return $form;
        }

        public function saveClicked($button) {
            $form = $button->getForm();
            $values = $form->getValues();

            try {
                CategoryModel::insert($values);
                /*Environment::getCache()->clean(array(
                    Cache::TAGS => array("categories")
                ));*/
                $this->redirect('this');

            } catch (PDOException $e) {
                if($e->errorInfo[1] == 1062) {
                    if (strpos($e->getMessage(), $values['name'])) {
                        $form->addError("Kategorie s tímto jménem již existuje");
                    }
                    elseif (strpos($e->getMessage(), $values['url_slug'])) {
                        $form->addError("Kategorie s touto URL již existuje");
                    }
                }
                else {
                    
                    Debug::log($e->getMessage());
                }
                $this->invalidateControl('errorsnew');
            }
        }

        protected function createComponentEditCategoryForm($name) {
            $form = $this->createComponentNewCategoryForm($name);
        
            $form->addHidden('id');

            $form->removeComponent($form['save']);

            $form->addSubmit('update', 'Uložit')->onClick[] = array($this, 'updateClicked');

            //$form->getElementPrototype()->class[] = "ajax";

            return $form;

        }
        
        public function updateClicked($button) {
            $form = $button->getForm();
            $values = $form->getValues();
            
            try {
                $category = $this->fetchRow("category", $values['id']);
                unset($values['id']);
                $category->update((array)$values);
                /*Environment::getCache()->clean(array(
                    Cache::TAGS => array("categories")
                ));*/
                $this->redirect('this');

            } catch (PDOException $e) {
                if($e->errorInfo[1] == 1062) {
                    if (strpos($e->getMessage(), $values['name'])) {
                        $form->addError("Kategorie s tímto jménem již existuje");
                    }
                    elseif (strpos($e->getMessage(), $values['url_slug'])) {
                        $form->addError("Kategorie s touto URL již existuje");
                    }
                }
                else {
                    
                    Debug::log($e->getMessage());
                }
                $this->invalidateControl('errorsedit');
            }
        }
        
        protected function createComponentCategoriesGrid($name) {
        $grid = new DataGrid($this,$name);
        
        $translator = new GettextTranslator(Environment::expand(APP_DIR.'/templates/grid.cs.mo'));
        $grid->setTranslator($translator);
     
        $grid->bindDataTable(dibi::dataSource('SELECT *
                        FROM category'));
        
        //nastaveni
        $grid->displayedItems = array(10, 20, 50);

        //sloupce
        $grid->addColumn('name', 'název');
        $grid->addColumn('sort', 'pořadí');
        $grid->addColumn('active', 'aktivní');
        
        //filtry
        $grid['name']->addFilter();
        $grid['sort']->addFilter();
        $grid['active']->addSelectboxFilter(array( '0' => "Ne", '1' => "Ano"), TRUE);
        
         //vychozi razeni
        $grid['sort']->addDefaultSorting('asc');

        // povolí ukládání stavů komponenty do session
        $grid->rememberState = TRUE;

        // nastavíme klíč pro akce (a také i pro operace, o těch později)
        $grid->keyName = 'id';

        // přidáme sloupec pro akce (sloupců může být i více)
        $grid->addActionColumn('Akce');
        
        // a naplníme datagrid akcemi pomocí továrničky
        $grid->addAction('skupiny štítíků', 'TagGroup:', Html::el('span')->class('btn')->setText("skupiny štítků"), $useAjax = FALSE,'category_id');
        $grid->addAction('produkty', 'Product:', Html::el('span')->class('btn')->setText("produkty"), $useAjax = FALSE,'category_id');

        $grid->addAction('editovat', 'edit!', Html::el('span')->class('btn info')->setText("editovat"), $useAjax = TRUE,'id');
        $grid->addAction('smazat', 'confirmForm:confirmDelete!', Html::el('span')->class('btn danger')->setText("smazat"), $useAjax = TRUE);
        
        // nadefinujeme si operace, tyto hodnoty je možno nechat překládat translatorem
        $operations = array('delete' => 'smazat',"aktivní"=>array( 'active0' => "Ne", 'active1' => "Ano"));

        // poté callback(y), které mají operaci zpracovat
        $callback = array($this, 'gridOperationHandler'); // $this je presenter

        // povolíme operace
        $grid->allowOperations($operations, $callback);
        
        //replacement
        $el = Html::el('span');
        $grid['active']->replacement['1'] = clone $el->class("ui-icon ui-icon-check")->title("Ano");
        $grid['active']->replacement['0'] = clone $el->class("ui-icon ui-icon-closethick")->title("Ne");
        
        return $grid;
    }
    
     public function gridOperationHandler(SubmitButton $button)
    {
        $form = $button->getParent();
        $grid = $this->getComponent('categoriesGrid');
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
                    $category = $this->fetchRow("category", $id);
                    $this->deleteCategory($category);
                    
                }
                
                break;
            case 'active0':
                foreach($keys as $id) {
                    $this->activeCategory($id, 0);
                    
                }
                
                break;
           case 'active1':
                foreach($keys as $id) {
                    $this->activeCategory($id, 1);
                    
                }
                
                break;
            
            default:
                break;
        }

        $this->invalidateControl('grid');

        // $this může být v kontextu komponenta i presenter
        if (!Environment::getHttpRequest()->isAjax()) $this->redirect('this');
    
    }

        protected function createComponentConfirmForm() {
            $form = new ConfirmationDialog();

            $form->getFormButton('yes')->caption = 'Ano';
            $form->getFormButton('no')->caption = 'Ne';

            $form->getFormButton('yes')->getControlPrototype()->class('btn primary');
            $form->getFormButton('no')->getControlPrototype()->class('btn');

            $form->addConfirmer(
                'delete', // název signálu bude 'confirmDelete!'
                array($this, 'delete'),
                array($this, 'questionDelete')
            );

            return $form;
        }

        public function questionDelete($dialog, $params) {
            $category = $this->fetchRow("category", $params['id']);
            return sprintf('Chcete opravdu smazat kategorii \'%s\' a všechny produkty z této kategorie?', $category['name']);
        }

        public function delete($id, $dialog) {
            $category = $this->fetchRow("category", $id);
            $this->deleteCategory($category);
            
            if (!$this->isAjax()) $this->redirect('this');

                $this->invalidateControl('categories');
           
        }
        
        private function deleteCategory($category) {
        try {
           
            $category->delete();
            $this->flashMessage("Kategorie ".$category['name']." smazána.", 'success');
            /*Environment::getCache()->clean(array(
                Cache::TAGS => array("products,tagGroups,categories")
            ));*/
            return true;
        } catch (PDOException $exc) {
            $this->flashMessage('Ajaj, nepovedlo se kategorii ' . $category['name'] . ' smazat.', 'error');
            Debug::log($exc, Debug::ERROR);
            
            return false;
            //if (!$this->isAjax()) $this->redirect('this');
        }
        }
        
        private function activeCategory($id,$active) {
         try {
             $category = $this->fetchRow('category ', $id);
             $category['active'] = $active;
             
             $category->update();
            /* Environment::getCache()->clean(array(
                Cache::TAGS => array("categories")
             ));*/
             
             $this->flashMessage('Změna stavu kategorie '.$category['name'].' provedena','success');
         } catch (PDOException $exc) {
            $this->flashMessage('Ajaj, nepovedlo se.','error');
            Debug::log($exc, Debug::ERROR);
        }
    
    }
}
