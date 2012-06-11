<?php //netteCache[01]000362a:2:{s:4:"time";s:21:"0.51108400 1338986236";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:76:"/var/www/webtoad/interierdecor/app/AdminModule/templates/Orders.detail.latte";i:2;i:1336170115;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/AdminModule/templates/Orders.detail.latte

?><?php
$_l = LatteMacros::initRuntime($template, NULL, 'lqcqml80t1'); unset($_extends);


//
// block layout
//
if (!function_exists($_l->blocks['layout'][] = '_lb27693182cc_layout')) { function _lb27693182cc_layout($_l, $_args) { extract($_args)
?>
<div class="container-fluid">
    <div class="sidebar">
        
        <div class="well">
            <h5>Změnit stav</h5>
<?php if (is_object($changeStateForm)) $_ctrl = $changeStateForm; else $_ctrl = $control->getWidget($changeStateForm); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('begin') ?>
                <div class="inline-inputs">
                    <?php echo TemplateHelpers::escapeHtml($changeStateForm['state_id']->control->class('input-small')) ?>

                                
                    <?php echo TemplateHelpers::escapeHtml($changeStateForm['change']->control->class('btn primary')) ?>

                </div>
<?php if (is_object($changeStateForm)) $_ctrl = $changeStateForm; else $_ctrl = $control->getWidget($changeStateForm); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('end') ?>
        </div>
        
        <div class="well">
            <a href="<?php echo TemplateHelpers::escapeHtml($control->link("Export:invoice", array('id'=>$sale['id']))) ?>">

                faktura excel
            </a>

            <a href="<?php echo TemplateHelpers::escapeHtml($control->link("Export:receipt", array('id'=>$sale['id']))) ?>">

                dodací list excel
            </a>

        </div>
        
        <div class="well">
            <a data-controls-modal="newproduct" data-backdrop="static" class="btn success">
                <i class="icon-plus icon-white"></i>
                přidat položku
            </a>
        </div>
        
        <div class="well">
            <a data-controls-modal="newdiscount" data-backdrop="static" class="btn success">
                <i class="icon-plus icon-white"></i>
                přidat slevu
            </a>
        </div>
       
    </div>
    
    <div class="content">
        <div class="page-header">
            <h1>Objednávka č.<?php echo TemplateHelpers::escapeHtml($sale['id']) ?> <small>Stav: <span class="label notice"><?php echo TemplateHelpers::escapeHtml($sale->state['name']) ?></span></small></h1>
        </div>
        
<div id="<?php echo $control->getSnippetId('flashes') ?>"><?php call_user_func(reset($_l->blocks['_flashes']), $_l, $template->getParams()) ?></div>        
        
        <div id="<?php echo $control->getSnippetId('products') ?>"><?php call_user_func(reset($_l->blocks['_products']), $_l, $template->getParams()) ?></div>        <div class="row">
            <div class="span8">
                <h2><?php echo TemplateHelpers::escapeHtml($template->upper('osobní údaje')) ?></h2>
                <table>
                    <tr>
                        <th>Email:</th>
                        <td> <?php echo TemplateHelpers::escapeHtml($sale['email']) ?></td>
                    </tr>
                    <tr>
                        <th>Jméno a přijmení:</th>
                        <td><?php echo TemplateHelpers::escapeHtml($sale['name']) ?></td>
                    </tr>
                    <tr>
                        <th>Telefon:</th>
                        <td><?php echo TemplateHelpers::escapeHtml($sale['phone']) ?></td>
                    </tr>
                </table>
            </div>
            <div class="span8"><?php if ($sale['iscompany']): ?>
                <h2><?php echo TemplateHelpers::escapeHtml($template->upper('chci nakoupit na firmu')) ?></h2>
<?php endif ;if ($sale['iscompany']): ?>
                <table>

                    <tr>
                        <th>Společnost:</th>
                        <td><?php echo TemplateHelpers::escapeHtml($sale['company']) ?></td>
                    </tr>
                    <tr>
                        <th>IČ:</th>
                        <td><?php echo TemplateHelpers::escapeHtml($sale['ic']) ?></td>
                    </tr><?php if ($sale['dic']): ?>
                    <tr>

                        <th>DIČ:</th>
                        <td><?php echo TemplateHelpers::escapeHtml($sale['dic']) ?></td>
                    </tr>
<?php endif ?>
                </table>
<?php endif ?>
            </div>
        </div>
        <div class="row">
            <div class="span8">
                <h2><?php if ($sale['iscompany']): echo TemplateHelpers::escapeHtml($template->upper('firemní')) ;endif ?> <?php echo TemplateHelpers::escapeHtml($template->upper('adresa')) ?> </h2>
                <table>
                    <tr>
                        <th>Město:</th>
                        <td><?php echo TemplateHelpers::escapeHtml($sale['city']) ?></td>
                    </tr>
                    <tr>
                        <th>Ulice:</th>
                        <td><?php echo TemplateHelpers::escapeHtml($sale['street']) ?></td>
                    </tr>
                    <tr>
                        <th>PSČ:</th>
                        <td><?php echo TemplateHelpers::escapeHtml($sale['postcode']) ?></td>
                    </tr>
                </table>
            </div>
            <div class="span8"><?php if ($sale['shipaddress']): ?>
                <h2><?php echo TemplateHelpers::escapeHtml($template->upper('doručit jinam')) ?></h2>
<?php endif ;if ($sale['shipaddress']): ?>
                <table>

                    <tr>
                        <th>Město:</th>
                        <td><?php echo TemplateHelpers::escapeHtml($sale['shipcity']) ?></td>
                    </tr>
                    <tr>
                        <th>Ulice: </th>
                        <td><?php echo TemplateHelpers::escapeHtml($sale['shipstreet']) ?></td>
                    </tr>
                    <tr>
                        <th>PSČ:</th>
                        <td><?php echo TemplateHelpers::escapeHtml($sale['shippostcode']) ?></td>
                    </tr>
        
                </table>
<?php endif ?>
            </div>
        </div>
    </div>
</div>

<div class="modal hide fade in" id="newproduct">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Nová položka objednávky</h3>
    </div>
<?php if (is_object($addItemForm)) $_ctrl = $addItemForm; else $_ctrl = $control->getWidget($addItemForm); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('begin') ?>
    <div class="modal-body">
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($addItemForm->getComponents(TRUE, '\Nette\Forms\Controls\HiddenField')) as $hidden): ?>
        <div><?php echo TemplateHelpers::escapeHtml($hidden->control) ?></div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>

<div id="<?php echo $control->getSnippetId('errors') ?>"><?php call_user_func(reset($_l->blocks['_errors']), $_l, $template->getParams()) ?></div>
        <div class="clearfix">
            <label class="control-label">Název:</label>
            <div class="input">
                <?php echo TemplateHelpers::escapeHtml($addItemForm['product']->control) ?>

            </div>
        </div>
        
        <div class="clearfix">
            <label class="control-label">Množství:</label>
            <div class="input">
                <?php echo TemplateHelpers::escapeHtml($addItemForm['amount']->control->class('mini')) ?>

            </div>
        </div>
        
    </div>
    <div class="modal-footer">
        <a href="#" class="close btn btn-large" data-dismiss="modal">Zavřít</a>
        <?php echo TemplateHelpers::escapeHtml($addItemForm['add']->control->class('btn primary')) ?>

    </div>
<?php if (is_object($addItemForm)) $_ctrl = $addItemForm; else $_ctrl = $control->getWidget($addItemForm); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('end') ?>
</div>

<div class="modal hide fade in" id="newdiscount">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>přidat slevu</h3>
    </div>
<?php if (is_object($discountForm)) $_ctrl = $discountForm; else $_ctrl = $control->getWidget($discountForm); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('begin') ?>
    <div class="modal-body">
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($discountForm->getComponents(TRUE, '\Nette\Forms\Controls\HiddenField')) as $hidden): ?>
        <div><?php echo TemplateHelpers::escapeHtml($hidden->control) ?></div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>

