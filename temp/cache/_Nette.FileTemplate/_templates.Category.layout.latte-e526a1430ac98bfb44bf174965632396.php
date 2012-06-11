<?php //netteCache[01]000364a:2:{s:4:"time";s:21:"0.83886600 1337109357";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:78:"/var/www/webtoad/interierdecor/app/FrontModule/templates/Category.layout.latte";i:2;i:1333528149;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/FrontModule/templates/Category.layout.latte

?><?php
$_l = LatteMacros::initRuntime($template, true, '73u627nd7h'); unset($_extends);


//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbca4f6e8110_content')) { function _lbca4f6e8110_content($_l, $_args) { extract($_args)
?>
<div id="category">

    
    <div class="top">
        <div class="lefttop">
        <h1><?php echo TemplateHelpers::escapeHtml($template->ucfirst($category['name'])) ?></h1>
        <div class="clear"></div>
        <div id="breadcrumbs">
<?php call_user_func(reset($_l->blocks['breadcrumbs']), $_l, get_defined_vars()) ?>
        </div>

        </div>
                <?php if ($presenter->tags): ?>

        <div class="filters">
            <div class="title"><?php echo TemplateHelpers::escapeHtml($template->upper('Váš filtr')) ?>:</div><?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($tagGroupes) as $tagGroup): ?>
            <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('filterline'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <span class="taggroup"><?php echo TemplateHelpers::escapeHtml($tagGroup['name']) ?>:</span>
<?php $groupTags = clone $tags ;foreach ($iterator = $_l->its[] = new SmartCachingIterator($groupTags->where('tagGroup_id',$tagGroup['id'])) as $tag): $ids = explode('+',$presenter->tags) ; unset($ids[array_search($tag['id'], $ids)]) ?>
                    <a href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('tags' => implode('+',$ids)))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('removeTag'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><?php echo TemplateHelpers::escapeHtml($tag['value']) ?></a>

                    <a href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('tags' => implode('+',$ids)))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('img', 'removeTag'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><img src="<?php echo TemplateHelpers::escapeHtml($staticUri) ?>/images/tag-cross.png" alt="remove tag" /></a>

                    <?php if (!$iterator->isLast()): ?> + <?php endif ?>

<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
            </div>
<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
                        <div class="all">
                <div class="filtercount"><div id="<?php echo $control->getSnippetId('filtercount') ?>"><?php call_user_func(reset($_l->blocks['_filtercount']), $_l, $template->getParams()) ?></div></div>
<?php if (count($tags) > 0): ?>
                <a href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('tags' => NULL, 'from'=> NULL, 'to'=> NULL))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('removeTag'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>odebrat vše</a>
<?php endif ;if (count($tags) > 0): ?>
                <a href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('tags' => NULL, 'from'=> NULL, 'to'=> NULL))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('removeTag','img'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><img src="<?php echo TemplateHelpers::escapeHtml($staticUri) ?>/images/tag-cross.png" alt="remove tags" /></a>
<?php endif ?>
            </div>
            
        </div>
<?php else: ?>
        <div class="filters">
            <p class="title">Vybírejte si produkty přesně podle vašich představ.</p>
            <p>Vyfiltrujte si produkty podle kriterií v levé části.</p>
        </div>
<?php endif ?>
                <div class="clear"></div>
    </div>
<?php if ($count == 0): ?>
    <div class="notice">
            <p class="info">Tuto kategorii produktů připravujeme.</p>
        </div>
<?php else: ?>
    <div class="mainpanel">
<?php LatteMacros::callBlock($_l, 'main', $template->getParams()) ?>
    </div>
<?php if ($count > 0): ?>
    <div class="leftpanel">
<?php call_user_func(reset($_l->blocks['left']), $_l, get_defined_vars()) ?>
    </div>
<?php endif ;endif ?>
    <div class="clear"></div>
    
</div>
<?php
}}


//
// block breadcrumbs
//
if (!function_exists($_l->blocks['breadcrumbs'][] = '_lb98040a8cfb_breadcrumbs')) { function _lb98040a8cfb_breadcrumbs($_l, $_args) { extract($_args)
?>
            <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Homepage:")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('first'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="left"></div>
                <div class="center">interierdecor</div>
                <div class="right"></div>
            </a>

            <a href="<?php echo TemplateHelpers::escapeHtml($control->link(":Front:Category:", array('id' => $category['id']))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('active'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

                <div class="left"></div>
                <div class="center"><?php echo TemplateHelpers::escapeHtml($template->lower($category['name'])) ?></div>
                <div class="right"></div>
            </a>
<?php
}}


//
// block _filtercount
//
if (!function_exists($_l->blocks['_filtercount'][] = '_lb132ea58f51__filtercount')) { function _lb132ea58f51__filtercount($_l, $_args) { extract($_args); $control->validateControl('filtercount')
?>Filtru odpovídá: <?php echo TemplateHelpers::escapeHtml($products->count("*")) ?> produktů<?php
}}


//
// block left
//
if (!function_exists($_l->blocks['left'][] = '_lb28d7b9d9f1_left')) { function _lb28d7b9d9f1_left($_l, $_args) { extract($_args)
;if ($presenter->tags): ?>
        <div class="leftbox slider">
            <div class="name">Cenové rozmezí</div>
            <div class="slide">
                <label for="amount">Cena: </label>
                <input type="text" id="amount" />
                <div id="slider"></div>
            </div>
        </div>
<?php else: call_user_func(reset($_l->blocks['tips']), $_l, get_defined_vars()) ;endif ?><div id="<?php echo $control->getSnippetId('tags') ?>"><?php call_user_func(reset($_l->blocks['_tags']), $_l, $template->getParams()) ?></div><?php
}}


