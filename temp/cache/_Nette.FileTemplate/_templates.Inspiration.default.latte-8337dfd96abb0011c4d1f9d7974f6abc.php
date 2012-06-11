<?php //netteCache[01]000368a:2:{s:4:"time";s:21:"0.01831000 1339421876";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:82:"/var/www/webtoad/interierdecor/app/FrontModule/templates/Inspiration.default.latte";i:2;i:1333528312;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/FrontModule/templates/Inspiration.default.latte

?><?php
$_l = LatteMacros::initRuntime($template, NULL, 'mcmz9xf8z2'); unset($_extends);


//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbb0f74c33dc_content')) { function _lbb0f74c33dc_content($_l, $_args) { extract($_args)
?>
<div id="inspiration">
    <div class="top">
        <div class="lefttop">
        <h1>Inspirace</h1>
        <div class="clear"></div>
        <div id="breadcrumbs">
            <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Homepage:")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('first'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="left"></div>
                <div class="center">interierdecor</div>
                <div class="right"></div>
            </a>

            <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Inspiration:", array('category_id'=>NULL, 'tagGroup_id'=>NULL))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('active'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="left"></div>
                <div class="center">inspirace</div>
                <div class="right"></div>
            </a>

        </div>
        </div>
        <div class="filters">
            <h2>Získejte inspiraci pro váš byt či dům</h2>
            <p>Prohlédněte si, jak naše produkty promění váš dům či byt. </p>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="categories">
        <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('number',$presenter->category_id ? 'unactive1' : 'active1'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>1</div>

        <h2>Vyberte kategorii</h2>
         
         <div class="menu">
                          <?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($categories_tagGroup) as $ct): ?><a href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('category_id'=>$ct['category_id'], 'tagGroup_id'=>NULL))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Inspiration:',array('category_id'=>$ct['category_id'])) ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <?php echo TemplateHelpers::escapeHtml($ct->category['name']) ?>

             </a>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
                      </div>
         
         <div class="clear"></div>
    </div>
    <?php if ($presenter->category_id): ?>
    <div class="categories">

        <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('number',$presenter->tagGroup_id ? 'unactive2' : 'active2'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>2</div>

        <h2>Vyberte podle čeho chcete vybírat</h2>
        
        <div class="menu">
                         <?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($category_tagGroups) as $ct): ?><a href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('tagGroup_id'=>$ct['tagGroup_id'],'tag_id'=>NULL))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->isLinkCurrent('Inspiration:',array('tagGroup_id'=>$ct['tagGroup_id'])) ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <?php echo TemplateHelpers::escapeHtml($ct->tagGroup['name']) ?>

             </a>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
                     </div>
         
         <div class="clear"></div>
    </div>
<?php endif ?>
    <?php if ($presenter->tagGroup_id): ?>
    <div class="categories">

        <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('number',$presenter->tag_id ? 'unactive3' : 'active3'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>3</div>

        <h2>Vyberte jakou inspiraci chcete zobrazit</h2>
        
        
        <div class="tags">
                        <?php if ($category_tagGroup['hp']): ?>

            <a class="prev browse left disabled"></a>
            <div class="tagGroup-scrollable">
                <div class="items">
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($image_tags) as $image_tag): $modulus = $iterator->getCounter() % 5 ?>
                        <?php if ($iterator->isFirst()): ?><div class="group"><?php endif ?>

                        <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('tag',$modulus == 0 ? 'last':null,$presenter->tag_id == $image_tag['tag_id'] ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                            <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('image',$modulus == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                                <a class="img" href="<?php echo TemplateHelpers::escapeHtml($control->link("this#carusel", array('tag_id' => $image_tag['tag_id']))) ?>">

<?php if ($image_tag->tag['picture_path']): ?>
                                        <?php echo TemplateHelpers::escapeHtml($template->image($image_tag->tag['picture_path'], 150, 109, $image_tag->tag['value'], FALSE, FALSE, FALSE, FALSE, NULL, NULL, NULL, Image::PNG)) ?>

<?php endif ?>
                                </a>

                                
                                <div class="name"><a href="<?php echo TemplateHelpers::escapeHtml($control->link("this#carusel", array('tag_id' => $image_tag['tag_id']))) ?>"><?php echo TemplateHelpers::escapeHtml($image_tag->tag['value']) ?></a></div>
                            </div>

                        </div>

<?php if ($modulus == 0): ?>
                            <?php if ($iterator->isLast()): ?></div>
                            <?php else: ?></div><div class="group">
<?php endif ;elseif ($iterator->isLast()): ?>
                            </div>
<?php endif ;endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
                    
                </div>
            </div>
            <a class="next browse right disabled"></a>
<?php else: ?>
            <div class="list"><?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($image_tags) as $image_tag): ?>
                <a href="<?php echo TemplateHelpers::escapeHtml($control->link("this#carusel", array('tag_id' => $image_tag->tag['id']))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->linkCurrent ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><?php echo TemplateHelpers::escapeHtml($image_tag->tag['value']) ?></a>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
            </div> 
<?php endif ?>
             
        </div>
<?php endif ?>
        
        <div class="clear"></div>
    </div>
    <?php if ($presenter->tag_id): ?>
    <div class="categories"  id="carusel">

        <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('number','active4'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>4</div>

        <h2>Vyberte si inspirační obrázek a podívejte se, které produkty zobrazuje</h2>
        <div class="clear"></div>
        <div class="carusel">
            <a class="prev browse left disabled"></a>
            <div class="images-scrollable">
                <div class="items">
                                        <?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($tag->image_tag()) as $image_tag): ?><a data-image_id="<?php echo TemplateHelpers::escapeHtml($image_tag['image_id']) ?>" class="img detail" class="fancybox">

                        <?php echo TemplateHelpers::escapeHtml($template->image($image_tag->image['image_path'], 590, 458, 'inspirace', FALSE, TRUE, TRUE, FALSE)) ?>

                    </a>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
                     
                </div>
            </div>
            <a class="next browse right disabled"></a>
            
            <div class="clear"></div>
        </div>
    </div>
<?php endif ?>
</div>
<div style="display: none;">
<div id="<?php echo $control->getSnippetId('detail') ?>"><?php call_user_func(reset($_l->blocks['_detail']), $_l, $template->getParams()) ?></div></div>

<?php
}}


