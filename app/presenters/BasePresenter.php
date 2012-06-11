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
abstract class BasePresenter extends Presenter
{
    const DPH = 0.2;

    protected $translator;

    protected function startup() {
		$this->translator = new Translator;
                //TODO translate into english
		/*Rules::$defaultMessages = array(
                        Form::FILLED => 'Pole %label musí být vyplněno',
			Form::MAX_LENGTH => 'Maximální délka pole %label je %d znaků.',
                        Form::FLOAT => 'Pole %label musí být numerické'
		);*/

		return parent::startup();
	}

    function templatePrepareFilters($template) {
		$template->registerFilter('TemplateFilters::removePhp');
                return parent::templatePrepareFilters($template);
    }

    protected function beforeRender() {
        $this->template->staticUri = $this->template->baseUri . "/static";
	TemplateHelpers::$dateFormat = $this->translator->translate('j.n.Y');
	$this->template->setTranslator($this->translator);

        $this->template->registerHelper('ucfirst','ucfirst');
        $this->template->registerHelper('currencyKc', 'Helpers::currencyKc');
        $this->template->registerHelper('currency', 'Helpers::currency');
        $this->template->registerHelper('roundUp', 'Helpers::roundUp');
        $this->template->registerHelper('dph', 'Helpers::dph');
        $this->template->registerHelper('image', 'Helpers::image');
        $this->template->registerHelper('imageDb', 'Helpers::imageDb');
        
        $texy = new Texy();

        $this->template->registerHelper('texy', callback($texy, 'process'));

    }

    public function afterRender()
    {
            if ($this->isAjax() && $this->hasFlashSession()) {
                $this->invalidateControl('flashes');
            }
    }

    protected function fetchRow($table, $id) {
		$return = BaseModel::fetchRow($table, $id);
		if (!$return) {
			throw new BadRequestException($this->translator->translate('Item not found.'));
		}
		return $return;
    }

    protected function createComponentCss()
    {
            $css = new CssLoader;

            // cesta na disku ke zdroji
            $css->sourcePath = WWW_DIR . "/static/css";

            // cesta na webu ke zdroji (kvůli absolutizaci cest v css souboru)
            $css->sourceUri = $this->template->staticUri;

            // cesta na webu k cílovému adresáři
            $css->tempUri = $this->template->staticUri. "/temp";

            // cesta na disku k cílovému adresáři
            $css->tempPath = WWW_DIR . "/static/temp";

            $css->media = 'screen';

            return $css;
        }

    protected function createComponentCssPrint()
    {
            $css = new CssLoader;

            // cesta na disku ke zdroji
            $css->sourcePath = WWW_DIR . "/static/css";

            // cesta na webu ke zdroji (kvůli absolutizaci cest v css souboru)
            $css->sourceUri = $this->template->staticUri;

            // cesta na webu k cílovému adresáři
            $css->tempUri = $this->template->staticUri. "/temp";

            // cesta na disku k cílovému adresáři
            $css->tempPath = WWW_DIR . "/static/temp";

            $css->media = 'print';

            return $css;
    }
}
