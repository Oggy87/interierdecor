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
class Front_BasketPresenter extends Front_BasePresenter
{

    public function actionPreview() {
        $namespace = Environment::getSession('order');
        if (!$namespace->values) {
            $this->redirect('default');
        }
        $namespace->token = md5(uniqid());
        $namespace->setExpiration(60, 'token');
        
        $this->template->values = $namespace->values;
    }
    
    public function actionOrder() {
        $namespace = Environment::getSession('order');
        if (!$namespace->token) {
            $this->flashMessage('Bezpečnostní token vypršel, odešlete prosím Vaši objednávku znovu.', 'info');
            $this->redirect('preview');
        }
        if (!$namespace->values) {
            $this->flashMessage('Platnost vaší objednávky vypršela. Je nutné ji vyplnit znovu.', 'info');
            $this->redirect('default');
        }
        else {
            $order = OrderModel::fetchByToken($namespace->token);
            
            $user = Environment::getUser();
            $user->setNamespace('front');
            
            if($order) {
                $this->flashMessage('Objednávka č. i'.$order['id'].' již byla odeslána. Pokud se jedná o chybu, kontaktujte nás na emailové adrese info@tapety-podlahy.cz.', 'error');
            }
            else {

                $values = array_merge($namespace->values['customer'], $namespace->values['shippay']);
                $values['total'] = $namespace->values['totalPrice'];
                $values['token'] = $namespace->token;
                $values['dph'] = BasePresenter::DPH;
                $datetime = new DateTime53;
                $values['created'] = $datetime;
                $products = $namespace->values['products'];

                if($user->isLoggedIn()) {
                    $values['customer_id'] = $user->id;
                }
                else {
                    //podivat jestli znam email..pokud ne..registrace
                    $customer = BaseModel::fetchAll("customer")->where("lower(email)",  String::lower($values['email']))->fetch();
                    if(!$customer) {
                        $password = CustomerModel::randChars(6);
                        list($name,$surname) = explode(" ", $values['name']);
                        $code = CustomerModel::register(array('email'=>$values['email'],
                                                            'password'=>$password,
                                                            'name'=>$name,
                                                            'surname'=>$surname,
                                                            'phone'=>$values['phone'],
                                                            'iscompany' => $values['iscompany'],
                                                            'company' => $values['company'],
                                                            'ic'=>$values['ic'],
                                                            'dic'=>$values['dic'],
                                                            'city'=>$values['city'],
                                                            'street'=>$values['street'],
                                                            'postcode'=>$values['postcode'],
                                                            'shipaddress'=>$values['shipaddress'],
                                                            'shipcity'=>$values['shipcity'],
                                                            'shipstreet'=>$values['shipstreet'],
                                                            'shippostcode'=>$values['shippostcode']));
                        if($code == CustomerModel::OK) {
                            $customer = BaseModel::fetchAll("customer")->where("lower(email)",  String::lower($values['email']))->fetch();
                        }
                    }
                    
                    $values['customer_id'] = $customer['id'];
                }
                try {
                    $order = OrderModel::newOrder($values, $products);
                    $this->template->order = $order;
                    
                    $namespace->remove();
                    $session = Environment::getSession('basket');
                    $session->remove();
                    BasketModel::clear($user->id);
                    
                    $this->flashMessage('Objednávka byla úspěšně odeslána k vyřízení.', 'success');
   
                    try {
                        $template = new FileTemplate();
                        $template->setFile(APP_DIR.'/templates/order.email.latte');
                        $template->registerFilter(new LatteFilter);
                        $template->registerHelper('nl2br','nl2br');
                        $template->registerHelper('number','number_format');
                        $template->registerHelper('date','Nette\Templates\TemplateHelpers::date');
                        $template->registerHelper('currency','Helpers::currency');
                        $template->registerHelper('dph', 'Helpers::dph');

                        $template->presenter = Environment::getApplication()->getPresenter();
                        $template->baseUri = Environment::getVariable('baseUri');
                        $template->values = $values;
                        $template->products = $products;
                        $template->order = $order;
                        if(isset($customer) AND isset($password)) $template->password = $password;

                        $mail = new Mail;
                        $mail->setFrom('Objednávka Tapety-podlahy.cz <objednavky@tapety-podlahy.cz>');
                        $mail->addTo($values['email']);
                        $mail->addBcc('petr.ogurcak@gmail.com');
                        $mail->setSubject('Potvrzení objednávky č.: i'.$order['id']);
                        $mail->setHtmlBody($template);
                        $mail->send();

                        OrderModel::update($order['id'], array('customerEmailSent' => 1));

                        $this->flashMessage('Objednávka byla odeslána na Váš mail.', 'success');
                    } catch (InvalidStateException $e) {
                        Debug::log($exc, Debug::ERROR);
                        //TODO odeslat mail aby se objednavka odeslala rucne
                        
                    }
                    
                    try {
                        $template = new FileTemplate();
                        $template->setFile(APP_DIR.'/templates/order.email.latte');
                        $template->registerFilter(new LatteFilter);
                        $template->registerHelper('nl2br','nl2br');
                        $template->registerHelper('number','number_format');
                        $template->registerHelper('date','Nette\Templates\TemplateHelpers::date');
                        $template->registerHelper('currency','Helpers::currency');
                        $template->registerHelper('dph', 'Helpers::dph');
                        
                        $template->presenter = Environment::getApplication()->getPresenter();
                        $template->baseUri = Environment::getVariable('baseUri');
                        $template->values = $values;
                        $template->products = $products;
                        $template->order = $order;

                        $mail = new Mail;
                        $mail->setFrom('Objednávka Tapety-podlahy.cz <eshop@tapety-podlahy.cz>');
                        $mail->addTo('objednavky@tapety-podlahy.cz');
                        $mail->addBcc('petr.ogurcak@gmail.com');
                        $mail->setSubject('Objednávka č.: i'.$order['id']);
                        $mail->setHtmlBody($template);
                        $mail->send();

                        OrderModel::update($order['id'], array('sellerEmailSent' => 1));

                    } catch (InvalidStateException $e) {
                        Debug::log($exc, Debug::ERROR);
                        //TODO odeslat mail aby se objednavka odeslala rucne
                        
                    }
                    
                   
                } catch (PDOException $exc) {
                    Debug::log($exc, Debug::ERROR);
                    $this->flashMessage('Nepodařilo se uložit objednávku. Chybu se budeme ihned snažit řešit.', 'error');
                }
            }
        }
    }
    