//
// block _detail
//
if (!function_exists($_l->blocks['_detail'][] = '_lbaa19a069dc__detail')) { function _lbaa19a069dc__detail($_l, $_args) { extract($_args); $control->validateControl('detail')
?>
    <div id="detail">
<?php if (isset($image)): ?>
        <?php echo TemplateHelpers::escapeHtml($template->image($image['image_path'], 590, 458, 'inspirace', FALSE, TRUE, TRUE, FALSE, 'image')) ?>

        <div class="products"><?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($image->image_product()) as $image_product): ?>
            <div class="product">

<?php if ($image_product->product['active']): ?>
                <div class="image"><?php if ($image_product->product['recommended']): ?>
                    <div class="label-recommended"></div>
<?php endif ;if ($image_product->product['newprice']): ?>
                    <div class="label-action"></div>
<?php endif ;if ($image_product->product['saved'] >= $onemonthago): ?>
                    <div class="label-new"></div>
<?php endif ;if ($image_product->product['productPhoto_id']): ?>
                        <a class="img" href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $image_product->product['id']))) ?>">

                        <?php echo TemplateHelpers::escapeHtml($template->image($image_product->product->productPhoto['image_path'], 140, 107, $image_product->product['name'], FALSE, TRUE, FALSE, FALSE)) ?>

                        </a>

<?php endif ?>
                </div>
                <div class="text">
                    <h2><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $image_product->product['id']))) ?>"><?php echo TemplateHelpers::escapeHtml($image_product->product['name']) ?></a></h2>
                                        <div class="category"><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Category:", array('id'=>$image_product->product['category_id']))) ?>"><?php echo TemplateHelpers::escapeHtml($image_product->product->category['name']) ?></a></div>
                
                    <div class="price">
<?php if ($image_product->product["newprice"]): ?>
                            <span><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($image_product->product['price'], BasePresenter::DPH))) ?></span><strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($image_product->product['newprice'], BasePresenter::DPH))) ?></strong>                         <?php else: ?>

                            <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($image_product->product['price'], BasePresenter::DPH))) ?></strong> / <?php echo TemplateHelpers::escapeHtml($image_product->product->unit['name']) ?>

<?php endif ?>
                    </div>
                    <a class="addtobasket ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToBasket!", array('product_id' => $image_product->product['id']))) ?>">přidat do košíku</a>

                </div>
<?php endif ?>
                <div class="clear"></div>
            </div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
        </div>
<?php endif ?>
    </div>
<?php
}}


//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lb29fcf71933_scripts')) { function _lb29fcf71933_scripts($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'scripts', $template->getParams()) ?>
    <script type="text/javascript">
    head.ready(function() {

        $(".tagGroup-scrollable").scrollable();
            
        $(".images-scrollable").scrollable();

        $(".detail").click(function() {
            $this = $(this);
            $.get(<?php echo TemplateHelpers::escapeJs($control->link("detail!")) ?>,{'image_id': $this.data('image_id')}, function(payload) {
                for(var id in payload.snippets) {
                    jQuery.nette.updateSnippet(id, payload.snippets[id]);
                } 
                $.fancybox({
                   'content' : $("#detail"),
                   'autoDimensions'    : false,
                   'width'              : 970,
                   'height'             : 460,
                   'scrolling'         : 'no',
                   'titleShow'         : false
               });
            });
            
        })
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
$title = 'inspirace' ;if ($category): $title .= ' - '.$category['name'] ;endif ;if ($tag): $title .= ' - '.$tag['value'] ;endif ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()); } ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['scripts']), $_l, get_defined_vars()); } ?>

<?php
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
