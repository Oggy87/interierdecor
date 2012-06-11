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
class Front_CustomerPresenter extends Front_BasePresenter
{
    protected function  startup() {
        parent::startup();

        $session = Environment::getSession();
        if (!$session->isStarted()) {
                $session->start();
        }

        $user = Environment::getUser();
        $user->setNamespace('front');

        // user authentication
        if (!in_array($this->getView(), array('signin','register','forgottenPassword'))) {
            if (!$user->isLoggedIn()) {
                if ($user->getLogoutReason() === User::INACTIVITY) {
                    $this->flashMessage($this->translator->translate('Byl jste odhlášen kvůli dlouhé neaktivitě. Prosím přihlašte se znovu.'));
		}
		$backlink = $this->getApplication()->storeRequest();
		$this->redirect('signin', array ('backlink' => $backlink));
            }
        }
    }
    
    public function renderDefault() {
        $this->template->sales = BaseModel::fetchAll("sale")->where("customer_id",  $this->getUser()->getId())->order("created");
    }
    
    public function renderRegister() {
        $this->template->form = $this['registerForm'];
    }
    
    public function renderSignin() {
        $this->template->form = $this['signInForm'];
    }
    
    public function renderSale($id) {
        $this->template->sale = $this->fetchRow("sale", $id);
    }
    
    public function renderAccount() {
        $this->template->form = $this['accountForm'];
    }
    
    public function renderPassword() {
        $this->template->form = $this['changePassword'];
    }
    
    public function renderForgottenPassword() {
        $this->template->form = $this['forgottenPasswordForm'];
    }
    
    protected function createComponentRegisterForm($name) {
        $form = new AppForm($this,$name);

        $form->addText('email', 'Email:')
                ->setType('email')
                ->addRule(Form::FILLED)
                ->addCondition(Form::FILLED)
                ->addRule(Form::EMAIL);

        $form->addPassword('password', 'Heslo:')
                ->addRule(Form::FILLED, 'Vyplňte heslo.')
                ->addRule(Form::MIN_LENGTH, 'Heslo musí mít minimálně %d znaků.', 5);

        $form->addText('name', 'Jméno:')
                ->addRule(Form::FILLED, 'Vyplňte Vaše jméno.');

        $form->addText('surname', 'Přijmení:')
                ->addRule(Form::FILLED, 'Vyplňte Vaše přijmení.');

        /*$form->addText('phone', 'Telefon:')
                ->addRule(Form::FILLED, 'Vyplňte Váš telefon.');*/
                //->addRule('Validators::check_phone','Uvedl jste neplatné telefonní číslo.');

        $form->addSubmit('send', 'Registrovat');

        $form->onSubmit[] = callback($this, 'registerFormSubmitted');
        
        return $form;
    }

