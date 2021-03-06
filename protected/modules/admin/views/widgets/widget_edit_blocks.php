<?php /* @var $languages Language[] */ ?>
<?php /* @var $templates array */ ?>
<?php /* @var $categories array */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model WidgetEx */ ?>
<?php /* @var $types array */ ?>

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
                <a href="<?php echo Yii::app()->createUrl('admin/widgets/editfiltration',array('id' => $model->id)); ?>"><?php echo __a('Filtration'); ?></a>
                <a href="<?php echo Yii::app()->createUrl('admin/widgets/edit',array('id' => $model->id)); ?>" class="active"><?php echo __a('General'); ?></a>
            <?php endif; ?>
        </div><!--/header-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>
            <table>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'label'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'label',array('placeholder' => __a('Label'))); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'tree_id'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'tree_id',$categories);?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'block_limit'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'block_limit',array('placeholder' => __a('Limit'), 'style' => 'width:100px;')); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'include_from_nested'); ?></td>
                    <td class="value"><?php echo $form->checkBox($model,'include_from_nested'); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'template_name'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'template_name',$templates);?></td>
                </tr>
                <?php if(!empty($types)): ?>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'filtration_by_type_id'); ?></td>
                        <td class="value"><?php echo $form->dropDownList($model,'filtration_by_type_id',$types);?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value">
                        <?php echo $form->error($model,'label',array('class'=>'error')); ?>
                        <?php echo $form->error($model,'tree_id',array('class'=>'error')); ?>
                        <?php echo $form->error($model,'template_name',array('class'=>'error')); ?>
                    </td>
                </tr>
            </table>

            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>