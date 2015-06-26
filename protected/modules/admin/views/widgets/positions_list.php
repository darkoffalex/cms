<?php /* @var $items WidgetPositionEx[] */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Widget positions'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/widgets/positionadd'); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
        <div class="content list">
            <div class="list-row title">
                <div class="cell"><?php echo __a('Label'); ?></div>
                <div class="cell"><?php echo __a('Position name'); ?></div>
                <div class="cell price"><?php echo __a('Widgets'); ?></div>
                <div class="cell type"><?php echo __a('Status'); ?></div>
                <div class="cell action"><?php echo __a('Actions'); ?></div>
            </div><!--/list-row-->

            <?php foreach($items as $index => $item): ?>
                <div class="list-row h60">
                    <div class="cell"><?php echo $item->label; ?></div>
                    <div class="cell"><?php echo $item->position_name; ?></div>
                    <div class="cell price"><?php echo count($item->widgetRegistrations); ?></div>
                    <div class="cell type"><?php echo Constants::getStatusName($item->status_id); ?></div>
                    <div class="cell action">
                        <a href="<?php echo Yii::app()->createUrl('admin/widgets/positionedit',array('id' => $item->id)); ?>" class="action edit"></a>
                        <a href="<?php echo Yii::app()->createUrl('admin/widgets/positionelete',array('id' => $item->id)); ?>" class="action delete confirm-box"></a>
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