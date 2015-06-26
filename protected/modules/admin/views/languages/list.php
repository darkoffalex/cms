<?php /* @var $items Language[] */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Languages'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/languages/add'); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
        <div class="content list">
            <div class="list-row title">
                <div class="cell"><?php echo __a('Label'); ?></div>
                <div class="cell type"><?php echo __a('Name'); ?></div>
                <div class="cell price"><?php echo __a('Prefix'); ?></div>
                <div class="cell type"><?php echo __a('Status'); ?></div>
                <div class="cell action bigger"><?php echo __a('Actions'); ?></div>
            </div><!--/list-row-->

            <?php foreach($items as $index => $item): ?>
                <div class="list-row h60">
                    <div class="cell"><a href=""><?php echo $item->label; ?></a></div>
                    <div class="cell type"><?php echo $item->name; ?></div>
                    <div class="cell price"><?php echo $item->prefix; ?></div>
                    <div class="cell type"><?php echo Constants::getStatusName($item->status); ?></div>
                    <div class="cell action bigger">
                        <?php if(count($items) > 1): ?>
                            <a href="<?php echo Yii::app()->createUrl('admin/languages/move',array('id' => $item->id, 'dir' => 'up')); ?>" class="action to-top"></a>
                            <a href="<?php echo Yii::app()->createUrl('admin/languages/move',array('id' => $item->id, 'dir' => 'down')); ?>" class="action to-bottom"></a>
                            <a href="<?php echo Yii::app()->createUrl('admin/languages/delete',array('id' => $item->id)); ?>" class="action delete confirm-box"></a>
                        <?php endif; ?>
                        <a href="<?php echo Yii::app()->createUrl('admin/languages/edit',array('id' => $item->id)); ?>" class="action edit"></a>
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