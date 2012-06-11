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
class Admin_OrdersPresenter extends Admin_BasePresenter
{

    public function  startup() {
        parent::startup();

        $config = Environment::getConfig();
        dibi::connect($config->database);
    }
    
    public function handleRemoveItem($product_id) {
        $saleProduct = $this->fetchRow('saleProduct', array('sale_id'=>$this->getParam('id'),'product_id'=>$product_id));
        $total = $saleProduct['total'];
        $saleProduct->delete();
        
        $total = $saleProduct->sale['total'] - $total;
        $saleProduct->sale->update(array('total'=>$total));
        
        $this->invalidateControl('products');
    }
    
    public function handleRemoveDiscount($saleDiscount_id) {
        $saleDiscount = $this->fetchRow('saleDiscount',$saleDiscount_id);
        
        $saleDiscount->sale['total'] = $saleDiscount->sale->saleProduct()->aggregation("SUM(total)") + $saleDiscount->sale['shippingPrice'] +  $saleDiscount->sale['paymethodPrice'] ;
        $saleDiscount->sale->update();   
        
        $saleDiscount->delete();
        
        $this->invalidateControl('products');
    }
    
    public function handleChangeAmount($product_id,$amount) {
        $saleProduct = $this->fetchRow('saleProduct', array('sale_id'=>$this->getParam('id'),'product_id'=>$product_id));
        $total = (int)$amount * $saleProduct['priceDPH'];
        $saleProduct->update(array('amount'=>(int)$amount,'total'=> $total));

        //$total = $total + $saleProduct->sale['shippingPrice'];
        if((int)$amount > (int)$saleProduct['amount']) {
            $saleProduct->sale->update(array('total'=> new NotORM_Literal("total + $saleProduct[priceDPH]") ));
        }
        elseif((int)$amount < (int)$saleProduct['amount']) {
            $saleProduct->sale->update(array('total'=> new NotORM_Literal("total - $saleProduct[priceDPH]") ));
        }
        $this->invalidateControl('products');
    }
    
    public function renderDetail($id) {
        $this->template->sale = $this->fetchRow("sale", $id);
        $this->template->products = $this->template->sale->saleProduct();
        $this->template->saleDiscount = $this->template->sale->saleDiscount()->where('saleProduct_id', NULL)->fetch();
        
        $this->template->changeStateForm = $this['changeStateForm'];
        $this->template->addItemForm = $this['addItemForm'];
        $this->template->discountForm = $this['discountForm'];
    }
    
