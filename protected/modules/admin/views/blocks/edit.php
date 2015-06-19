<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model ContentItemEx */ ?>
<?php /* @var $categories array */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $languages Language[] */ ?>
<?php /* @var $this BlocksController */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Content blocks'); ?></h1>
        <ul class="actions">
            <?php $params = !empty($selectedCategory) ? $params = array('cid' => $selectedCategory->id) : array(); ?>
            <li><a href="<?php echo Yii::app()->createUrl('admin/blocks/list', $params); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo __a('Edit block'); ?></span>
        </div><!--/header-->

        <?php if($model->contentType->hasTranslatableFields()): ?>
            <div class="tab-line">
                <?php foreach($languages as $index => $lng): ?>
                    <span <?php if($index == 0): ?>class="active"<?php endif;?> data-lang="<?php echo $lng->id; ?>"><?php echo $lng->name; ?></span>
                <?php endforeach; ?>
            </div><!--/tab-line-->
        <?php endif; ?>

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'edit-form','enableAjaxValidation'=>false,'htmlOptions'=>array('enctype' => 'multipart/form-data'),'clientOptions' => array('validateOnSubmit'=>true))); ?>

            <?php if($model->contentType->hasTranslatableFields()): ?>
                <div class="tabs">
                    <?php foreach($languages as $index => $lng): ?>
                        <table data-tab="<?php echo $lng->id; ?>" <?php if($index == 0): ?>class="active"<?php endif;?>>
                            <?php foreach($model->contentType->contentItemFields as $field):
                                $trlTextValue = getif($field->getValueFor($model->id)->getOrCreateTrl($lng->id)->text,'');
                                ?>

                                <?php if($field->field_type_id == Constants::FIELD_TYPE_TEXT_TRL): ?>
                                <?php if(!$field->use_wysiwyg): ?>
                                    <tr>
                                        <td class="label"><?php echo __a($field->label); ?> [<?php echo $lng->prefix; ?>]:</td>
                                        <td class="value"><input type="text" name="ContentItemEx[dynamic_trl][<?php echo $field->id; ?>][<?php $lng->id; ?>]" value="<?php echo $trlTextValue; ?>"></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td class="label"><?php echo __a($field->label); ?> [<?php echo $lng->prefix; ?>]:</td>
                                        <td class="value"><textarea name="ContentItemEx[dynamic_trl][<?php echo $field->id; ?>][<?php $lng->id; ?>]"><?php echo $trlTextValue; ?></textarea></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif;?>
                            <?php endforeach; ?>
                        </table>
                    <?php endforeach;?>
                </div><!--/tabs-->
            <?php endif; ?>

            <div class="separate-block">
                <table>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'label'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'label',array('placeholder' => __a('Label'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'status_id'); ?></td>
                        <td class="value"><?php echo $form->dropDownList($model,'status_id',$statuses);?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'tree_id'); ?></td>
                        <td class="value"><?php echo $form->dropDownList($model,'tree_id',$categories);?></td>
                    </tr>
                </table>
            </div>

            <div class="form-zone">
                <table>
                    <?php foreach($model->contentType->contentItemFields as $field): ?>
                        <?php $this->renderPartial('_dynamic_field',array('field' => $field, 'item' => $model)); ?>
                    <?php endforeach; ?>
                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value">
                            <?php echo $form->error($model,'label',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'tree_id',array('class'=>'error')); ?>
                        </td>
                    </tr>
                </table>
            </div>

            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>