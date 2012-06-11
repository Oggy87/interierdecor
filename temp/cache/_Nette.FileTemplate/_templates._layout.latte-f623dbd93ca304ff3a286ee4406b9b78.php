<?php //netteCache[01]000356a:2:{s:4:"time";s:21:"0.91303100 1337109357";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:70:"/var/www/webtoad/interierdecor/app/FrontModule/templates/@layout.latte";i:2;i:1337109039;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/FrontModule/templates/@layout.latte

?><?php
$_l = LatteMacros::initRuntime($template, true, 'r5o7it1e3w'); unset($_extends);


//
// block css
//
if (!function_exists($_l->blocks['css'][] = '_lb088caa4629_css')) { function _lb088caa4629_css($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'css', $template->getParams()) ;$_ctrl = $control->getWidget("css"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('screen.css') ;
}}


//
// block layout
//
if (!function_exists($_l->blocks['layout'][] = '_lb6e51bb5e78_layout')) { function _lb6e51bb5e78_layout($_l, $_args) { extract($_args)
?>
<div id="head-container">
    <div id="head">
        <a class="logo" href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Homepage:")) ?>">úvodní stránka</a>

               <?php if ($user->isLoggedIn()): ?>

            <div id="user"><?php $customer = $user->getIdentity() ?>

                <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Customer:")) ?>"><?php echo TemplateHelpers::escapeHtml($customer->name) ?> <?php echo TemplateHelpers::escapeHtml($customer->surname) ?></a>

                <span>|</span>
                <a href="<?php echo TemplateHelpers::escapeHtml($control->link("out", array('backlink' => $presenter->getApplication()->storeRequest()))) ?>">odhlásit</a>

            </div>
<?php else: ?>
            <div id="user">
                <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Customer:signin")) ?>">Přihlášení</a>

                <span>|</span>
                <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Customer:register")) ?>">Registrovat</a>

            </div>
<?php endif ?>
        
<div id="<?php echo $control->getSnippetId('basket') ?>"><?php call_user_func(reset($_l->blocks['_basket']), $_l, $template->getParams()) ?></div>        <div class="search">
<?php $searchform = $control['searchForm'] ;if (is_object($searchform)) $_ctrl = $searchform; else $_ctrl = $control->getWidget($searchform); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('begin') ?>
                <?php echo TemplateHelpers::escapeHtml($searchform['text']->control) ;echo TemplateHelpers::escapeHtml($searchform['search']->control) ?>

<?php if (is_object($searchform)) $_ctrl = $searchform; else $_ctrl = $control->getWidget($searchform); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('end') ?>
        </div>
    </div>
</div>
<div id="menu-container">
    <div id="menu">
        <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Homepage:")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('cufon',$presenter->linkCurrent ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>úvod</a>

        <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Inspiration:", array('category_id' => NULL, 'tagGroup_id'=>NULL))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('cufon',$presenter->isLinkCurrent(':Front:Inspiration:') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>inspirace</a>

        <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Visualisation:")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('cufon',$presenter->linkCurrent ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>vizualizace</a>
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator(CategoryModel::fetch()) as $category): ?>
        <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => $category['id'], 'tags' => NULL, 'razeni' => NULL, 'from' => NULL,'to' => NULL))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('cufon',$presenter->isLinkCurrent(':Front:Category:', array('id' =>$category['id'])) ? 'active':null,(isset($product) AND $product['category_id'] == $category['id']) ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><?php echo TemplateHelpers::escapeHtml($template->lower($category['name'])) ?></a>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
        <a href="<?php echo TemplateHelpers::escapeHtml($control->link("Contact:")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('cufon',$presenter->linkCurrent ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>kontakty</a>

    </div>
</div>
<div id="page-container">
<?php LatteMacros::callBlock($_l, 'content', $template->getParams()) ?>
</div>

<div class="modal">
    <div id="basketbox">
        <div class="notice">Právě jste vložili do košíku:</div><div class="right"></div>
<div id="<?php echo $control->getSnippetId('basketproduct') ?>"><?php call_user_func(reset($_l->blocks['_basketproduct']), $_l, $template->getParams()) ?></div>        <div class="clear"></div>
        <div class="bottom">
            <div class="back">
                <div class="left"></div>
                <a class="close" href="#">zpět</a>
            </div>
            <div class="order">
                <a class="order" href="<?php echo TemplateHelpers::escapeHtml($control->link("Basket:")) ?>">objednat</a>

                <div class="right"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div><div id="footer-container">
    </div>
<?php
}}


//
// block _basket
//
if (!function_exists($_l->blocks['_basket'][] = '_lbe144cb51fb__basket')) { function _lbe144cb51fb__basket($_l, $_args) { extract($_args); $control->validateControl('basket')
;if ($user->isLoggedIn()): ?>
            
            <div id="basket">                <?php if ($basketamount > 0): ?>
                <a href="<?php echo TemplateHelpers::escapeHtml($control->link("Basket:")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('basket'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($basketsum, BasePresenter::DPH))) ?> s DPH</a>
<?php endif ?>
                <a href="<?php echo TemplateHelpers::escapeHtml($control->link("Basket:")) ?>">košík</a>  

            </div>
<?php else: ?>
            
            <div id="basket"><?php if ($basketamount > 0): ?>
                <a href="<?php echo TemplateHelpers::escapeHtml($control->link("Basket:")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('basket'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($basketsum, BasePresenter::DPH))) ?> s DPH</a>
<?php endif ?>
                <a href="<?php echo TemplateHelpers::escapeHtml($control->link("Basket:")) ?>">košík</a>

            </div>
<?php endif ;
}}