<div id="<?php echo $control->getSnippetId('discounterrors') ?>"><?php call_user_func(reset($_l->blocks['_discounterrors']), $_l, $template->getParams()) ?></div>
        <div class="clearfix" style="display: none;">
            <label class="control-label">Sleva k:</label>
            <div class="input">
                <?php echo TemplateHelpers::escapeHtml($discountForm['saleProduct_id']->control) ?>

            </div>
        </div>
        
        <div class="clearfix">
            <label class="control-label">Výše slevy: (0.01 - 1.00)</label>
            <div class="input">
                <?php echo TemplateHelpers::escapeHtml($discountForm['value']->control) ?>

            </div>
        </div>
        
    </div>
    <div class="modal-footer">
        <a href="#" class="close btn btn-large" data-dismiss="modal">Zavřít</a>
        <?php echo TemplateHelpers::escapeHtml($addItemForm['add']->control->class('btn primary')) ?>

    </div>
<?php if (is_object($discountForm)) $_ctrl = $discountForm; else $_ctrl = $control->getWidget($discountForm); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('end') ?>
</div>


<?php
}}


//
// block _flashes
//
if (!function_exists($_l->blocks['_flashes'][] = '_lb3602e1d5dc__flashes')) { function _lb3602e1d5dc__flashes($_l, $_args) { extract($_args); $control->validateControl('flashes')
;foreach ($iterator = $_l->its[] = new SmartCachingIterator($flashes) as $flash): ?>
        <div class="flash alert-message <?php echo TemplateHelpers::escapeHtml($flash->type) ?>">

            <a class="close" href="#">×</a>
                    <?php echo TemplateHelpers::escapeHtml($flash->message) ?>

        </div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ;
}}


