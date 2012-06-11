<?php //netteCache[01]000364a:2:{s:4:"time";s:21:"0.45754100 1337152549";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:78:"/var/www/webtoad/interierdecor/app/FrontModule/templates/Product.default.latte";i:2;i:1337152545;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/FrontModule/templates/Product.default.latte

?><?php
$_l = LatteMacros::initRuntime($template, NULL, 'sb4gs0m78i'); unset($_extends);


//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb35f23af93e_content')) { function _lb35f23af93e_content($_l, $_args) { extract($_args)
?>
<div id="product">
    <div class="top">
        <h1><?php echo TemplateHelpers::escapeHtml($template->ucfirst($title)) ?></h1>

        <div class="clear"></div>
        
        <div id="breadcrumbs">
            <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Homepage:")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('first'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="left"></div>
                <div class="center">interierdecor</div>
                <div class="right"></div>
            </a>

            <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => $product->category['id']))) ?>">

                <div class="left"></div>
                <div class="center"><?php echo TemplateHelpers::escapeHtml($template->lower($product->category['name'])) ?></div>
                <div class="right"></div>
            </a>

            <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Product:", array('id' => $product['id']))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('active'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="left"></div>
                <div class="center"><?php echo TemplateHelpers::escapeHtml($template->lower($product['name'])) ?></div>
                <div class="right"></div>
            </a>

        </div>

        <div class="clear"></div>
    </div>

<?php call_user_func(reset($_l->blocks['main']), $_l, get_defined_vars()) ?>
</div>
<?php
}}


//
// block main
//
if (!function_exists($_l->blocks['main'][] = '_lbc502699b5a_main')) { function _lbc502699b5a_main($_l, $_args) { extract($_args)
?>
    
    <div class="mainpanel">
         
        <div class="productimages">
            <div class="productimage"><?php if ($product['recommended']): ?>
                <div class="label-recommended"></div>
<?php endif ;if ($product['newprice']): ?>
                <div class="label-action"></div>
<?php endif ;if ($product['saved'] >= $onemonthago): ?>
                <div class="label-new"></div>
<?php endif ;if ($product['productPhoto_id']): $bigphoto = Helpers::image($product->productPhoto['image_path'], 1200, 900, $product['name'], TRUE,FALSE,FALSE,FALSE) ?>
                    <a href="<?php echo TemplateHelpers::escapeHtml($bigphoto->src) ?>" rel="product-gallery" class="fancybox img"><?php echo TemplateHelpers::escapeHtml($template->image($product->productPhoto['image_path'], 355, 262, $product['name'], FALSE, TRUE, TRUE, FALSE)) ?></a>
<?php endif ;$pr_tg = $product->product_tag()->where('tag.tagGroup_id',Front_BasePresenter::TAG_KOLEKCE_ID)->fetch() ;if ($product['visualisation_path']): ?>
                <a class="tovisualisation" href="<?php echo TemplateHelpers::escapeHtml($control->link("Visualisation:#choose", array('id'=> $pr_tg['tag_id']))) ?>">do vizualizace</a>    
<?php endif ?>
                
                <div class="price">
                    <div class="left"></div>
                    <div class="content">
<?php if ($product["newprice"]): ?>
                            <span class="oldprice"><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></span><strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['newprice'], BasePresenter::DPH))) ?></strong>                         <?php else: ?>

                            <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></strong>
<?php endif ?>
                        <span>/ <?php echo TemplateHelpers::escapeHtml($product->unit['name']) ?> s DPH</span>
                    </div>
                </div>
            </div>
<?php if ((count($productPhotos) > 0) OR (count($image_products) > 0)): ?>
            <div class="others">
                <a class="prev browse left disabled"></a>

                <div id="productPhoto-scrollable">
                    <div class="items">
                