//
// block tips
//
if (!function_exists($_l->blocks['tips'][] = '_lbdc5def7b78_tips')) { function _lbdc5def7b78_tips($_l, $_args) { extract($_args)
;if ((count($recommended) > 0) OR (count($discount) > 0) OR (count($new) > 0)): ?>
                        <div class="leftbox">
                <div class="name">Naše tipy</div>
                <div class="content"><?php if (count($recommended) > 0): ?>
                    <a href="<?php echo TemplateHelpers::escapeHtml($control->link("recommended")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->linkCurrent ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><span>doporučujeme</span></a>
<?php endif ;if (count($new) > 0): ?>
                    <a href="<?php echo TemplateHelpers::escapeHtml($control->link("new")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->linkCurrent ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><span>novinky</span></a>
<?php endif ;if (count($discount) > 0): ?>
                    <a href="<?php echo TemplateHelpers::escapeHtml($control->link("actions")) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->linkCurrent ? 'active':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><span>v akci</span></a>
<?php endif ?>
                </div>
            </div>
                    <?php endif ?>

<?php
}}


//
// block _tags
//
if (!function_exists($_l->blocks['_tags'][] = '_lbc7bbea62ba__tags')) { function _lbc7bbea62ba__tags($_l, $_args) { extract($_args); $control->validateControl('tags')
?>
                <?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($category_tagGroupes) as $category_tagGroup): ?>

                <?php $tags = BaseModel::fetchAll('tag')->where("tagGroup_id",$category_tagGroup->tagGroup['id'])->order("value") ;if ($tags->count('*') > 0): ?>
        <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('tag-group'))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>>

            <div class="name closed"><?php echo TemplateHelpers::escapeHtml($template->ucfirst($category_tagGroup->tagGroup['name'])) ?></div>
            <div class="tags"  style="display:none;">
<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($tags) as $tag): if (BaseModel::fetchAll("product_tag")->where("tag_id",$tag['id'])->where("product.active",1)->count('*') > 0): if ($presenter->tags): $tagsurl = $presenter->tags.'+'.$tag['id'] ;else: $tagsurl = $tag['id'] ;endif ?>
                    <a href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('tags' => $tagsurl))) ?>"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($presenter->linkCurrent ? 'active':null,$iterator->isLast() ? 'last':null))))) echo ' class="' . TemplateHelpers::escapeHtml($_l->tmp) . '"' ?>><span><?php echo TemplateHelpers::escapeHtml($tag['value']) ?></span></a>

<?php endif ;endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
            </div>
        </div>
<?php endif ;endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
            
<?php
}}


//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lbdef206c4a5_scripts')) { function _lbdef206c4a5_scripts($_l, $_args) { extract($_args)
;LatteMacros::callBlockParent($_l, 'scripts', $template->getParams()) ?>
<script type="text/javascript">
    head.ready(function() {

      /*  $(".tag-group .tags").livequery(function() {
            $(this).hide();
        });*/
        $(".tag-group .name").livequery(function() {
            $(this).addClass("closed");
        });
        /*$(".tag-group").hover(function() {
            $(this).children(".name").removeClass("closed");
            $(this).children(".name").addClass("open");
            $(this).children(".tags").slideDown('slow');
        }, function(){
             
        });*/
        
         
        $(".tag-group .closed").live('click',function() {
            $(this).removeClass("closed");
            $(this).addClass("open");
            $(this).next(".tags").slideDown('slow');
        });
        $(".tag-group .open").live('click',function() {
            $(this).removeClass("open");
            $(this).addClass("closed");
            $(this).next(".tags").slideUp('slow');
        });
        
        $( "#slider" ).slider({
            range: true,
            min: 0,
            max: <?php echo $template->roundUp($template->dph($maxprice, BasePresenter::DPH)) ?>,
            values: [ <?php if ($presenter->from): echo $presenter->from ;else: ?>0<?php endif ?>, <?php if ($presenter->to): echo $presenter->to ;else: echo $template->dph($maxprice, BasePresenter::DPH) ;endif ?> ],
            slide: function( event, ui ) {
                $( "#amount" ).val( ui.values[ 0 ] + " Kč - " + ui.values[ 1 ] + " Kč");
            },
            change: function(event, ui) {
                $.get(<?php echo TemplateHelpers::escapeJs($control->link("priceRange!")) ?>, {'from': ui.values[ 0 ], 'to': ui.values[ 1 ]}, function(payload) {
                    for(var id in payload.snippets) {
                        $.nette.updateSnippet(id, payload.snippets[id]);
                    }
                });
            }
	});
	$( "#amount" ).val( $( "#slider" ).slider( "values", 0 ) + " Kč - " + $( "#slider" ).slider( "values", 1 ) + " Kč" );
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

<?php $title = $category['name'] ;foreach ($iterator = $_l->its[] = new SmartCachingIterator($tags) as $tag): $title .= ' - '.$tag['value'] ;endforeach; array_pop($_l->its); $iterator = end($_l->its)  ?>

<?php
if ($_l->extends) {
	ob_end_clean();
	LatteMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
