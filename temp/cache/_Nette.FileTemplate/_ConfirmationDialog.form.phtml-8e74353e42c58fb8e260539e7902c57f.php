<?php //netteCache[01]000361a:2:{s:4:"time";s:21:"0.38381600 1337153124";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:75:"/var/www/webtoad/interierdecor/app/components/ConfirmationDialog/form.phtml";i:2;i:1279046444;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/components/ConfirmationDialog/form.phtml

?><?php
$_l = LatteMacros::initRuntime($template, NULL, 'b919rewhsk'); unset($_extends);


//
// block _
//
if (!function_exists($_l->blocks['_'][] = '_lb9406e4d892__')) { function _lb9406e4d892__($_l, $_args) { extract($_args); $control->validateControl(false)
;if ($visible): ?>
<div <?php if ($class != ''): ?>class="<?php echo TemplateHelpers::escapeHtml($class) ?>"<?php endif ?>>
	<?php echo TemplateHelpers::escapeHtml($question) ?>

<?php $_ctrl = $control->getWidget("form"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render() ?>
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
?><div id="<?php echo $control->getSnippetId(false) ?>"><?php call_user_func(reset($_l->blocks['_']), $_l, $template->getParams()) ?></div><?php
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
