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
class Admin_SignPresenter extends BasePresenter
{

	/** @persistent */
        public $backlink = '';

	/**
	 * Sign in form component factory.
	 * @return AppForm
	 */
	protected function createComponentSignInForm()
	{
		$form = new AppForm;
		$form->addText('email', 'Email:')
                        ->setType('email')
			->addRule(AppForm::FILLED)
                        ->addCondition(AppForm::FILLED)
                            ->addRule(AppForm::EMAIL);

		$form->addPassword('password', 'Password:')
			->addRule(AppForm::FILLED);

		$form->addSubmit('send', 'Sign in');

		$form->onSubmit[] = callback($this, 'signInFormSubmitted');
		return $form;
	}

	public function signInFormSubmitted($form)
	{
		try {
			$values = $form->getValues();
			$this->getUser()->setExpiration('+ 14 days', FALSE);
                        
			$this->getUser()->login($values['email'], $values['password']);
			
                        $this->getApplication()->restoreRequest($this->backlink);
                        $this->redirect('Homepage:');

		} catch (AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}



	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('in');
	}

}
