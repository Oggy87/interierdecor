<?php //netteCache[01]000365a:2:{s:4:"time";s:21:"0.90549500 1337151114";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:79:"/var/www/webtoad/interierdecor/app/FrontModule/templates/Category.default.latte";i:2;i:1337118480;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/FrontModule/templates/Category.default.latte

?><?php
$_l = LatteMacros::initRuntime($template, true, '8ulv31l7n3'); unset($_extends);


//
// block main
//
if (!function_exists($_l->blocks['main'][] = '_lbc69ad44b79_main')) { function _lbc69ad44b79_main($_l, $_args) { extract($_args)
?>
<div class="products">
<div id="<?php echo $control->getSnippetId('orders') ?>"><?php call_user_func(reset($_l->blocks['_orders']), $_l, $template->getParams()) ?></div><div id="<?php echo $control->getSnippetId('products') ?>"><?php call_user_func(reset($_l->blocks['_products']), $_l, $template->getParams()) ?></div></div>
<?php
}}


//
// block _orders
//
if (!function_exists($_l->blocks['_orders'][] = '_lbef909d3bbf__orders')) { function _lbef909d3bbf__orders($_l, $_args) { extract($_args); $control->validateControl('orders')
;if ($presenter->tags): ?>
    <div class="order">

        seřadit: 
        <a href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('razeni' => 'od-nejlevnejsich'))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->linkCurrent ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>od nejlevnějších</a>

        <a href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('razeni' => 'od-nejdrazsich'))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->linkCurrent ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>od nejdražších</a>

        <a href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('razeni' => NULL))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->linkCurrent ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>abecedně</a>

    </div>
<?php endif ;
}}


//
// block _products
//
if (!function_exists($_l->blocks['_products'][] = '_lb91876eaacc__products')) { function _lb91876eaacc__products($_l, $_args) { extract($_args); $control->validateControl('products')
?>
    
<?php if ($presenter->tags): ?>
                <?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($products) as $product): ?><div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('product',$iterator->getCounter() % 3 == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

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
<?php endif ;if ($product['productPhoto_id']): ?>
                    <a class="img" href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product['id']))) ?>">

                    <?php echo TemplateHelpers::escapeHtml($template->image($product->productPhoto['image_path'], 195, 140, $product['name'], FALSE, TRUE, FALSE, FALSE)) ?>

                    </a>

<?php endif ?>
                <div class="name"><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product['id']))) ?>"><?php echo TemplateHelpers::escapeHtml($product['name']) ?></a></div>
            </div>
            <div class="price">
<?php if ($product["newprice"]): ?>
                    <span><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></span><strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['newprice'], BasePresenter::DPH))) ?></strong>                 <?php else: ?>

                    <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></strong> / <?php echo TemplateHelpers::escapeHtml($product->unit['name']) ?>

<?php endif ?>
            </div>
            <a class="addtobasket ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToBasket!", array('product_id' => $product['id']))) ?>">přidat do košíku</a>

                                </div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>

        <div class="clear"></div>
<?php $_ctrl = $control->getWidget("stranka"); if ($_ctrl instanceof IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render() ?>
            <?php else: ?>

<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($category_hptagGroupes) as $category_tagGroup): ?>
                <div class="fullbox">
            <div class="h"><h2><?php echo TemplateHelpers::escapeHtml($template->upper($category_tagGroup->tagGroup['name'])) ?></h2></div>
            
            <a class="prev browse left disabled"></a>

            <div class="tagGroup-scrollable">
                <div class="items">
<?php $tagids = BaseModel::fetchAll('tag')->where("tagGroup_id",$category_tagGroup->tagGroup['id'])->select("id") ;foreach ($iterator = $_l->its[] = new SmartCachingIterator(BaseModel::fetchAll("product_tag")->where("tag_id",$tagids)->where("product.active",1)->order("tag.value")->group("tag_id")) as $product_tag): ?>

<?php $tag = $product_tag->tag ;$modulus = $iterator->getCounter() % 4 ?>
                    
<?php if ($presenter->tags): $tagsurl = $presenter->tags.'+'.$tag['id'] ;else: $tagsurl = $tag['id'] ;endif ?>
                    
                    <?php if ($iterator->isFirst()): ?><div class="group"><?php endif ?>

                        <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('tag',$iterator->getCounter() % 4 == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                            <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('image',$iterator->getCounter() % 4 == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                                <a class="img" href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('tags' => $tagsurl))) ?>">

<?php if ($tag['picture_path']): ?>
                                        <?php echo TemplateHelpers::escapeHtml($template->image($tag['picture_path'], 150, 109, $tag['value'], FALSE, FALSE, FALSE, FALSE, NULL, NULL, NULL, Image::PNG)) ?>

<?php endif ?>
                                </a>

                                
                                <div class="name"><a href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('tags' => $tagsurl))) ?>"><?php echo TemplateHelpers::escapeHtml($tag['value']) ?></a></div>
                            </div>

                        </div>

<?php if ($modulus == 0): ?>
                        <?php if ($iterator->isLast()): ?></div>
                        <?php else: ?></div><div class="group">
