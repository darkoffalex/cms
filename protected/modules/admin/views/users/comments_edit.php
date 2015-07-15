<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model CommentEx */ ?>
<?php /* @var $blocks array */ ?>
<?php /* @var $users array */ ?>


<main>
    <div class="title-bar world">
        <h1><?php echo __a('Comments'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/users/comments'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <?php $message = $model->isNewRecord ? 'Add comment' : 'Edit comment' ?>
            <span><?php echo __a($message); ?></span>
        </div><!--/header-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array('enctype' => 'multipart/form-data'),'clientOptions' => array('validateOnSubmit'=>true))); ?>
            <table>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'user_id'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'user_id',$users); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'content_item_id'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'content_item_id',$blocks); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'text'); ?></td>
                    <td class="value"><?php echo $form->textArea($model,'text'); ?></td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value">
                        <?php echo $form->error($model,'login',array('class'=>'error')); ?>
                        <?php echo $form->error($model,'password',array('class'=>'error')); ?>
                    </td>
                </tr>
            </table>

            <?php $this->endWidget(); ?>
        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>