//
// block _products
//
if (!function_exists($_l->blocks['_products'][] = '_lb08221aaea5__products')) { function _lb08221aaea5__products($_l, $_args) { extract($_args); $control->validateControl('products')
?>
        <table class="zebra-striped">

            <tr>
                <th>Produkt:</th>
                <th>Cena za kus:</th>
                <th>Množství:</th>
                <th>Cena bez DPH:</th>
                <th>Cena s DPH:</th>
                <th>&nbsp;</th>
            </tr>
<?php $productsprice = 0 ;foreach ($iterator = $_l->its[] = new SmartCachingIterator($products) as $product): ?>
            <tr>

                <td class="product">
                    <a href="<?php echo TemplateHelpers::escapeHtml($presenter->link(":Front:Product:", array('id' => $product['product_id']))) ?>"><?php echo TemplateHelpers::escapeHtml($product["name"]) ?></a>
                </td>
                <td class="silver price oneunitprice">
                    <?php echo TemplateHelpers::escapeHtml($template->currency($product["price"])) ?> bez DPH
                </td>
                <td class="strong">
                    <?php echo TemplateHelpers::escapeHtml($product['amount']) ?> <?php echo TemplateHelpers::escapeHtml($product['unit']) ?>

                    <a class="ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("changeAmount!", array('product_id'=>$product['product_id'],'amount'=>$product['amount']+1))) ?>">+</a> 
<?php if ($product['amount']>1): ?>
                    <a class="ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("changeAmount!", array('product_id'=>$product['product_id'],'amount'=>$product['amount']-1))) ?>">-</a>
<?php endif ?>
                </td>
<?php $price = $product["price"] * $product['amount'] ?>
                <td class="silver price">
                    <?php echo TemplateHelpers::escapeHtml($template->currency($price)) ?> bez DPH
                </td>
                <td class="price">
                    <span><?php echo TemplateHelpers::escapeHtml($template->currency($product["total"])) ?></span> s DPH
                </td>
<?php $productsprice += $price ?>
                <td><a class="ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("removeItem!", array('product_id'=>$product['product_id']))) ?>">odebrat</a></td>
            </tr>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
            
            <tr class="summary">
                <td class="empty">&nbsp;</td>
                <td class="empty">&nbsp;</td>
                <td class="strong">celkem:</td>
                <td class="price"><?php echo TemplateHelpers::escapeHtml($template->currency($productsprice)) ?> bez DPH</td>
                <td class="price"><span><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($productsprice, BasePresenter::DPH))) ?></span> s DPH</td>
                <td>&nbsp;</td>
            </tr>
        <?php if ($saleDiscount['total'] > 0): ?>
            <tr>

                <td class="empty">sleva</td>
                <td class="empty">&nbsp;</td>
                <td class="strong"><?php echo TemplateHelpers::escapeHtml($saleDiscount['value'] * 100) ?> %</td>
                <td class="price">- <?php echo TemplateHelpers::escapeHtml($template->currency($saleDiscount['total'] * 100 /(100+($sale['dph']*100)))) ?> bez DPH</td>
                <td class="price"><span>- <?php echo TemplateHelpers::escapeHtml($template->currency($saleDiscount['total'])) ?></span> s DPH</td>
                <td><a class="ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("removeDiscount!", array('saleDiscount_id'=>$saleDiscount['id']))) ?>">odebrat</a></td>
            </tr>
