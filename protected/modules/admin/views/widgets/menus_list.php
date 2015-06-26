<?php /* @var $items MenuEx[] */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Menus'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/widgets/menuadd'); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
        <div class="content list">
            <div class="list-row title">
                <div class="cell"><?php echo __a('Label'); ?></div>
                <div class="cell price"><?php echo __a('Categories'); ?></div>
                <div class="cell type"><?php echo __a('Template'); ?></div>
                <div class="cell action"><?php echo __a('Actions'); ?></div>
            </div><!--/list-row-->

            <?php foreach($items as $index => $item): ?>
                <div class="list-row h94">
                    <div class="cell"><?php echo $item->label; ?></div>
                    <div class="cell price"><?php echo count($item->tree->children); ?></div>
                    <div class="cell type"><?php echo $item->template_name; ?></div>
                    <div class="cell action">
                        <a href="<?php echo Yii::app()->createUrl('admin/widgets/menuedit',array('id' => $item->id)); ?>" class="action edit"></a>
                        <a href="<?php echo Yii::app()->createUrl('admin/widgets/menudelete',array('id' => $item->id)); ?>" class="action delete confirm-box"></a>
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