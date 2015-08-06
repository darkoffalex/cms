<?php /* @var $languages Language[] */ ?>
<?php /* @var $fieldTypes array */ ?>
<?php /* @var $contentType ContentTypeEx */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model ContentItemFieldEx */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Fields of').' "'.$contentType->label.'"' ; ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/types/fields',array('id' => $contentType->id)); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo __a('Edit field'); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <?php foreach($languages as $index => $lng): ?>
                <span <?php if($index == 0): ?>class="active"<?php endif;?> data-lang="<?php echo $lng->id; ?>"><?php echo $lng->name; ?></span>
            <?php endforeach; ?>
        </div><!--/tab-line-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>
            <div class="tabs">
                <?php foreach($languages as $index => $lng): ?>
                    <table data-tab="<?php echo $lng->id; ?>" <?php if($index == 0): ?>class="active"<?php endif;?>>
                        <tr>
                            <td class="label"><?php echo __a('Name'); ?> [<?php echo $lng->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="ContentItemFieldEx[name][<?php echo $lng->id; ?>]" value="<?php echo $model->getOrCreateTrl($lng->id)->name; ?>"></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo __a('Description'); ?> [<?php echo $lng->prefix; ?>]:</td>
                            <td class="value"><textarea name="ContentItemFieldEx[description][<?php echo $lng->id; ?>]"><?php echo $model->getOrCreateTrl($lng->id)->description; ?></textarea></td>
                        </tr>
                    </table>
                <?php endforeach;?>
            </div><!--/tabs-->

            <table>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'label'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'label',array('placeholder' => __a('Label'))); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'field_name'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'field_name',array('placeholder' => __a('Variable name'))); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'field_type_id'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'field_type_id',$fieldTypes,array('id' => 'type-selector', 'class' => 'trigger-field'));?></td>
                </tr>
                <tr class="triggered" data-trigger="type-selector" data-condition="<?php echo Constants::FIELD_TYPE_TEXT; ?>,<?php echo Constants::FIELD_TYPE_TEXT_TRL; ?>">
                    <td class="label"><?php echo $form->labelEx($model,'use_wysiwyg'); ?></td>
                    <td class="value"><?php echo $form->checkBox($model,'use_wysiwyg')?></td>
                </tr>
                <tr class="triggered" data-trigger="type-selector" data-condition="<?php echo Constants::FIELD_TYPE_SELECTABLE ?>">
                    <td class="label top-aligned"><?php echo __a('Selectable variants'); ?></td>
                    <td class="value">
                        <div class="content list smaller" id="variant-table">
                            <div class="list-row title h36">
                                <div class="cell"><?php echo __a('Value') ?></div>
                                <div class="cell"><?php echo __a('Title'); ?></div>
                                <div class="cell"></div>
                            </div><!--/list-row-->
                            <?php $variants = $model->getSelectableVariants(); ?>
                            <?php if(empty($variants)): ?>
                                <div class="list-row h36 editable-row">
                                    <div class="cell no-padding"><input class="in-table-input" type="text" placeholder="<?php echo __a('Your value'); ?>" value="" name="ContentItemFieldEx[vars][value][]"></div>
                                    <div class="cell no-padding"><input class="in-table-input" type="text" placeholder="<?php echo __a('Your title'); ?>" value="" name="ContentItemFieldEx[vars][title][]"></div>
                                    <div class="cell no-padding smallest"><a href="#" class="spec-icon delete editable-table row-del"></a></div>
                                </div><!--/list-row-->
                            <?php else: ?>
                                <?php foreach($variants as $value => $title): ?>
                                    <div class="list-row h36 editable-row">
                                        <div class="cell no-padding"><input class="in-table-input" type="text" placeholder="<?php echo __a('Your value'); ?>" value="<?php echo $value; ?>" name="ContentItemFieldEx[vars][value][]"></div>
                                        <div class="cell no-padding"><input class="in-table-input" type="text" placeholder="<?php echo __a('Your title'); ?>" value="<?php echo $title; ?>" name="ContentItemFieldEx[vars][title][]"></div>
                                        <div class="cell no-padding smallest"><a href="#" class="spec-icon delete editable-table row-del"></a></div>
                                    </div><!--/list-row-->
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div><!--/content-->
                        <a href="#" class="spec-icon add editable-table row-add" data-table="#variant-table" data-action="yes" data-names="ContentItemFieldEx[vars][value],ContentItemFieldEx[vars][title]" data-placeholders="<?php echo __a('Your value'); ?>,<?php echo __a('Your title'); ?>"></a>
                    </td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value">
                        <?php echo $form->error($model,'label',array('class'=>'error')); ?>
                        <?php echo $form->error($model,'field_name',array('class'=>'error')); ?>
                    </td>
                </tr>
            </table>

            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>