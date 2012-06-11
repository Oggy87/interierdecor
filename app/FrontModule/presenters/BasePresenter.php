<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */


/**
 * Base class for all application presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */
abstract class Front_BasePresenter extends BasePresenter
{

    const TAPETY_ID = 1;
    const OSVETLENI_ID = 3;
    const PODLAHY_ID = 5;
    const NABYTEK_ID = 2;
    const DOPLNKY_ID = 4;

    const TAG_KOLEKCE_ID = 3;
    
    private $backlink = '';

    protected function startup() {
        parent::startup();

        $session = Environment::getSession();
        if (!$session->isStarted()) {
            $session->start();
        }

        $user = Environment::getUser();
        $user->setNamespace('front');
        
        $user->onLoggedIn[] = array($this, 'convertBasketToDb');
        $user->onLoggedOut[] = array($this, 'convertBasketFromDb');
    }

    public function  beforeRender() {
        parent::beforeRender();

        $user = Environment::getUser();
        $user->setNamespace('front');

        if($user->isLoggedIn()) {
            $this->template->basket = BasketModel::fetchBasket($user->getId());
            $this->template->basketsum = $this->template->basket->aggregation("SUM(amount * IF(product.newprice,product.newprice,product.price))");
            $this->template->basketamount = $this->template->basket->aggregation("SUM(amount)");
        }
        else {
            $this->template->basket = Environment::getSession('basket');
            $this->template->basketsum = 0;
            $this->template->basketamount = 0;
            foreach(Environment::getSession('basket') as $product_id => $amount) {
                $product = BaseModel::fetchAll('product')->select("IF(newprice,newprice,price) AS price")->where("id", $product_id)->fetch();
                $this->template->basketsum += $amount * $product['price'];
                $this->template->basketamount += $amount;
            }
        }
        
        $onemonthago = new DateTime('31 days ago');
        $this->template->onemonthago = $onemonthago->format("Y-m-d");

        $this->template->visualisation = Environment::getSession('visualisation');
        
    }
    
    public function handleAddToVisual($product_id) {
         $this->template->visualproduct = $this->fetchRow('product', $product_id);
         $this->invalidateControl('visualproduct');
    }