<?php if (count($productPhotos) > 0): foreach ($iterator = $_l->its[] = new SmartCachingIterator($productPhotos) as $productPhoto): $modulus = $iterator->getCounter() % 3 ?>
                            <?php if ($iterator->isFirst()): ?><div><?php endif ?>


<?php $bigphoto = Helpers::image($productPhoto['image_path'], 1200, 900, 'inspirace', TRUE,FALSE,FALSE,FALSE) ?>
                            <a class="fancybox" rel="product-gallery" href="<?php echo TemplateHelpers::escapeHtml($bigphoto->src) ?>">
                                    <?php echo TemplateHelpers::escapeHtml($template->image($productPhoto['image_path'], 102, 64, 'inspirace', FALSE, TRUE, FALSE, FALSE)) ?>

                            </a>
<?php if ($modulus == 0): ?>
                                </div>
                                <?php if (!$iterator->isLast()): ?><div><?php endif ?>

<?php endif ?>
                            <?php if ($iterator->isLast()): if ($modulus != 0): ?></div><?php endif ;endif ?>

<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ;endif ?>
                                       </div>
                </div>

                <a class="next browse right disabled"></a>

                <div class="clear"></div>
            </div>
<?php endif ?>
        </div>

        <div class="productdata">
             
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($category_tagGroupes) as $category_tagGroup): $product_tags = $product->product_tag()->where("tag.tagGroup_id",$category_tagGroup->tagGroup['id'])->order("value") ;if ($product_tags->count('*') > 0): ?>
            <div <?php if ($_l->tmp = trim(implode(" ", array_unique(array('tag-group'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="name"><?php echo TemplateHelpers::escapeHtml($template->lower($category_tagGroup->tagGroup['name'])) ?>:</div>
                <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('tags',$iterator->getCounter() > 3 ? 'longtags':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

<?php if ($category_tagGroup->tagGroup['images']): foreach ($iterator = $_l->its[] = new SmartCachingIterator($product_tags) as $product_tag): if ($product_tag->tag['picture_path']): if ($category_tagGroup->tagGroup['filter'] == 1): ?>
                            <a class="img" href="<?php echo TemplateHelpers::escapeHtml($control->link("Category:", array('id' => $product['category_id'], 'tags' => $product_tag['tag_id']))) ?>">
<?php endif ?>
                                <?php echo TemplateHelpers::escapeHtml($template->image($product_tag->tag['picture_path'], NULL, 32, $product_tag->tag['value'], FALSE, FALSE, FALSE, FALSE, NULL, NULL, $product_tag->tag['value'])) ?>
<?php if ($category_tagGroup->tagGroup['filter'] == 1): ?>
                            </a>
<?php endif ;endif ;endforeach; array_pop($_l->its); $iterator = end($_l->its) ;else: foreach ($iterator = $_l->its[] = new SmartCachingIterator($product_tags) as $product_tag): if ($category_tagGroup->tagGroup['filter'] == 1): ?>
                        <a href="<?php echo TemplateHelpers::escapeHtml($control->link("Category:", array('id' => $product['category_id'], 'tags' => $product_tag['tag_id']))) ?>"><?php endif ;if (!$category_tagGroup->tagGroup['filter']): ?><span>
<?php endif ?>
                            <?php echo TemplateHelpers::escapeHtml($product_tag->tag['value']) ?>
<?php if (!$category_tagGroup->tagGroup['filter']): ?>
                            </span>
<?php endif ;if ($category_tagGroup->tagGroup['filter'] == 1): ?>
                        </a>
<?php endif ?>
                        <?php if (!$iterator->isLast()): ?>,  <?php endif ?>

<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ;endif ?>
                </div>

            </div>

<?php endif ;endforeach; array_pop($_l->its); $iterator = end($_l->its) ;if ($product['file_name']): ?>
            <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('tag-group'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="name">příloha:</div>
                <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('tags'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                    <a href="<?php echo TemplateHelpers::escapeHtml($product['file_path']) ?>"><?php echo TemplateHelpers::escapeHtml($product['file_name']) ?></a>
                </div>

            </div>
<?php endif ?>
                        

            <div class="addbasketbox">
                <div class="name">DO KOŠÍKU</div>
                <div class="box">
                    <a class="addtobasket ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToBasket!", array('product_id' => $product['id']))) ?>">přidat do košíku</a>

                                                        </div>
            </div>

            <div class="clear"></div>
        </div>
        <?php if ($product['description_html']): ?>
        <div class="description">

                <?php echo $template->texy($product['description_html']) ?>

        </div>
<?php endif ?>
            <div class="clear"></div>
                <div class="clear"></div>
        
<?php if (isset($productTypes)): ?>
            <div class="similar">
            <h2><?php echo TemplateHelpers::escapeHtml($template->upper('Další varianty produktu')) ?></h2>

            <a class="prev browse left disabled"></a>

            <div id="productTypes-scrollable">
                <div class="items">
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($productTypes) as $product): $modulus = $iterator->getCounter() % 4 ?>

                    <?php if ($iterator->isFirst()): ?><div class="group"><?php endif ?>

                        <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('product',$iterator->getCounter() % 4 == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                            <div class="image"><?php if ($product['recommended']): ?>
                                <div class="label-recommended"></div>
<?php endif ;if ($product['newprice']): ?>
                                <div class="label-action"></div>
<?php endif ;if ($product['saved'] >= $onemonthago): ?>
                                <div class="label-new"></div>
<?php endif ?>
                                <a class="todetail" href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product['id']))) ?>">detail produktu</a>

<?php $pr_tg = $product->product_tag()->where('tag.tagGroup_id',Front_BasePresenter::TAG_KOLEKCE_ID)->fetch() ;if ($product['visualisation_path']): ?>
                                <a class="tovisualisation" href="<?php echo TemplateHelpers::escapeHtml($control->link("Visualisation:#choose", array('id'=> $pr_tg['tag_id']))) ?>">do vizualizace</a>    
<?php endif ?>
                                                                <?php if ($product['productPhoto_id']): ?>

                                    <a class="img" href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product['id']))) ?>">

                                    <?php echo TemplateHelpers::escapeHtml($template->image($product->productPhoto['image_path'], 195, 140, $product['name'], FALSE, TRUE, FALSE, FALSE)) ?>

                                    </a>

