<?php

/**
 * Description of BasePresenter
 *
 * @author oggy
 */
class Admin_BasePresenter extends BasePresenter {

    protected function  startup() {
        parent::startup();

        $session = Environment::getSession();
        if (!$session->isStarted()) {
                $session->start();
        }

        $user = Environment::getUser();
        $user->setNamespace('admin');

        // user authentication
        if ($this->getName() != 'Admin:Sign') {
            if (!$user->isLoggedIn()) {
                if ($user->getLogoutReason() === User::INACTIVITY) {
                    $this->flashMessage($this->translator->translate('Byl jste odhlášen kvůli dlouhé neaktivitě. Prosím přihlašte se znovu.'));
		}
		$backlink = $this->getApplication()->storeRequest();
		$this->redirect('Sign:in', array ('backlink' => $backlink));
            }
        }
    }

    public function  beforeRender() {
        parent::beforeRender();

        $user = Environment::getUser();
        $user->setNamespace('admin');
    }
    
    
}