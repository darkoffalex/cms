<?php /* @var $menu array */ ?>
<?php /* @var $current_controller string */ ?>

<ul>
    <?php foreach($menu as $controller => $params): ?>
        <li <?php if($controller == $current_controller):?> style="font-weight: bold"; <?php endif; ?>><a href="<?php echo Yii::app()->urlManager->createAdminUrl('/admin/'.$controller.'/'.$params['default']) ?>"><?php echo __a($params['title']) ?></a></li>
    <?php endforeach; ?>
</ul>
