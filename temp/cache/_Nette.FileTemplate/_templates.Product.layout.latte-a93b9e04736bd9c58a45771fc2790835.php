<?php //netteCache[01]000363a:2:{s:4:"time";s:21:"0.23753000 1337153147";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:77:"/var/www/webtoad/interierdecor/app/AdminModule/templates/Product.layout.latte";i:2;i:1328266328;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/AdminModule/templates/Product.layout.latte

?><?php
$_l = LatteMacros::initRuntime($template, true, 'rl6m9kyzsx'); unset($_extends);


//
// block css
//
if (!function_exists($_l->blocks['css'][] = '_lbe1c95b0363_css')) { function _lbe1c95b0363_css($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'css', $template->getParams()) ;$_ctrl = $control->getWidget("css"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render('../texyla/css/style.css') ;
}}


//
// block js
//
if (!function_exists($_l->blocks['js'][] = '_lbf703db838e_js')) { function _lbf703db838e_js($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'js', $template->getParams()) ?>
    <script type="text/javascript">
        head.js("http://www.google.com/jsapi",
                "<?php echo $staticUri ?>/js/plupload.full.js",
                "<?php echo $staticUri ?>/js/cs.js",
                "<?php echo $staticUri ?>/js/jquery.tourl.js",
                "<?php echo $staticUri ?>/texyla/js/texyla.js",
                "<?php echo $staticUri ?>/texyla/js/selection.js",
                "<?php echo $staticUri ?>/texyla/js/texy.js",
                "<?php echo $staticUri ?>/texyla/js/buttons.js",
                "<?php echo $staticUri ?>/texyla/js/dom.js",
                "<?php echo $staticUri ?>/texyla/js/view.js",
                "<?php echo $staticUri ?>/texyla/js/ajaxupload.js",
                "<?php echo $staticUri ?>/texyla/js/window.js",
                "<?php echo $staticUri ?>/texyla/languages/cs.js",
                "<?php echo $staticUri ?>/texyla/plugins/table/table.js"
        );
    </script>
<?php
}}


//
// block layout
//
if (!function_exists($_l->blocks['layout'][] = '_lb914eadbc45_layout')) { function _lb914eadbc45_layout($_l, $_args) { extract($_args)
?>
    <div id="product" class="container-fluid">
        <div class="sidebar">
            <div  class="pagination">
            <ul>
                <li class="prev"><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:")) ?>">← Zpět na Přehled produktů</a></li>
            </ul>
            </div>
            
            <ul class="pills">
                <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Product:edit') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("edit", array('id'=> $product['id']))) ?>">editovat produkt</a></li>

                <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Product:images') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("images", array('id'=> $product['id']))) ?>">obrázky produktu (<?php echo TemplateHelpers::escapeHtml($template->number($product->productPhoto()->where("NOT id",$product['productPhoto_id'])->count("*"))) ?>)</a></li>

                <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Product:visualisation') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("visualisation", array('id'=> $product['id']))) ?>">vizualizace</a></li>

                <li<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Product:variants') ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><a href="<?php echo TemplateHelpers::escapeHtml($control->link("variants", array('id'=> $product['id']))) ?>">varianty (<?php echo TemplateHelpers::escapeHtml($template->number(BaseModel::fetchAll("product")->where("NOT productType_id",NULL)->where("productType_id",$product['productType_id'])->count("*"))) ?>)</a></li>

            </ul>

            <a class="btn success large" href="<?php echo TemplateHelpers::escapeHtml($control->link("new", array('id'=>$product['id']))) ?>">nová varianta</a><br /><br />
            <a class="btn danger large" href="<?php echo TemplateHelpers::escapeHtml($control->link("delete!", array('id'=>$product['id']))) ?>">smazat produkt</a>


        </div>
        
        <div class="content">
<?php LatteMacros::callBlock($_l, 'content', $template->getParams()) ?>
        </div>
       

</div>
<?php
}}


//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lbc05bdc8ee8_scripts')) { function _lbc05bdc8ee8_scripts($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'scripts', $template->getParams()) ?>
    <script type="text/javascript">
    head.ready(function() {
    $(document).ready(function(){

        var defaultOptions = {
            baseDir: '<?php echo $staticUri ?>/texyla',
            previewPath: '<?php echo $presenter->link("Texyla:preview") ?>',
            filesPath: '<?php echo $presenter->link("Texyla:listFiles") ?>',
            filesUploadPath: '<?php echo $presenter->link("Texyla:upload") ?>',
            filesMkDirPath: '<?php echo $presenter->link("Texyla:mkDir") ?>',
            filesRenamePath: '<?php echo $presenter->link("Texyla:rename") ?>',
            filesDeletePath: '<?php echo TemplateHelpers::escapeJs($presenter->link("Texyla:delete")) ?>',

            toolbar: ['h2','h3','h4','bold', 'italic', null, 'ul', 'ol', null, 'sup','sub',null,'link', null, "table", null]
        };
        
        $.texyla.setDefaults(defaultOptions);
       
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
$_l->extends = '@layout.latte' ?>





<?php
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
