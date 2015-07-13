<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model UserEx */ ?>
<?php /* @var $roles array */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $cliTypes array */ ?>


<main>
    <div class="title-bar world">
        <h1><?php echo __a('Users'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/users/list'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <?php $message = $model->isNewRecord ? 'Add new user' : 'Edit user' ?>
            <span><?php echo __a($message); ?></span>
        </div><!--/header-->

        <div class="inner-content">
            <div class="form-zone">
                <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array('enctype' => 'multipart/form-data'),'clientOptions' => array('validateOnSubmit'=>true))); ?>
                <table>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'login'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'login',array('placeholder' => __a('Username'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'password'); ?></td>
                        <td class="value"><?php echo $form->passwordField($model,'password',array('placeholder' => __a('Reassign password'), 'value' => '')); ?></td>
                    </tr>
                    <tr>
                        <td class="line-separation label"><span></span></td>
                        <td class="value"></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'email'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'email',array('placeholder' => __a('Email'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'name'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'name',array('placeholder' => __a('Name'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'surname'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'surname',array('placeholder' => __a('Surname'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'signature'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'signature',array('placeholder' => __a('Signature bellow comments and posts'))); ?></td>
                    </tr>
                    <tr>
                        <td class="line-separation label"><span></span></td>
                        <td class="value"></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo __a('Avatar'); ?></td>
                        <td class="value">
                            <?php echo $form->fileField($model,'avatar', array('data-label' => __a('Browse'))); ?>
                            <div class="image-zone">
                                <div class="list">
                                    <div class="image">
                                        <?php if(!empty($model->avatar_filename)): ?>
                                            <img src="<?php echo $model->avatarUrl(); ?>" alt="" />
                                            <a href="<?php echo Yii::app()->createUrl('admin/users/delavatar',array('id' => $model->id)); ?>" class="delete active confirm-box"></a>
                                        <?php else: ?>
                                            <img src="<?php echo $this->assets; ?>/images/no-image-upload.png" alt="" />
                                            <a href="#" class="delete"></a>
                                        <?php endif;?>
                                    </div>
                                </div><!--/list-->
                            </div><!--/image-zone-->
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo __a('Photo'); ?></td>
                        <td class="value">
                            <?php echo $form->fileField($model,'photo', array('data-label' => __a('Browse'))); ?>
                            <div class="image-zone">
                                <div class="list">
                                    <div class="image">
                                        <?php if(!empty($model->photo_filename)): ?>
                                            <img src="<?php echo $model->photoUrl(); ?>" alt="" />
                                            <a href="<?php echo Yii::app()->createUrl('admin/users/delphoto',array('id' => $model->id)); ?>" class="delete active confirm-box"></a>
                                        <?php else: ?>
                                            <img src="<?php echo $this->assets; ?>/images/no-image-upload.png" alt="" />
                                            <a href="#" class="delete"></a>
                                        <?php endif;?>
                                    </div>
                                </div><!--/list-->
                            </div><!--/image-zone-->
                        </td>
                    </tr>
                    <?php if($model->id != Yii::app()->getUser()->id): ?>
                        <tr>
                            <td class="line-separation label"><span></span></td>
                            <td class="value"></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($model,'status_id'); ?></td>
                            <td class="value"><?php echo $form->dropDownList($model,'status_id',$statuses); ?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($model,'role_id'); ?></td>
                            <td class="value"><?php echo $form->dropDownList($model,'role_id',$roles); ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="line-separation label"><span></span></td>
                        <td class="value"></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'phone'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'phone',array('placeholder' => __a('Phone number'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'mobile_phone'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'mobile_phone',array('placeholder' => __a('Mobile phone number'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'fax'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'fax',array('placeholder' => __a('Fax number'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'address'); ?></td>
                        <td class="value"><?php echo $form->textArea($model,'address',array('placeholder' => __a('Address'))); ?></td>
                    </tr>
                    <tr>
                        <td class="line-separation label"><span></span></td>
                        <td class="value"></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'shop_client_type'); ?></td>
                        <td class="value"><?php echo $form->dropDownList($model,'shop_client_type',$cliTypes); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'shop_company_name'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'shop_company_name',array('placeholder' => __a('Company name'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'shop_personal_code'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'shop_personal_code',array('placeholder' => __a('Company code'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'shop_bank_name'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'shop_bank_name',array('placeholder' => __a('Bank name'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'shop_bank_account'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'shop_bank_account',array('placeholder' => __a('Account number'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'shop_vat_code'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'shop_vat_code',array('placeholder' => __a('VAT code'))); ?></td>
                    </tr>
                    <tr>
                        <td class="line-separation label"><span></span></td>
                        <td class="value"></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'last_visit_time'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'last_visit_time',array('disabled' => 'disabled', 'value' => date('Y-m-d H:i:s'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'last_ip'); ?></td>
                        <td class="value"><?php echo $form->textField($model,'last_ip',array('disabled' => 'disabled')); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($model,'ip_list'); ?></td>
                        <td class="value"><?php echo $form->textArea($model,'ip_list',array('disabled' => 'disabled')); ?></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value">
                            <?php echo $form->error($model,'login',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'password',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'email',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'name',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'surname',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'signature',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'avatar',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'photo',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'phone',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'mobile_phone',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'fax',array('class'=>'error')); ?>
                            <?php echo $form->error($model,'address',array('class'=>'error')); ?>
                        </td>
                    </tr>
                </table>

                <?php $this->endWidget(); ?>
            </div>
        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>