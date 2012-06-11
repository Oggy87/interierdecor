<?php //netteCache[01]000370a:2:{s:4:"time";s:21:"0.27277300 1337177713";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:84:"/var/www/webtoad/interierdecor/app/FrontModule/templates/Visualisation.default.latte";i:2;i:1337177540;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/FrontModule/templates/Visualisation.default.latte

?><?php
$_l = LatteMacros::initRuntime($template, NULL, '808j3r3r5z'); unset($_extends);


//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb7a31b367c6_content')) { function _lb7a31b367c6_content($_l, $_args) { extract($_args)
?>
<div id="visualisation">
    <div class="top">
        <div class="lefttop">
        <h1>Vizualizace tapet</h1>
        <div class="clear"></div>
        <div id="breadcrumbs">
            <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Homepage:")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('first'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="left"></div>
                <div class="center">interierdecor</div>
                <div class="right"></div>
            </a>

            <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Visualisation:")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('active'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="left"></div>
                <div class="center">vizualizace</div>
                <div class="right"></div>
            </a>

        </div>
        </div>
        <div class="filters">
            <img src="<?php echo TemplateHelpers::escapeHtml($staticUri) ?>/images/vizualizace-image.png" width="177" height="122" alt="vizualizace" />
            <h2>Vyzkoušejte náš unikátní online nástroj pro vizualizaci tapet přímo v interiéru</h2>
            <div class="text">Vyberte si z našich produktů a jednoduchým <strong>přetažením</strong> je umístěte přímo do
                iteriéru.</div>
        </div>
        <div class="clear"></div>
    </div>
    
    
        <div class="fullbox"  id="choose">
            <div class="h"><h2><?php echo TemplateHelpers::escapeHtml($template->upper('Výběr kolekce')) ?></h2></div>
            
            <a class="prev browse left disabled"></a>

            <div class="tagGroup-scrollable">
                <div class="items">                  
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($collections) as $tag): $modulus = $iterator->getCounter() % 6 ?>
                    <?php if ($iterator->isFirst()): ?><div class="group"><?php endif ?>

                        <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('tag',$iterator->getCounter() % 6 == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                            <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('image',$iterator->getCounter() % 6 == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                                <a class="img" href="<?php echo TemplateHelpers::escapeHtml($control->link("this#choose", array('id'=> $tag['id']))) ?>">

<?php if ($tag['picture_path']): ?>
                                        <?php echo TemplateHelpers::escapeHtml($template->image($tag['picture_path'], 150, 109, $tag['value'], FALSE, FALSE, FALSE, FALSE, NULL, NULL, NULL, Image::PNG)) ?>

<?php endif ?>
                                </a>


                                <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('name',$presenter->getParam('id') == $tag['id']  ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                                    <a href="<?php echo TemplateHelpers::escapeHtml($control->link("this#choose", array('id'=> $tag['id']))) ?>"><?php echo TemplateHelpers::escapeHtml($tag['value']) ?></a>

                                </div>

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


            <div class="clear"></div>
        </div>
        
    
    <div class="products">
        
        <div class="choose">
<div id="<?php echo $control->getSnippetId('choose') ?>"><?php call_user_func(reset($_l->blocks['_choose']), $_l, $template->getParams()) ?></div>        </div>
    
    </div>
        
    <div class="clear"></div>
<div id="<?php echo $control->getSnippetId('visualisation') ?>"><?php call_user_func(reset($_l->blocks['_visualisation']), $_l, $template->getParams()) ?></div>    <div class="toolsbar">
        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("cleanVisualisation!")) ?>">vyčistit vizualizaci</a>

    </div>
    
</div>
<?php
}}


