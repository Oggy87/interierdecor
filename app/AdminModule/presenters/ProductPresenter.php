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
class Admin_ProductPresenter extends Admin_BasePresenter
{
     public function  startup() {
        parent::startup();

        $config = Environment::getConfig();
        dibi::connect($config->database);

        /*$config = Environment::getConfig('security');
        Debug::barDump(hash_hmac('sha256', 'zaba' . '8uio51dx' , $config->hmacKey));*/
        
    }
    
    public function handleAvailableTags($tagGroup) {
        foreach(BaseModel::fetchAll('tag')->where('tagGroup_id', $tagGroup)->order('value') as $tag)
            $this->payload->availableTags[] = $tag['value'];

        $this->sendPayload();
    }
    
    public function handleDeleteFile($id) {
        $product = $this->fetchRow("product", $id);
        try {
            $product['file_path'] = NULL;
            $product['file_name'] = NULL;
            
            $product->update();
            @unlink(WWW_DIR.$product['file_path']);
            /*Environment::getCache()->clean(array(
                Cache::TAGS => array("product/$product[id]")
            ));*/
        }
        catch (PDOException $exc) {
            Debug::log($exc, Debug::ERROR);
        }
        
        $this->invalidateControl('files');
    }
    
    public function handleImageThumb($tmpname) {
        
        $file = Helpers::thumb('/../temp/plupload/'.$tmpname, 355, 262);
        
        $this->template->image = $file;

        $this->invalidateControl('perexPhoto');

        //$this->terminate(); // ukončí presenter
    }
    
    public function handleImagesThumb($files) {
        
        $this->template->images = array();
        foreach($files as $file) {
            array_push($this->template->images, Helpers::thumb('/temp/plupload/'.$file['target_name'],140,140));
        }
        $this->invalidateControl('images');
    }
    
    public function handleVisualThumb($tmpname) {
        
        $file = Helpers::thumb('/../temp/plupload/'.$tmpname, NULL, 67);
        
        $this->template->visualisation = $file;

        $this->invalidateControl('visualisation');
    }

    public function handleRotate($image,$direction) {
        $thumb = Image::fromFile(WWW_DIR.$image);
        $rotatedImage = $thumb->rotate($direction,0);

        $rotatedImage->save(WWW_DIR.$image,100,Image::JPEG);

        $dateTime = new DateTime53();

        $newSize = Image::calculateSize($rotatedImage->width, $rotatedImage->height, NULL, 330, Image::FIT);

        $img = Html::el('img');
        $img->src =  Environment::getVariable('baseUri').$image.'?'.$dateTime->getTimestamp();
        $img->width = $newSize['0'];
        $img->height = $newSize['1'];

        $this->template->image = $img;
        $this->template->file = $image;

        $this->invalidateControl('perexPhoto');
    }
    
    public function handleDeleteImage($productPhoto_id) {
        $productPhoto = $this->fetchRow("productPhoto", $productPhoto_id);

        try {
            $image_path = $productPhoto['image_path'];
            
          /*  Environment::getCache()->clean(array(
                Cache::TAGS => array("products", "product/$productPhoto[product_id]")
            ));*/
            
            $productPhoto->delete();
            //smazat stavajici obrazek
            @unlink(WWW_DIR.'/static/'.$image_path);
            // Remove old  photos files
            Helpers::removeTempImages($image_path);
            //nahrat novy obrazek
        } catch (PDOException $e) {
            $this->flashMessage('Nepodařilo se obrázek smazat.', 'error');
            Debug::log($e, Debug::ERROR);
        }
        
        $this->invalidateControl('images');
    }
    
