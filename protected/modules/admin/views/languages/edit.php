<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model Language */ ?>
<?php /* @var $statuses array */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Languages'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/languages/list'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <?php $message = $model->isNewRecord ? 'Add language' : 'Edit language' ?>
            <span><?php echo __a($message); ?></span>
        </div><!--/header-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>

                <table>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'label'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'label',array('placeholder' => __a('Label'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'name'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'name',array('placeholder' => __a('Self-name'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'prefix'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'prefix',array('placeholder' => __a('Short prefix'), 'style' => 'width:100px;')); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'status'); ?></td>
                        <td class="value"><?php echo $form->dropDownList($model,'status',$statuses);?></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value">
                            <?php echo $form->error($model,'prefix',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'label',array('class'=>'error')); ?>
                        </td>
                    </tr>
                </table>

            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>