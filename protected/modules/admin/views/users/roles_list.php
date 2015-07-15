<?php /* @var $items RoleEx[] */ ?>
<?php /* @var $this UsersController */ ?>
<?php /* @var $search string */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Roles'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/users/addrole'); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
        <div class="content list">
            <div class="list-row title">
                <div class="cell"><?php echo __a('ID'); ?></div>
                <div class="cell"><?php echo __a('Role name'); ?></div>
                <div class="cell type"><?php echo __a('Usr QNT'); ?></div>
                <div class="cell type"><?php echo __a('Admin access'); ?></div>
                <div class="cell action"><?php echo __a('Actions'); ?></div>
            </div><!--/list-row-->
            <?php foreach($items as $item): ?>
                <div class="list-row h60">
                    <div class="cell"><?php echo $item->id; ?></div>
                    <div class="cell"><?php echo $item->label; ?></div>
                    <div class="cell type"><?php echo count($item->users); ?></div>
                    <div class="cell type"><?php echo $item->admin_access ? __a('Granted') : __a('Denied'); ?></div>
                    <div class="cell action">
                        <?php if(!$item->readonly): ?>
                            <?php if(CurUser::get()->permissionLvl() <= $item->permission_level): ?>
                                <a href="<?php echo Yii::app()->createUrl('admin/users/editrole',array('id' => $item->id)); ?>" class="action edit edit-page"></a>
                            <?php endif; ?>
                            <?php if(CurUser::get()->permissionLvl() < $item->permission_level): ?>
                                <a href="<?php echo Yii::app()->createUrl('admin/users/deleterole',array('id' => $item->id)); ?>" class="action delete delete-page confirm-box"></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div><!--/list-row-->
            <?php endforeach;?>
        </div><!--/content-->
    <?php else: ?>
        <div class="content list">
            <div class="list-row">
                <div class="cell"><?php echo __a('List is empty'); ?></div>
            </div><!--/list-row-->
        </div>
    <?php endif;?>
</main>