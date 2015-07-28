<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model SubscriptionEx */ ?>
<?php /* @var $statuses array */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Subscription'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/users/subscription'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <?php $message = $model->isNewRecord ? 'Add subscription' : 'Edit subscription' ?>
            <span><?php echo __a($message); ?></span>
        </div><!--/header-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array('enctype' => 'multipart/form-data'),'clientOptions' => array('validateOnSubmit'=>true))); ?>
            <table>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'email'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'email'); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'status_id'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'status_id',$statuses); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'period_in_seconds'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'period_in_seconds', array('value' => !$model->isNewRecord ? $model->periodInDays() : '', 'class' => 'numeric-input-block')); ?></td>
                </tr>
                <?php if(!$model->isNewRecord): ?>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'last_time_send'); ?></td>
                    <?php $lts = !empty($model->last_time_send) ? date('Y-m-d H:i:s',$model->last_time_send) : ''; ?>
                    <td class="value"><?php echo $form->textField($model,'last_time_send', array('disabled' => 'disabled', 'value' => $lts)); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'subscriber_ip'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'subscriber_ip', array('disabled' => 'disabled')); ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value">
                        <?php echo $form->error($model,'email',array('class'=>'error')); ?>
                        <?php echo $form->error($model,'period_in_seconds',array('class'=>'error')); ?>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>