//
// block _choose
//
if (!function_exists($_l->blocks['_choose'][] = '_lb291b859bd4__choose')) { function _lb291b859bd4__choose($_l, $_args) { extract($_args); $control->validateControl('choose')
?>
            <a class="prev browse left disabled"></a>
<?php if (isset($products)): ?>
            <div id="products-scrollable">
                <div class="items">
<?php if (count($products) > 0): foreach ($iterator = $_l->its[] = new SmartCachingIterator($products) as $product): $modulus = $iterator->getCounter() % 7 ?>
                        
                        <?php if ($iterator->isFirst()): ?><div class="group"><?php endif ?>

                            <div rel="<?php echo TemplateHelpers::escapeHtml($product['id']) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('productvis',$product['visualisation_path'] ? 'visualable':null,$iterator->getCounter() % 7 == 0 ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                                <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array($product['visualisation_path'] ? 'drag' : 'nodrag'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>></div>

                                <div class="image">
                                    <a class="addbasket" href="<?php echo TemplateHelpers::escapeHtml($control->link("addToBasket!", array('product_id' => $product['id']))) ?>"><span>přidat do košíku</span></a>

<?php if ($product['productPhoto_id']): ?>
                                        <a class="img" href="<?php echo TemplateHelpers::escapeHtml($control->link("Product:", array('id' => $product['id']))) ?>">

                                        <?php echo TemplateHelpers::escapeHtml($template->image($product->productPhoto['image_path'], 103, 103, $product['name'], FALSE, TRUE, FALSE, FALSE)) ?>

                                        </a>

<?php endif ?>
                                                                    </div>
                                <div class="price">
<?php if ($product["newprice"]): ?>
                                        <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['newprice'], BasePresenter::DPH))) ?></strong>
<?php else: ?>
                                        <strong><?php echo TemplateHelpers::escapeHtml($template->currency($template->dph($product['price'], BasePresenter::DPH))) ?></strong>
<?php endif ?>
                                     / <?php echo TemplateHelpers::escapeHtml($product->unit['name']) ?>

                                </div>
                                                            </div>

<?php if ($modulus == 0): ?>
                            <?php if ($iterator->isLast()): ?></div>
                            <?php else: ?></div><div class="group">
<?php endif ;elseif ($iterator->isLast()): ?>
                            </div>
<?php endif ;endforeach; array_pop($_l->its); $iterator = end($_l->its) ;endif ?>
                </div>
            </div>
<?php endif ?>
            <a class="next browse right disabled"></a>

            <div class="clear"></div>
<?php
}}


//
// block _visualisation
//
if (!function_exists($_l->blocks['_visualisation'][] = '_lb980c843942__visualisation')) { function _lb980c843942__visualisation($_l, $_args) { extract($_args); $control->validateControl('visualisation')
?>
    <div class="interier-container">
        <div id="interier">
            <div class="wall leftwall" id="wall1" <?php if ($visualisation->wall1): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall1->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall1->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall1->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall1): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall1'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall leftwall" id="wall2" <?php if ($visualisation->wall2): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall2->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall2->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall2->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall2): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall2'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall leftwall" id="wall3" <?php if ($visualisation->wall3): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall3->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall3->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall3->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall3): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall3'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall leftwall" id="wall4" <?php if ($visualisation->wall4): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall4->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall4->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall4->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall4): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall4'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall5" <?php if ($visualisation->wall5): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall5->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall5->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall5->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall5): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall5'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall6" <?php if ($visualisation->wall6): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall6->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall6->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall6->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall6): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall6'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall7" <?php if ($visualisation->wall7): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall7->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall7->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall7->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall7): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall7'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall8" <?php if ($visualisation->wall8): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall8->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall8->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall8->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall8): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall8'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall9" <?php if ($visualisation->wall9): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall9->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall9->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall9->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall9): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall9'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall10" <?php if ($visualisation->wall10): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall10->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall10->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall10->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall10): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall10'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall11" <?php if ($visualisation->wall11): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall11->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall11->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall11->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall11): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall11'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall12" <?php if ($visualisation->wall12): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall12->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall12->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall12->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall12): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall12'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall13" <?php if ($visualisation->wall13): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall13->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall13->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall13->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall13): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall13'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall14" <?php if ($visualisation->wall14): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall14->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall14->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall14->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall14): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall14'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall15" <?php if ($visualisation->wall15): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall15->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall15->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall15->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall15): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall15'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            <div class="wall" id="wall16" <?php if ($visualisation->wall16): ?>style="background-image: url('<?php echo $staticUri ?>/<?php echo $visualisation->wall16->backgroundimage ?>')" data-product_id="<?php echo TemplateHelpers::escapeHtml($visualisation->wall16->product['id']) ?>" data-rotate="<?php echo TemplateHelpers::escapeHtml($visualisation->wall16->rotate) ?>"<?php endif ?>>
                    <div class="frame"></div>