    protected function createComponentOrdersGrid($name) {
        $grid = new DataGrid($this,$name);
        
        $translator = new GettextTranslator(Environment::expand(APP_DIR.'/templates/grid.cs.mo'));
        $grid->setTranslator($translator);
     
        $grid->bindDataTable(dibi::dataSource('SELECT sale.id, created, sale.name, shipping, paymethod, total, state.name AS state, state_id, invoice.number AS invoice
                        FROM sale
                        LEFT JOIN state ON (sale.state_id = state.id)
                        LEFT JOIN invoice ON (sale.invoice_id = invoice.id)'));
        
        //nastaveni
        $grid->displayedItems = array(10, 20, 50);

        //sloupce
        $grid->addColumn('id', 'č. obj.');
        $grid->addDateColumn('created', 'odeslána','%d.%m.%Y %H:%M:%S');
        $grid->addColumn('name', 'zákazník');
        $grid->addColumn('shipping', 'doprava');
        $grid->addColumn('paymethod', 'způsob platby');
        $grid->addColumn('total', 'cena');
        $grid->addColumn('state', 'stav');
        $grid->addColumn('invoice', 'faktura');

        //
        $grid['total']->formatCallback[] = 'Helpers::currencyKc';
        
        //filtry
        $grid['id']->addFilter();
        $grid['shipping']->addSelectboxFilter(BaseModel::fetchPairs("shipping", "name"));
        $grid['paymethod']->addSelectboxFilter(BaseModel::fetchPairs("paymethod", "name"));
        $grid['total']->addFilter();
        $grid['name']->addFilter();
        $grid['state']->addSelectboxFilter(BaseModel::fetchPairs("state", "name"));
        $grid['invoice']->addFilter();

         //vychozi razeni
        $grid['created']->addDefaultSorting('desc');
        // povolí ukládání stavů komponenty do session
        $grid->rememberState = TRUE;

        // nastavíme klíč pro akce (a také i pro operace, o těch později)
        $grid->keyName = 'id';

        // přidáme sloupec pro akce (sloupců může být i více)
        $grid->addActionColumn('Akce');
        
        // a naplníme datagrid akcemi pomocí továrničky
        $grid->addAction('detail', 'detail', Html::el('span')->class('btn info')->setText("detail"), $useAjax = FALSE,'id');
        $grid->addAction('invoice', 'Export:invoice', Html::el('span')->class('btn')->setText("faktura"), $useAjax = FALSE,'id');
        
        // nadefinujeme si operace, tyto hodnoty je možno nechat překládat translatorem
        $operations = array("změnit stav"=>BaseModel::fetchPairs("state", "name"));

        // poté callback(y), které mají operaci zpracovat
        $callback = array($this, 'gridOperationHandler'); // $this je presenter

        // povolíme operace
        $grid->allowOperations($operations, $callback);
        
        //
        $renderer = $grid->getRenderer();
        $renderer->onRowRender[] = array($this, 'gridOnRowRendered');
        
        $grid['state']->replacement['new'] = 'k vyřízení';
        $grid['state']->replacement['waiting'] = 'čeká na platbu';
        $grid['state']->replacement['send'] = 'odeslaná';
        $grid['state']->replacement['canceled'] = 'zrušená';
        
        //styly
        $grid['shipping']->getHeaderPrototype()->style('width: 90px');
        $grid['paymethod']->getHeaderPrototype()->style('width: 90px');
        
        return $grid;
    }
    
    public function gridOnRowRendered(Html $row, DibiRow $data)
    {
        switch ($data->state_id) {
            case 6:
                $row->addClass("green");

                break;
             case 4:
                $row->addClass("blue");

                break;
            case 5:
                $row->addClass("red");

                break;

            default:
                break;
        }
        return $row;
    }
    
    public function gridOperationHandler(SubmitButton $button)
    {
        $form = $button->getParent();
        $grid = $this->getComponent('ordersGrid');
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
        
        foreach($keys as $id) {
            $sale = $this->fetchRow("sale", $id);
            $this->changeState($sale, $values['operations']);
                    
        }

        $this->invalidateControl('grid');

        // $this může být v kontextu komponenta i presenter
        if (!Environment::getHttpRequest()->isAjax()) $this->redirect('this');
    }
    
    protected function createComponentChangeStateForm($name) {
        $form = new AppForm($this, $name);
        
        $sale = $this->fetchRow("sale", $this->getParam('id'));
        $form->addSelect('state_id','Změnit stav:', BaseModel::fetchPairs('state', 'name'))
                ->setDefaultValue($sale['state_id']);
        
        $form->addSubmit('change','Změnit');
        $form->onSubmit[] = array($this, 'changeStateSubmit');
        
        return $form;
    }
    
    public function changeStateSubmit($form) {
        $values = $form->getValues();
        $sale = $this->fetchRow("sale", $this->getParam('id'));
        
        $this->changeState($sale, $values['state_id']);
        
        $this->flashMessage("Stav objednávky změněn.", "success");
        
        $this->redirect('this');
    }
    
    protected function createComponentAddItemForm($name) {
        $form = new AppForm($this, $name);
        
        $form->addText('product', 'Produkt:')
                ->setRequired("Vyplňte název produktu.");
        $form->addText('amount', 'Množsvtí:')
                ->addRule(AppForm::FILLED,'Vyplňte množství')
                ->addCondition(AppForm::FILLED)
                        ->addRule(AppForm::FLOAT,"Vyplňte číselné množství");
        
        $form->addSubmit('add','Přidat');
        $form->onSubmit[] = array($this, 'addItemSubmit');
        
        $form->getElementPrototype()->class[] = "ajax";
        return $form;
    }
    
    public function addItemSubmit($form) {
        $values = $form->getValues();

        $product = BaseModel::fetchAll('product')->where("product.active",1)
                                                ->where("LOWER(name) LIKE LOWER(?) COLLATE utf8_general_ci",'%'.$values['product'].'%')->fetch();
        if(!$product) {
            $form->addError("Produkt nenalezen");
            $this->invalidateControl('errors');
            return false;
        }
        
        $values['product_id'] = $product['id'];
        unset($values['product']);
        $values['name'] = $product['name'];
        $values['unit_id'] = $product['unit_id'];
        $values['unit'] = $product->unit['name'];
        if($product['newprice']) 
            $values['price'] = $product['newprice'];
        else 
            $values['price'] = $product['price'];
        
        $values['priceDPH'] = $values['price'] * (1+BasePresenter::DPH);
        $values['total'] = $values['priceDPH'] * $values['amount'];
        $values['sale_id'] = $this->getParam('id');
        
        try {
            OrderModel::addItem($values);
        } catch(PDOException $exc) {
            $form->addError("Chyba");
            $this->invalidateControl('errors');
            return false;
            Debug::log($exc, Debug::ERROR);
        }
        
        $this->redirect('this');
    }
    
    protected function createComponentDiscountForm($name) {
        $form = new AppForm($this,$name);
        
        $saleProducts = BaseModel::fetchAll('saleProduct')->where('sale_id',  $this->getParam('id'))->fetchPairs('id','name');
        $form->addSelect('saleProduct_id', 'Sleva k ', array_merge(array(NULL=>'k celé objednávce'), $saleProducts));
                
        $form->addText('value','Sleva:') 
                ->addRule(AppForm::FILLED, "Vyplňte procentuální výši slevy")
                ->addCondition(AppForm::FILLED)
                    ->addRule(AppForm::FLOAT,"Sleva musí být číslo")
                    ->addRule(AppForm::RANGE,'Sleva musí být v rozmezí od %g do %g', array(0.01, 1.00));
        
        $form->addSubmit('add','Přidat');
        $form->onSubmit[] = array($this, 'addDiscountSubmit');
        
        $form->getElementPrototype()->class[] = "ajax";
        return $form;
    }
    
    public function addDiscountSubmit($form) {
        $values = $form->getValues();
        if($values['saleProduct_id'] == '') $values['saleProduct_id'] = NULL;
        $values['sale_id'] = $this->getParam('id');
        
        try {
            if (OrderModel::addDiscount($values)) 
                $this->flashMessage("Sleva nastavena",'success');
            else {
                $this->flashMessage("Sleva nemohla být nastavena",'error');
            }
        }
        catch (PDOException $exc) {
            Debug::log($exc, Debug::ERROR);
        }
        
        $this->redirect('this');
    }
    
    private function changeState($sale, $state_id) {
         $sale['state_id'] =  $state_id;
         $sale->update();
         
         if ($sale['state_id'] == 3 OR $sale['state_id'] == 4) {
             try {
                $template = new FileTemplate();
                $template->setFile(APP_DIR . '/templates/orderstate.email.latte');
                $template->registerFilter(new LatteFilter);

                $template->presenter = Environment::getApplication()->getPresenter();
                $template->baseUri = Environment::getVariable('baseUri');
                $template->sale = $sale;

                $mail = new Mail;
                $mail->setFrom('Objednávky Tapety-podlahy.cz <objednavky@tapety-podlahy.cz>');
                $mail->addTo($sale['email']);
                $mail->addBcc('petr.ogurcak@gmail.com');
                $mail->setSubject('Stav objednávky č.: i' . $sale['id']);
                $mail->setHtmlBody($template);
                $mail->send();

                $this->flashMessage('Odeslán email o změně stavu objednávky.', 'success');
            } catch (InvalidStateException $e) {
                Debug::log($exc, Debug::ERROR);
                //TODO odeslat mail aby se objednavka odeslala rucne
            }
        }
    }
}
