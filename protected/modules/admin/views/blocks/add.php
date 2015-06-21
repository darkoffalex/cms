<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model ContentItemEx */ ?>
<?php /* @var $types array */ ?>
<?php /* @var $categories array */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $languages Language[] */ ?>
<?php /* @var $selectedCategory TreeEx */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Content blocks'); ?></h1>
        <ul class="actions">
            <?php $params = !empty($selectedCategory) ? $params = array('cid' => $selectedCategory->id) : array(); ?>
            <li><a href="<?php echo Yii::app()->createUrl('admin/blocks/list', $params); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo __a('Add block'); ?></span>
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
                            <td class="value"><input type="text" name="ContentItemEx[name][<?php echo $lng->id; ?>]" value=""></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo __a('Meta title'); ?> [<?php echo $lng->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="ContentItemEx[meta_title][<?php echo $lng->id; ?>]" value=""></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo __a('Meta keywords'); ?> [<?php echo $lng->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="ContentItemEx[meta_keywords][<?php echo $lng->id; ?>]" value=""></td>
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
                    <td class="label"><?php echo $form->labelEx($model,'tree_id'); ?></td>
                    <?php $selId = !empty($selectedCategory) ? $selectedCategory->id : null; ?>
                    <td class="value"><?php echo $form->dropDownList($model,'tree_id',$categories,array('options' => array($selId =>array('selected'=>true))));?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'content_type_id'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'content_type_id',$types);?></td>
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
                        <?php echo $form->error($model,'content_type_id',array('class'=>'error')); ?>
                    </td>
                </tr>
            </table>

            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>