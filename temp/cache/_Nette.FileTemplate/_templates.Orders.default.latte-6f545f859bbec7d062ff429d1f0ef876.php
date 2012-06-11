<?php //netteCache[01]000363a:2:{s:4:"time";s:21:"0.50458900 1338986050";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:77:"/var/www/webtoad/interierdecor/app/AdminModule/templates/Orders.default.latte";i:2;i:1326228524;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/AdminModule/templates/Orders.default.latte

?><?php
$_l = LatteMacros::initRuntime($template, NULL, 'jnn4yjzuis'); unset($_extends);


//
// block js
//
if (!function_exists($_l->blocks['js'][] = '_lbcdcbd512b9_js')) { function _lbcdcbd512b9_js($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'js', $template->getParams()) ?>
    <script type="text/javascript">
        head.js("<?php echo $staticUri ?>/js/datagrid.js");
        
    head.ready(function() {
    $(document).ready(function(){

        $('a[title=smazat]').livequery( function() {
            $(this).click(function() {
                $('#snippet-confirmForm-').dialog('open');
            });
        });

        $("#snippet-confirmForm-").dialog("destroy");

        $("#snippet-confirmForm-").dialog({
                            autoOpen: false,
                            modal: true,
                            title: 'Potvrzení akce',
                            width:590,
                            buttons: {

                            }
        });

        $("#frmform-no").livequery('click', function(event) {
            event.preventDefault();
            $("#snippet-confirmForm-").dialog('close')
        });

    });
    });
    </script>
<?php
}}


//
// block layout
//
if (!function_exists($_l->blocks['layout'][] = '_lb98895445f5_layout')) { function _lb98895445f5_layout($_l, $_args) { extract($_args)
?>
<div class="container-fluid">
        <div class="page-header">
            <h1>Objednávky</h1>
        </div>
        
<div id="<?php echo $control->getSnippetId('flashes') ?>"><?php call_user_func(reset($_l->blocks['_flashes']), $_l, $template->getParams()) ?></div>            
        <div id="<?php echo $control->getSnippetId('grid') ?>"><?php call_user_func(reset($_l->blocks['_grid']), $_l, $template->getParams()) ?></div>

        </div>

<?php
}}


//
// block _flashes
//
if (!function_exists($_l->blocks['_flashes'][] = '_lb25373d97e0__flashes')) { function _lb25373d97e0__flashes($_l, $_args) { extract($_args); $control->validateControl('flashes')
;foreach ($iterator = $_l->its[] = new SmartCachingIterator($flashes) as $flash): ?>
            <div class="flash alert-message <?php echo TemplateHelpers::escapeHtml($flash->type) ?>">

                <a class="close" href="#">×</a>
                <?php echo TemplateHelpers::escapeHtml($flash->message) ?>

            </div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ;
}}


//
// block _grid
//
if (!function_exists($_l->blocks['_grid'][] = '_lba240f5a7b7__grid')) { function _lba240f5a7b7__grid($_l, $_args) { extract($_args); $control->validateControl('grid')
;$_ctrl = $control->getWidget("ordersGrid"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render() ;
}}

//
// end of blocks
//

if ($_l->extends) {
	ob_start();
} elseif (isset($presenter, $control) && $presenter->isAjax() && $control->isControlInvalid()) {
	return LatteMacros::renderSnippets($control, $_l, get_defined_vars());
}
$title = 'Objednávky' ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['js']), $_l, get_defined_vars()); } ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['layout']), $_l, get_defined_vars()); }  
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
