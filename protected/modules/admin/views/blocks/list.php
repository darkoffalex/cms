<?php /* @var $items ContentItemEx[] */ ?>
<?php /* @var $types ContentTypeEx[] */ ?>
<?php /* @var $categories array */ ?>
<?php /* @var $selectedType ContentTypeEx */ ?>
<?php /* @var $selectedCategory TreeEx */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Content blocks'); ?></h1>
        <ul class="actions">
            <select name="category" class="float-left filter-drop-down">
                <option value="1">Category 1</option>
                <option value="2">Category 2</option>
<!--                --><?php //foreach($categories as $id => $label): ?>
<!--                    <option value="--><?php //echo $id ?><!--">--><?php //echo $label; ?><!--</option>-->
<!--                --><?php //endforeach;?>
            </select>
            <li><a href="" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
        <div class="content list">
            <div class="list-row title">
                <div class="cell"><?php echo __a('Label'); ?></div>
                <div class="cell type"><?php echo __('Type'); ?></div>
                <div class="cell type"><?php echo __('Category'); ?></div>
                <div class="cell action"><?php echo __a('Actions'); ?></div>
            </div><!--/list-row-->

            <div class="list-row">
                <?php foreach($items as $item): ?>
                    <div class="cell"><?php echo $item->label; ?></div>
                    <div class="cell type"><?php echo $item->contentType->label; ?></div>
                    <div class="cell type"><?php echo $item->tree->label; ?></div>
                    <div class="cell action">
                        <a href="<?php echo Yii::app()->createUrl('admin/blocks/edit',array('id' => $item->id)); ?>" class="action edit edit-page"></a>
                        <a href="<?php echo Yii::app()->createUrl('admin/blocks/delete',array('id' => $item->id)); ?>" class="action delete delete-page confirm-box"></a>
                    </div>
                <?php endforeach;?>
            </div><!--/list-row-->
        </div><!--/content-->

        <?php if(CPager::getInstance()->getTotalPages() > 1): ?>
            <div class="pagination">
                <?php $controller = Yii::app()->controller->id; ?>
                <?php $action = Yii::app()->controller->action->id; ?>
                <?php $cid = Yii::app()->request->getParam('cid',0); ?>
                <?php $tid = Yii::app()->request->getParam('tid',0); ?>
                <?php for($i=0; $i < CPager::getInstance()->getTotalPages(); $i++):
                    $url = Yii::app()->createUrl('admin/'.$controller.'/'.$action,array('page' => $i+1, 'cid' => $cid, 'tid' => $tid));
                    $active = CPager::getInstance()->getCurrentPage() == $i+1;
                    ?>
                    <a href="<?php echo $url; ?>" <?php if($active): ?>class="active"<?php endif;?>><?php echo $i+1; ?></a>
                <?php endfor;?>
            </div><!--/pagination-->
        <?php endif;?>
    <?php else: ?>
        <div class="content list">
            <div class="list-row">
                <div class="cell"><?php echo __('List is empty'); ?></div>
            </div><!--/list-row-->
        </div>
    <?php endif;?>
</main>