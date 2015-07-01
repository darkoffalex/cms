<?php /* @var $model GlobalSettingsEx */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $categories Array */ ?>
<?php /* @var $themes Array */ ?>

<style>
    .label.bigger
    {
        font-size: 17px;
        /*border-bottom: 1px solid #EFEFEF;*/
        /*border-right: 1px solid #EFEFEF;*/
        /*border-bottom-right-radius: 10px;*/
    }
    .content.menu-content .inner-content .label.non-centered
    {
        vertical-align: top;
    }

    .content.menu-content .inner-content textarea, .content .inner-content .form-zone textarea.smaller
    {
        height: 100px;
    }
    .last
    {
        height: 40px;
    }
</style>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Global settings'); ?></h1>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo __a('Edit settings'); ?></span>
        </div><!--/header-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>

            <table>

                <tr>
                    <td class="label bigger"><b><?php echo __a('Meta'); ?></b></td>
                    <td class="value"></td>
                </tr>
                <tr>
                    <td class="line-separation label"><span></span></td>
                    <td class="value"></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'site_name'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'site_name'); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'site_description'); ?></td>
                    <td class="value"><?php echo $form->textArea($model,'site_description',array('class' => 'smaller'));?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'site_keywords'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'site_keywords');?></td>
                </tr>
                <tr>
                    <td class="last"></td>
                    <td class="value"></td>
                </tr>

                <tr>
                    <td class="label bigger"><b><?php echo __a('Pagination'); ?></b></td>
                    <td class="value"></td>
                </tr>
                <tr>
                    <td class="line-separation label"><span></span></td>
                    <td class="value"></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'per_page_qnt'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'per_page_qnt',array('class' => 'numeric-input-block', 'style' => 'width:100px;')); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'images_qnt'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'images_qnt',array('class' => 'numeric-input-block', 'style' => 'width:100px;')); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'files_qnt'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'files_qnt',array('class' => 'numeric-input-block', 'style' => 'width:100px;')); ?></td>
                </tr>
                <tr>
                    <td class="last"></td>
                    <td class="value"></td>
                </tr>

                <tr>
                    <td class="label bigger"><b><?php echo __a('Content'); ?></b></td>
                    <td class="value"></td>
                </tr>
                <tr>
                    <td class="line-separation label"><span></span></td>
                    <td class="value"></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'home_page_category_id'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'home_page_category_id',$categories); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'active_theme'); ?></td>
                    <td class="value"><?php echo $form->dropDownList($model,'active_theme',$themes); ?></td>
                </tr>
                <tr>
                    <td class="last"></td>
                    <td class="value"></td>
                </tr>

                <tr>
                    <td class="label bigger"><b><?php echo __a('Contact details'); ?></b></td>
                    <td class="value"></td>
                </tr>
                <tr>
                    <td class="line-separation label"><span></span></td>
                    <td class="value"></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'webmaster_email'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'webmaster_email'); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'admin_email'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'admin_email'); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($model,'admin_phone'); ?></td>
                    <td class="value"><?php echo $form->textField($model,'admin_phone'); ?></td>
                </tr>
                <tr>
                    <td class="last"></td>
                    <td class="value"></td>
                </tr>

                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value">
                        <?php echo $form->error($model,'site_name',array('class'=>'error')); ?>
                        <?php echo $form->error($model,'per_page_qnt',array('class'=>'error')); ?>
                        <?php echo $form->error($model,'images_qnt',array('class'=>'error')); ?>
                        <?php echo $form->error($model,'files_qnt',array('class'=>'error')); ?>
                    </td>
                </tr>
            </table>

            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>