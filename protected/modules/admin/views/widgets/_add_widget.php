<?php /* @var $this WidgetsController */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model WidgetEx */ ?>
<?php /* @var $types array */ ?>

<div class="lightbox add-box">
    <div class="wrap">
        <div class="middle">
            <div class="content">
                <span class="header"><?php echo __a('New widget'); ?></span>
                <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>true,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>
                <table>
                    <tr>
                        <td><?php echo $form->labelEx($model,'label'); ?></td>
                        <td><?php echo $form->textField($model,'label',array('placeholder' => __a('Label'))); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'type_id'); ?></td>
                        <td><?php echo $form->dropDownList($model,'type_id',$types); ?></td>
                    </tr>
                </table>
                <?php echo CHtml::submitButton(__a('Save'),array('class' => 'float-left')); ?>
                <input type="button" value="<?php echo __a('Cancel'); ?>" class="float-left light-box-close">
                <div class="errorMessage float-right">
                    <?php echo $form->error($model,'label'); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div><!--/content-->
        </div>
    </div><!--/wrap/middle-->
</div><!--/lightbox-->

