<?php /* @var $widget WidgetEx */ ?>
<?php /* @var $content TreeEx[] */ ?>

<?php
/*
 * TemplateType:Menu
 * TemplateName:Main menu
 */
?>

<ul>
    <?php foreach($content as $item): ?>
    <li><a href="<?php echo $item->getUrl(); ?>"><?php echo $item->trl->name; ?></a></li>
    <?php endforeach; ?>
</ul>