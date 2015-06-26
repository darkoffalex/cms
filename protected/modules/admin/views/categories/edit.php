<?php /* @var $languages Language[] */ ?>
<?php /* @var $parents array */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $templates array */ ?>
<?php /* @var $item_templates array */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model TreeEx */ ?>
<?php /* @var $this CategoriesController */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Categories'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/categories/list'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo __a('Edit category'); ?></span>
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
                                <td class="value"><input type="text" name="TreeEx[name][<?php echo $lng->id; ?>]" value="<?php echo $model->getOrCreateTrl($lng->id)->name; ?>"></td>
                            </tr>
                            <tr>
                                <td class="label"><?php echo __a('Description'); ?> [<?php echo $lng->prefix; ?>]:</td>
                                <td class="value"><input type="text" name="TreeEx[description][<?php echo $lng->id; ?>]" value="<?php echo $model->getOrCreateTrl($lng->id)->description; ?>"></td>
                            </tr>
                            <tr>
                                <td class="label"><?php echo __a('Text'); ?> [<?php echo $lng->prefix; ?>]:</td>
                                <td class="value"><textarea class="editor-area" name="TreeEx[text][<?php echo $lng->id; ?>]"><?php echo $model->getOrCreateTrl($lng->id)->text; ?></textarea></td>
                            </tr>

                            <tr>
                                <td class="label"><?php echo __a('Meta title'); ?> [<?php echo $lng->prefix; ?>]:</td>
                                <td class="value"><input type="text" name="TreeEx[meta_title][<?php echo $lng->id; ?>]" value="<?php echo $model->getOrCreateTrl($lng->id)->meta_title; ?>"></td>
                            </tr>
                            <tr>
                                <td class="label"><?php echo __a('Meta keywords'); ?> [<?php echo $lng->prefix; ?>]:</td>
                                <td class="value"><input type="text" name="TreeEx[meta_keywords][<?php echo $lng->id; ?>]" value="<?php echo $model->getOrCreateTrl($lng->id)->meta_keywords; ?>"></td>
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
                        <td class="value"><?php echo $form->dropDownList($model,'parent_id',$parents,array('options' => array($model->id=>array('disabled' => true))));?></td>
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
                        <td class="label"><?php echo $form->labelEx($model,'image'); ?></td>
                        <td class="value"><?php echo $form->fileField($model,'image', array('data-label' => __a('Browse'))); ?></td>
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
            <div class="image-zone">
                <strong><?php echo __a('Images'); ?></strong>

                <div class="list">
                    <?php if(!empty($model->imageOfTrees)): ?>
                        <?php foreach($model->imageOfTrees as $iot): ?>
                            <div class="image">
                                <img src="<?php echo $iot->image->getCachedUrl(160,120); ?>" alt="" />
                                <a href="<?php echo Yii::app()->createUrl('admin/categories/delimgdirect',array('id' => $iot->image_id)); ?>" class="delete active confirm-box"></a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="image">
                            <img src="<?php echo $this->assets; ?>/images/no-image-upload.png" alt="" />
                            <a href="#" class="delete"></a>
                        </div>
                    <?php endif;?>
                </div><!--/list-->
            </div><!--/image-zone-->
        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>