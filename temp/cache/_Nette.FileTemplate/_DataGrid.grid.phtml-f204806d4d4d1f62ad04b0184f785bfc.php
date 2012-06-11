<?php //netteCache[01]000351a:2:{s:4:"time";s:21:"0.16242200 1337153124";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:65:"/var/www/webtoad/interierdecor/app/components/DataGrid/grid.phtml";i:2;i:1322230935;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/components/DataGrid/grid.phtml

?><?php
$_l = LatteMacros::initRuntime($template, NULL, 'd2foq8wmqu'); unset($_extends);


//
// block _
//
if (!function_exists($_l->blocks['_'][] = '_lb3b48404027__')) { function _lb3b48404027__($_l, $_args) { extract($_args); $control->validateControl(false)
?>

<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($flashes) as $flash): ?>
<div class="flash alert-message <?php echo TemplateHelpers::escapeHtml($flash->type) ?>">
    <a class="close" href="#">×</a>
    <?php echo TemplateHelpers::escapeHtml($flash->message) ?>

</div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>

<?php if (is_object($control)) $_ctrl = $control; else $_ctrl = $control->getWidget($control); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('begin') ;if (is_object($control)) $_ctrl = $control; else $_ctrl = $control->getWidget($control); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('errors') ;if (is_object($control)) $_ctrl = $control; else $_ctrl = $control->getWidget($control); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('body') ;if (is_object($control)) $_ctrl = $control; else $_ctrl = $control->getWidget($control); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('end') ?>

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
?><div id="<?php echo $control->getSnippetId(false) ?>"><?php call_user_func(reset($_l->blocks['_']), $_l, $template->getParams()) ?></div><?php
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
