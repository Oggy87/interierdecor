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
class Admin_ShippingPresenter extends Admin_BasePresenter
{

    public function  startup() {
        parent::startup();

        $config = Environment::getConfig();
        dibi::connect($config->database);
    }
    
    public function handleEdit($id) {
        $unit = $this->fetchRow('shipping', $id);
        $this['editShippingForm']->setDefaults($unit);
        $this['editShippingForm']['id']->setValue($unit['id']);
        $this->invalidateControl('edit');
    }
    
    public function renderDefault(){
        $this->template->unitform = $this['shippingForm'];
        $this->template->editform = $this['editShippingForm'];
    }

    protected function createComponentShippingGrid($name) {
        $grid = new DataGrid($this,$name);
        
        $translator = new GettextTranslator(Environment::expand(APP_DIR.'/templates/grid.cs.mo'));
        $grid->setTranslator($translator);
     
        $grid->bindDataTable(dibi::dataSource('SELECT *
                        FROM shipping'));
        
        //nastaveni
        $grid->displayedItems = array(10, 20, 50);

        //sloupce
        $grid->addColumn('name', 'název');
        $grid->addColumn('price', 'cena');
        
        //filtry
        $grid['name']->addFilter();

        $grid['price']->formatCallback[] = 'Helpers::currencyKc';

        // povolí ukládání stavů komponenty do session
        $grid->rememberState = TRUE;

        // nastavíme klíč pro akce (a také i pro operace, o těch později)
        $grid->keyName = 'id';

        // přidáme sloupec pro akce (sloupců může být i více)
        $grid->addActionColumn('Akce');
        
        // a naplníme datagrid akcemi pomocí továrničky
        $grid->addAction('editovat', 'edit!', Html::el('span')->class('btn info')->setText("editovat"), $useAjax = TRUE,'id');
        $grid->addAction('smazat', 'confirmForm:confirmDelete!', Html::el('span')->class('btn danger')->setText("smazat"), $useAjax = TRUE);
        
        // nadefinujeme si operace, tyto hodnoty je možno nechat překládat translatorem
        $operations = array("delete" => "smazat");

        // poté callback(y), které mají operaci zpracovat
        $callback = array($this, 'gridOperationHandler'); // $this je presenter

        // povolíme operace
        $grid->allowOperations($operations, $callback);

        return $grid;
    }
    
    public function gridOperationHandler(SubmitButton $button)
    {
        $form = $button->getParent();
        $grid = $this->getComponent('shippingGrid');
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
        
        if($values['operations'] == 'delete') {
            foreach($keys as $id) {
                $this->delete($id);
            }
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
        $unit = $this->fetchRow('shipping', $params['id']);
        return sprintf('Chcete opravdu smazat metodu dopravy \'%s\'?', $unit['name']);
    }
    
    public function delete($id) {
        try {
            $unit = $this->fetchRow("shipping", $id);
            $unit->delete();
            
            $this->flashMessage("Způsob dopravy smazán.", "success");
            $this->invalidateControl("grid");
        } catch(PDOException $exc) {

                $this->flashMessage("Nepodařilo se způsob dopravy smazat.", "error");
                Debug::log($exc,Debug::ERROR);
  
        }
    }
    
    protected function createComponentShippingForm($name) {
        $form = new AppForm($this,$name);
        
        $form->addText('name', 'Název')
                ->setRequired("Vyplňte název způsobu dopravy.");
        
        $form->addText('price', "Cena")
                ->addRule(Form::FILLED, 'Vyplňte cenu.')
                ->addRule(Form::FLOAT, 'Cena musí být číslo.');
        
        $form->addSubmit('save', 'Uložit')->onClick[] = callback($this, 'saveShipping');
        //$form->getElementPrototype()->class = 'ajax';
        
        return $form;
    }
    
     protected function createComponentEditShippingForm($name) {

        $form = $this->createComponentShippingForm($name);
        $form->addHidden('id');

        return $form;
    }
    
    public function saveShipping($button) {
        $values = $button->getForm()->getValues();
        
        try {
            ShippingModel::save($values);
            $this->flashMessage("Způsob dopravy uložen.", "success");
            //if(!$this->isAjax()) 
            $this->redirect('this');
            //$this->invalidateControl("grid");
        } catch(PDOException $exc) {
            $this->flashMessage("Nastala chyba při ukládání způsobu dopravy.", "error");
            Debug::log($exc, Debug::ERROR);
        }
    }
    
}
