<?php //netteCache[01]000356a:2:{s:4:"time";s:21:"0.79446200 1337153107";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:70:"/var/www/webtoad/interierdecor/app/AdminModule/templates/@layout.latte";i:2;i:1333453134;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/AdminModule/templates/@layout.latte

?><?php
$_l = LatteMacros::initRuntime($template, NULL, 'rblrrkmxel'); unset($_extends);


//
// block css
//
if (!function_exists($_l->blocks['css'][] = '_lb53fc1530c6_css')) { function _lb53fc1530c6_css($_l, $_args) { extract($_args)
?>
            <link rel="stylesheet/less" href="<?php echo $staticUri ?>/less/bootstrap.less" />
            <link rel="stylesheet" type="text/css" href="<?php echo TemplateHelpers::escapeHtml($staticUri) ?>/css/jquery.fancybox-1.3.4.css" />
<?php $_ctrl = $control->getWidget("css"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('jquery-ui-1.8.16.custom.css') ;
}}


//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lbfdcc272f85_scripts')) { function _lbfdcc272f85_scripts($_l, $_args) { extract($_args)
?>
	<script type="text/javascript" src="<?php echo TemplateHelpers::escapeHtml($staticUri) ?>/js/head.min.js"></script>
        <script type="text/javascript" src="<?php echo TemplateHelpers::escapeHtml($staticUri) ?>/js/less-1.1.3.min.js"></script>
<?php
}}


//
// block headjs
//
if (!function_exists($_l->blocks['headjs'][] = '_lba245eb220a_headjs')) { function _lba245eb220a_headjs($_l, $_args) { extract($_args)
?>
        <script type="text/javascript">
            head.js("http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js",
                    "<?php echo $staticUri ?>/js/netteForms.js",
                    "<?php echo $staticUri ?>/js/jquery.livequery.js",
                    "<?php echo $staticUri ?>/js/jquery.nette.js",
                    "<?php echo $staticUri ?>/js/jquery-ui-1.8.14.custom.min.js",
                    "<?php echo $staticUri ?>/js/jquery.fancybox-1.3.4.pack.js",
                    "<?php echo $staticUri ?>/js/jquery.easing-1.3.pack.js",
                    "<?php echo $staticUri ?>/js/jquery.mousewheel-3.0.4.pack.js",
                    "<?php echo $staticUri ?>/js/jquery.tools.min.js",
                    "<?php echo $staticUri ?>/js/bootstrap-dropdown.js",
                    "<?php echo $staticUri ?>/js/bootstrap-alerts.js",
                    "<?php echo $staticUri ?>/js/bootstrap-modal.js",
                    
                    function() {
                        $('.topbar').dropdown();
                        $(".alert-message").alert()
                        $('.modal').modal();
                    }
          );
	</script>
<?php
}}


//
// block js
//
if (!function_exists($_l->blocks['js'][] = '_lb439696d3a0_js')) { function _lb439696d3a0_js($_l, $_args) { extract($_args)
?>
        <script type="text/javascript">
        head.ready(function() {

            $(document).ready(function(){

                $("form").livequery( function() {
                    Nette.initForm(this);
                }); 
                
                $("a.fancybox").fancybox();               

            });
        });
        </script>
<?php
}}


//
// block topbar
//
if (!function_exists($_l->blocks['topbar'][] = '_lbed2b9838d4_topbar')) { function _lbed2b9838d4_topbar($_l, $_args) { extract($_args)
?>
    <div class="topbar">

        <div class="topbar-inner">
            <div class="<?php echo TemplateHelpers::escapeHtml($container) ?>">
                <a class="brand" href="<?php echo TemplateHelpers::escapeHtml($control->link("Default:")) ?>">Administrace</a>

                <ul class="nav">
                    <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Categories:*') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Categories:")) ?>">Kategorie</a></li>

                    <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Product:*') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:")) ?>">Produkty</a></li>

                    <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('TagGroup:*') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("TagGroup:", array('category_id'=>NULL))) ?>">Skupiny štítků</a></li>

                    <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Tag:*') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Tag:", array('tagGroup_id'=>NULL))) ?>">Štítky</a></li>

                    <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Unit:*') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Unit:")) ?>">Jednotky</a></li>

                    <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Shipping:*') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Shipping:")) ?>">Doprava</a></li>

                    <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Paymethod:*') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Paymethod:")) ?>">Platba</a></li>

                    <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Inspiration:*') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Inspiration:")) ?>">Inspirace</a></li>

                    
                    <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Orders:*') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Orders:")) ?>">Objednávky</a></li>

                </ul>

                <ul class="nav secondary-nav">
<?php $customer = $user->getIdentity() ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#"><?php echo TemplateHelpers::escapeHtml($customer->name) ?> <?php echo TemplateHelpers::escapeHtml($customer->surname) ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Sign:out")) ?>">odhlásit</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo TemplateHelpers::escapeHtml($control->link("")) ?>">nastavení</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
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
extract(array('container' => 'container-fluid'), EXTR_SKIP) ?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="robots" content="no-index" />

        <meta name="owner" content="Petr Ogurčák" />
        <meta name="copyright" content="Petr Ogurčák; petr.ogurcak.cz" />
        <meta name="author" content="Petr Ogurčák; petr.ogurcak.cz" />
        
        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->


	<title><?php echo TemplateHelpers::escapeHtml($template->ucfirst($title)) ?> | Administrace tapety-podlahy.cz</title>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['css']), $_l, get_defined_vars()); } ?>

	<link rel="shortcut icon" href="<?php echo TemplateHelpers::escapeHtml($basePath) ?>/favicon.ico" type="image/x-icon" />
        
<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['scripts']), $_l, get_defined_vars()); } ?>
        
<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['headjs']), $_l, get_defined_vars()); }  if (!$_l->extends) { call_user_func(reset($_l->blocks['js']), $_l, get_defined_vars()); } ?>
        
</head>

<body>
        <?php if (!$_l->extends) { call_user_func(reset($_l->blocks['topbar']), $_l, get_defined_vars()); } ?>
    
<?php LatteMacros::callBlock($_l, 'layout', $template->getParams()) ?>

</body>
</html>


<?php
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
