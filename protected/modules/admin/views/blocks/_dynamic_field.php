<?php /* @var $item ContentItemEx */ ?>
<?php /* @var $field ContentItemFieldEx */ ?>

<?php if($field->field_type_id == Constants::FIELD_TYPE_NUMERIC): ?>
    <tr>
        <td class="label"><?php echo __a($field->label); ?></td>
        <td class="value"><input type="text" name="ContentItemEx[dynamic][<?php echo $field->id; ?>]" value="<?php echo $field->getValueFor($item->id)->numeric_value; ?>" placeholder="<?php echo __a('Number'); ?>"></td>
    </tr>
<?php elseif($field->field_type_id == Constants::FIELD_TYPE_PRICE):?>
    <tr>
        <td class="label"><?php echo __a($field->label); ?></td>
        <td class="value"><input type="text" name="ContentItemEx[dynamic][<?php echo $field->id; ?>]" value="<?php echo $field->getValueFor($item->id)->numeric_value; ?>" placeholder="<?php echo __a('0.00'); ?>"></td>
    </tr>
<?php elseif($field->field_type_id == Constants::FIELD_TYPE_TEXT): ?>
    <?php if(!$field->use_wysiwyg): ?>
        <tr>
            <td class="label"><?php echo __a($field->label); ?>:</td>
            <td class="value"><input type="text" name="ContentItemEx[dynamic][<?php echo $field->id; ?>]" value="<?php echo $field->getValueFor($item->id)->text_value; ?>" placeholder="<?php echo __('Text'); ?>"></td>
        </tr>
    <?php else: ?>
        <tr>
            <td class="label"><?php echo __a($field->label); ?>:</td>
            <td class="value"><textarea name="ContentItemEx[dynamic][<?php echo $field->id; ?>]"><?php echo $field->getValueFor($item->id)->text_value; ?></textarea></td>
        </tr>
    <?php endif; ?>
<?php elseif($field->field_type_id == Constants::FIELD_TYPE_BOOLEAN): ?>
    <tr>
        <td class="label"><?php echo __a($field->label); ?></td>
        <td class="value">
            <input type="hidden" name="ContentItemEx[dynamic][<?php echo $field->id; ?>]" value="0">
            <input value="1" name="ContentItemEx[dynamic][<?php echo $field->id; ?>]" type="checkbox" <?php if($field->getValueFor($item->id)->numeric_value != 0): ?> checked <?php endif; ?>>
        </td>
    </tr>
<?php elseif($field->field_type_id == Constants::FIELD_TYPE_DATE): ?>
    <tr>
        <td class="label"><?php echo __a($field->label); ?></td>
        <td class="value">
            <?php $seconds = $field->getValueFor($item->id)->numeric_value; ?>
            <?php $currentDate = !empty($seconds) ? date('m/d/Y',$seconds) : date('m/d/Y',time());  ?>
            <input class="date-picker-block" name="ContentItemEx[dynamic][<?php echo $field->id; ?>]" type="text" value="<?php echo $currentDate;  ?>" placeholder="<?php echo __a('Date'); ?>">
        </td>
    </tr>
<?php elseif($field->field_type_id == Constants::FIELD_TYPE_IMAGE): ?>
    <tr>
        <td class="label"><?php echo __a($field->label); ?></td>
        <td class="value"><input name="DynamicFileField_<?php echo $field->id; ?>" type="file" data-label="<?php echo __('Browse'); ?>"></td>
    </tr>
<?php elseif($field->field_type_id == Constants::FIELD_TYPE_FILE): ?>
    <tr>
        <td class="label"><?php echo __a($field->label); ?></td>
        <td class="value"><input name="DynamicFileField_<?php echo $field->id; ?>" type="file" data-name="<?php echo __('Browse'); ?>"></td>
    </tr>
<?php endif?>