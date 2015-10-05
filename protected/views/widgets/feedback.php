<?php /* @var $this Controller */ ?>
<?php /* @var $widget WidgetEx */ ?>
<?php /* @var $content ContentItemFieldEx[] */ ?>

<?php
/*
 * TemplateType:Form
 * TemplateName:Feedback
 */
?>

<?php if(!DynamicForms::getInstance()->isSuccessful($widget->id)): ?>
<form method="post">
    <?php foreach($content as $index => $field): ?>

        <?php $old = DynamicForms::getInstance()->getOldValue($widget->id,$field->id) ?>
        <?php echo $field->formFieldEssentials(); ?>

        <?php if($field->field_type_id == Constants::FIELD_TYPE_TEXT): ?>
            <label for="<?php echo $field->id; ?>"><?php echo !empty($field->trl) ? $field->trl->name : ''; ?></label>
            <input name="<?php echo $field->form_field_name; ?>" id="<?php echo $field->id; ?>" type="text" value="<?php echo $old; ?>" placeholder="<?php echo !empty($field->trl) ? $field->trl->name : ''; ?>"><br>
        <?php elseif($field->field_type_id == Constants::FIELD_TYPE_BOOLEAN): ?>
            <label for="<?php echo $field->id; ?>"><?php echo !empty($field->trl) ? $field->trl->name : ''; ?></label>
            <input <?php if($old): ?> checked <?php endif; ?> name="<?php echo $field->form_field_name; ?>" id="<?php echo $field->id; ?>" type="checkbox" value="1"><br>
        <?php elseif($field->field_type_id == Constants::FIELD_TYPE_NUMERIC || $field->field_type_id == Constants::FIELD_TYPE_PRICE): ?>
            <label for="<?php echo $field->id; ?>"><?php echo !empty($field->trl) ? $field->trl->name : ''; ?></label>
            <input name="<?php echo $field->form_field_name; ?>" id="<?php echo $field->id; ?>" type="text" value="<?php echo $old; ?>" placeholder="<?php echo !empty($field->trl) ? $field->trl->name : ''; ?>"><br>
        <?php elseif($field->field_type_id == Constants::FIELD_TYPE_MULTIPLE_CHECKBOX): ?>
            <?php foreach($field->getSelectableVariants() as $value => $title): ?>
                <label for="<?php echo $field->id ?>_<?php echo $value; ?>"><?php echo $title; ?></label>
                <input id="<?php echo $field->id ?>_<?php echo $value; ?>" value="<?php echo $value ?>" name="<?php echo $field->form_field_name_group ?>" type="checkbox"><br>
            <?php endforeach; ?>
        <?php endif; ?>
        <label style="color: red;"><?php echo DynamicForms::getInstance()->getError($widget->id,$field->id); ?></label><br>
    <?php endforeach; ?>
    <br>

    <?php if($widget->form_captcha): ?>
        <img src="<?php echo DynamicForms::getInstance()->getCapUrl(); ?>"><br>
        <label for="cap"><?php echo __('Captcha'); ?></label><br>
        <input id="cap" value="" name="<?php echo DynamicForms::getInstance()->getCapFieldName($widget->id); ?>" placeholder=""><br>
        <label style="color: red;"><?php echo DynamicForms::getInstance()->getError($widget->id,'cap'); ?></label><br>
    <?php endif; ?>

    <input type="submit">
</form>
<?php else: ?>
    <label><?php echo __('You message successfully sent'); ?></label>
<?php endif; ?>



