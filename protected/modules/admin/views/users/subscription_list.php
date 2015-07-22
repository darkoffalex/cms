<?php /* @var $items SubscriptionEx[] */ ?>
<?php /* @var $this UsersController */ ?>
<?php /* @var $email string */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Subscription'); ?></h1>
        <ul class="actions">
            <li>
                <form method="get" action="<?php echo Yii::app()->createUrl('admin/users/subscription'); ?>" class="special-filter-form">
                    <button type="submit" class="filter-submit"></button>
                    <input type="text" name="email" class="float-left filter-drop-down" value="<?php echo $email; ?>" placeholder="<?php echo __a('Email'); ?>">
                </form>
            </li>
            <li><a href="<?php echo Yii::app()->createUrl('admin/users/subscribe'); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
        <div class="content list">
            <div class="list-row title">
                <div class="cell"><?php echo __a('ID'); ?></div>
                <div class="cell"><?php echo __a('Email'); ?></div>
                <div class="cell"><?php echo __a('Period (days)'); ?></div>
                <div class="cell"><?php echo __a('IP address'); ?></div>
                <div class="cell action"><?php echo __a('Actions'); ?></div>
            </div><!--/list-row-->

            <?php foreach($items as $item): ?>
                <div class="list-row h60">
                    <div class="cell"><?php echo $item->id; ?></div>
                    <div class="cell"><?php echo $item->email; ?></div>
                    <div class="cell"><?php echo $item->periodInDays(); ?></div>
                    <div class="cell"><?php echo $item->subscriber_ip; ?></div>
                    <div class="cell action">
                        <a href="<?php echo Yii::app()->createUrl('admin/users/subscribeedit',array('id' => $item->id)); ?>" class="action edit edit-page"></a>
                        <a href="<?php echo Yii::app()->createUrl('admin/users/subscribedelete',array('id' => $item->id)); ?>" class="action delete delete-page confirm-box"></a>
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
                    if(!empty($email)) $params['email'] = $email;
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