<?php endif ;elseif ($iterator->isLast()): ?>
                        </div>
<?php endif ?>
                          <?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>

                </div>
            </div>
            
            <a class="next browse right disabled"></a>


            <div class="clear"></div>
        </div>
                <?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>


                <?php if (count($recommended) > 0): ?><div class="fullbox">

            <div class="hd"><h2><?php echo TemplateHelpers::escapeHtml($template->upper('doporučujeme')) ?></h2> <a class="more" href="<?php echo TemplateHelpers::escapeHtml($control->link("recommended")) ?>"> » další doporučené produkty » </a></div>
            <?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($recommended) as $product): ?>
            <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('product',$iterator->getCounter() % 3 == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="image"><?php if ($product['recommended']): ?>
                    <div class="label-recommended"></div>
<?php endif ;if ($product['newprice']): ?>
                    <div class="label-action"></div>
<?php endif ;if ($product['saved'] >= $onemonthago): ?>
                    <div class="label-new"></div>
<?php endif ?>
                    <a class="todetail" href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product['id']))) ?>">detail produktu</a>
<?php if ($product['visualisation_path']): ?>
                    <a class="tovisualisation ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToVisual!", array('product_id' => $product['id']))) ?>">vizualizovat</a>
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
                        <span><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></span><strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['newprice'], BasePresenter::DPH))) ?></strong>                     <?php else: ?>

                        <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></strong> / <?php echo TemplateHelpers::escapeHtml($product->unit['name']) ?>

<?php endif ?>
                </div>
                <a class="addtobasket ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToBasket!", array('product_id' => $product['id']))) ?>">přidat do košíku</a>

                           </div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>

            <div class="clear"></div>
        </div>
<?php endif ?>
        <?php if (count($discount) > 0): ?>
        <div class="fullbox">

            <div class="hd"><h2><?php echo TemplateHelpers::escapeHtml($template->upper('Akční ceny')) ?></h2><a class="more" href="<?php echo TemplateHelpers::escapeHtml($control->link("actions")) ?>"> » další produkty s akční cenou » </a></div>
            <?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($discount) as $product): ?>
            <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('product',$iterator->getCounter() % 3 == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="image"><?php if ($product['recommended']): ?>
                    <div class="label-recommended"></div>
<?php endif ;if ($product['newprice']): ?>
                    <div class="label-action"></div>
<?php endif ;if ($product['saved'] >= $onemonthago): ?>
                    <div class="label-new"></div>
<?php endif ?>
                    <a class="todetail" href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product['id']))) ?>">detail produktu</a>
<?php if ($product['visualisation_path']): ?>
                    <a class="tovisualisation ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToVisual!", array('product_id' => $product['id']))) ?>">vizualizovat</a>
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
                        <span><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></span><strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['newprice'], BasePresenter::DPH))) ?></strong>                     <?php else: ?>

                        <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></strong> / <?php echo TemplateHelpers::escapeHtml($product->unit['name']) ?>

<?php endif ?>
                </div>
                <a class="addtobasket ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToBasket!", array('product_id' => $product['id']))) ?>">přidat do košíku</a>

                            </div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>

            <div class="clear"></div>
        </div>
<?php endif ?>
        <?php if (count($new) > 0): ?>
        <div class="fullbox">

            <div class="hd"><h2><?php echo TemplateHelpers::escapeHtml($template->upper('novinky')) ?></h2><a class="more" href="<?php echo TemplateHelpers::escapeHtml($control->link("new")) ?>"> » další novinky » </a></div>
            <?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($new) as $product): ?>
            <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('product',$iterator->getCounter() % 3 == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="image"><?php if ($product['recommended']): ?>
                    <div class="label-recommended"></div>
<?php endif ;if ($product['newprice']): ?>
                    <div class="label-action"></div>
<?php endif ;if ($product['saved'] >= $onemonthago): ?>
                    <div class="label-new"></div>
<?php endif ?>
                    <a class="todetail" href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product['id']))) ?>">detail produktu</a>
<?php if ($product['visualisation_path']): ?>
                    <a class="tovisualisation ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToVisual!", array('product_id' => $product['id']))) ?>">vizualizovat</a>
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
                    <span><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></span><strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['newprice'], BasePresenter::DPH))) ?></strong>                     <?php else: ?>

                    <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></strong> / <?php echo TemplateHelpers::escapeHtml($product->unit['name']) ?>

<?php endif ?>
                </div>
                <a class="addtobasket ajax" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToBasket!", array('product_id' => $product['id']))) ?>">přidat do košíku</a>

                            </div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>

            <div class="clear"></div>
        </div>
<?php endif ?>
            <?php endif ?>

<?php
}}


//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lbaf49b51e23_scripts')) { function _lbaf49b51e23_scripts($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'scripts', $template->getParams()) ?>
    <script type="text/javascript">
    head.ready(function() {

        $(function() {
            // initialize scrollable
            $(".tagGroup-scrollable").scrollable();
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
$_l->extends = 'Category.layout.latte' ?>



<?php
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
