<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model ContentItemEx */ ?>
<?php /* @var $types array */ ?>
<?php /* @var $categories array */ ?>
<?php /* @var $selectedCategory TreeEx */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Content types'); ?></h1>
        <ul class="actions">
            <?php $params = !empty($selectedCategory) ? $params = array('cid' => $selectedCategory->id) : array(); ?>
            <li><a href="<?php echo Yii::app()->createUrl('admin/blocks/list', $params); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo __a('Add block'); ?></span>
        </div><!--/header-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>

            <table>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'label'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'label',array('placeholder' => __a('Label'))); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'predefined_template_name'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'predefined_template_name',$templates);?></td>
                </tr>
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

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>