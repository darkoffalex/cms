<?php /* @var $languages Language[] */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model OrderDeliveryEx */ ?>
<?php /* @var $this StoreController */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Delivery'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/store/delivery'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <?php $message = $model->isNewRecord ? "Create delivery" : "Edit delivery"; ?>
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
                                <td class="value"><input type="text" name="OrderDeliveryEx[title][<?php echo $lng->id; ?>]" value="<?php echo $model->getOrCreateTrl($lng->id)->title; ?>"></td>
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
                        <td class="label"><?php echo $form->labelEx($model,'status_id'); ?></td>
                        <td class="value"><?php echo $form->dropDownList($model,'status_id',$statuses);?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'price'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'price', array('placeholder' => __('0.00'), 'class' => 'numeric-input-price', 'value' => centsToPrice($model->price)));?></td>
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
            </div>
        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>