    public function handleDeleteVisualisation($id) {
        $product = $this->fetchRow("product", $id);

        try {            
            //smazat stavajici obrazek
            @unlink(WWW_DIR.'/static/'.$product['visualisation_path']);
            // Remove old  photos files
            Helpers::removeTempImages($product['visualisation_path']);
            $product['visualisation_path'] = NULL;
            $product->update();
            
            /*Environment::getCache()->clean(array(
                Cache::TAGS => array("products", "product/$product[id]")
            ));*/
        } catch (PDOException $e) {
            $this->flashMessage('Nepodařilo se obrázek smazat.', 'error');
            Debug::log($e, Debug::ERROR);
        }
        
        $this->redirect('this');
    }

    public function handleDelete($id) {
        $this->delete($id);
    }

    public function renderNew() {

        $this->template->form = $this['newProduct'];
        if($this['newProduct']['productPhoto']['tmpname']->getValue()) {
            $this->handleImageThumb($this['newProduct']['productPhoto']['tmpname']->getValue());
        }
        
        if($this->getParam('id')) {
            $product = $this->fetchRow("product", $this->getParam('id'));//->select('category_id','description_html','unit_id','price','newprice','active','recommended','productType_id');
            unset($product['name']);
            unset($product['url_slug']);
            
            $this->template->form['product']->setDefaults($product);
            
            foreach(BaseModel::fetchAll('category_tagGroup')->where('category_id',$product['category_id'])->order('sort') as $category_tagGroup) {
                $tags = array();
                $product_tags = $product->product_tag()->where("tag.tagGroup_id",$category_tagGroup->tagGroup['id'])->order("value");

                foreach ($product_tags as $product_tag) {
                    $tags[] = $product_tag->tag['value'];
                }

                $default = implode(',', $tags);
                if($default != '') $default .= ', ';
                $this->template->form['tags'][$category_tagGroup['category_id']][$category_tagGroup['tagGroup_id']]->setDefaultValue($default);
            }
        }
        
    }
   

    public function renderEdit($id) {
        $this->template->form = $this['editProduct'];
        
        try {
            $this->template->product = $this->fetchRow('product', $id);
        }
        catch (BadRequestException $exc) {
            throw new InvalidArgumentException("Produkt neexistuje.");
        }

        //thumb product
        if(!isset($this->template->image) AND $this->template->product->productPhoto['image_path']) {
            $this->template->form['productPhoto']['tmpname']->setDefaultValue($this->template->product->productPhoto['image_path']);

            $file = Helpers::thumb('/static/'.$this->template->product->productPhoto['image_path'], 355, 262);
            
            $this->template->image = $file;
        }

    }
    
    public function renderImages($id) {
        
        try {
            $this->template->product = $this->fetchRow('product', $id);
        }
        catch (BadRequestException $exc) {
            throw new InvalidArgumentException("Produkt neexistuje.");
        }
        
        $this->template->productPhotos = BaseModel::fetchAll('productPhoto')->where("product_id", $this->template->product['id'])->where("NOT id",$this->template->product['productPhoto_id']);
        
        $this->template->form = $this['images'];
    }
    
    public function renderVisualisation($id) {
        try {
            $this->template->product = $this->fetchRow('product', $id);
        }
        catch (BadRequestException $exc) {
            throw new InvalidArgumentException("Produkt neexistuje.");
        }
        
        $this->template->form = $this['visualisationForm'];
        
        if($this->template->form['tmpname']->getValue()) {
            $this->handleVisualThumb($this->template->form['tmpname']->getValue());
        }
        if(!isset($this->template->visualisation) AND $this->template->product['visualisation_path'] != NULL) {
            $file = Helpers::thumb('/static/'.$this->template->product['visualisation_path'], NULL, 67);
            
            $this->template->visualisation = $file;
        }
    }
    
    public function renderVariants($id) {
        try {
            $this->template->product = $this->fetchRow('product', $id);
        }
        catch (BadRequestException $exc) {
            throw new InvalidArgumentException("Produkt neexistuje.");
        }
    }
 

