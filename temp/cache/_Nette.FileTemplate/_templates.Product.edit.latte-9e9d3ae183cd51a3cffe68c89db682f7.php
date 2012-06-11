<?php //netteCache[01]000361a:2:{s:4:"time";s:21:"0.12374200 1337153147";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:75:"/var/www/webtoad/interierdecor/app/AdminModule/templates/Product.edit.latte";i:2;i:1332157159;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/AdminModule/templates/Product.edit.latte

?><?php
$_l = LatteMacros::initRuntime($template, true, 's3fuo3whap'); unset($_extends);


//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbd6609133ea_content')) { function _lbd6609133ea_content($_l, $_args) { extract($_args)
?>
            <div class="page-header">
                <h1>Editovat produkt <?php echo TemplateHelpers::escapeHtml($product['name']) ?></h1>
            </div>
            
            
<div id="<?php echo $control->getSnippetId('flashes') ?>"><?php call_user_func(reset($_l->blocks['_flashes']), $_l, $template->getParams()) ?></div>            
<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $control->getWidget($form); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('begin') ?>
            
<div id="<?php echo $control->getSnippetId('formerrors') ?>"><?php call_user_func(reset($_l->blocks['_formerrors']), $_l, $template->getParams()) ?></div>            
            <div class="row">
                <div class="span no-margin">
                <div class="row no-margin">
                <div class="span7">
                    <fieldset>
                        <legend>Obrázek</legend>
                        
                        <?php echo TemplateHelpers::escapeHtml($form['productPhoto']['name']->control) ?>

                        <?php echo TemplateHelpers::escapeHtml($form['productPhoto']['tmpname']->control) ?>


                        <div class="clearfix">
