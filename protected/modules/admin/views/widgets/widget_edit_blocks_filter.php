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
            <?php $title = $model->isNewRecord ? 'Add blocks widget' : 'Edit blocks widget'; ?>
            <span><?php echo __a($title); ?></span>

            <?php if(!empty($model->filtrationByType)): ?>
                <a href="<?php echo Yii::app()->createUrl('admin/widgets/editfiltration',array('id' => $model->id)); ?>" class="active"><?php echo __a('Filtration'); ?></a>
                <a href="<?php echo Yii::app()->createUrl('admin/widgets/edit',array('id' => $model->id)); ?>"><?php echo __a('General'); ?></a>
            <?php endif; ?>
        </div><!--/header-->

        <div class="inner-content">
            <form method="post" action="">
                <table>
                    <?php $fields = $model->filtrationByType->getFilterableFields();?>
                    <?php if(!empty($fields)): ?>
                        <?php foreach($fields as $field): ?>
                            <tr>
                                <td class="label"><label for="field_<?php echo $field->id; ?>"><?php echo $field->label; ?></label></td>
                                <td class="value filtration-conditions">
                                    <?php $filterValue = $model->filtrationValFor($field->id); ?>
                                    <?php $filterCondition = $model->filtrationConFor($field->id); ?>

                                    <?php if($field->field_type_id == Constants::FIELD_TYPE_BOOLEAN): ?>
                                        <select class="fcb" name="ConditionsForm[<?php echo $field->id; ?>][condition]" id="field_<?php echo $field->id; ?>">
                                            <option <?php if($filterCondition == Constants::FILTER_CONDITION_IGNORE): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_IGNORE; ?>"><?php echo __a('Ignore'); ?></option>
                                            <option <?php if($filterCondition == Constants::FILTER_CONDITION_SET): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_SET; ?>"><?php echo __a('Selected only'); ?></option>
                                            <option <?php if($filterCondition == Constants::FILTER_CONDITION_UNSET): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_UNSET; ?>"><?php echo __a('Unselected only'); ?></option>
                                        </select>
                                    <?php elseif($field->field_type_id == Constants::FIELD_TYPE_NUMERIC): ?>
                                    <input type="text" class="numeric-input-block" placeholder="<?php echo __a('Key value'); ?>" value="<?php echo $filterValue; ?>" name="ConditionsForm[<?php echo $field->id; ?>][value]">
                                    <select id="field_<?php echo $field->id; ?>" name="ConditionsForm[<?php echo $field->id; ?>][condition]">
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_IGNORE): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_IGNORE; ?>"><?php echo __a('Ignore'); ?></option>
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_EQUAL): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_EQUAL; ?>"><?php echo __a('Equal'); ?></option>
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_MORE): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_MORE; ?>"><?php echo __a('More than'); ?></option>
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_LESS): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_LESS; ?>"><?php echo __a('Less than'); ?></option>
                                    </select>
                                    <?php elseif($field->field_type_id == Constants::FIELD_TYPE_PRICE): ?>
                                    <input type="text" class="numeric-input-price" placeholder="<?php echo __a('Key value'); ?>" value="<?php echo centsToPrice($filterValue); ?>" name="ConditionsForm[<?php echo $field->id; ?>][value]">
                                    <select id="field_<?php echo $field->id; ?>" name="ConditionsForm[<?php echo $field->id; ?>][condition]">
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_IGNORE): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_IGNORE; ?>"><?php echo __a('Ignore'); ?></option>
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_EQUAL): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_EQUAL; ?>"><?php echo __a('Equal'); ?></option>
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_MORE): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_MORE; ?>"><?php echo __a('More than'); ?></option>
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_LESS): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_LESS; ?>"><?php echo __a('Less than'); ?></option>
                                    </select>
                                <?php elseif($field->field_type_id == Constants::FIELD_TYPE_DATE): ?>
                                    <?php $seconds = !empty($filterValue) ? $filterValue : time(); ?>
                                    <input type="text" class="date-picker-block" placeholder="<?php echo __a('Key value'); ?>" value="<?php echo date('m/d/Y',$seconds); ?>" name="ConditionsForm[<?php echo $field->id; ?>][value]">
                                    <select id="field_<?php echo $field->id; ?>" name="ConditionsForm[<?php echo $field->id; ?>][condition]">
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_IGNORE): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_IGNORE; ?>"><?php echo __a('Ignore'); ?></option>
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_EQUAL): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_EQUAL; ?>"><?php echo __a('Equal'); ?></option>
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_MORE): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_MORE; ?>"><?php echo __a('More than'); ?></option>
                                        <option <?php if($filterCondition == Constants::FILTER_CONDITION_LESS): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_LESS; ?>"><?php echo __a('Less than'); ?></option>
                                    </select>
                                <?php endif;?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td class="label">&nbsp;</td>
                            <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td><?php echo __a('This type has no fields which can be used in filter conditions'); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </form>
        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>