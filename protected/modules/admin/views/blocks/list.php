<?php /* @var $items ContentItemEx[] */ ?>
<?php /* @var $category TreeEx[] */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Content blocks'); ?></h1>
        <ul class="actions">
            <li><a href="" class="action add"></a></li>
            <li><a href="" class="action del delete-all-pages" data-id="checkbox"></a></li>
        </ul>
    </div><!--/title-bar-->
    <div class="content list">
        <div class="list-row title">
            <div class="cell checkbox"><input type="checkbox" value="0" name="checkbox" id="checkall_pages"/></div>
            <div class="cell"><?php echo __a('Label'); ?></div>
            <div class="cell action"><?php echo __a('Actions'); ?></div>
        </div><!--/list-row-->

        <div class="list-row">
            <?php foreach($items as $item): ?>
                <div class="cell checkbox"><input type="checkbox" name="del_block[<?php echo $item->id; ?>]" value="1"/></div>
                <div class="cell"><?php echo $item->label; ?></div>
                <div class="cell action">
                    <a href="<?php echo Yii::app()->createUrl('admin/blocks/edit',array('id' => $item->id)); ?>" class="action edit edit-page"></a>
                    <a href="<?php echo Yii::app()->createUrl('admin/blocks/delete',array('id' => $item->id)); ?>" class="action delete delete-page confirm-box"></a>
                </div>
            <?php endforeach;?>
        </div><!--/list-row-->

    </div><!--/content-->

    <?php if(C) ?>
    <div class="pagination">
        <a href="pages.html" class="active">1</a>
        <a href="pages.html">2</a>
        <a href="pages.html">3</a>
        <a href="pages.html">4</a>
    </div><!--/pagination-->
</main>