    public function handleWall($productid,$name,$rotate = 0) {
        $product = $this->fetchRow('product', $productid);

        if(!file_exists(WWW_DIR.'/static/temp/product-montage'.$product['id'].'.png')) {
            $image = $this->getVisualMontage($product,$rotate);
        }

        switch ($name) {
            case 'wall1':
                if(!file_exists(WWW_DIR.'/static/temp/wall1-'.$product['id'].'-'.$rotate.'.png')) {
                    $file = WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png';

                    $montage = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $montage->cropImage(126, 349, 0, 0);
                    $montage->shearImage('transparent', 0 , -30);

                    $montage->writeImage(WWW_DIR.'/static/temp/wall1-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall1-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wal1'));
                break;
            case 'wall2':
                if(!file_exists(WWW_DIR.'/static/temp/wall2-'.$product['id'].'-'.$rotate.'.png')) {
                    $montage = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $montage->cropImage(126,277,126,72);
                    $montage->shearImage('transparent', 0 , -30);

                    $montage->writeImage(WWW_DIR.'/static/temp/wall2-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall2-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall2'));
                break;
            case 'wall3':
                if(!file_exists(WWW_DIR.'/static/temp/wall3-'.$product['id'].'.png')) {
                    $montage = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $montage->cropImage(126,206,0,349);
                    $montage->shearImage('transparent', 0 , -30);

                    $montage->writeImage(WWW_DIR.'/static/temp/wall3-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall3-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall3'));
                break;
            case 'wall4':
                if(!file_exists(WWW_DIR.'/static/temp/wall4-'.$product['id'].'-'.$rotate.'.png')) {
                    $montage = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $montage->cropImage(126,206,126,349);
                    $montage->shearImage('transparent', 0 , -30);

                    $montage->writeImage(WWW_DIR.'/static/temp/wall4-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall4-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall4'));
                break;
            case 'wall5':
                if(!file_exists(WWW_DIR.'/static/temp/wall5-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    //$image->crop(252, 9, 157, 206);
                    $image->cropImage(157,206,252,9);

                    $image->writeImage(WWW_DIR.'/static/temp/wall5-'.$product['id'].'-'.$rotate.'.png');

                }
                $this->payload->backgroundimage = 'temp/wall5-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall5'));
                break;
             case 'wall6':
                if(!file_exists(WWW_DIR.'/static/temp/wall6-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $image->cropImage(157, 206, 409, 9);
                 
                    $image->writeImage(WWW_DIR.'/static/temp/wall6-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall6-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall6'));
                break;
             case 'wall7':
                if(!file_exists(WWW_DIR.'/static/temp/wall7-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $image->cropImage(157, 206, 252, 215);
                    
                    $image->writeImage(WWW_DIR.'/static/temp/wall7-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall7-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall7'));
                break;
             case 'wall8':
                if(!file_exists(WWW_DIR.'/static/temp/wall8-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $image->cropImage(157, 206, 409, 215);
                    
                    $image->writeImage(WWW_DIR.'/static/temp/wall8-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall8-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall8'));
                break;
            case 'wall9':
                if(!file_exists(WWW_DIR.'/static/temp/wall9-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $image->cropImage(157, 206, 566, 9);
                    
                    $image->writeImage(WWW_DIR.'/static/temp/wall9-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall9-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall9'));
                break;
            case 'wall10':
                if(!file_exists(WWW_DIR.'/static/temp/wall10-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $image->cropImage(157, 206, 723, 9);
                    
                    $image->writeImage(WWW_DIR.'/static/temp/wall10-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall10-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall10'));
                break;
            case 'wall11':
                if(!file_exists(WWW_DIR.'/static/temp/wall11-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $image->cropImage(157, 206, 566, 215);
                    
                    $image->writeImage(WWW_DIR.'/static/temp/wall11-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall11-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall11'));
                break;
            case 'wall12':
                if(!file_exists(WWW_DIR.'/static/temp/wall12-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $image->cropImage(157, 206, 723, 215);
                    
                    $image->writeImage(WWW_DIR.'/static/temp/wall12-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall12-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall12'));
                break;
            case 'wall13':
                if(!file_exists(WWW_DIR.'/static/temp/wall13-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $image->cropImage(157, 206, 880, 9);
                    
                    $image->writeImage(WWW_DIR.'/static/temp/wall13-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall13-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall13'));
                break;
             case 'wall14':
                if(!file_exists(WWW_DIR.'/static/temp/wall14-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $image->cropImage(162, 206, 1037, 9);
                    
                    $image->writeImage(WWW_DIR.'/static/temp/wall14-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall14-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall14'));
                break;
                
            case 'wall15':
                if(!file_exists(WWW_DIR.'/static/temp/wall15-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $image->cropImage(157, 206, 880, 215);
                    
                    $image->writeImage(WWW_DIR.'/static/temp/wall15-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall15-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall15'));
                
                break;
             case 'wall16':
                if(!file_exists(WWW_DIR.'/static/temp/wall16-'.$product['id'].'-'.$rotate.'.png')) {
                    $image = new Imagick(WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');
                    $image->cropImage(162, 206, 1037, 215);
                    
                    $image->writeImage(WWW_DIR.'/static/temp/wall16-'.$product['id'].'-'.$rotate.'.png');
                }
                $this->payload->backgroundimage = 'temp/wall16-'.$product['id'].'-'.$rotate.'.png';
                $this->payload->clearlink = $this->link('clear!',array('wall'=>'wall16'));
                break;   
             
            default:
                break;
        }

        $this->payload->rotate = $rotate;
        
        if($product['newprice']) $price = Helpers::currency (Helpers::dph ($product['newprice'], BasePresenter::DPH));
        else $price = Helpers::currency (Helpers::dph ($product['price'], BasePresenter::DPH));
        $this->payload->product = array(
                            'id' => $product['id'],
                            'link' => $this->link('Product:',array('id' => $product['id'])),
                            'text' => $product['name'],
                            'price' => $price,
                            'basketlink' => $this->link('addToBasket!',array('product_id' => $product['id']))
                            );
        
        $visualisation = Environment::getSession('visualisation');
        $visualisation->$name = $this->payload;

        $this->terminate();
    }

    public function handleAddToBasket($product_id,$amount = 1) {
        $user = Environment::getUser();
        $user->setNamespace('front');

        $basket = Environment::getSession('basket');

        if($user->isLoggedIn()) {
            if (!BasketModel::addToBasket(array($product_id => $amount), $user->getId())) {
                $this->flashMessage('Nepodařilo se zboží přidat do košíku', 'error');
            }
        }
        else {
            if ($basket[intval($product_id)]) {
                $basket[intval($product_id)] += $amount;
            }
            else {
                $basket[intval($product_id)] = intval($amount);
            }
        }

        $this->template->basketamount = $amount;
        $this->template->basketproduct = $this->fetchRow('product', $product_id);
        if($this->template->basketproduct->unit['deci']) {
            $this['addBasketForm']['amount']->addRule(Form::FLOAT);
        }
        else {
            $this['addBasketForm']['amount']->addRule(Form::INTEGER);
        }
        if($user->isLoggedIn()) {
            $this->template->basketproductamount = BasketModel::fetchBasket($user->getId())->where("product_id",$product_id)->aggregation("SUM(amount)");
        }
        else {
            $this->template->basketproductamount = $basket[$product_id];
        }
        if(!$this->isAjax()) $this->redirect ('this');
        $this->invalidateControl('basketproduct');
        $this->invalidateControl('basket');
    }

    public function convertBasketToDb($user) {
        $basket = Environment::getSession('basket');

        BasketModel::intoBasket($basket, $user->getId());
        
    }

    public function convertBasketFromDb($user) {
        $basket = Environment::getSession('basket');

        $basketdb = BasketModel::fetchBasket($user->getId());
        foreach($basketdb as $basket_product) {
            $basket[$basket_product['product_id']] = $basket_product['amount'];
        }
    }

    /**
     * Sign in form component factory.
     * @return AppForm
     */
    protected function createComponentSignInForm() {
        $form = new AppForm;
        $form->addText('email', 'Email:')
                ->setType('email')
                ->addRule(AppForm::FILLED)
                ->addCondition(AppForm::FILLED)
                ->addRule(AppForm::EMAIL);

        $form->addPassword('password', 'Heslo:')
                ->addRule(AppForm::FILLED);

        $form->addSubmit('send', 'přihlásit se');

        $form->onSubmit[] = callback($this, 'signInFormSubmitted');
        return $form;
    }

    public function signInFormSubmitted($form) {
        try {
            $values = $form->getValues();
            $this->getUser()->setExpiration('+ 14 days', FALSE);

            $this->getUser()->login($values['email'], $values['password']);

            $this->getApplication()->restoreRequest($this->backlink);
            $this->redirect('Customer:');
        } catch (AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }

    protected function createComponentAddBasketForm($name) {
        $form = new AppForm($this, $name);

        $form->addHidden('product_id');
        
        $form->addText('amount')->setDefaultValue("1");

        $form->addSubmit("add","změnit");
        $form->onSubmit[] = array($this, 'addBasketFormSubmitted');

        $form->getElementPrototype()->class[] = "ajax";

        return $form;
    }

    public function addBasketFormSubmitted($form) {

        $values = $form->getValues();

        $user = Environment::getUser();
        $user->setNamespace('front');
        

        $basket = Environment::getSession('basket');

        if($user->isLoggedIn()) {
            if (!BasketModel::addToBasket(array($values['product_id'] => $values['amount']), $user->getId())) {
                $this->flashMessage('Nepodařilo se zboží přidat do košíku', 'error');
            }
        }
        else {
            if ($basket[intval($values['product_id'])]) {
                $basket[intval($values['product_id'])] = $values['amount'];
            }
            else {
                $basket[intval($values['product_id'])] = intval($values['amount']);
            }
        }
        
        if(!$this->isAjax()) $this->redirect('this');
        $this->invalidateControl('basket');
        $this->invalidateControl('bask');
    }
    
    protected function createComponentSearchForm() {
        $form = new AppForm($this,'searchForm');

        //$form->setAction($this->link('Search:', array('do' => 'searchForm-submit')));
        
        $form->addText('text')
                ->addRule(AppForm::FILLED,"Zadejte co chcete hledat.");

        $form->addSubmit("search","hledat v produktech");
        $form->onSubmit[] = array($this, 'searchFormSubmitted');
        
        return $form;
    }
    
    public function searchFormSubmitted($form) {
        $values = $form->getValues();
        $this->redirect(':Front:Search:',$values);
    }

    public function actionOut($backlink) {
        $this->getUser()->logout();
        $this->flashMessage('Byl jste odhlášen.');
        $this->getApplication()->restoreRequest($backlink);
        $this->redirect(':Front:Homepage:');
    }
    
    protected function getVisualMontage($product,$rotate = 0) {
        $image_path = WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png';
        
        if(!file_exists($image_path)) {
            $visual = Image::fromFile(WWW_DIR.'/static/'.$product['visualisation_path']);
            if($rotate != 0) {
                $visual->rotate(270,0);
            }
            $visual->save(WWW_DIR.'/static/temp/test2.png');
            $im = imagecreatetruecolor(1199, 564);
            imagesettile($im, $visual->getImageResource());
            imagefilledrectangle($im, 1199, 564, 0, 0, IMG_COLOR_TILED);
            imagepng($im, WWW_DIR.'/static/temp/product-montage'.$product['id'].'-'.$rotate.'.png');

            imagedestroy($im);
        }
        return $image_path;
    }
}
