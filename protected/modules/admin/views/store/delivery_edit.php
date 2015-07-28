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
                        <td class="value"><?php echo $form->textField($model,'price', array('placeholder' => __('0.00'), 'class' => 'numeric-input-price', 'value' => !empty($model->price) ? centsToPrice($model->price) : ''));?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'price_weight_dependency'); ?></td>
                        <td class="value"><?php echo $form->checkBox($model,'price_weight_dependency');?></td>
                    </tr>
                    <tr>
                        <td class="label top-aligned"><?php echo __a('Weight depending prices'); ?></td>
                        <td class="value">
                            <div class="content list smaller" id="dependency-table">
                                <div class="list-row title h36">
                                    <div class="cell"><?php echo __a('Weight') ?></div>
                                    <div class="cell"><?php echo __a('Price'); ?></div>
                                    <div class="cell"></div>
                                </div><!--/list-row-->
                                <div class="list-row h36 editable-row">
                                    <div class="cell no-padding"><input class="in-table-input numeric-input-price" type="text" placeholder="0.00" value="" name="OrderDeliveryEx[wp][weight][]"></div>
                                    <div class="cell no-padding"><input class="in-table-input numeric-input-price" type="text" placeholder="0.00" value="" name="OrderDeliveryEx[wp][price][]"></div>
                                    <div class="cell no-padding smallest"><a href="#" class="spec-icon delete"></a></div>
                                </div><!--/list-row-->
                            </div><!--/content-->
                            <a href="#" class="spec-icon add table-manage row-add" data-table="#dependency-table"></a>
                        </td>
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