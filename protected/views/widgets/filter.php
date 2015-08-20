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
        <?php $val = __in_filter($price->id); ?>
        <?php if(!empty($price->filter_variants)): ?>
            <label for="field_<?php echo $price->id; ?>"><?php echo $price->trl->name; ?></label>
            <select id="field_<?php echo $price->id; ?>" name="<?php echo $price->filter_field_name ?>">
                <?php foreach($price->filter_variants as $key => $title): ?>
                    <option <?php if($val == $key): ?> selected <?php endif; ?> value="<?php echo $key ?>"><?php echo $title ?></option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <label for="field_<?php echo $price->id; ?>"><?php echo $price->trl->name; ?></label>
            <input id="field_<?php echo $price->id; ?>" type="text" value="<?php echo $val; ?>" name="<?php echo $price->filter_field_name ?>">
        <?php endif; ?>
    <?php endif; ?>

    <br>

    <?php if(!empty($date)): ?>
        <?php $date->filterEssentials(); ?>
        <?php $val = __in_filter($date->id); ?>
        <label for="field_<?php echo $date->id; ?>"><?php echo $date->trl->name; ?></label>
        <input id="field_<?php echo $date->id; ?>" type="text" value="<?php echo $val; ?>" name="<?php echo $date->filter_field_name ?>">
    <?php endif; ?>

    <br>

    <?php if(!empty($color)): ?>
        <?php $color->filterEssentials(); ?>
        <?php $val = __in_filter($color->id); ?>
        <label><?php echo $color->trl->name; ?></label><br>
        <?php foreach($color->filter_variants as $key => $title): ?>
            <label for="<?php echo $color->id.'_'.$key; ?>"><?php echo __($title); ?></label>
            <input <?php if(is_array($val) && in_array($key,$val)): ?> checked <?php endif; ?> id="<?php echo $color->id.'_'.$key; ?>" type="checkbox" value="<?php echo $key; ?>" name="<?php echo $color->filter_field_name_group; ?>"><br>
        <?php endforeach; ?>
    <?php endif; ?>

    <br>

    <input type="submit" name="<?php echo ContentItemFieldEx::FILTER_CLEAN_BUTTON_NAME; ?>" value="<?php echo __('Clean'); ?>">

    <br>

    <input type="submit">
</form>