<div id="<?php echo $control->getSnippetId('perexPhoto') ?>"><?php call_user_func(reset($_l->blocks['_perexPhoto']), $_l, $template->getParams()) ?></div>                        </div>
<?php $_ctrl = $control->getWidget("upload"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->renderPerexPhoto() ?>

                              
                    </fieldset>
                </div>
                
                <div class="span8">
                    <fieldset>
                        <legend>Základní údaje</legend>
                        <div class="clearfix">
                            <?php echo TemplateHelpers::escapeHtml($form['product']['category_id']->label) ?>

                            <div class="input">
                                <?php echo TemplateHelpers::escapeHtml($form['product']['category_id']->control) ?>

                            </div>
                        </div>
                        <div class="clearfix">
                            <?php echo TemplateHelpers::escapeHtml($form['product']['name']->label) ?>

                            <div class="input">
                                <?php echo TemplateHelpers::escapeHtml($form['product']['name']->control) ?>

                            </div>
                        </div>
                        <div class="clearfix">
                            <?php echo TemplateHelpers::escapeHtml($form['product']['url_slug']->label) ?>

                            <div class="input">
                                <?php echo TemplateHelpers::escapeHtml($form['product']['url_slug']->control) ?>

                            </div>
                        </div>
                        <div class="clearfix">
                            <?php echo TemplateHelpers::escapeHtml($form['product']['price']->label) ?>

                            <div class="input">
                                <div class="inline-inputs">
                                <?php echo TemplateHelpers::escapeHtml($form['product']['price']->control->class('mini')) ?>

<span id="<?php echo $control->getSnippetId('unit') ?>"><?php call_user_func(reset($_l->blocks['_unit']), $_l, $template->getParams()) ?></span>                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <?php echo TemplateHelpers::escapeHtml($form['product']['newprice']->label) ?>

                            <div class="input">
                                <?php echo TemplateHelpers::escapeHtml($form['product']['newprice']->control->class('mini')) ?>

                                <span class="help-inline">Produkt bude označen značkou Akce.</span>
                            </div>
                        </div>
                        <div class="clearfix">
                            <?php echo TemplateHelpers::escapeHtml($form['product']['recommended']->label) ?>

                            <div class="input">
                                <div class="inputs-list">
                                    <label>
                                        <?php echo TemplateHelpers::escapeHtml($form['product']['recommended']->control) ?>

                                        <span>Produkt bude označen značkou Doporučujeme a zobrazen v sekci Doporučujeme.</span>
                                    </label>
                                </div>
                                
                            </div>
                        </div>
                    </fieldset>
                    
                </div>
                </div>
                
                <div class="row no-margin">
                <div class="span15">
                    <fieldset>
                        <legend>Popis produktu</legend>
                        <div class="form-stacked">
                        <div class="clearfix">

                            <div class="input">
                                <?php echo TemplateHelpers::escapeHtml($form['product']['description_html']->control->class('span14')->rows(8)) ?>

                                <span class="help-block">Textový popis produktu je velmi důležitým prvkem, jak pro zákazníka, tak pro vyhledávače.</span>
                            </div>
                        </div>
                        </div>
                    </fieldset>
                </div>
                </div>
                </div>
                <div class="span12">
                    <fieldset>
                        <legend>Specifikace:</legend>
<?php $tags = $form['tags'] ;foreach ($iterator = $_l->its[] = new SmartCachingIterator($tags->getComponents()) as $tag): ?>
                        <div id="<?php echo TemplateHelpers::escapeHtml($tag->getName()) ?>">

<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($tag->controls) as $ctl): if (!$ctl->getOption('rendered') && $ctl->getForm(FALSE) === $form): ?>
                            <div class="clearfix">

                                                                    <?php if ($ctl instanceof Button || $ctl instanceof Checkbox): ?>&nbsp;<?php else: echo $ctl->label ;endif ?>

                                
                                <div class="input">
                                    <?php echo $ctl->control->class('span9') ;if ($ctl instanceof Checkbox): echo $ctl->label ;endif ?>

                                </div>
                                <script type="text/javascript">
                                    head.ready(function() {

                                            function split( val ) {
                                                    return val.split( /,\s*/ );
                                            }
                                            function extractLast( term ) {
                                                    return split( term ).pop();
                                            }

                                            $('input[name="tags[<?php echo $tag->getName() ?>][<?php echo $ctl->getName() ?>]"]').livequery(function() {
                                                $(this)// don't navigate away from the field on tab when selecting an item
                                                    .bind( "keydown", function( event ) { 
                                                            if ( event.keyCode === $.ui.keyCode.TAB &&
                                                                            $( this ).data( "autocomplete" ).menu.active ) {
                                                                    event.preventDefault();
                                                            }
                                                    })
                                                    .autocomplete({
                                                            minLength: 0,
                                                            source: function( request, response ) {
                                                                    $.getJSON( <?php echo TemplateHelpers::escapeJs($presenter->link("availableTags!")) ?>, {
                                                                        tagGroup: <?php echo TemplateHelpers::escapeJs($ctl->getName()) ?>

                                                                    }, function(payload) {
                                                                        // delegate back to autocomplete, but extract the last term
                                                                        response( $.ui.autocomplete.filter(
                                                                            payload.availableTags, extractLast( request.term ) ) );
                                                                    });
                                                            },
                                                            focus: function() {
                                                                    // prevent value inserted on focus
                                                                    return false;
                                                            },
                                                            select: function( event, ui ) {
                                                                    var terms = split( this.value );

                                                                    var i = terms.indexOf(ui.item.value);
                                                                    if(i!=-1) {
                                                                        terms.splice(i, 1);
                                                                        this.value = terms;
                                                                    }
                                                                    else {
                                                                        // remove the current input
                                                                        terms.pop();
                                                                        // add the selected item
                                                                        terms.push( ui.item.value );
                                                                        // add placeholder to get the comma-and-space at the end
                                                                        terms.push( "" );
                                                                        this.value = terms.join( ", " );
                                                                    }

                                                                    return false;
                                                            },
                                                            close: function(event) {
                                                               /* if (typeof(event.handler) != '') {
                                                                    if (event.handler.guid == 26) {
                                                                        $(this).autocomplete("search","");
                                                                        return false;
                                                                    }
                                                                }*/
                                                            },
                                                            appendTo:".tags-autocomplete"
                                                    }).focus(function(){
                                                        $(this).autocomplete("search","");
                                                    })/*.mouseout(function() {
                                                        $(this).autocomplete("close");
                                                    }).data( "autocomplete" )._renderItem = function( ul, item ) {
                                                        var insert = '';
                                                        if(item.value.substr(item.value.length-1) == '*')
                                                            insert = item.value.substr(0,item.value.length-1) + '<span class="star">*</span>';
                                                        else insert = item.value;
                                                        return $( "<li></li>" )
                                                            .data( "item.autocomplete", item )
                                                            .append( "<a class=tag>" + insert + "</a>")
                                                            .appendTo( ul );
                                                    };*/
                                            });
                                });
                                </script>
                                
                            </div>
<?php endif ;endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
                        </div><?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?><div class="tags-autocomplete"></div>
                    </fieldset>  
                </div>
                
            </div>

            <div class="row">             
                <div class="span8">
                    <fieldset>
                        <legend>Soubor:</legend>
                        <div class="clearfix">
                            <?php echo TemplateHelpers::escapeHtml($form['product']['file_path']->label) ?>

                            <div class="input">
                                <?php echo TemplateHelpers::escapeHtml($form['product']['file_path']->control) ?>

                            </div>
                        </div>
                        <div class="clearfix">
                            <?php echo TemplateHelpers::escapeHtml($form['product']['file_name']->label) ?>

                            <div class="input">
                                <?php echo TemplateHelpers::escapeHtml($form['product']['file_name']->control) ?>

                            </div>
                        </div>
                    </fieldset>
                </div><?php if ($product['file_path']): ?>
                <div class="span8">
