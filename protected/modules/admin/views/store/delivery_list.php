<?php /* @var $items OrderDeliveryEx[] */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Delivery'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/store/adddelivery'); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
        <div class="content list">
            <div class="list-row title">
                <div class="cell"><?php echo __a('Label'); ?></div>
                <div class="cell price"><?php echo __a('Price'); ?></div>
                <div class="cell price"><?php echo __a('Status'); ?></div>
                <div class="cell action"><?php echo __a('Actions'); ?></div>
            </div><!--/list-row-->

            <?php foreach($items as $index => $item): ?>
                <div class="list-row h60">
                    <div class="cell"><a href=""><?php echo $item->label; ?></a></div>
                    <div class="cell price"><?php echo centsToPrice($item->price) ; ?></div>
                    <div class="cell price"><?php echo Constants::getStatusName($item->status_id); ?></div>
                    <div class="cell action">
                        <a href="<?php echo Yii::app()->createUrl('admin/store/deletedelivery',array('id' => $item->id)); ?>" class="action delete <?php echo !empty($item->orders) ? 'block-box' : 'confirm-box'; ?>"></a>
                        <a href="<?php echo Yii::app()->createUrl('admin/store/editdelivery',array('id' => $item->id)); ?>" class="action edit"></a>
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