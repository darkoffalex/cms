<?php /* @var $model WidgetEx */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Widgets');?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/widgets/list'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content page-content">

        <div class="header">
            <?php $title = $model->isNewRecord ? 'Add form widget' : 'Edit form widget'; ?>
            <span><?php echo __a($title); ?></span>

            <?php if($model->form_type_id == Constants::FORM_WIDGET_FEEDBACK): ?>
                <a href="<?php echo Yii::app()->createUrl('admin/widgets/feedbackincoming',array('id' => $model->id)); ?>"><?php echo __a('Incoming messages'); ?></a>
                <?php if(!empty($model->filtrationByType)): ?>
                    <a class="active" href="<?php echo Yii::app()->createUrl('admin/widgets/feedbackvalidation',array('id' => $model->id)); ?>"><?php echo __a('Field validation'); ?></a>
                <?php endif; ?>
            <?php endif; ?>

            <a href="<?php echo Yii::app()->createUrl('admin/widgets/edit',array('id' => $model->id)); ?>"><?php echo __a('General'); ?></a>
        </div><!--/header-->

        <div class="inner-content">
            <form method="post" action="">
                <table>
                    <?php $fields = $model->filtrationByType->getFrontEditableFields(true);?>
                    <?php if(!empty($fields)): ?>
                        <?php foreach($fields as $field): ?>
                            <tr>
                                <td class="label"><label for="field_<?php echo $field->id; ?>"><?php echo $field->label; ?></label></td>
                                <td class="value filtration-conditions">
                                    <?php $selected = $model->validationConfigFor($field->id); ?>
                                    <?php if($field->field_type_id == Constants::FIELD_TYPE_NUMERIC || $field->field_type_id == Constants::FIELD_TYPE_PRICE): ?>
                                        <select class="fcb" name="ValidationParams[<?php echo $field->id; ?>][rule]" id="field_<?php echo $field->id; ?>">
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_IGNORE): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_IGNORE; ?>"><?php echo __a('Ignore'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_NOT_ZERO): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_NOT_ZERO; ?>"><?php echo __a('Not zero'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_POSITIVE): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_POSITIVE; ?>"><?php echo __a('Just positive values'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_NEGATIVE): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_NEGATIVE; ?>"><?php echo __a('Just negative values'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_NUM_INTERVAL): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_NUM_INTERVAL; ?>"><?php echo __a('Specified interval'); ?></option>
                                        </select>
                                    <?php elseif($field->field_type_id == Constants::FIELD_TYPE_TEXT): ?>
                                        <select class="fcb" name="ValidationParams[<?php echo $field->id; ?>][rule]" id="field_<?php echo $field->id; ?>">
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_IGNORE): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_IGNORE; ?>"><?php echo __a('Ignore'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_NOT_EMPTY): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_NOT_EMPTY; ?>"><?php echo __a('Not empty'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_LENGTH): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_LENGTH ?>"><?php echo __a('Specified length'); ?></option>
                                        </select>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"></td>
                                <td class="filtration-conditions">
                                    <input type="text" placeholder="<?php echo __a('Value'); ?>" value="" name="ValidationParams[<?php echo $field->id; ?>][value_0]">
                                </td>
                            </tr>
                            <tr>
                                <td class="label"></td>
                                <td class="filtration-conditions">
                                    <input type="text" placeholder="<?php echo __a('From'); ?>" value="" name="ValidationParams[<?php echo $field->id; ?>][value_0]">
                                    <input type="text" placeholder="<?php echo __a('To'); ?>" value="" name="ValidationParams[<?php echo $field->id; ?>][value_1]">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td class="label">&nbsp;</td>
                            <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td><?php echo __a('Selected type has no fields which can be configured for validation'); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </form>
        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>