<?php /* @var $this ControllerAdmin */ ?>
<?php /* @var $content string */ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo $this->assets; ?>/css/vendor.css" rel="stylesheet">
    <link href="<?php echo $this->assets; ?>/css/vendor.dashboard.css" rel="stylesheet">
    <title><?php echo $this->title; ?></title>
</head>
<body>
<div class="fluid">
    <header>
        <div class="wrapper">
            <div class="menu">
                <span class="bar a"></span>
                <span class="bar b"></span>
                <span class="bar c"></span>
                <span class="bar d"></span><!--triangle-->
            </div><!--/menu-->
            <span class="logo">Web Constructor</span><!--/logo-->

<!--            <a href="" class="calendar"></a>-->
<!--            <a href="" class="messages"><span class="bubble">305</span></a>-->
<!--            <a href="" class="notices"><span class="bubble">305</span></a>-->
            <a href="" class="user"></a>

            <ul class="user-open">
                <li><a href="<?php echo Yii::app()->createUrl('admin/main/logout'); ?>"><?php echo __a('Logout'); ?></a><span class="icon out"></span></li>
                <li><a href="#"><?php echo __a('User info'); ?></a><span class="icon pencil"></span></li>
            </ul>
            <?php $this->widget('admin.widgets.Lang'); ?>
        </div><!--/wrapper-->
    </header>
    <div class="content-fluid">
        <aside><!-- class="minimized" if sidebar must be minimized when page loads (from cookie: inluMenu == 'minimized')-->
            <?php $this->widget('admin.widgets.Menu'); ?>
        </aside>

        <?php echo $content; ?>

    </div><!--/content-fluid-->
</div><!--fluid-->

<script src="<?php echo $this->assets; ?>/js/jquery-1.11.2.min.js"></script>
<script src="<?php echo $this->assets; ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $this->assets; ?>/js/vendor.js"></script>
<script src="<?php echo $this->assets; ?>/js/vendor.dialog-box.js"></script>
<script src="<?php echo $this->assets; ?>/js/vendor.preloader.js"></script>

<input type="hidden" id="confirmation-question" value="<?php echo __a('Are you sure ?'); ?>">
<input type="hidden" id="confirmation-yes" value="<?php echo __a('Yes');?>">
<input type="hidden" id="confirmation-no" value="<?php echo __a('Cancel');?>">
</body>
</html>