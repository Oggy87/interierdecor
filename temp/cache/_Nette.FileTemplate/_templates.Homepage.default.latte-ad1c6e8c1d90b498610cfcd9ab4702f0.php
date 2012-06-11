<?php //netteCache[01]000365a:2:{s:4:"time";s:21:"0.90797400 1338986009";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:79:"/var/www/webtoad/interierdecor/app/FrontModule/templates/Homepage.default.latte";i:2;i:1328261917;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/FrontModule/templates/Homepage.default.latte

?><?php
$_l = LatteMacros::initRuntime($template, NULL, '20pbt53sq8'); unset($_extends);


//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb56d0804447_content')) { function _lb56d0804447_content($_l, $_args) { extract($_args)
?>
<div id="hp">


    <div class="top">
        <h1>Chcete dát interiéru svého bytu či domu moderní vzhled?</h1>
        <blockquote>
        Oblékněte jej do unikátních tapet, vybavte jej moderním nábytkem a podlahou,
        dodekurjte jej designovými doplňky a ukažte jej v tom pravém světle.
        </blockquote>
    </div>

    <div class="mainpanel">
<?php call_user_func(reset($_l->blocks['main']), $_l, get_defined_vars()) ?>
    </div>


    <div class="leftpanel">
<?php call_user_func(reset($_l->blocks['left']), $_l, get_defined_vars()) ?>
    </div>


    <div class="clear"></div>
</div>
<?php
}}


//
// block main
//
if (!function_exists($_l->blocks['main'][] = '_lb78edded91b_main')) { function _lb78edded91b_main($_l, $_args) { extract($_args)
?>
        <a class="category-main" id="tapety" href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' =>Front_HomepagePresenter::TAPETY_ID))) ?>">

            <span>Tapety</span>
        </a>

        <a class="category" id="osvetleni" href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => Front_HomepagePresenter::OSVETLENI_ID))) ?>">

            <span>Osvětlení</span>
        </a>

        <a class="category even" id="podlahy" href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => Front_HomepagePresenter::PODLAHY_ID))) ?>">

            <span>Podlahy</span>
        </a>

        <a class="category" id="nabytek" href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => Front_HomepagePresenter::NABYTEK_ID))) ?>">

            <span>Nábytek</span>
        </a>

        <a class="category even" id="doplnky" href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => Front_HomepagePresenter::DOPLNKY_ID))) ?>">

            <span>Doplňky</span>
        </a>
<?php
}}


//
// block left
//
if (!function_exists($_l->blocks['left'][] = '_lbab1564075c_left')) { function _lbab1564075c_left($_l, $_args) { extract($_args)
?>
        <div class="virtualisation">
            <h2><?php echo TemplateHelpers::escapeHtml($template->upper('unikátní vizualizace tapet')) ?></h2>
            <p>“ Chcete vidět naše tapety přímo v interiéru? Promítněte si je v
            pomocí naší <a href="<?php echo TemplateHelpers::escapeHtml($control->link("Visualisation:")) ?>">vizualizace</a> přímo na stěnu. ”</p>
            <a class="button-virtualisation" href="<?php echo TemplateHelpers::escapeHtml($control->link("Visualisation:")) ?>">Vizualizace tapet</a>

        </div>

        <div class="textbox text">
            <h2><?php echo TemplateHelpers::escapeHtml($template->upper('Designové studio Interier Decor')) ?></h2>
            <p>je specialistou v oblasti designu interiérů. Nabízíme široké spektrum
            designových prvků. Naší specialitou jsou unikátní <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => Front_HomepagePresenter::TAPETY_ID))) ?>">moderní tapety na
            zeď</a>, které dodají Vašemu interiéru jedinečnost a nový rozměr. </p>
            <p>Váš interiér vybavíme také <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => Front_HomepagePresenter::DOPLNKY_ID))) ?>">dekorativními doplňky</a>, <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => Front_HomepagePresenter::NABYTEK_ID))) ?>">moderním nábytkem</a>,
            <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => Front_HomepagePresenter::PODLAHY_ID))) ?>">podlahami</a> a <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => Front_HomepagePresenter::OSVETLENI_ID))) ?>">designovými svítidly a osvětlením</a>.</p>
            <img class="fleft" src="<?php echo TemplateHelpers::escapeHtml($staticUri) ?>/images/katalogy.png" width="151" height="108" alt="katalogy" />
                        <div class="fleft last">
                <h3>O nás</h3>
                <ul>
                                       <li><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Contact:")) ?>">Kontakt</a></li>
                                   </ul>
            </div>

            <div class="clear"></div>
        </div><?php
}}


//
// block modalvisual
//
if (!function_exists($_l->blocks['modalvisual'][] = '_lba11179adc7_modalvisual')) { function _lba11179adc7_modalvisual($_l, $_args) { extract($_args)
;
}}

//
// end of blocks
//

if ($_l->extends) {
	ob_start();
} elseif (isset($presenter, $control) && $presenter->isAjax() && $control->isControlInvalid()) {
	return LatteMacros::renderSnippets($control, $_l, get_defined_vars());
}
$title = 'Eshop' ?>
<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()); } ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['modalvisual']), $_l, get_defined_vars()); }  
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