<?php endif ?>
            
            <tr>
                <td>Způsob doručení: <strong><?php echo TemplateHelpers::escapeHtml($sale['shipping']) ?></strong></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="price"><span><?php echo TemplateHelpers::escapeHtml($template->currency($sale['shippingPrice'])) ?></span> s DPH</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Způsob platby: <strong><?php echo TemplateHelpers::escapeHtml($sale['paymethod']) ?></strong></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="price"><span><?php echo TemplateHelpers::escapeHtml($template->currency($sale['paymethodPrice'])) ?></span> s DPH</td>
                <td>&nbsp;</td>
            </tr>
            <tr class="summary">
                <td class="empty">&nbsp;</td>
                <td class="empty">&nbsp;</td>
                <td class="strong">celkem k úhradě:</td>
                <td>&nbsp;</td>
                <td class="price"><span><?php echo TemplateHelpers::escapeHtml($template->currency($sale['total'])) ?></span> s DPH</td>
                <td>&nbsp;</td>
            </tr>
        </table>
<?php
}}


//
// block _errors
//
if (!function_exists($_l->blocks['_errors'][] = '_lbf20e69a698__errors')) { function _lbf20e69a698__errors($_l, $_args) { extract($_args); $control->validateControl('errors')
;if ($addItemForm->hasErrors()): ?>
        <div class="row">
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($addItemForm->errors) as $error): ?>
                <div class="alert-message warning">

                    <?php echo $error ?>

                </div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
        </div>
<?php endif ;
}}


//
// block _discounterrors
//
if (!function_exists($_l->blocks['_discounterrors'][] = '_lb6d403a8ef9__discounterrors')) { function _lb6d403a8ef9__discounterrors($_l, $_args) { extract($_args); $control->validateControl('discounterrors')
;if ($discountForm->hasErrors()): ?>
        <div class="row">
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($discountForm->errors) as $error): ?>
                <div class="alert-message warning">

                    <?php echo $error ?>

                </div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
        </div>
<?php endif ;
}}

//
// end of blocks
//

if ($_l->extends) {
	ob_start();
} elseif (isset($presenter, $control) && $presenter->isAjax() && $control->isControlInvalid()) {
	return LatteMacros::renderSnippets($control, $_l, get_defined_vars());
}
$title = 'Detail objednávky' ?>


<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['layout']), $_l, get_defined_vars()); }  
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