    public function registerFormSubmitted($form) {
        $values = $form->getValues();
        unset($values['password2']);

        $code = CustomerModel::register($values);
        if($code == CustomerModel::OK) {
            $this->flashMessage('Paráda, jste registrovaným zákazníkem tapety-podlahy.cz.', 'success');

            try {
                $this->getUser()->setNamespace('front');
                $this->getUser()->login($values['email'],$values['password']);

                $mail = new Mail;
                $mail->setFrom('Interierdecor.cz <info@tapety-podlahy.cz>');
                $mail->addTo($values['email']);
                $mail->addBcc('interierdecor@gmail.com');
                $mail->setSubject('Registrace tapety-podlahy.cz');
                $mail->setHtmlBody('<p>Dobrý den,
děkujeme za Vaši registrace v internetovém obchodě <a href="http://www.tapety-podlahy.cz">tapety-podlahy.cz</a>.</p>

<p>Vaše přihlašovací údaje:</p>
<p>email:'.$values['email'].'</p>
<p>heslo:'.$values['password'].'</p>

<p>Váš tým tapety-podlahy.cz</p>');
                try {
                    $mail->send();
                }
                catch(InvalidStateException $exc) {
                    Debug::log($exc->getMessage(),Debug::ERROR);
                }
            }
            catch (AuthenticationException $e) {
                $form->addError($e->getMessage());
                $this->flashMessage($e->getMessage());
                Debug::log($exc->getMessage());
                $this->redirect('Customer:');
            }
            
            $this->redirect('Customer:');
        }
        
        elseif ($code === CustomerModel::ERROR_DUPLICATION_EMAIL) {
            $form->addError('Zákazník s tímto e-mailem je již v zaregistrován!');

        } else {
            $form->addError('Nepodařilo se Vás zaregistrovat. Kontaktujte nás ...');
        }
    }
    
    public function createComponentAccountForm($name) {
        $form = new AppForm($this,$name);
        
        $form->addText('email', 'Email:')
                    ->setRequired()
                ->addRule(Form::EMAIL, 'Vyplňte prosím email.');
        $form->addText('name', 'Jméno a přijmení:')
                ->addRule(Form::FILLED,'Vyplňte prosím jméno a přijmení.');
        $form->addText('phone', 'Telefon:')
                ->addRule(Form::FILLED, 'Vyplňte prosím telefon.');
        
        $form->addCheckbox('iscompany')   
                ->addCondition(Form::EQUAL, TRUE)
                    ->toggle('iscompany')
                    ->toggle('iscompanyheading');
        $form->addText('company','Název:')
                ->addConditionOn($form['iscompany'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte název.');
        $form->addText('ic', 'IČ:')
                ->addConditionOn($form['iscompany'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte IČ.')
                    ->addRule('Validators::verifyIC', 'Zadané IČ není validní.');
        $form->addText('dic', 'DIČ:')
                ->addConditionOn($form['iscompany'], Form::EQUAL, TRUE)
                ->addCondition(Form::FILLED)
                    ->addRule(Form::LENGTH, 'Délka DIČ je %d znaků.', 10);
        
        $form->addText('city', 'Město:')
                ->addRule(Form::FILLED,'Vyplňte prosím město.');
        $form->addText('street','Ulice:')
                ->addRule(Form::FILLED,'Vyplňte prosím ulici.');
        $form->addText('postcode','PSČ:')
                ->addRule(Form::FILLED,'Vyplňte prosím PSČ.');
        
        $form->addCheckbox('shipaddress')   
                ->addCondition(Form::EQUAL, TRUE)
                    ->toggle('shipaddress');
        $form->addText('shipcity', 'Město:')
                ->addConditionOn($form['shipaddress'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte prosím město.');
        $form->addText('shipstreet','Ulice:')
                ->addConditionOn($form['shipaddress'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte prosím ulici.');
        $form->addText('shippostcode','PSČ:')
                ->addConditionOn($form['shipaddress'], Form::EQUAL, TRUE)
                    ->addRule(Form::FILLED,'Vyplňte prosím PSČ.');
        
        $form->addSubmit('submit', 'uložit')
                ->onClick[] = array($this, 'accountSubmitted');
        
        $user = Environment::getUser();
        $user->setNamespace('front');

        $row = BaseModel::fetchRow('customer', $user->getId());
        $row['name'] = $row['name'].' '.$row['surname'];
        $form->setDefaults($row, FALSE);

        return $form;
    }
    
    public function accountSubmitted($button) {
        $form = $button->getForm();
        $values = $form->getValues();


        list($name,$surname) = explode(' ', $values['name']);
        $values['name'] = $name;
        $values['surname'] = $surname;
        try {
            CustomerModel::update($this->getUser()->getId(), $values);
            $this->flashMessage("Vaše údaje změneny.", 'success');
        } catch (PDOException $exc) {
            if ($exc->errorInfo[1] == 1062) {
                if (strpos($exc->getMessage(), $values['email'])) {
                    $form->addError("Tento email je již používán.", "error");
                }
            } else {
                $this->flashMessage("Při ukládání nastala chyba, budeme ji ihned řešit.", 'error');
                Debug::log($exc->getMessage(), Debug::ERROR);
            }
        }

        $this->redirect('this');
    }
    
    protected function createComponentChangePassword($name) {
        $form = new AppForm($this, $name);

        $form->addPassword('password', 'Nové heslo:')
                ->addRule(Form::FILLED,'Vložte nové heslo.')
                ->addRule(Form::MIN_LENGTH, 'Minimální délka hesla je %d znaků.', 5);

        $form->addPassword('password2', 'Heslo znovu:')
                ->addRule(Form::FILLED, 'Vyplňte heslo znovu.')
                ->addConditionOn($form['password'], Form::VALID)
                    ->addRule(Form::EQUAL, 'Hesla se musí shodovat', $form['password']);

        $form->addSubmit('send', 'Změnit heslo');

        $form->onSubmit[] = callback($this, 'changePasswordSubmitted');
        return $form;
    }
    
    public function changePasswordSubmitted($form) {
        $values= $form->getValues();
        
        if(CustomerModel::changePassword($this->getUser()->getId(), $values['password'])) {
            $this->flashMessage("Heslo změněno.", "success");
            $this->redirect('this');
        }
        else {
            $this->flashMessage("Nepodařilo se heslo změnit.", "erorr");
        }
    }
    
    protected function createComponentForgottenPasswordForm($name) {

        $form = new AppForm($this,$name);

        $form->addText('email', 'E-mail:')
                ->addRule(Form::EMAIL, 'Vyplňte prosím validní emailovou adresu.');

        $form->addSubmit('send', 'Zaslat nové heslo');

        $form->onSubmit[] = callback($this, 'forgottenPasswordFormSubmitted');

        return $form;
    }
    
    public function forgottenPasswordFormSubmitted($form) {
        $values = $form->getValues();
        
        $customer = $this->fetchRow('customer', array('email' => $values['email']));

        if (!$customer) {
            $this->flashMessage('Uživatel s tímto emailem nebyl nalezen.', 'error');
        }
        $password = CustomerModel::randChars(5);
        if (CustomerModel::changePassword($customer['id'], $password)) {
            try {
                $template = new FileTemplate();
                $template->setFile(APP_DIR . '/templates/forgottenPassword.email.latte');
                $template->registerFilter(new LatteFilter);
                $template->registerHelper('nl2br', 'nl2br');
                $template->registerHelper('number', 'number_format');
                $template->registerHelper('date', 'Nette\Templates\TemplateHelpers::date');
                $template->registerHelper('currency', 'Helpers::currency');

                $template->presenter = Environment::getApplication()->getPresenter();
                $template->baseUri = Environment::getVariable('baseUri');
                $template->email = $values['email'];
                $template->password = $password;

                $mail = new Mail;
                $mail->setFrom('tapety-podlahy.cz <eshop@tapety-podlahy.cz>');
                $mail->addTo($values['email']);
                $mail->setSubject('Zapomenuté heslo');
                $mail->setHtmlBody($template);
                $mail->send();
                
                $this->flashMessage('Nové heslo Vám bylo zasláno na uvedený email.', 'success');
            } catch (InvalidStateException $e) {
                $this->flashMessage('Nepodařilo se vygenerované heslo odeslat, informujte nás prosím na adrese info@tapety-podlahy.cz.', 'error');
                Debug::log($exc, Debug::ERROR);
            }
        }
        else {
            $this->flashMessage('Nepodařilo se vygenerovat nové heslo.', 'error');
        }
    }

}
