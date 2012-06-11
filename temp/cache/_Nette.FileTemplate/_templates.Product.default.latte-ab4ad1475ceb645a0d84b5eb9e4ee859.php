<?php //netteCache[01]000364a:2:{s:4:"time";s:21:"0.69652600 1337153123";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:78:"/var/www/webtoad/interierdecor/app/AdminModule/templates/Product.default.latte";i:2;i:1326228542;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/AdminModule/templates/Product.default.latte

?><?php
$_l = LatteMacros::initRuntime($template, NULL, 'yylcu2ezxv'); unset($_extends);


//
// block js
//
if (!function_exists($_l->blocks['js'][] = '_lb4153a17668_js')) { function _lb4153a17668_js($_l, $_args) { extract($_args)
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
if (!function_exists($_l->blocks['layout'][] = '_lb2a91254b72_layout')) { function _lb2a91254b72_layout($_l, $_args) { extract($_args)
?>
<div class="container-fluid">
    <div class="sidebar">
        
        <div class="well">
            <a class="btn large primary" href="<?php echo TemplateHelpers::escapeHtml($control->link("new")) ?>">nový produkt</a>

        </div>
        
        
          </div>
    <div class="content">
        <div class="page-header">
            <h1>Přehled všech produktů</h1>
        </div>
        
<div id="<?php echo $control->getSnippetId('flashes') ?>"><?php call_user_func(reset($_l->blocks['_flashes']), $_l, $template->getParams()) ?></div>            
        <div id="<?php echo $control->getSnippetId('grid') ?>"><?php call_user_func(reset($_l->blocks['_grid']), $_l, $template->getParams()) ?></div>

<?php $_ctrl = $control->getWidget("confirmForm"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render() ?>
    </div>
</div><?php
}}


//
// block _flashes
//
if (!function_exists($_l->blocks['_flashes'][] = '_lbfa8a1a44da__flashes')) { function _lbfa8a1a44da__flashes($_l, $_args) { extract($_args); $control->validateControl('flashes')
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
if (!function_exists($_l->blocks['_grid'][] = '_lb8d9d95b68c__grid')) { function _lb8d9d95b68c__grid($_l, $_args) { extract($_args); $control->validateControl('grid')
;$_ctrl = $control->getWidget("productGrid"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render() ;
}}

//
// end of blocks
//

if ($_l->extends) {
	ob_start();
} elseif (isset($presenter, $control) && $presenter->isAjax() && $control->isControlInvalid()) {
	return LatteMacros::renderSnippets($control, $_l, get_defined_vars());
}
$title = 'Produkty' ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['js']), $_l, get_defined_vars()); } ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['layout']), $_l, get_defined_vars()); }  
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
