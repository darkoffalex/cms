<?php /* @var $items CommentEx[] */ ?>
<?php /* @var $this UsersController */ ?>
<?php /* @var $blocks array */ ?>

<?php /* @var $usr string */ ?>
<?php /* @var $ip string */ ?>
<?php /* @var $bid int */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Comments'); ?></h1>
        <ul class="actions">
            <li>
                <form method="get" action="<?php echo Yii::app()->createUrl('admin/users/comments'); ?>" class="special-filter-form w750">
                    <button type="submit" class="filter-submit"></button>
                    <select name="bid" class="float-left filter-drop-down">
                        <option value="0"><?php echo __a('None'); ?></option>
                        <?php foreach($blocks as $id => $name): ?>
                            <option <?php if($bid == $id): ?> selected <?php endif; ?> <?php if(!is_numeric($id)): ?> disabled <?php endif; ?> <?php if(!is_numeric($id)): ?> style="font-weight: bolder;" <?php endif; ?> value="<?php echo $id; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="ip" class="float-left filter-drop-down" value="<?php echo $ip; ?>" placeholder="<?php echo __a('Commentator IP'); ?>">
                    <input type="text" name="usr" class="float-left filter-drop-down" value="<?php echo $usr; ?>" placeholder="<?php echo __a('User ID, name, surname, login'); ?>">
                </form>
            </li>
            <?php if(!empty($blocks)): ?>
                <li><a href="<?php echo Yii::app()->createUrl('admin/users/addcomment'); ?>" class="action add"></a></li>
            <?php endif; ?>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
        <div class="content list">
            <div class="list-row title">
                <div class="cell"><?php echo __a('ID'); ?></div>
                <div class="cell"><?php echo __a('User'); ?></div>
                <div class="cell"><?php echo __a('IP'); ?></div>
                <div class="cell"><?php echo __a('Content item'); ?></div>
                <div class="cell"><?php echo __a('Added time'); ?></div>
                <div class="cell action"><?php echo __a('Actions'); ?></div>
            </div><!--/list-row-->

            <?php foreach($items as $item): ?>
                <div class="list-row h60">
                    <div class="cell"><?php echo $item->id; ?></div>
                    <div class="cell"><?php echo $item->getCommentatorUsername(); ?></div>
                    <div class="cell"><?php echo $item->user_ip; ?></div>
                    <div class="cell"><?php echo !empty($item->contentItem->label) ? $item->contentItem->label : ''; ?></div>
                    <div class="cell"><?php echo date('Y-m-d H:i:s',$item->created_time); ?></div>
                    <div class="cell action">
                        <?php if($item->permissionLevel() > CurUser::get()->permissionLvl() || (!empty($item->user) && $item->user->id == Yii::app()->getUser()->id)): ?>
                            <a href="<?php echo Yii::app()->createUrl('admin/users/editcomment',array('id' => $item->id)); ?>" class="action edit edit-page"></a>
                            <a href="<?php echo Yii::app()->createUrl('admin/users/deletecomment',array('id' => $item->id)); ?>" class="action delete delete-page confirm-box"></a>
                        <?php endif; ?>
                    </div>
                </div><!--/list-row-->
            <?php endforeach;?>
        </div><!--/content-->

        <?php if(CPager::getInstance()->getTotalPages() > 1): ?>
            <div class="pagination">
                <?php $controller = Yii::app()->controller->id; ?>
                <?php $action = Yii::app()->controller->action->id; ?>
                <?php $cid = Yii::app()->request->getParam('cid',0); ?>
                <?php $tid = Yii::app()->request->getParam('tid',0); ?>
                <?php for($i=0; $i < CPager::getInstance()->getTotalPages(); $i++):

                    $params = array('page' => $i + 1);
                    if(!empty($usr)) $params['usr'] = $usr;
                    if(!empty($ip)) $params['ip'] = $ip;
                    if(!empty($bid)) $params['bid'] = $bid;

                    $url = Yii::app()->createUrl('admin/'.$controller.'/'.$action,$params);
                    $active = CPager::getInstance()->getCurrentPage() == $i+1;
                    ?>
                    <a href="<?php echo $url; ?>" <?php if($active): ?>class="active"<?php endif;?>><?php echo $i+1; ?></a>
                <?php endfor;?>
            </div><!--/pagination-->
        <?php endif;?>
    <?php else: ?>
        <div class="content list">
            <div class="list-row">
                <div class="cell"><?php echo __a('List is empty'); ?></div>
            </div><!--/list-row-->
        </div>
    <?php endif;?>
</main>