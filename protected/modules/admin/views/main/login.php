<?php /* @var $this MainController */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_mdl LoginForm */ ?>

<div class="login-wrapper">
    <div class="login-middle">
        <div class="login-box">
            <h1><?php echo __a('web constructor'); ?></h1>
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'login-form','enableAjaxValidation'=>false,'htmlOptions'=>array('id' => 'login-form'))); ?>
                <div class="input">
                    <?php echo $form->textField($form_mdl,'username',array('placeholder' => __a('Login')));?>
                    <div class="errorMessage"><?php echo $form->error($form_mdl,'username'); ?></div>
                </div>
                <div class="input">
                    <?php echo $form->passwordField($form_mdl, 'password', array('placeholder' => __a('Password'))); ?>
                    <div class="errorMessage"><?php echo $form->error($form_mdl,'password'); ?></div>
                </div>
                <input type="submit" value="<?php echo __a("Enter"); ?>" />
<!--                <a href="#">--><?php //echo __a('I forgot my password'); ?><!--</a>-->
            <?php $this->endWidget(); ?>
        </div><!--/login-box-->
    </div><!--/login-middle-->
</div><!--/login-wrapper-->