<?php if ($visualisation->wall16): ?>
                    <div class="tools">
                        <a class="clean" href="<?php echo TemplateHelpers::escapeHtml($control->link("clear!#choose", array('wall'=>'wall16'))) ?>">odebrat</a>

                        <a class="rotate" href="#choose">otočit</a>
                    </div>
<?php endif ?>
            </div>
            
            <div class="floor" style="background-image: url('<?php echo TemplateHelpers::escapeHtmlCss($staticUri) ?>/images/podlaha2.png');"></div>
            <div class="shadows"></div>
            <dii class="chair"></dii>
        </div>
    </div>
<?php
}}


//
// block modalvisual
//
if (!function_exists($_l->blocks['modalvisual'][] = '_lb24336a3dae_modalvisual')) { function _lb24336a3dae_modalvisual($_l, $_args) { extract($_args)
;
}}


//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lb008208a4b5_scripts')) { function _lb008208a4b5_scripts($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'scripts', $template->getParams()) ?>
    <script type="text/javascript">
    head.ready(function() {

        $(function() {
            // initialize scrollable

        $("#products-scrollable").livequery( function() {
            $(this).scrollable();
            $(".visualable").draggable({ 
                                helper: "clone",
                                appendTo: 'body',
                                containment: 'window',
                                scroll: false
            });
        });
        
       /* $("#interier").livequery( function() {
            $(".wall").draggable({ 
                                helper: "clone",
                                appendTo: 'body',
                                containment: 'window',
                                scroll: false
            });
        });*/
        
        $(function() {
            // initialize scrollable
            $(".tagGroup-scrollable").scrollable();
        });

        $(".wall").droppable({
            hoverClass: 'cursor-paint-texture',
            over: function(event, ui) {
                $(this).children('div.frame').addClass( "highlight" );
            },
            out: function(event, ui) {
                $(this).children('div.frame').removeClass( "highlight" );
            },
            drop: function(event, ui) {
                var id = $(ui.draggable).attr("rel");
                var wall = $(this);

                wall.data('product_id',id);
                wall.data('rotate',0);
                
                $.get(<?php echo TemplateHelpers::escapeJs($control->link("wall!")) ?>,{'productid': id, 'name': wall.attr("id")}, function(payload) {
                    wall.children().removeClass( "highlight" );
                    wall.css("background-image", "url(<?php echo $staticUri ?>/"+payload.backgroundimage+")" );
                    wall.html('<div class="frame"></div><div class="tools"><a class="clean" href="'+payload.clearlink+'#choose">odebrat</a><a class="rotate" href="#">otočit</a></div>');
                });
            }
        });
        
        $(".wall .rotate").livequery('click', function(e) {
            e.preventDefault();
            wall = $(this).closest('.wall');
            if(wall.data('rotate') == 0) {
                rotate = 90;
            }
            else {
                rotate = 0;
            }
            $.get(<?php echo TemplateHelpers::escapeJs($control->link("wall!")) ?>,{'productid': wall.data('product_id'), 'name': wall.attr("id"), 'rotate' : rotate}, function(payload) {
                    wall.css("background-image", "url(<?php echo $staticUri ?>/"+payload.backgroundimage+")" );
                    wall.data('rotate',rotate);
                });
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
$title = 'Vizualizace tapet' ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()); }  if (!$_l->extends) { call_user_func(reset($_l->blocks['modalvisual']), $_l, get_defined_vars()); } ?>

<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['scripts']), $_l, get_defined_vars()); }  
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
