<?php /* @var $languages Language[] */ ?>
<?php /* @var $templates array */ ?>
<?php /* @var $categories array */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model WidgetEx */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Widgets');?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/widgets/list'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <?php $title = $model->isNewRecord ? 'Add breadcrumbs' : 'Edit breadcrumbs'; ?>
            <span><?php echo __a($title); ?></span>
        </div><!--/header-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>

            <table>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'label'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'label',array('placeholder' => __a('Label'))); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'breadcrumbs_root_level'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'breadcrumbs_root_level',array('placeholder' => __a('Root on level'), 'style' => 'width:100px;')); ?></td>
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
                        <?php echo $form->error($model,'breadcrumbs_root_level',array('class'=>'error')); ?>
                    </td>
                </tr>
            </table>

            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>