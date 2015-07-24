<?php /* @var $roots array */ ?>
<?php /* @var $items TreeEx[] */ ?>
<?php /* @var $parent int */ ?>
<?php /* @var $this ControllerAdmin|CategoriesController */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Categories'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/categories/add') ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content">
        <div class="title-table">
            <div class="cell drag-drop"><?php echo __a('Drag and Drop'); ?></div>
            <div class="cell"><?php echo __a('Label'); ?></div>
            <div class="cell sequen"><?php echo __a('Items'); ?></div>
            <div class="cell sequen"><?php echo __a('Order'); ?></div>
            <div class="cell type"><?php echo __a('Template'); ?></div>
            <div class="cell action"><?php echo __a('Actions');?></div>
        </div><!--table-->
        <div class="sortable">
            <?php $this->renderPartial('_list',array('roots' => $roots, 'parent' => $parent)); ?>
        </div><!--/sortable-->

    </div><!--/content-->
</main>

<input type="hidden" id="ajax-refresh-link" value="<?php echo Yii::app()->createUrl('admin/categories/list'); ?>">
<input type="hidden" id="ajax-swap-link" value="<?php echo Yii::app()->createUrl('/admin/categories/reorder'); ?>">