    public function createComponentNewProduct($name) {
        $form = new AppForm($this, $name);

        $product = $form->addContainer('product');
        $product->addHidden('productType_id');
        $product->addSelect('category_id', 'Kategorie:', BaseModel::fetchPairs('category', 'name'))
                ->skipFirst(' - ')
                ->setRequired('Vyberte kategorii.');

        $product->addText('name', 'Název:', '' , '100');
                //->addRule(Form::FILLED, 'Vyplňte titulek sekce.');

        $product->addText('url_slug', 'Url:', '56')
                ->addRule(Form::FILLED, 'Vyplňte url.)');

        $product->addText('price', 'Cena bez DPH:')
                ->addRule(Form::FILLED, 'Vyplňte cenu.')
                ->addRule(Form::FLOAT, 'Cena musí být číslo.');

        $product->addSelect('unit_id', 'Jednotka:', BaseModel::fetchPairs('unit', 'name'))
                ->skipFirst(' - ')
                ->addRule(Form::FILLED, 'Vyberte jednotku.');
        
        $product->addText('newprice', 'Akční cena bez DPH:')
                ->addCondition(Form::FILLED)
                    ->addRule(Form::FLOAT, 'Cena musí být číslo.');

        $product->addTextArea('description_html', 'Popis:', '60', '4');
                //->addRule(Form::FILLED, 'Popis musí být vyplněn.');

        $product->addRadioList('active', 'Aktivní:', array('1' => 'ano','0' => 'ne'))
                ->setDefaultValue('1');
        
        $product->addCheckbox('recommended', 'Doporučujeme:');
          
        $product->addFile('file_path','Soubor:');
        
        $product->addText('file_name','Pojmenování souboru:')
                     ->addConditionOn($form['product']['file_path'], Form::FILLED)
                            ->addRule(Form::FILLED, 'Pojmenujte soubor.');     

        $productPhoto = $form->addContainer('productPhoto');
        $productPhoto->addHidden('name');
        $productPhoto->addHidden('tmpname')
                       // ->addConditionOn($form['section'], ~Form::EQUAL,'actuality')
                            ->addRule(Form::FILLED, 'Nahrajte prosím foto.');     

        $tags = $form->addContainer('tags');
        foreach(BaseModel::fetchAll("category") as $category) {
            $form['product']['category_id']->addCondition(Form::EQUAL, /*str_replace('-', '', String::webalize($category['name']))*/$category['id'])
                                    ->toggle(/*str_replace('-', '', String::webalize($category['name']))*/$category['id']);

            $container = $tags->addContainer(/*str_replace('-', '', String::webalize($category['name']))*/$category['id']);
            foreach(BaseModel::fetchAll('category_tagGroup')->where('category_id',$category['id'])->order('sort') as $category_tagGroup) {
                $container->addText($category_tagGroup->tagGroup['id'],$category_tagGroup->tagGroup['name'].':');
            }

        }

        $form->addSubmit('send', 'Uložit')
                ->onClick[] = array($this, 'newProductSubmit');
        $form->addSubmit('sendNext', 'Uložit a vytvořit další')
                ->onClick[] = array($this, 'newProductSubmit');

        $unit = $form->addContainer('unit');
        $unit->addText('name', 'Jednotka:');
                //->addRule(Form::FILLED, 'Vyplňte jednotku.');

        $form->addSubmit('sendUnit', '+')
                ->setValidationScope(NULL)
                ->onClick[] = array($this, 'newUnitClicked');

        //$form->getElementPrototype()->class[] = "ajax";

        return $form;
    }
    

