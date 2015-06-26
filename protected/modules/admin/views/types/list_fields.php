<?php /* @var $items ContentItemFieldEx[] */ ?>
<?php /* @var $type ContentTypeEx */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Fields of').' "'.$type->label.'"' ; ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/types/list'); ?>" class="action undo"></a></li>
            <li><a href="<?php echo Yii::app()->createUrl('admin/types/addfield',array('id' => $type->id)); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
        <div class="content list">
            <div class="list-row title">
                <div class="cell"><?php echo __a('Name'); ?></div>
                <div class="cell"><?php echo __a('Field name'); ?></div>
                <div class="cell category"><?php echo __a('Field type'); ?></div>
                <div class="cell action"><?php echo __a('Actions'); ?></div>
            </div><!--/list-row-->

            <?php foreach($items as $index => $item): ?>
                <div class="list-row h94">
                    <div class="cell"><?php echo $item->label; ?></div>
                    <div class="cell"><?php echo $item->field_name; ?></div>
                    <div class="cell category"><?php echo Constants::getTypeName($item->field_type_id); ?></div>
                    <div class="cell action">
                        <a href="<?php echo Yii::app()->createUrl('admin/types/editfield',array('id' => $item->id)); ?>" class="action edit"></a>
                        <a href="<?php echo Yii::app()->createUrl('admin/types/deletefield',array('id' => $item->id)); ?>" class="action delete confirm-box"></a>
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