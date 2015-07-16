<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model CommentEx */ ?>
<?php /* @var $blocks array */ ?>
<?php /* @var $users array */ ?>
<?php /* @var $selected int|null */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Comments'); ?></h1>
        <ul class="actions">
            <?php $params = array(); ?>
            <?php if(!empty($model->content_item_id)): $params['bid'] = $model->content_item_id; endif;?>
            <li><a href="<?php echo Yii::app()->createUrl('admin/users/comments',$params); ?>" class="action undo"></a></li>
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
                    <td class="value">
                        <select name="CommentEx[content_item_id]" id="CommentEx_content_item_id">
                            <?php foreach($blocks as $id => $name): ?>
                                <option <?php if($model->content_item_id == $id || $selected == $id): ?> selected <?php endif; ?> <?php if(!is_numeric($id)): ?> disabled <?php endif; ?> <?php if(!is_numeric($id)): ?> style="font-weight: bolder;" <?php endif; ?> value="<?php echo $id; ?>"><?php echo $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'text'); ?></td>
                    <td class="value"><?php echo $form->textArea($model,'text'); ?></td>
                </tr>
                <tr>
                    <td class="line-separation label"><span></span></td>
                    <td class="value"></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'guest_nickname'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'guest_nickname'); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'guest_name'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'guest_name'); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'guest_surname'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'guest_surname'); ?></td>
                </tr>
                <tr>
                    <td class="line-separation label"><span></span></td>
                    <td class="value"></td>
                </tr>
                <?php if(!$model->isNewRecord): ?>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'user_ip'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'user_ip', array('disabled' => 'disabled')); ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value">
                        <?php echo $form->error($model,'text',array('class'=>'error')); ?>
                    </td>
                </tr>
            </table>

            <?php $this->endWidget(); ?>
        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>