<?php endif ?>
                                <div class="name"><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product['id']))) ?>"><?php echo TemplateHelpers::escapeHtml($product['name']) ?></a></div>
                            </div>
                             <div class="price">
<?php if ($product["newprice"]): ?>
                                    <span><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></span><strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['newprice'], BasePresenter::DPH))) ?></strong>                                 <?php else: ?>

                                    <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></strong> / <?php echo TemplateHelpers::escapeHtml($product->unit['name']) ?>

<?php endif ?>
                            </div>
                            <a class="addtobasket ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToBasket!", array('product_id' => $product['id']))) ?>">přidat do košíku</a>

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

            <div class="clear"></div>
        </div>
<?php endif ?>
        
         
<?php if (count($image_products) > 0): ?>
        <div class="inspiration">
            <h2><?php echo TemplateHelpers::escapeHtml($template->upper('Inspirace')) ?></h2>

            <a class="prev browse left disabled"></a>

            <div id="inspiration-scrollable">
                <div class="items">
                                
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($image_products) as $image_product): $modulus = $iterator->getCounter() % 6 ?>

                    <?php if ($iterator->isFirst()): ?><div><?php endif ?>

<?php $bigphoto = Helpers::image($image_product->image['image_path'], 1200, 900, 'inspirace', TRUE,FALSE,FALSE,FALSE) ?>
                        <a class="fancybox" rel="inspiration-gallery" href="<?php echo TemplateHelpers::escapeHtml($bigphoto->src) ?>">
                            <?php echo TemplateHelpers::escapeHtml($template->image($image_product->image['image_path'], 123, 94, 'inspirace', FALSE, TRUE, FALSE, FALSE)) ?>

                        </a>
