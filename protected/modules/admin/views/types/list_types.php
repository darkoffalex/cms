<?php /* @var $items ContentTypeEx[] */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo __a('Content types'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/types/addtype'); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
        <div class="content list">
            <div class="list-row title">
                <div class="cell"><?php echo __a('Name'); ?></div>
                <div class="cell price"><?php echo __a('Fields qnt'); ?></div>
                <div class="cell price"><?php echo __a('Used in'); ?></div>
                <div class="cell action"><?php echo __a('Actions'); ?></div>
            </div><!--/list-row-->

            <?php foreach($items as $index => $item): ?>
                <div class="list-row h94">
                    <div class="cell"><a href="<?php echo Yii::app()->createUrl('admin/types/fields',array('id' => $item->id)); ?>"><?php echo $item->label; ?></a></div>
                    <div class="cell price"><?php echo count($item->contentItemFields); ?></div>
                    <div class="cell price"><?php echo count($item->contentItems); ?></div>
                    <div class="cell action">
                        <a href="<?php echo Yii::app()->createUrl('admin/types/edittype',array('id' => $item->id)); ?>" class="action edit"></a>
                        <a href="<?php echo Yii::app()->createUrl('admin/types/deletetype',array('id' => $item->id)); ?>" class="action delete confirm-box"></a>
                    </div>
                </div><!--/list-row-->
            <?php endforeach;?>
        </div><!--/content-->

        <?php if(CPager::getInstance()->getTotalPages() > 1): ?>
            <div class="pagination">
                <?php $controller = Yii::app()->controller->id; ?>
                <?php $action = Yii::app()->controller->action->id; ?>
                <?php for($i=0; $i < CPager::getInstance()->getTotalPages(); $i++):
                    $url = Yii::app()->createUrl('admin/'.$controller.'/'.$action,array('page' => $i+1));
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