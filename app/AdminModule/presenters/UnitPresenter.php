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
class Admin_UnitPresenter extends Admin_BasePresenter
{

    public function  startup() {
        parent::startup();

        $config = Environment::getConfig();
        dibi::connect($config->database);
    }
    
    public function handleEdit($id) {
        $unit = $this->fetchRow('unit', $id);
        $this['editUnitForm']->setDefaults($unit);
        $this['editUnitForm']['id']->setValue($unit['id']);
        $this->invalidateControl('edit');
    }
    
    public function renderDefault(){
        $this->template->unitform = $this['unitForm'];
        $this->template->editform = $this['editUnitForm'];
    }

    protected function createComponentUnitsGrid($name) {
        $grid = new DataGrid($this,$name);
        
        $translator = new GettextTranslator(Environment::expand(APP_DIR.'/templates/grid.cs.mo'));
        $grid->setTranslator($translator);
     
        $grid->bindDataTable(dibi::dataSource('SELECT *
                        FROM unit'));
        
        //nastaveni
        $grid->displayedItems = array(10, 20, 50);

        //sloupce
        $grid->addColumn('name', 'název');
        $grid->addColumn('deci', 'desetinný');
        
        //filtry
        $grid['name']->addFilter();
        $grid['deci']->addSelectboxFilter(array( '0' => "Ne", '1' => "Ano"), TRUE);

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
        
        //replacement
        $el = Html::el('span');
        $grid['deci']->replacement['1'] = clone $el->class("ui-icon ui-icon-check")->title("Ano");
        $grid['deci']->replacement['0'] = clone $el->class("ui-icon ui-icon-closethick")->title("Ne");
        
        return $grid;
    }
    
    public function gridOperationHandler(SubmitButton $button)
    {
        $form = $button->getParent();
        $grid = $this->getComponent('unitsGrid');
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
        $unit = $this->fetchRow('unit', $params['id']);
        return sprintf('Chcete opravdu smazat jednotku \'%s\'?', $unit['name']);
    }
    
    public function delete($id) {
        try {
            $unit = $this->fetchRow("unit", $id);
            $unit->delete();
            
            $this->flashMessage("Jednotka smazána.", "success");
            $this->invalidateControl("grid");
        } catch(PDOException $exc) {
            if($exc->errorInfo[1] == 1451) {
                $this->flashMessage("Jednotku nelze smazat, je používána v některých produktech.", "error");
            }
            else {
                $this->flashMessage("Nepodařilo se jednotku smazat.", "error");
                Debug::log($exc,Debug::ERROR);
            }
            
        }
    }
    
    protected function createComponentUnitForm($name) {
        $form = new AppForm($this,$name);
        
        $form->addText('name', 'Název')
                ->setRequired("Vyplňte název jednotky.");
        
        $form->addSelect('deci', "Desetinný", array(0=>'ne',1=>'ano'));
        
        $form->addSubmit('save', 'Uložit')->onClick[] = callback($this, 'saveUnit');
        //$form->getElementPrototype()->class = 'ajax';
        
        return $form;
    }
    
     protected function createComponentEditUnitForm($name) {

        $form = $this->createComponentUnitForm($name);
        $form->addHidden('id');

        return $form;
    }
    
    public function saveUnit($button) {
        $values = $button->getForm()->getValues();
        
        try {
            UnitModel::save($values);
            $this->flashMessage("Jednotka uložena.", "success");
            //if(!$this->isAjax()) 
            $this->redirect('this');
            //$this->invalidateControl("grid");
        } catch(PDOException $exc) {
            $this->flashMessage("Nastala chyba při ukládání jednotky.", "error");
            Debug::log($exc, Debug::ERROR);
        }
    }
    
}
