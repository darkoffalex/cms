<?php /* @var $languages Language[] */ ?>
<?php /* @var $templates array */ ?>
<?php /* @var $categories array */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model MenuEx */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Menus');?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/widgets/menus'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <?php $title = $model->isNewRecord ? 'Add menu' : 'Edit menu'; ?>
            <span><?php echo __a($title); ?></span>
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
                            <td class="value"><input type="text" name="MenuEx[name][<?php echo $lng->id; ?>]" value="<?php echo $model->getOrCreateTrl($lng->id)->name; ?>"></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo __a('Description'); ?> [<?php echo $lng->prefix; ?>]:</td>
                            <td class="value"><textarea class="editor-area" name="MenuEx[description][<?php echo $lng->id; ?>]"><?php echo $model->getOrCreateTrl($lng->id)->description; ?></textarea></td>
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
                    <td class="label"><?php echo $form->labelEx($model,'tree_id'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'tree_id',$categories);?></td>
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
                        <?php echo $form->error($model,'tree_id',array('class'=>'error')); ?>
                        <?php echo $form->error($model,'template_name',array('class'=>'error')); ?>
                    </td>
                </tr>
            </table>

            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>