<?php /* @var $actions Array */ ?>
<?php /* @var $role RoleEx */ ?>
<?php /* @var $this UsersController */ ?>

<div class="content list smaller">
    <?php foreach($actions as $controller => $params):
        $title = __a(!empty($params[0]) ? $params[0] : $controller);
        $actionList = !empty($params[1]) ? $params[1] : array()
        ?>
        <div class="list-row title h36">
            <div class="cell"><?php echo $title ?></div>
            <div class="cell action smallest"><?php echo __a('Access'); ?></div>
        </div><!--/list-row-->
        <?php foreach($actionList as $action => $title): ?>
        <div class="list-row h36">
            <div class="cell"><label for="<?php echo $controller."_".$action ?>"><?php echo __a($title) ?></label></div>
            <div class="cell action smallest"><input id="<?php echo $controller."_".$action ?>" name="RoleEx[permissions][<?php echo $controller ?>][<?php echo $action; ?>]" <?php if($role->allowed($controller,$action)): ?> checked <?php endif; ?> type="checkbox"></div>
        </div><!--/list-row-->
        <?php endforeach; ?>
    <?php endforeach; ?>
</div><!--/content-->