<?php if ($modulus == 0): ?>
                        <?php if ($iterator->isLast()): ?></div>
                        <?php else: ?></div><div>
<?php endif ;elseif ($iterator->isLast()): ?>
                        </div>
<?php endif ;endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
                </div>
            </div>

            <a class="next browse right disabled"></a>

            <div class="clear"></div>
        </div>
<?php endif ?>
                 
<?php if (count($similar) > 0): ?>
        <div class="similar">
            <h2><?php echo TemplateHelpers::escapeHtml($template->upper('Podobné produkty')) ?></h2>

            <a class="prev browse left disabled"></a>

            <div id="similar-scrollable">
                <div class="items">
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($similar) as $product_tag): $modulus = $iterator->getCounter() % 4 ?>

                    <?php if ($iterator->isFirst()): ?><div class="group"><?php endif ?>

                        <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('product',$iterator->getCounter() % 4 == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                            <div class="image"><?php if ($product_tag->product['recommended']): ?>
                                <div class="label-recommended"></div>
<?php endif ;if ($product_tag->product['newprice']): ?>
                                <div class="label-action"></div>
<?php endif ;if ($product_tag->product['saved'] >= $onemonthago): ?>
                                <div class="label-new"></div>
<?php endif ?>
                                <a class="todetail" href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product_tag['product_id']))) ?>">detail produktu</a>

<?php $pr_tg = $product_tag->product->product_tag()->where('tag.tagGroup_id',Front_BasePresenter::TAG_KOLEKCE_ID)->fetch() ;if ($product_tag->product['visualisation_path']): ?>
                                <a class="tovisualisation" href="<?php echo TemplateHelpers::escapeHtml($control->link("Visualisation:#choose", array('id'=> $pr_tg['tag_id']))) ?>">do vizualizace</a>    
<?php endif ?>
                                                                <?php if ($product_tag->product['productPhoto_id']): ?>

                                    <a class="img" href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product_tag['product_id']))) ?>">

                                    <?php echo TemplateHelpers::escapeHtml($template->image($product_tag->product->productPhoto['image_path'], 195, 140, $product_tag->product['name'], FALSE, TRUE, FALSE, FALSE)) ?>

                                    </a>

<?php endif ?>
                                <div class="name"><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product_tag['product_id']))) ?>"><?php echo TemplateHelpers::escapeHtml($product_tag->product['name']) ?></a></div>
                            </div>
                             <div class="price">
<?php if ($product_tag->product["newprice"]): ?>
                                    <span><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product_tag->product['price'], BasePresenter::DPH))) ?></span><strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product_tag->product['newprice'], BasePresenter::DPH))) ?></strong>                                 <?php else: ?>

                                    <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product_tag->product['price'], BasePresenter::DPH))) ?></strong> / <?php echo TemplateHelpers::escapeHtml($product_tag->product->unit['name']) ?>

<?php endif ?>
                            </div>
                            <a class="addtobasket ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToBasket!", array('product_id' => $product_tag['product_id']))) ?>">přidat do košíku</a>

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

            <div class="clear"></div>
        </div>
<?php endif ?>
            </div>
<?php
}}


//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lb5ba7b7fb70_scripts')) { function _lb5ba7b7fb70_scripts($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'scripts', $template->getParams()) ?>
    <script type="text/javascript">
    head.ready(function() {

        $(function() {
            // initialize scrollable
            $("#productPhoto-scrollable").scrollable();
        });

        $(function() {
            // initialize scrollable
            $("#inspiration-scrollable").scrollable();
        });

        $(function() {
            // initialize scrollable
            $("#similar-scrollable").scrollable();
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
$title = $product['name'] ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()); } ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['scripts']), $_l, get_defined_vars()); }  
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