<div id="<?php echo $control->getSnippetId('files') ?>"><?php call_user_func(reset($_l->blocks['_files']), $_l, $template->getParams()) ?></div>                </div>
<?php endif ?>
            </div>

            <div class="row">
                <div class="span8">
                    <fieldset>
                        <legend>Další nastavení:</legend>
                        <div class="clearfix">
                            <?php echo TemplateHelpers::escapeHtml($form['product']['active']->label) ?>

                            <div class="input">
                                <ul class="inputs-list">
                                    <li>
                                        <label>
                                            <?php echo $form['product']['active']->getControl('1') ?>

                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <?php echo $form['product']['active']->getControl('0') ?>

                                        </label>
                                    </li>
                                </ul>
                                <span class="help-block">Pokud zvolíte, že produkt není aktivní, uloží se, ale než bude aktivován nebude v nabídce eshopu zobrazen.</span>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            
            <div class="actions">
                
                <?php if (isset($form['sendNext'])): echo TemplateHelpers::escapeHtml($form['sendNext']->control->class('btn primary large')) ;endif ?>

                <?php echo TemplateHelpers::escapeHtml($form['send']->control->class('btn primary large')) ?>

            </div>

<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $control->getWidget($form); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('end') ?>
            
        </div>
<?php
}}


//
// block _flashes
//
if (!function_exists($_l->blocks['_flashes'][] = '_lb835c0b62d2__flashes')) { function _lb835c0b62d2__flashes($_l, $_args) { extract($_args); $control->validateControl('flashes')
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
if (!function_exists($_l->blocks['_formerrors'][] = '_lb2e1bb905f6__formerrors')) { function _lb2e1bb905f6__formerrors($_l, $_args) { extract($_args); $control->validateControl('formerrors')
;$errors = $form->errors ;if ($errors): call_user_func(reset($_l->blocks['entryerrors']), $_l, get_defined_vars()) ;endif ;
}}


//
// block entryerrors
//
if (!function_exists($_l->blocks['entryerrors'][] = '_lb3e2ba9fbad_entryerrors')) { function _lb3e2ba9fbad_entryerrors($_l, $_args) { extract($_args)
?>
                <div class="alert-message error block-message">

                    <ul><?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($errors) as $error): ?>
                        <li><?php echo TemplateHelpers::escapeHtml($error) ?></li>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
                    </ul>
                </div>
<?php
}}


//
// block _perexPhoto
//
if (!function_exists($_l->blocks['_perexPhoto'][] = '_lb914c929ea5__perexPhoto')) { function _lb914c929ea5__perexPhoto($_l, $_args) { extract($_args); $control->validateControl('perexPhoto')
;if (isset($image)): ?>
                                <?php echo TemplateHelpers::escapeHtml($image['thumb']) ?>

<?php else: ?>
                                <ul class="media-grid">
                                    <li><div class="a"><img class="thumbnail" src="http://placehold.it/355x262" alt="" /></div></li>
                                </ul>
<?php endif ;
}}


//
// block _unit
//
if (!function_exists($_l->blocks['_unit'][] = '_lbfd368d6236__unit')) { function _lbfd368d6236__unit($_l, $_args) { extract($_args); $control->validateControl('unit')
?>
                                    <?php echo TemplateHelpers::escapeHtml($form['product']['unit_id']->control->class('mini')) ?>


                                    <?php echo TemplateHelpers::escapeHtml($form['unit']['name']->control->class('mini')) ?>

                                    <?php echo TemplateHelpers::escapeHtml($form['sendUnit']->control->class('btn')) ?>

<?php
}}


//
// block _files
//
if (!function_exists($_l->blocks['_files'][] = '_lbd98000a1ce__files')) { function _lbd98000a1ce__files($_l, $_args) { extract($_args); $control->validateControl('files')
?>
                    <h5>Přiložený soubor</h5>
                    <div><a href="<?php echo TemplateHelpers::escapeHtml($basePath) ;echo TemplateHelpers::escapeHtml($product['file_path']) ?>"><?php echo TemplateHelpers::escapeHtml($product['file_name']) ?></a> <a class="ajax btn btn-small" href="<?php echo TemplateHelpers::escapeHtml($control->link("deleteFile!")) ?>">smazat</a></div><?php
}}


//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lbf41c6fcea5_scripts')) { function _lbf41c6fcea5_scripts($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'scripts', $template->getParams()) ?>
    <script type="text/javascript">
    head.ready(function() {
    $(document).ready(function(){
        var perex_options = {
            toolbar: ['bold', 'italic', null,'sup','sub',null,'link']
        }
        $('[name="product[description_html]"]').texyla(perex_options);
    
    });
    });
    </script>
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

<?php $title = 'Editovat produkt' ?>

        

<?php
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
