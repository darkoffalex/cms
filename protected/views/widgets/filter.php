<?php /* @var $widget WidgetEx */ ?>
<?php /* @var $content ContentItemFieldEx[] */ ?>

<?php
/*
 * TemplateType:Filter
 * TemplateName:Filter Widget
 */
?>

<form method="post">
    <?php $price = $widget->getFilterField('price'); ?>
    <?php $date = $widget->getFilterField('date'); ?>
    <?php $color = $widget->getFilterField('color'); ?>

    <?php if(!empty($price)): ?>
        <?php $price->filterEssentials(); ?>
        <?php if(!empty($price->filter_variants)): ?>
            <label for="field_<?php echo $price->id; ?>"><?php echo $price->trl->name; ?></label>
            <select id="field_<?php echo $price->id; ?>" name="<?php echo $price->filter_field_name ?>">
                <?php foreach($price->filter_variants as $key => $title): ?>
                    <option value="<?php echo $key ?>"><?php echo $title ?></option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <label for="field_<?php echo $price->id; ?>"><?php echo $price->trl->name; ?></label>
            <input id="field_<?php echo $price->id; ?>" type="text" value="" name="<?php echo $price->filter_field_name ?>">
        <?php endif; ?>
    <?php endif; ?>

    <br>

    <?php if(!empty($date)): ?>
        <?php $date->filterEssentials(); ?>
        <label for="field_<?php echo $date->id; ?>"><?php echo $date->trl->name; ?></label>
        <input id="field_<?php echo $date->id; ?>" type="text" value="" name="<?php echo $date->filter_field_name ?>">
    <?php endif; ?>

    <br>

    <?php if(!empty($color)): ?>

    <?php endif; ?>

    <input type="submit">
</form>
