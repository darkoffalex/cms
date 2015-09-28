<?php /* @var $widget WidgetEx */ ?>
<?php /* @var $content ContentItemFieldEx[] */ ?>

<?php
/*
 * TemplateType:Form
 * TemplateName:Feedback
 */
?>

<form method="post">
    <?php foreach($content as $index => $field): ?>
        <?php if($field->field_type_id == Constants::FIELD_TYPE_TEXT): ?>
            <?php echo $field->formFieldEssentials(); ?>
            <label for="<?php echo $field->id; ?>"><?php echo !empty($field->trl) ? $field->trl->name : ''; ?></label>
            <input name="<?php echo $field->form_field_name; ?>" id="<?php echo $field->id; ?>" type="text" value="" placeholder="<?php echo !empty($field->trl) ? $field->trl->name : ''; ?>"><br>
        <?php elseif($field->field_type_id == Constants::FIELD_TYPE_BOOLEAN): ?>
            <?php echo $field->formFieldEssentials(); ?>
            <label for="<?php echo $field->id; ?>"><?php echo !empty($field->trl) ? $field->trl->name : ''; ?></label>
            <input name="<?php echo $field->form_field_name; ?>" id="<?php echo $field->id; ?>" type="checkbox" value="1"><br>
        <?php elseif($field->field_type_id == Constants::FIELD_TYPE_NUMERIC): ?>
            <?php echo $field->formFieldEssentials(); ?>
            <label for="<?php echo $field->id; ?>"><?php echo !empty($field->trl) ? $field->trl->name : ''; ?></label>
            <input name="<?php echo $field->form_field_name; ?>" id="<?php echo $field->id; ?>" type="text" value="" placeholder="<?php echo !empty($field->trl) ? $field->trl->name : ''; ?>"><br>
        <?php endif; ?>
    <?php endforeach; ?>
    <br>
    <input type="submit">
</form>


