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
            <?php $title = $model->isNewRecord ? 'Add form widget' : 'Edit form widget'; ?>
            <span><?php echo __a($title); ?></span>

            <?php if($model->form_type_id == Constants::FORM_WIDGET_FEEDBACK): ?>
                <a href="<?php echo Yii::app()->createUrl('admin/widgets/feedbackincoming',array('id' => $model->id)); ?>"><?php echo __a('Incoming messages'); ?></a>
                <?php if(!empty($model->filtrationByType)): ?>
                <a href="<?php echo Yii::app()->createUrl('admin/widgets/feedbackvalidation',array('id' => $model->id)); ?>"><?php echo __a('Field validation'); ?></a>
                <?php endif; ?>
            <?php endif; ?>

            <a href="<?php echo Yii::app()->createUrl('admin/widgets/edit',array('id' => $model->id)); ?>" class="active"><?php echo __a('General'); ?></a>
        </div><!--/header-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>

            <table>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'label'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'label',array('placeholder' => __a('Label'))); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'form_type_id'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'form_type_id',Constants::formTypeList(),array('id' => 'form_type_id', 'class' => 'trigger-field'));?></td>
                </tr>
                <tr class="triggered" data-trigger="form_type_id" data-condition="<?php echo Constants::FORM_WIDGET_FEEDBACK; ?>">
                    <td class="label"><?php echo __a('Fields'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'filtration_by_type_id',$types);?></td>
                </tr>
                <tr class="triggered" data-trigger="form_type_id" data-condition="<?php echo Constants::FORM_WIDGET_FEEDBACK; ?>">
                    <td class="label"><?php echo $form->labelEx($model,'feedback_email'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'feedback_email',array('placeholder' => __a('Email for feedback'))); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'form_captcha'); ?></td>
                    <td class="value"><?php echo $form->checkBox($model,'form_captcha');?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'template_name'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'template_name',$templates);?></td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value">
                        <?php echo $form->error($model,'label',array('class'=>'error')); ?>
                        <?php echo $form->error($model,'template_name',array('class'=>'error')); ?>
                        <?php echo $form->error($model,'feedback_email',array('class'=>'error')); ?>
                    </td>
                </tr>
            </table>

            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>