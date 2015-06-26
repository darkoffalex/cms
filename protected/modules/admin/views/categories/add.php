<?php /* @var $languages Language[] */ ?>
<?php /* @var $parents array */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $templates array */ ?>
<?php /* @var $item_templates array */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model TreeEx */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Categories'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/categories/list'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo __a('Add category'); ?></span>
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
                                <td class="value"><input type="text" name="TreeEx[name][<?php echo $lng->id; ?>]" value=""></td>
                            </tr>
                            <tr>
                                <td class="label"><?php echo __a('Description'); ?> [<?php echo $lng->prefix; ?>]:</td>
                                <td class="value"><input type="text" name="TreeEx[description][<?php echo $lng->id; ?>]" value=""></td>
                            </tr>
                            <tr>
                                <td class="label"><?php echo __a('Text'); ?> [<?php echo $lng->prefix; ?>]:</td>
                                <td class="value"><textarea class="editor-area" name="TreeEx[text][<?php echo $lng->id; ?>]"></textarea></td>
                            </tr>

                            <tr>
                                <td class="label"><?php echo __a('Meta title'); ?> [<?php echo $lng->prefix; ?>]:</td>
                                <td class="value"><input type="text" name="TreeEx[meta_title][<?php echo $lng->id; ?>]" value=""></td>
                            </tr>
                            <tr>
                                <td class="label"><?php echo __a('Meta keywords'); ?> [<?php echo $lng->prefix; ?>]:</td>
                                <td class="value"><input type="text" name="TreeEx[meta_keywords][<?php echo $lng->id; ?>]" value=""></td>
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
                        <td class="label"><?php echo $form->labelEx($model,'parent_id'); ?></td>
                        <td class="value"><?php echo $form->dropDownList($model,'parent_id',$parents);?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'template_name'); ?></td>
                        <td class="value"><?php echo $form->dropDownList($model,'template_name',$templates);?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'item_template_name'); ?></td>
                        <td class="value"><?php echo $form->dropDownList($model,'item_template_name',$item_templates);?></td>
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