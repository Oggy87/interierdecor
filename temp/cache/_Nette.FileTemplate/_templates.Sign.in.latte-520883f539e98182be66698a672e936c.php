<?php //netteCache[01]000356a:2:{s:4:"time";s:21:"0.66839500 1337153107";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:70:"/var/www/webtoad/interierdecor/app/AdminModule/templates/Sign.in.latte";i:2;i:1323265478;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/AdminModule/templates/Sign.in.latte

?><?php
$_l = LatteMacros::initRuntime($template, NULL, 'aizxq68u8o'); unset($_extends);


//
// block topbar
//
if (!function_exists($_l->blocks['topbar'][] = '_lb911dac63fd_topbar')) { function _lb911dac63fd_topbar($_l, $_args) { extract($_args)
;
}}


//
// block layout
//
if (!function_exists($_l->blocks['layout'][] = '_lb40c3ec5893_layout')) { function _lb40c3ec5893_layout($_l, $_args) { extract($_args)
?>
<div class="container">
    <div class="span10 middlebox signin">
        <div class="head"><h1>Přihlásit se</h1></div>

<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $control->getWidget($form); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('begin') ?>

        <!-- errors --><?php if ($form->hasErrors()): call_user_func(reset($_l->blocks['errors']), $_l, get_defined_vars()) ;endif ?>

        <fieldset>
            <div class="clearfix">
                <?php echo TemplateHelpers::escapeHtml($form['email']->label) ?>

                <div class="input"><?php echo TemplateHelpers::escapeHtml($form['email']->control) ?></div>
            </div>
            <div class="clearfix">
                <?php echo TemplateHelpers::escapeHtml($form['password']->label) ?>

                <div class="input"><?php echo TemplateHelpers::escapeHtml($form['password']->control) ?></div>
            </div>
           
            <div class="submit">
                <?php echo TemplateHelpers::escapeHtml($form['send']->control->class('btn primary large')) ?>

            </div>

        </fieldset>
<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $control->getWidget($form); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('end') ?>
    </div>
</div>
<?php
}}


//
// block errors
//
if (!function_exists($_l->blocks['errors'][] = '_lb97c06196c7_errors')) { function _lb97c06196c7_errors($_l, $_args) { extract($_args)
?>
        <div>
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($form->errors) as $error): ?>
            <div class="alert-message error"><?php echo TemplateHelpers::escapeHtml($error) ?></div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
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
$title = 'Přihlášení do administrace' ;$robots = 'noindex' ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['topbar']), $_l, get_defined_vars()); } ?>


<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['layout']), $_l, get_defined_vars()); }  
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