    public function renderDefault() {
        $this->template->form = $this['order'];
        $this->template->products = $this['order']['products'];
    }

    public function renderAddress() {
        $this->template->signform = $this['signInForm'];
        $this->template->form = $this['order2'];
    }
    
    public function renderPreview() {
        $namespace = Environment::getSession('order');
        $namespace->values['totalPrice'] = $namespace->values["total"] + $namespace->values['shippay']['shippingPrice'] + $namespace->values['shippay']['paymethodPrice'];

        $this->template->totalPrice = $namespace->values['totalPrice'];
    }

    public function handleRemoveFromBasket($product_id) {
        $user = Environment::getUser();
        $user->setNamespace('front');

        if($user->isLoggedIn()) {
            BasketModel::removeFromBasket($product_id, $user->getId());
        }
        else {
            $basket = Environment::getSession('basket');
            unset($basket[$product_id]);
        }
        if(!$this->isAjax()) $this->redirect ('this');
        $this->invalidateControl('basket');
        $this->invalidateControl('step1basket');
    }

    public function handleChangeAmount($product_id,$amount) {
        $user = Environment::getUser();
        $user->setNamespace('front');

        $product = $this->fetchRow("product", $product_id);
        if($product->unit['deci']) {
            $amount = floatval(str_replace(',', '.', $amount));
        }
        else {
            $amount = intval($amount);
        }

        if($user->isLoggedIn()) {
            BasketModel::update($user->getId(), $product_id, $amount);
        }
        else {
            $basket = Environment::getSession('basket');
            $basket[$product_id] = $amount;
        }
        if(!$this->isAjax()) $this->redirect ('this');
        $this->invalidateControl('basket');
        $this->invalidateControl('step1basket');
    }

