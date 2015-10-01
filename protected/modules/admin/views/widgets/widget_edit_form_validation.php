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

                                    <?php $config = $model->validationConfigFor($field->id); ?>
                                    <?php $selected = !empty($config['rule']) ? $config['rule'] : null; ?>
                                    <?php $specified_value = !empty($config['specified']) ? $config['specified'] : null; ?>
                                    <?php $interval = !empty($config['interval']) ? $config['interval'] : array(); ?>

                                    <?php if($field->field_type_id == Constants::FIELD_TYPE_NUMERIC || $field->field_type_id == Constants::FIELD_TYPE_PRICE): ?>
                                        <select class="fcb trigger-field" name="ValidationParams[<?php echo $field->id; ?>][rule]" id="field_<?php echo $field->id; ?>_numeric">
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_IGNORE): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_IGNORE; ?>"><?php echo __a('Ignore'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_NOT_ZERO): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_NOT_ZERO; ?>"><?php echo __a('Not zero / Not empty'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_POSITIVE): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_POSITIVE; ?>"><?php echo __a('Just positive values'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_NEGATIVE): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_NEGATIVE; ?>"><?php echo __a('Just negative values'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_NUM_INTERVAL): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_NUM_INTERVAL; ?>"><?php echo __a('Specified interval'); ?></option>
                                        </select>
                                    <?php elseif($field->field_type_id == Constants::FIELD_TYPE_TEXT): ?>
                                        <select class="fcb trigger-field" name="ValidationParams[<?php echo $field->id; ?>][rule]" id="field_<?php echo $field->id; ?>_text">
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_IGNORE): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_IGNORE; ?>"><?php echo __a('Ignore'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_NOT_EMPTY): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_NOT_EMPTY; ?>"><?php echo __a('Not empty'); ?></option>
                                            <option <?php if($selected == Constants::FORM_VAL_FIELD_LENGTH): ?> selected <?php endif; ?> value="<?php echo Constants::FORM_VAL_FIELD_LENGTH ?>"><?php echo __a('Specified length'); ?></option>
                                        </select>
                                    <?php endif;?>
                                </td>
                            </tr>

                            <?php $classInputStrict = $field->field_type_id == Constants::FIELD_TYPE_PRICE ? 'numeric-input-price' : 'numeric-input-block'; ?>

                            <tr class="triggered" data-trigger="field_<?php echo $field->id; ?>_text" data-condition="<?php echo Constants::FORM_VAL_FIELD_LENGTH ?>">
                                <td class="label"><?php echo __('Value'); ?></td>
                                <td class="filtration-conditions">
                                    <input class="<?php echo $classInputStrict; ?>" type="text" placeholder="" value="<?php echo $specified_value; ?>" name="ValidationParams[<?php echo $field->id; ?>][specified]">
                                </td>
                            </tr>
                            <tr class="triggered" data-trigger="field_<?php echo $field->id; ?>_numeric" data-condition="<?php echo Constants::FORM_VAL_FIELD_NUM_INTERVAL ?>">
                                <td class="label"><?php echo __('Interval') ?></td>
                                <td class="filtration-conditions">
                                    <input class="<?php echo $classInputStrict; ?>" type="text" placeholder="" value="<?php echo !empty($interval[0]) ? $interval[0] : ''; ?>" name="ValidationParams[<?php echo $field->id; ?>][interval][]">
                                    <input class="<?php echo $classInputStrict; ?>" type="text" placeholder="" value="<?php echo !empty($interval[1]) ? $interval[1] : ''; ?>" name="ValidationParams[<?php echo $field->id; ?>][interval][]">
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