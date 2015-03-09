<?php /* @var $this MainController */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_mdl LoginForm */ ?>

<?php $form=$this->beginWidget('CActiveForm', array('id' =>'login-form','enableAjaxValidation'=>false,'htmlOptions'=>array())); ?>

<?php echo $form->textField($form_mdl,'username',array('placeholder' => __a('Login')));?>
<?php echo $form->passwordField($form_mdl, 'password', array('placeholder' => __a('Password'))); ?>

<input type="submit" value="<?php echo __a("Enter"); ?>">

<?php if($form_mdl->hasErrors()): ?>
    <?php $passwordErr = $form->error($form_mdl,'password'); ?>
    <?php $usernameErr = $form->error($form_mdl,'username'); ?>
    <?php if($usernameErr): ?>
        <?php echo __a($usernameErr); ?>
    <?php elseif($passwordErr): ?>
        <?php echo __a($passwordErr); ?>
    <?php endif ?>
<?php endif; ?>

<?php $this->endWidget(); ?>