    public function createComponentOrder($name) {
        $form = new AppForm($this,$name);

        $products = $form->addContainer('products');

        $user = Environment::getUser();
        $user->setNamespace('front');
        if($user->isLoggedIn()) {
            $basket = BasketModel::fetchBasket($user->getId())->fetchPairs('product_id','amount');
        }
        else {
            $basket = Environment::getSession('basket');
        }

        foreach ($basket as $product_id => $amount) {
            $p = $products->addContainer($product_id);
            $product = $this->fetchRow("product", $product_id);
            $p->addHidden('name');
            $p->addText('amount')
                    ->setDefaultValue($amount)
                    ->getControlPrototype()
                        ->data['product_id'] = $product_id;
            if($product->unit['deci']) {
                $p['amount']->addRule(Form::FLOAT, 'Množství produktu %s musí být celé nebo desetinné číslo.',$product['name']);
            }
            else {
                $p['amount']->addRule(Form::INTEGER, 'Množství produktu %s musí být celé číslo.',$product['name']);
            }
            $p->addHidden('price');
            $p->addHidden('unit_id');
            $p->addHidden('unit');
            $p->addHidden('total');
        }

        $pay = $form->addContainer('shippay');
        $shipping = BaseModel::fetchPairs('shipping', 'name');
        $pay->addRadioList('shipping_id', 'Způsob dopravy', $shipping)
                ->addRule(Form::FILLED, 'Vyberte způsob dopravy');

        $paymethod = BaseModel::fetchPairs('paymethod', 'name');
        $pay->addRadioList('paymethod_id', 'Způsob platby', $paymethod)
                ->addRule(Form::FILLED, 'Vyberte způsob platby');
        
        $form->addHidden('total');

        $form->addSubmit('submit', 'Pokračovat v objednávce')
                ->onClick[] = array($this, 'OrderSubmitted');
        
        $namespace = Environment::getSession('order');
        if($namespace->values) $form->setDefaults($namespace->values);

        return $form;
    }

    public function orderSubmitted($button) {
        $form = $button->getForm();

        $namespace = Environment::getSession('order');
        if($namespace->values) {
            $namespace->values = array_merge($namespace->values, $form->getValues());
        }
        else {
            $namespace->values = $form->getValues();
        }
        $shipping = $this->fetchRow('shipping', $namespace->values['shippay']['shipping_id']);
        $namespace->values['shippay']['shipping'] = $shipping['name'];
        $namespace->values['shippay']['shippingPrice'] = $shipping['price'];
        $paymethod = $this->fetchRow('paymethod', $namespace->values['shippay']['paymethod_id']);
        $namespace->values['shippay']['paymethod'] = $paymethod['name'];
        $namespace->values['shippay']['paymethodPrice'] = $paymethod['price'];
        
        /*$namespace->values['token'] = md5(uniqid());*/

        $this->redirect('address');
    }
    