    public function newProductSubmit($button) {
        $form = $button->getForm();
        $values = $form->getValues();
        try {
            $product = ProductModel::newProduct($values);
           /* Environment::getCache()->clean(array(
                Cache::TAGS => array("products","tagGroups","tag")
            ));*/
            $this->flashMessage('Produkt úspěšně uložen', 'success');
  
            if ($form['send']->isSubmittedBy()){
                if ($this->getAction() == 'edit')
                    $this->redirect('this');
                else
                    $this->redirect('edit',array("id"=> $product['id']));
            }
            elseif ($form['sendNext']->isSubmittedBy()) {
                if ($this->getAction() == 'new')
                    $this->redirect('new');
                else
                    $this->redirect('default');
            }
            
        } catch (PDOException $e) {
            if($e->errorInfo[1] == 1062) {
                if (strpos($e->getMessage(), $values['product']['url_slug'])) {
                    $form->addError("Produkt s touto URL již existuje, musíte zvolit jinou url. Je také možné že tento produkt již v databázi máte, editujte tedy dosavadní produkt.");
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
    
    protected function createComponentVisualisationForm($name) {
        $form = new AppForm($this, $name);
        
        $product = $this->fetchRow('product', $this->getParam('id'));
        
        $form->addHidden('name');
        $form->addHidden('tmpname');
                       // ->addConditionOn($form['section'], ~Form::EQUAL,'actuality')
                           // ->addRule(Form::FILLED, 'Nahrajte prosím foto k článku.');

        $form->addText('visualisation_width', 'Šířka produktu:')
                            ->addConditionOn($form['tmpname'], Form::FILLED)
                                ->addRule(Form::FILLED, 'Vyplňte prosím šířku obrázku k vizualizaci.')
                                ->addRule(Form::FLOAT, 'Šířka musí být číslo.');
        $form->addText('visualisation_height', 'Výška produktu:')
                            ->addConditionOn($form['tmpname'], Form::FILLED)
                                ->addRule(Form::FILLED, 'Vyplňte prosím výšku obrázku k vizualizaci.')
                                ->addRule(Form::FLOAT, 'Výška musí být číslo.');
        
        $form->addSubmit('send', 'Uložit');
        $form->onSubmit[] = array($this, 'visualisationSubmit');
        
        $form->setDefaults($product);

        //$form->getElementPrototype()->class[] = "ajax";

        return $form;
    }
    
    public function visualisationSubmit($form) {
        $values = $form->getValues();
        
        $product = $this->fetchRow('product', $this->getParam('id'));
        try {
            ProductModel::saveVisualisation($product, $values);
            /*Environment::getCache()->clean(array(
                Cache::TAGS => array("products", "product/$product[id]")
            ));*/
            $this->flashMessage('Vizualizace uložena.', 'success');
  
            $this->redirect('this');
            
        } catch (PDOException $e) {

            $form->addError('Nastala chyba při ukládání do databáze.');
            
            $this->invalidateControl('formerrors');
            Debug::log($e, Debug::ERROR);
        }
    }

    public function createComponentEditProduct($name) {

        $product = $this->fetchRow('product', $this->getParam('id'));

        $form = $this->createComponentNewProduct($name);
        $form['product']->addHidden('id');

        $form['product']->setDefaults($product);

        foreach(BaseModel::fetchAll('category_tagGroup')->where('category_id',$product['category_id'])->order('sort') as $category_tagGroup) {
            $tags = array();
            $product_tags = $product->product_tag()->where("tag.tagGroup_id",$category_tagGroup->tagGroup['id'])->order("value");

            foreach ($product_tags as $product_tag) {
                $tags[] = $product_tag->tag['value'];
            }
            
            $default = implode(',', $tags);
            if($default != '') $default .= ', ';
            $form['tags'][$category_tagGroup['category_id']][$category_tagGroup['tagGroup_id']]->setDefaultValue($default);
        }

        $form->removeComponent($form['sendNext']);
        $form->removeComponent($form['send']);
        
        $form->addSubmit('send', 'Uložit');
        $form->onSubmit[] = array($this, 'editSubmit');

        return $form;
    }
    
    public function editSubmit($form) {

        $values = $form->getValues();

        try {
            ProductModel::editProduct($values);
            $id = $values['product']['id'];
            /*Environment::getCache()->clean(array(
                Cache::TAGS => array("product/$id","products","tag")
            ));*/
            $this->flashMessage('Změny byly uloženy.', 'success');
  
            $this->redirect('this');
            
        } catch (PDOException $e) {
            if($e->errorInfo[1] == 1062) {
                if (strpos($e->getMessage(), $values['product']['url_slug'])) {
                    $form->addError("Produkt s touto URL již existuje, musíte zvolit jinou url. Je také možné že tento produkt již v databázi máte, editujte tedy dosavadní produkt.");
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
    
    protected function createComponentImages($name) {
        $form = new AppForm($this, $name);
        
        $form->addSubmit('send', 'Uložit');
        $form->onSubmit[] = array($this, 'imagesSubmit');

        return $form;
    }
    
    public function imagesSubmit($form) {
        $values = $form->getValues();
        if(isset($_POST['flash_uploader']))
            $values['flash_uploader'] = $_POST['flash_uploader'];

        $product = $this->fetchRow('product', $this->getParam('id'));
        try {
            ProductModel::saveImages($product, $values);
            /*Environment::getCache()->clean(array(
                Cache::TAGS => array("products", "product/$product[id]")
            ));*/
            $this->flashMessage('Obrázky uloženy.', 'success');
  
            $this->redirect('this');
            
        } catch (PDOException $e) {

            $form->addError('Nastala chyba při ukládání do databáze.');
            
            $this->invalidateControl('formerrors');
            Debug::log($e, Debug::ERROR);
        }

    }

    protected function createComponentUpload($name) {
        $multiUpload = new MultiUpload();

        return $multiUpload;
    }
    
    public function createComponentVariantsGrid($name) {        
        $product = $this->fetchRow('product', $this->getParam('id'));
        
        $grid = new DataGrid($this,$name);
        
        $translator = new GettextTranslator(Environment::expand(APP_DIR.'/templates/grid.cs.mo'));
        $grid->setTranslator($translator);

        $grid->bindDataTable(dibi::dataSource('SELECT product.*
                        FROM product
                        LEFT JOIN unit ON (product.unit_id = unit.id)
                        WHERE productType_id = %i',$product['productType_id']));

        //nastaveni
        $grid->displayedItems = array(10, 20, 50);

        //sloupce');
        $grid->addColumn('productPhoto_id', 'Obrázek');
        $grid->addColumn('name', 'Název');
        $grid->addColumn('price', 'Cena');
        $grid->addColumn('newprice', 'Akční cena');
        $grid->addColumn('active', 'Aktivní');
        $grid->addColumn('recommended', 'Doporučujeme');
        
        //
        $grid['price']->formatCallback[] = 'Helpers::currencyKc';
        $grid['newprice']->formatCallback[] = 'Helpers::currencyKc';
        $grid['productPhoto_id']->formatCallback[] = 'Helpers::productPhotoGrid';
        
        //filtry
        $grid['active']->addSelectboxFilter(array( '0' => "Ne", '1' => "Ano"), TRUE);
        $grid['recommended']->addSelectboxFilter(array( '0' => "Ne", '1' => "Ano"), TRUE);
        //$grid['price']->addFilter();
        $grid['name']->addFilter();

         //vychozi razeni
        $grid['name']->addDefaultSorting();

        // povolí ukládání stavů komponenty do session
        $grid->rememberState = TRUE;

        // nastavíme klíč pro akce (a také i pro operace, o těch později)
        $grid->keyName = 'id';

        // přidáme sloupec pro akce (sloupců může být i více)
        $grid->addActionColumn('Akce');

        // a naplníme datagrid akcemi pomocí továrničky
        $grid->addAction('editovat', 'edit', Html::el('span')->class('btn info')->setText("editovat"), $useAjax = FALSE,'id');
        $grid->addAction('smazat', 'confirmForm:confirmDelete!', Html::el('span')->class('btn danger')->setText("smazat"), $useAjax = TRUE);
        
        // nadefinujeme si operace, tyto hodnoty je možno nechat překládat translatorem
        $operations = array('delete' => 'smazat','activate' => 'aktivovat', 'deactivate' => 'deaktivovat');

        // poté callback(y), které mají operaci zpracovat
        $callback = array($this, 'gridOperationHandler'); // $this je presenter

        // povolíme operace
        $grid->allowOperations($operations, $callback);
        
        //replacement
        $el = Html::el('span');
        $grid['active']->replacement['1'] = clone $el->class("ui-icon ui-icon-check")->title("Ano");
        $grid['active']->replacement['0'] = clone $el->class("ui-icon ui-icon-closethick")->title("Ne");
        $grid['recommended']->replacement['1'] = clone $el->class("ui-icon ui-icon-check")->title("Ano");
        $grid['recommended']->replacement['0'] = clone $el->class("ui-icon ui-icon-closethick")->title("Ne");
        
        //styly
        $grid['active']->getHeaderPrototype()->style('width: 90px');
        $grid['recommended']->getHeaderPrototype()->style('width: 110px');
        
        return $grid;
    
    }

    public function createComponentProductGrid($name) {
        $grid = new DataGrid($this,$name);
        
        $translator = new GettextTranslator(Environment::expand(APP_DIR.'/templates/grid.cs.mo'));
        $grid->setTranslator($translator);

        $grid->bindDataTable(dibi::dataSource('SELECT product.*, category.name AS category
                        FROM product
                        LEFT JOIN category ON (product.category_id = category.id)
                        LEFT JOIN unit ON (product.unit_id = unit.id)'));

        //nastaveni
        $grid->displayedItems = array(10, 20, 50);

        //sloupce
        $grid->addColumn('category_id', 'Kategorie');
        $grid->addColumn('productPhoto_id', 'Obrázek');
        $grid->addColumn('name', 'Název');
        $grid->addColumn('price', 'Cena');
        $grid->addColumn('newprice', 'Akční cena');
        $grid->addColumn('active', 'Aktivní');
        $grid->addColumn('recommended', 'Doporučujeme');
        
        //
        $grid['price']->formatCallback[] = 'Helpers::currencyKc';
        $grid['newprice']->formatCallback[] = 'Helpers::currencyKc';
        $grid['productPhoto_id']->formatCallback[] = 'Helpers::productPhotoGrid';

        $categories = BaseModel::fetchPairs('category', 'name');
        
        //filtry
        $grid['category_id']->addSelectboxFilter($categories);
        $grid['active']->addSelectboxFilter(array( '0' => "Ne", '1' => "Ano"), TRUE);
        $grid['recommended']->addSelectboxFilter(array( '0' => "Ne", '1' => "Ano"), TRUE);
        //$grid['price']->addFilter();
        $grid['name']->addFilter();

         //vychozi razeni
        $grid['name']->addDefaultSorting();
        // výchozí filtrování
        if($this->getParam('category_id')) {
            $grid['category_id']->addDefaultFiltering($this->getParam('category_id')); // výchozí filtrování
        }
        
        // povolí ukládání stavů komponenty do session
        $grid->rememberState = TRUE;

        // nastavíme klíč pro akce (a také i pro operace, o těch později)
        $grid->keyName = 'id';

        // přidáme sloupec pro akce (sloupců může být i více)
        $grid->addActionColumn('Akce');

        // a naplníme datagrid akcemi pomocí továrničky
        $grid->addAction('editovat', 'edit', Html::el('span')->class('btn info')->setText("editovat"), $useAjax = FALSE,'id');
        $grid->addAction('smazat', 'confirmForm:confirmDelete!', Html::el('span')->class('btn danger')->setText("smazat"), $useAjax = TRUE);
        
        // nadefinujeme si operace, tyto hodnoty je možno nechat překládat translatorem
        $operations = array('delete' => 'smazat','activate' => 'aktivovat', 'deactivate' => 'deaktivovat');

        // poté callback(y), které mají operaci zpracovat
        $callback = array($this, 'gridOperationHandler'); // $this je presenter

        // povolíme operace
        $grid->allowOperations($operations, $callback);
        
        //replacement
        $el = Html::el('span');
        $grid['active']->replacement['1'] = clone $el->class("ui-icon ui-icon-check")->title("Ano");
        $grid['active']->replacement['0'] = clone $el->class("ui-icon ui-icon-closethick")->title("Ne");
        $grid['recommended']->replacement['1'] = clone $el->class("ui-icon ui-icon-check")->title("Ano");
        $grid['recommended']->replacement['0'] = clone $el->class("ui-icon ui-icon-closethick")->title("Ne");
        
        foreach($categories as $id => $name) {
            $grid['category_id']->replacement[$id] = $name;
        }
        
        //styly
        $grid['active']->getHeaderPrototype()->style('width: 90px');
        $grid['recommended']->getHeaderPrototype()->style('width: 110px');
        
        return $grid;
    }
    
    public function gridOperationHandler(SubmitButton $button)
    {
        $form = $button->getParent();
        $grid = $this->getComponent('productGrid');
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
                    $this->deleteProduct($id);
                    
                }
                
                break;
            case 'activate':
                foreach($keys as $id) {
                    $this->activateProduct($id);
                    
                }
                
                break;
            case 'deactivate':
                foreach($keys as $id) {
                    $this->deactivateProduct($id);
                    
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
        $product = $this->fetchRow('product', $params['id']);
        return sprintf('Chcete opravdu smazat produkt \'%s\'?', $product['name']);
    }

    public function delete($id) {
        try {
            $product = $this->fetchRow('product', $id);
            if($product['productPhoto_id']) $productPhoto_path = $this->fetchRow('productPhoto',$product['productPhoto_id'])->select('image_path');
            $productPhotos = BaseModel::fetchAll('productPhoto')->where('product_id',$id);

            //smazat temp perex obrazky
            $temp = WWW_DIR.'/static/temp/';
            foreach($productPhotos as $productPhoto) {
                list($name, $suffix) = explode('.',$productPhoto['image_path'],2);
                foreach (Finder::findFiles(basename($name).'_*.*')->in($temp) as $key => $file) {
                        @unlink($key);
                }
            }
            $productPhotos->delete();
            
            if($product['productPhoto_id']) {
                list($name, $suffix) = explode('.',$productPhoto_path,2);
                foreach (Finder::findFiles(basename($name).'_*.*')->in($temp) as $key => $file) {
                        @unlink($key);
                }
            }
            if($product['visualisation_path']) {
                list($name, $suffix) = explode('.',$product['visualisation_path'],2);
                foreach (Finder::findFiles(basename($name).'_*.*')->in($temp) as $key => $file) {
                        @unlink($key);
                }
            }

            $delete = $product->delete();

            if ($delete) {
                if($product['productPhoto_id']) @unlink( WWW_DIR.'/static/'.$productPhoto_path);
                if($product['visualisation_path']) @unlink( WWW_DIR.'/static/'.$product['visualisation_path']);
                
                
            }
            $this->flashMessage('Produkt '.$product['name'].' smazán','success');
           /* Environment::getCache()->clean(array(
                Cache::TAGS => array("products","product/$product[id]")
            ));*/
            
            if(!$this->isAjax())$this->redirect('default');
            
        } catch (PDOException $exc) {
            $this->flashMessage('Ajaj, nepovedlo se produkt '.$product['name'].' smazat.','error');
            Debug::log($exc, Debug::ERROR);

            //if (!$this->isAjax()) $this->redirect('this');
        }
    }
    
    //pomocna fce bez redirectu ci invalidace pro operace
    private function deleteProduct($id) {
        try {
            $product = $this->fetchRow('product', $id);
            if($product['productPhoto_id']) $productPhoto_path = $this->fetchRow('productPhoto',$product['productPhoto_id'])->select('image_path');
            $productPhotos = BaseModel::fetchAll('productPhoto')->where('product_id',$id);

            //smazat temp perex obrazky
            $temp = WWW_DIR.'/static/temp/';
            foreach($productPhotos as $productPhoto) {
                list($name, $suffix) = explode('.',$productPhoto['image_path'],2);
                foreach (Finder::findFiles(basename($name).'_*.*')->in($temp) as $key => $file) {
                        @unlink($key);
                }
            }
            $productPhotos->delete();
            
            if($product['productPhoto_id']) {
                list($name, $suffix) = explode('.',$productPhoto_path,2);
                foreach (Finder::findFiles(basename($name).'_*.*')->in($temp) as $key => $file) {
                        @unlink($key);
                }
            }
            if($product['visualisation_path']) {
                list($name, $suffix) = explode('.',$product['visualisation_path'],2);
                foreach (Finder::findFiles(basename($name).'_*.*')->in($temp) as $key => $file) {
                        @unlink($key);
                }
            }

            $delete = $product->delete();

            if ($delete) {
                if($product['productPhoto_id']) @unlink( WWW_DIR.'/static/'.$productPhoto_path);
                if($product['visualisation_path']) @unlink( WWW_DIR.'/static/'.$product['visualisation_path']);
                $this->flashMessage('Produkt '.$product['name'].' smazán','success');
            }
            
           /* Environment::getCache()->clean(array(
                Cache::TAGS => array("products","product/$product[id]")
            ));*/
        } catch (PDOException $exc) {
            $this->flashMessage('Ajaj, nepovedlo se produkt '.$product['name'].' smazat.','error');
            Debug::log($exc, Debug::ERROR);
        }
    }

    private function activateProduct($id) {
         try {
             $product = $this->fetchRow('product', $id);
             $product['active'] = 1;
             
             $product->update();
            /* Environment::getCache()->clean(array(
                Cache::TAGS => array("products","product/$id")
            ));*/
             
             $this->flashMessage('Produkt '.$product['name'].' aktivován','success');
         } catch (PDOException $exc) {
            $this->flashMessage('Ajaj, nepovedlo se produkt '.$product['name'].' aktivovat.','error');
            Debug::log($exc, Debug::ERROR);
        }
    }
    
    private function deactivateProduct($id) {
         try {
             $product = $this->fetchRow('product', $id);
             $product['active'] = 0;
             
             $product->update();
           /*  Environment::getCache()->clean(array(
                Cache::TAGS => array("products","product/$id")
            ));*/
             $this->flashMessage('Produkt '.$product['name'].' deaktivován','success');
         } catch (PDOException $exc) {
            $this->flashMessage('Ajaj, nepovedlo se produkt '.$product['name'].' deaktivovat.','error');
            Debug::log($exc, Debug::ERROR);
        }
    }

    /*public function  createComponentNewUnit($name) {
        $form = new AppForm($this, $name);
        $form->addText('name', 'Jednotka:')
                ->addRule(Form::FILLED, 'Vyplňte jednotku.');
        $form->addSubmit('send', 'Uložit');
        $form->onSubmit[] = array($this, 'newUnitSubmit');
        $form->getElementPrototype()->class[] = "ajax";

        return $form;
    }*/

    public function newUnitClicked($button) {
        $form = $button->getForm();
        $values = $form->getValues();
        if($values['unit']['name']) {
            try{
                $form['unit']['name']->setValue(NULL,TRUE);
                $unit = UnitModel::insert($values['unit']);
                $form['product']['unit_id']
                    ->setItems(BaseModel::fetchPairs('unit', 'name'))
                    ->skipFirst(' - ')
                    ->setValue($unit['id']);
                
                $this->invalidateControl('unit');
            }
            catch (PDOException $e) {
                if($e->errorInfo[1] == 1062) {
                    if (strpos($e->getMessage(), $values['unit']['name'])) {
                        $form->addError("Tato jednotka již existuje.");
                    }
                }
                else {
                    $form->addError('Nastala chyba při ukládání do databáze.');
                }
                Debug::log($e, Debug::ERROR);
            }
        }
    }

}
