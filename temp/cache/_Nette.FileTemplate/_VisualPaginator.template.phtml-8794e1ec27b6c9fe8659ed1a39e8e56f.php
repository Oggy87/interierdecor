<?php //netteCache[01]000362a:2:{s:4:"time";s:21:"0.08716200 1337109359";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:76:"/var/www/webtoad/interierdecor/app/components/VisualPaginator/template.phtml";i:2;i:1299841718;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/components/VisualPaginator/template.phtml

?><?php
$_l = LatteMacros::initRuntime($template, NULL, 'q95yrlmb50'); unset($_extends);

if (isset($presenter, $control) && $presenter->isAjax() && $control->isControlInvalid()) {
	return LatteMacros::renderSnippets($control, $_l, get_defined_vars());
}
if ($paginator->pageCount > 1): ?>
<div class="paginator">
<?php if ($paginator->isFirst()): ?>
	<span class="cufon button previous">« Předchozí</span>
<?php else: ?>
	<a class="cufon previous" href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('page' => $paginator->page - 1))) ?>">« Předchozí</a>
<?php endif ?>

<?php foreach ($iterator = $_l->its[] = new SmartCachingIterator($steps) as $step): if ($step == $paginator->page): ?>
		<span class="cufon current"><?php echo TemplateHelpers::escapeHtml($step) ?></span>
<?php else: ?>
		<a class="cufon" href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('page' => $step))) ?>"><?php echo TemplateHelpers::escapeHtml($step) ?></a>
<?php endif ?>
	<?php if ($iterator->nextValue > $step + 1): ?><span>…</span><?php endif ?>

<?php endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>

<?php if ($paginator->isLast()): ?>
	<span class="cufon button next">Další »</span>
<?php else: ?>
	<a class="cufon next" href="<?php echo TemplateHelpers::escapeHtml($control->link("this", array('page' => $paginator->page + 1))) ?>">Další »</a>
<?php endif ?>
</div>
<?php endif ;