    public function createComponentOrder2($name) {
        $form = new AppForm($this,$name);
        
        $customer = $form->addContainer('customer');
        $customer->addText('email', 'Email:')
                    ->setRequired()
                ->addRule(Form::EMAIL, 'Vyplňte prosím email.');
        $customer->addText('name', 'Jméno a přijmení:')
                ->addRule(Form::FILLED,'Vyplňte prosím jméno a přijmení.');
        $customer->addText('phone', 'Telefon:')
                ->addRule(Form::FILLED, 'Vyplňte prosím telefon.');
        
        $customer->addCheckbox('iscompany')   
                ->addCondition(Form::EQUAL, TRUE)
                    ->toggle('iscompany')
                    ->toggle('iscompanyheading');
        $customer->addText('company','Název:')
                ->addConditionOn($customer['iscompany'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte název.');
        $customer->addText('ic', 'IČ:')
                ->addConditionOn($customer['iscompany'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte IČ.')
                    ->addRule('Validators::verifyIC', 'Zadané IČ není validní.');
        $customer->addText('dic', 'DIČ:')
                ->addConditionOn($customer['iscompany'], Form::EQUAL, TRUE)
                ->addCondition(Form::FILLED)
                    ->addRule(Form::LENGTH, 'Délka DIČ je %d znaků.', 10);
        
        $customer->addText('city', 'Město:')
                ->addRule(Form::FILLED,'Vyplňte prosím město.');
        $customer->addText('street','Ulice:')
                ->addRule(Form::FILLED,'Vyplňte prosím ulici.');
        $customer->addText('postcode','PSČ:')
                ->addRule(Form::FILLED,'Vyplňte prosím PSČ.');
        
        $customer->addCheckbox('shipaddress')   
                ->addCondition(Form::EQUAL, TRUE)
                    ->toggle('shipaddress');
        $customer->addText('shipcity', 'Město:')
                ->addConditionOn($customer['shipaddress'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte prosím město.');
        $customer->addText('shipstreet','Ulice:')
                ->addConditionOn($customer['shipaddress'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte prosím ulici.');
        $customer->addText('shippostcode','PSČ:')
                ->addConditionOn($customer['shipaddress'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte prosím PSČ.');
        
        $form->addCheckbox('remember')->setDefaultValue(TRUE);
       /* $form->addCheckbox('register')
                ->addCondition(Form::EQUAL, TRUE)
                    ->toggle('register');
        $form->addPassword('password', 'Heslo')
                ->addConditionOn($form['register'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte prosím heslo.')
                    ->addRule(Form::MIN_LENGTH, 'Heslo musí mít minimálně %d znaků.', 5);
        $form->addPassword('password2', 'Heslo znovu')
                ->addConditionOn($form['register'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte prosím kontrolu hesla.')
                ->addConditionOn($form['password'], Form::VALID)
                    ->addRule(Form::EQUAL, 'Hesla se musí shodovat', $form['password']);*/
        
        $form->addSubmit('submit', 'Na shrnutí objednávky')
                ->onClick[] = array($this, 'Order2Submitted');
        
        $user = Environment::getUser();
        $user->setNamespace('front');
        if($user->isLoggedIn()) {
            $row = BaseModel::fetchRow('customer', $user->getId());
            $row['name'] = $row['name'].' '.$row['surname'];
            $form['customer']->setDefaults($row, FALSE);
        }
        else {
            $namespace = Environment::getSession('order');
            if(isset($namespace->values['customer'])) $form['customer']->setDefaults($namespace->values['customer'], FALSE);
        }

        return $form;
    }

    public function order2Submitted($button) {
        $form = $button->getForm();
        $values = $form->getValues();

        $namespace = Environment::getSession('order');
        $namespace->setExpiration('+ 14 days');
        if($namespace->values) $namespace->values = array_merge($namespace->values, $values);
        
        $user = Environment::getUser();
        $user->setNamespace('front');
        
        if($user->isLoggedIn() AND $values['remember']) {
            list($name,$surname) = explode(' ', $values['customer']['name']);
            $values['customer']['name'] = $name;
            $values['customer']['surname'] = $surname;
            try {
                CustomerModel::update($user->getId(), $values['customer']);
            } catch (PDOException $exc) {
                Debug::log($exc->getMessage(),Debug::ERROR);
            }
            
        }
        $this->redirect('preview');
    }

}
