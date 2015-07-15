<?php /* @var $languages Language[] */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model RoleEx */ ?>
<?php /* @var $this UsersController */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Roles'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/users/roles'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <?php $message = $model->isNewRecord ? 'Add role' : 'Edit role' ?>
            <span><?php echo __a($message); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <?php foreach($languages as $index => $lng): ?>
                <span <?php if($index == 0): ?>class="active"<?php endif;?> data-lang="<?php echo $lng->id; ?>"><?php echo $lng->name; ?></span>
            <?php endforeach; ?>
        </div><!--/tab-line-->

        <div class="inner-content">
            <div class="form-zone">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array('enctype' => 'multipart/form-data'),'clientOptions' => array('validateOnSubmit'=>true))); ?>
                <div class="tabs">
                    <?php foreach($languages as $index => $lng): ?>
                        <table data-tab="<?php echo $lng->id; ?>" <?php if($index == 0): ?>class="active"<?php endif;?>>
                            <tr>
                                <td class="label"><?php echo __a('Name'); ?> [<?php echo $lng->prefix; ?>]:</td>
                                <td class="value"><input type="text" name="RoleEx[name][<?php echo $lng->id; ?>]" value="<?php echo $model->getOrCreateTrl($lng->id)->name; ?>"></td>
                            </tr>
                            <tr>
                                <td class="label"><?php echo __a('Description'); ?> [<?php echo $lng->prefix; ?>]:</td>
                                <td class="value">
                                    <textarea name="RoleEx[description][<?php echo $lng->id; ?>]"><?php echo $model->getOrCreateTrl($lng->id)->description; ?></textarea>
                                </td>
                            </tr>
                        </table>
                    <?php endforeach;?>
                </div><!--/tabs-->

                <table>
                    <?php if(CurUser::get()->roleId() != $model->id): ?>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($model,'label'); ?></td>
                            <td class="value"><?php echo $form->textField($model,'label',array('placeholder' => __a('Label'))); ?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($model,'admin_access'); ?></td>
                            <td class="value"><?php echo $form->checkBox($model,'admin_access');?></td>
                        </tr>
                        <tr>
                            <td class="label top-aligned"><?php echo $form->labelEx($model,'permissions'); ?></td>
                            <td class="value"><?php echo $this->renderPartial('_permissions',array('actions' => Constants::adminActionMap(), 'role' => $model)) ?></td>
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
                        </td>
                    </tr>
                </table>
            <?php $this->endWidget(); ?>
            </div>
        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>