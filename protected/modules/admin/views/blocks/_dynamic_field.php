<?php /* @var $item ContentItemEx */ ?>
<?php /* @var $field ContentItemFieldEx */ ?>
<?php /* @var $this BlocksController */ ?>

<?php if($field->field_type_id == Constants::FIELD_TYPE_NUMERIC): ?>
    <tr>
        <td class="label"><?php echo __a($field->label); ?></td>
        <td class="value"><input class="numeric-input-block" type="text" name="ContentItemEx[dynamic][<?php echo $field->id; ?>]" value="<?php echo $field->getValueFor($item->id)->numeric_value; ?>" placeholder="<?php echo __a('Number'); ?>"></td>
    </tr>
<?php elseif($field->field_type_id == Constants::FIELD_TYPE_PRICE):?>
    <tr>
        <td class="label"><?php echo __a($field->label); ?></td>
        <td class="value">
            <?php $cents = $field->getValueFor($item->id)->numeric_value; ?>
            <input class="numeric-input-price" type="text" name="ContentItemEx[dynamic][<?php echo $field->id; ?>]" value="<?php echo $cents > 0 ? centsToPrice($cents) : ''; ?>" placeholder="<?php echo __a('0.00'); ?>">
        </td>
    </tr>
<?php elseif($field->field_type_id == Constants::FIELD_TYPE_TEXT): ?>
    <?php if(!$field->use_wysiwyg): ?>
        <tr>
            <td class="label"><?php echo __a($field->label); ?>:</td>
            <td class="value"><input type="text" name="ContentItemEx[dynamic][<?php echo $field->id; ?>]" value="<?php echo $field->getValueFor($item->id)->text_value; ?>" placeholder="<?php echo __a('Text'); ?>"></td>
        </tr>
    <?php else: ?>
        <tr>
            <td class="label"><?php echo __a($field->label); ?>:</td>
            <td class="value"><textarea class="editor-area" name="ContentItemEx[dynamic][<?php echo $field->id; ?>]"><?php echo $field->getValueFor($item->id)->text_value; ?></textarea></td>
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
        <td class="value"><input name="DynamicFileField_<?php echo $field->id; ?>" type="file" data-label="<?php echo __a('Browse'); ?>"></td>
    </tr>
    <tr>
        <td class="label"></td>
        <td class="value image-zone smaller">
            <?php $valueObj = $field->getValueFor($item->id); ?>
            <?php $iov = $valueObj->imageOfValues; ?>
            <div class="list">
                <?php if(!empty($iov)): ?>
                    <?php foreach($iov as $imageOf): ?>
                        <div class="image">
                            <img src="<?php echo $imageOf->image->getCachedUrl(103,77,false); ?>" alt="">
                            <a href="<?php echo Yii::app()->createUrl('admin/blocks/deleteimagedirect',array('id' => $imageOf->image_id)); ?>" class="delete active confirm-box"></a>
                        </div>
                    <?php endforeach;?>
                <?php else:?>
                    <div class="image">
                        <img src="<?php echo $this->assets; ?>/images/no-image-upload.png" alt="">
                        <a href="#" class="delete"></a>
                    </div>
                <?php endif;?>
            </div>
        </td>
    </tr>
<?php elseif($field->field_type_id == Constants::FIELD_TYPE_FILE): ?>
    <tr>
        <td class="label"><?php echo __a($field->label); ?></td>
        <td class="value"><input name="DynamicFileField_<?php echo $field->id; ?>" type="file" data-name="<?php echo __a('Browse'); ?>"></td>
    </tr>
    <tr>
        <td class="label"></td>
        <td class="value file-zone">
            <?php $valueObj = $field->getValueFor($item->id); ?>
            <?php $fov = $valueObj->fileOfValues; ?>
            <?php if(!empty($fov)): ?>
                <div class="list">
                    <ul class="file">
                        <?php foreach($fov as $fileOf): ?>
                            <li><a href="<?php echo Yii::app()->createUrl('files/getfile',array('id' => $fileOf->file_id)); ?>"><?php echo $fileOf->file->original_filename; ?></a><a href="<?php echo Yii::app()->createUrl('admin/blocks/deletefiledirect',array('id' => $fileOf->file_id)); ?>" class="delete active confirm-box"></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif;?>
        </td>
    </tr>
<?php endif?>