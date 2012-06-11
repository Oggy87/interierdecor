<?php //netteCache[01]000344a:2:{s:4:"time";s:21:"0.93556100 1337109357";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:58:"/var/www/webtoad/interierdecor/app/templates/@layout.latte";i:2;i:1328821353;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/templates/@layout.latte

?><?php
$_l = LatteMacros::initRuntime($template, NULL, 'r1jcmu3dy8'); unset($_extends);


//
// block css
//
if (!function_exists($_l->blocks['css'][] = '_lb6fe267194a_css')) { function _lb6fe267194a_css($_l, $_args) { extract($_args)
;$_ctrl = $control->getWidget("css"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('reset.css','jquery-ui-1.8.11.custom.css') ?>
            <link rel="stylesheet" type="text/css" href="<?php echo TemplateHelpers::escapeHtml($staticUri) ?>/css/jquery.fancybox-1.3.4.css" />
<?php $_ctrl = $control->getWidget("cssPrint"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('reset.css') ;
}}


//
// block js
//
if (!function_exists($_l->blocks['js'][] = '_lb47b8f6a4b6_js')) { function _lb47b8f6a4b6_js($_l, $_args) { extract($_args)
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
                    "<?php echo $staticUri ?>/js/analytics.js"
          );
	</script>
<?php
}}


//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lb71fea664af_scripts')) { function _lb71fea664af_scripts($_l, $_args) { extract($_args)
?>
        <script type="text/javascript">
            head.ready(function(){
                
                _ga.create('UA-25339634-1', '.tapety-podlahy.cz');
                _gaq.push(['_setDomainName', 'none']);
                _gaq.push(['_setAllowLinker', true]);
                _gaq.push(['_trackPageview']);
                _gaq.push(['_trackPageLoadTime']);  
                
                <?php call_user_func(reset($_l->blocks['ga']), $_l, get_defined_vars()) ?>


                $("form").livequery( function() {
                    Nette.initForm(this);
                });

                $("a.fancybox").fancybox();               

            });
        </script>
<?php
}}


//
// block ga
//
if (!function_exists($_l->blocks['ga'][] = '_lb0f19fb1fe7_ga')) { function _lb0f19fb1fe7_ga($_l, $_args) { extract($_args)
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
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if (isset($description)): ?>
	<meta name="description" content="<?php echo TemplateHelpers::escapeHtml($description) ?>" />
<?php endif ;if (isset($robots)): ?>
	<meta name="robots" content="<?php echo TemplateHelpers::escapeHtml($robots) ?>" />
<?php endif ;if (isset($keywords)): ?>
        <meta name="keywords" content="<?php echo TemplateHelpers::escapeHtml($keywords) ?>" />
<?php endif ?>

        <meta name="owner" content="Petr Ogurčák" />
        <meta name="copyright" content="Petr Ogurčák; petr.ogurcak.cz" />
        <meta name="author" content="Petr Ogurčák; petr.ogurcak.cz" />

	<title><?php echo TemplateHelpers::escapeHtml($template->ucfirst($title)) ?> | Tapety-podlahy.cz</title>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['css']), $_l, get_defined_vars()); } ?>

	<link rel="shortcut icon" href="<?php echo TemplateHelpers::escapeHtml($basePath) ?>/favicon.ico" type="image/x-icon" />

	<script type="text/javascript" src="<?php echo TemplateHelpers::escapeHtml($staticUri) ?>/js/head.min.js"></script>
<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['js']), $_l, get_defined_vars()); }  if (!$_l->extends) { call_user_func(reset($_l->blocks['scripts']), $_l, get_defined_vars()); } ?>
</head>

<body>
    
<?php LatteMacros::callBlock($_l, 'layout', $template->getParams()) ?>

</body>
</html>
<?php
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
