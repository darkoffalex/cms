<?php /* @var $roots array */ ?>
<?php /* @var $items TreeEx[] */ ?>
<?php /* @var $parent int */ ?>
<?php /* @var $this ControllerAdmin|CategoriesController */ ?>

<?php foreach($roots as $index => $items): ?>
    <div class="menu-table" data-menu="<?php echo $index; ?>">
        <div class="cell draggable"><span class="ficoned drag"></span></div>

        <div class="cell block">
            <div class="inner-table">
                <?php foreach($items as $item): ?>
                    <?php if($item->id == $index): ?>
                        <div class="row root" data-id="<?php echo $item->id; ?>">
                            <div class="name"><?php echo $item->label; ?></div>
                            <div class="sequen"></div>
                            <div class="type"></div>
                            <div class="action">
                                <a href="#" class="edit"><span class="ficoned pencil"></span></a>
                                <a href="<?php echo Yii::app()->createUrl('admin/categories/delete',array('id' => $item->id)); ?>" class="delete confirm-box ajax"><span class="ficoned trash-can"></span></a>
                            </div>
                        </div><!--/row root-->
                    <?php else:?>
                        <div class="row" data-id="<?php echo $item->id; ?>" data-parent="<?php echo $item->parent_id; ?>">
                            <div class="name"><?php echo $item->label; ?></div>
                            <div class="sequen">
                                <?php if(!empty($item->parent) && count($item->parent->children) > 1): ?>
                                    <a href="<?php echo Yii::app()->createUrl('admin/categories/move',array('id' => $item->id, 'dir' => 'up')); ?>" class="go-up ajax"><span class="ficoned arrow-up"></span></a>
                                    <a href="<?php echo Yii::app()->createUrl('admin/categories/move',array('id' => $item->id, 'dir' => 'down')); ?>" class="go-down ajax"><span class="ficoned arrow-down"></span></a>
                                <?php endif;?>
                            </div><!--/sequen-->
                            <div class="type"></div>
                            <div class="action">
                                <a href="<?php echo Yii::app()->createUrl('admin/categories/edit',array('id' => $item->id)); ?>" class="edit"><span class="ficoned pencil"></span></a>
                                <a href="<?php echo Yii::app()->createUrl('admin/categories/delete',array('id' => $item->id)); ?>" class="delete confirm-box ajax"><span class="ficoned trash-can"></span></a>
                            </div>
                        </div><!--/row-->
                    <?php endif;?>
                <?php endforeach;?>
            </div><!--/inner-table-->
        </div><!--/menu-table-->
    </div><!--table-->
<?php endforeach;?>