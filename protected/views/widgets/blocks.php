<?php /* @var $widget WidgetEx */ ?>
<?php /* @var $content ContentItemEx[] */ ?>

<?php
/*
 * TemplateType:Blocks
 * TemplateName:Blocks
 */
?>

<?php foreach($content as $item): ?>
    <?php echo $item->trl->name."<br>"; ?>
<?php endforeach; ?>