//
// block _basketproduct
//
if (!function_exists($_l->blocks['_basketproduct'][] = '_lb59b18fb718__basketproduct')) { function _lb59b18fb718__basketproduct($_l, $_args) { extract($_args); $control->validateControl('basketproduct')
;if (isset($basketproduct)): ?>
                <div class="image">
<?php if ($basketproduct['productPhoto_id']): ?>
                    <?php echo TemplateHelpers::escapeHtml($template->image($basketproduct->productPhoto['image_path'], 195, 140, $basketproduct['name'], FALSE, TRUE, FALSE, FALSE)) ?>

<?php endif ?>
                </div>
                <div class="product">
                    <div class="name"><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $basketproduct['id']))) ?>"><?php echo TemplateHelpers::escapeHtml($basketproduct['name']) ?></div></a>
                    <div class="price">
                        v ceně 
<?php if ($basketproduct["newprice"]): ?>
                            <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($basketproduct['newprice'], BasePresenter::DPH))) ?></strong> 
<?php else: ?>
                            <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($basketproduct['price'], BasePresenter::DPH))) ?></strong> 
<?php endif ?>
                         / <?php echo TemplateHelpers::escapeHtml($basketproduct->unit['name']) ?>

                    </div>
                    <div class="addbasketbox">
<?php $form = $control['addBasketForm'] ;if (is_object($form)) $_ctrl = $form; else $_ctrl = $control->getWidget($form); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('begin') ?>
                            <?php echo TemplateHelpers::escapeHtml($form['product_id']->control->setValue($basketproduct['id'])) ?>

                            v košíků <?php echo TemplateHelpers::escapeHtml($form['amount']->control->setValue("{$basketproductamount}")) ?> <?php echo TemplateHelpers::escapeHtml($form['amount']->label->setText($basketproduct->unit['name'])) ?>

                            <?php echo TemplateHelpers::escapeHtml($form['add']->control->setText('přidat')) ?>

<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $control->getWidget($form); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('end') ?>
                                           </div>
                    <div class="basket">
                        <div class="h">Celkem v košíku:</div>
<div id="<?php echo $control->getSnippetId('bask') ?>"><?php call_user_func(reset($_l->blocks['_bask']), $_l, $template->getParams()) ?></div>                    </div>
                </div>
                <div class="clear"></div>
<?php endif ;
}}


//
// block _bask
//
if (!function_exists($_l->blocks['_bask'][] = '_lbd863d9a4ae__bask')) { function _lbd863d9a4ae__bask($_l, $_args) { extract($_args); $control->validateControl('bask')
;if ($user->isLoggedIn()): if ($basketamount > 0): ?>
                            <a  href="<?php echo TemplateHelpers::escapeHtml($control->link("Basket:")) ?>"><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($basketsum, BasePresenter::DPH))) ?> s DPH</a>
<?php endif ?>
 
<?php else: if ($basketamount > 0): ?>
                            <a  href="<?php echo TemplateHelpers::escapeHtml($control->link("Basket:")) ?>"><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($basketsum, BasePresenter::DPH))) ?> s DPH</a>
<?php endif ;endif ;
}}


//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lb8fe607682f_scripts')) { function _lb8fe607682f_scripts($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'scripts', $template->getParams()) ?>
<script type="text/javascript">
        head.ready(function() {
            $("#basketbox").dialog("destroy");

            $("#basketbox").dialog({
                        autoOpen: false,
			modal: true,
                        minWidth: 800,
                        resizable: false,
                        dialogClass: 'modal',
                        zIndex : 2000
            });

            $('a.addtobasket').live('click', function() {
                    $("#basketbox").dialog('open');
            });

            $('#basketbox a.close').live('click', function() {
                    $("#basketbox").dialog('close');
            });
            
            $("#visualbox").dialog("destroy");

            $("#visualbox").dialog({
                        autoOpen: false,
			modal: true,
                        width: 1219,
                        resizable: false,
                        dialogClass: 'modal'
            });

            $('a.tovisualisation').live('click', function() {
                    $("#visualbox").dialog('open');
            });

            $('#visualbox a.close').live('click', function() {
                    $("#visualbox").dialog('close');
            });

            $("#interiermodal .wall").live('mouseenter',function() {
                $(this).children().addClass( "highlight" );
                $(this).children().addClass( "cursor-paint-texture" );
            });
            $("#interiermodal .wall").mouseleave(function() {
                $(this).children().removeClass( "highlight" );
                $(this).children().removeClass( "cursor-paint-texture" );
            });
            $("#interiermodal .wall").livequery('click',function() {
                var id = $("#visualproduct").attr("rel");
                var wall = $(this);

                    $.get(<?php echo TemplateHelpers::escapeJs($control->link("wall!")) ?>,{'productid': id, 'name': wall.attr("id")}, function(payload) {
                        wall.children().removeClass( "highlight" );
                        wall.css("background-image", "url(<?php echo $staticUri ?>/"+payload.backgroundimage+")" );
                        //wall.html('<div><div class="cloud"><a class="name" href="'+payload.product.link+'">'+payload.product.text+'</a><span class="price">'+payload.product.price+'</span><a class="addtobasket ajax" href="'+payload.product.basketlink+'"></a></div></div>');
                    });
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
$_l->extends = '../../templates/@layout.latte' ?>



<?php
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
