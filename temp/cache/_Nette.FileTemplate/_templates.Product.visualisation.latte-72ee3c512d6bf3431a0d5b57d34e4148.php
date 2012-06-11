<?php //netteCache[01]000370a:2:{s:4:"time";s:21:"0.06593200 1337170065";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:84:"/var/www/webtoad/interierdecor/app/AdminModule/templates/Product.visualisation.latte";i:2;i:1323530656;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/AdminModule/templates/Product.visualisation.latte

?><?php
$_l = LatteMacros::initRuntime($template, true, 'uu6ra6ru5l'); unset($_extends);


//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbc5130b76d5_content')) { function _lbc5130b76d5_content($_l, $_args) { extract($_args)
?>
    <div class="page-header">
        <h1>Vizualizace produktu <?php echo TemplateHelpers::escapeHtml($product['name']) ?></h1>
    </div>
            
<div id="<?php echo $control->getSnippetId('flashes') ?>"><?php call_user_func(reset($_l->blocks['_flashes']), $_l, $template->getParams()) ?></div>            
<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $control->getWidget($form); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('begin') ?>
     
<div id="<?php echo $control->getSnippetId('formerrors') ?>"><?php call_user_func(reset($_l->blocks['_formerrors']), $_l, $template->getParams()) ?></div>             
    <div class="row">
         <div class="span19">
             <fieldset>
                        <div class="clearfix">
                            <div class="inline-inputs">
                                                                Výška produktu:
                                <?php echo $form['visualisation_height']->control->class('mini') ?> m
                                
                                                                <span class="divider">Šířka produktu:</span>
                                <?php echo $form['visualisation_width']->control->class('mini') ?> m
                            </div>
                        </div>
                        <div class="clearfix visualisation">
                            <?php echo TemplateHelpers::escapeHtml($form['name']->control) ?>

                            <?php echo TemplateHelpers::escapeHtml($form['tmpname']->control) ?>

                            
<div id="<?php echo $control->getSnippetId('visualisation') ?>"><?php call_user_func(reset($_l->blocks['_visualisation']), $_l, $template->getParams()) ?></div>                             
                         </div>
<?php $_ctrl = $control->getWidget("upload"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->renderVisualisation() ?>

                    </fieldset>
         </div>
    </div>

    <div class="actions">          
        <?php echo TemplateHelpers::escapeHtml($form['send']->control->class('btn primary large')) ?>

         <a class="btn danger large" href="<?php echo TemplateHelpers::escapeHtml($control->link("deleteVisualisation!", array('id'=>$product['id']))) ?>">smazat vizualizaci</a>

    </div>

<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $control->getWidget($form); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('end') ?>

<?php
}}


//
// block _flashes
//
if (!function_exists($_l->blocks['_flashes'][] = '_lb51e8139088__flashes')) { function _lb51e8139088__flashes($_l, $_args) { extract($_args); $control->validateControl('flashes')
;foreach ($iterator = $_l->its[] = new SmartCachingIterator($flashes) as $flash): ?>
    <div class="flash alert-message <?php echo TemplateHelpers::escapeHtml($flash->type) ?>">

        <a class="close" href="#">×</a>
        <?php echo TemplateHelpers::escapeHtml($flash->message) ?>

    </div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ;
}}


//
// block _formerrors
//
if (!function_exists($_l->blocks['_formerrors'][] = '_lbec5056463b__formerrors')) { function _lbec5056463b__formerrors($_l, $_args) { extract($_args); $control->validateControl('formerrors')
;$errors = $form->errors ;if ($errors): ?>
    <div class="alert-message error block-message">

        <ul><?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($errors) as $error): ?>
            <li><?php echo TemplateHelpers::escapeHtml($error) ?></li>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
        </ul>
    </div>
<?php endif ;
}}


//
// block _visualisation
//
if (!function_exists($_l->blocks['_visualisation'][] = '_lb3bffd30eb6__visualisation')) { function _lb3bffd30eb6__visualisation($_l, $_args) { extract($_args); $control->validateControl('visualisation')
?>
                                <div class="thumb">
<?php if (isset($visualisation)): ?>
                                    <?php echo TemplateHelpers::escapeHtml($visualisation['thumb']) ?>

<?php else: ?>
                                    <ul class="media-grid">
                                        <li><div class="a"><img class="thumbnail" src="http://placehold.it/50x67" alt="" /></div></li>
                                    </ul>
<?php endif ?>
                                </div>
<?php
}}

//
// end of blocks
//

if ($_l->extends) {
	ob_start();
} elseif (isset($presenter, $control) && $presenter->isAjax() && $control->isControlInvalid()) {
	return LatteMacros::renderSnippets($control, $_l, get_defined_vars());
}
$_l->extends = 'Product.layout.latte' ?>

<?php $title = 'Vizualizace produktu' ?>

       

<?php
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
