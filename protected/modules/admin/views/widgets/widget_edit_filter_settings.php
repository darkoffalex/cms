<?php /* @var $model WidgetEx */ ?>
<?php /* @var $this WidgetsController */ ?>

<?php //debugvar($model->getFiltrationArr()); ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Widgets');?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/widgets/list'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content page-content">

        <div class="header">
            <?php $title = $model->isNewRecord ? 'Add filter widget' : 'Edit filter widget'; ?>
            <span><?php echo __a($title); ?></span>

            <?php if(!empty($model->filtrationByType)): ?>
                <a href="<?php echo Yii::app()->createUrl('admin/widgets/filtersettings',array('id' => $model->id)); ?>" class="active"><?php echo __a('Settings'); ?></a>
                <a href="<?php echo Yii::app()->createUrl('admin/widgets/edit',array('id' => $model->id)); ?>"><?php echo __a('General'); ?></a>
            <?php endif; ?>
        </div><!--/header-->

        <div class="inner-content">
            <form method="post" action="">
                <table>
                    <?php $fields = $model->filtrationByType->getFilterConfigurableFields();?>
                    <?php if(!empty($fields)): ?>
                        <?php foreach($fields as $field): ?>
                            <?php if($field->field_type_id != Constants::FIELD_TYPE_TEXT): ?>
                                <tr>
                                    <td class="label"><label><strong><?php echo $field->label; ?></strong></label></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="field_<?php echo $field->id; ?>_type_select"><?php echo __a('Filtration type'); ?></label></td>
                                    <td>
                                        <select class="trigger-field" name="FilterSettings[<?php echo $field->id; ?>][filter_type]" id="field_<?php echo $field->id; ?>_type_select">
                                            <option <?php if($model->filterTypeForIs($field->id, Constants::FILTER_CONDITION_EQUAL)): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_EQUAL; ?>"><?php echo __a('Equal'); ?></option>
                                            <option <?php if($model->filterTypeForIs($field->id, Constants::FILTER_CONDITION_MORE)): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_MORE; ?>"><?php echo __a('More than'); ?></option>
                                            <option <?php if($model->filterTypeForIs($field->id, Constants::FILTER_CONDITION_LESS)): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_LESS; ?>"><?php echo __a('Less than'); ?></option>
                                            <option <?php if($model->filterTypeForIs($field->id, Constants::FILTER_CONDITION_BETWEEN)): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_BETWEEN ?>"><?php echo __a('Interval') ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="triggered" data-trigger="field_<?php echo $field->id; ?>_type_select" data-condition="<?php echo Constants::FILTER_CONDITION_EQUAL; ?>,<?php echo Constants::FILTER_CONDITION_MORE; ?>,<?php echo Constants::FILTER_CONDITION_LESS; ?>">
                                    <td class="label top-aligned"><label><?php echo __a('Preset variants') ?></label></td>
                                    <td>
                                        <?php $this->renderPartial('/common/_dynamic_js_table',array(
                                            'tableId' => 'variants_'.$field->id,
                                            'data' => array(),
                                            'actions' => true,
                                            'fieldBaseName' => 'FilterSettings['.$field->id.'][variants]',
                                            'fields' => array(
                                                array('name' => 'variant','title' => 'Variant', 'placeholder' => $field->field_type_id == Constants::FIELD_TYPE_PRICE ? '0.00' : '0', 'numeric' => $field->field_type_id == Constants::FIELD_TYPE_PRICE ? 'price' : 'numeric'),
                                            ),
                                        )); ?>
                                    </td>
                                </tr>
                                <tr class="triggered" data-trigger="field_<?php echo $field->id; ?>_type_select" data-condition="<?php echo Constants::FILTER_CONDITION_BETWEEN ?>">
                                    <td class="label top-aligned"><label><?php echo __a('Preset intervals') ?></label></td>
                                    <td>
                                        <?php $this->renderPartial('/common/_dynamic_js_table',array(
                                            'tableId' => 'intervals_'.$field->id,
                                            'data' => array(),
                                            'actions' => true,
                                            'fieldBaseName' => 'FilterSettings['.$field->id.'][intervals]',
                                            'fields' => array(
                                                array('name' => 'min','title' => 'Min', 'placeholder' => $field->field_type_id == Constants::FIELD_TYPE_PRICE ? '0.00' : '0', 'numeric' => $field->field_type_id == Constants::FIELD_TYPE_PRICE ? 'price' : 'numeric'),
                                                array('name' => 'max','title' => 'Max', 'placeholder' => $field->field_type_id == Constants::FIELD_TYPE_PRICE ? '0.00' : '0', 'numeric' => $field->field_type_id == Constants::FIELD_TYPE_PRICE ? 'price' : 'numeric'),
                                            ),
                                        )); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="line-separation label"><span></span></td>
                                    <td class="value"></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td class="label"><label><strong><?php echo $field->label; ?></strong></label></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="field_<?php echo $field->id; ?>_type_select"><?php echo __a('Filtration type'); ?></label></td>
                                    <td>
                                        <select class="trigger-field" name="FilterSettings[<?php echo $field->id; ?>][type]" id="field_<?php echo $field->id; ?>_type_select">
                                            <option <?php if($model->filterTypeForIs($field->id, Constants::FILTER_CONDITION_SIMILAR)): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_SIMILAR ?>"><?php echo __a('Similar') ?></option>
                                            <option <?php if($model->filterTypeForIs($field->id, Constants::FILTER_CONDITION_EQUAL)): ?> selected <?php endif; ?> value="<?php echo Constants::FILTER_CONDITION_EQUAL; ?>"><?php echo __a('Equal'); ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="triggered" data-trigger="field_<?php echo $field->id; ?>_type_select" data-condition="<?php echo Constants::FILTER_CONDITION_EQUAL; ?>">
                                    <td class="label top-aligned"><label><?php echo __a('Preset variants') ?></label></td>
                                    <td>
                                        <?php $this->renderPartial('/common/_dynamic_js_table',array(
                                            'tableId' => 'text_variants_'.$field->id,
                                            'data' => array(),
                                            'actions' => true,
                                            'fieldBaseName' => 'FilterSettings['.$field->id.'][variants]',
                                            'fields' => array(
                                                array('name' => 'variant', 'title' => 'Variant', 'placeholder' => 'Text')
                                            ),
                                        )); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="line-separation label"><span></span></td>
                                    <td class="value"></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td class="label">&nbsp;</td>
                            <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td><?php echo __a('This type has no fields which can be configured for filtration'); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </form>
        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>