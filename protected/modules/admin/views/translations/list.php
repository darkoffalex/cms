<?php /* @var $this TranslationsController */ ?>
<?php /* @var $languages Language[] */ ?>
<?php /* @var $current_lng Language */ ?>
<?php /* @var $items TranslationEx[] */ ?>
<?php /* @var $lng_id int */ ?>
<?php /* @var $model TranslationEx */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Translations'); ?></h1>
        <ul class="actions">
            <li><a href="#" class="action add light-box-open"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content translation">
        <div class="header">
            <span><?php echo __a('Translated labels'); ?></span>
        </div><!--/header-->
        <div class="translate-actions padding-right-725">
            <form action="<?php echo Yii::app()->createUrl('admin/translations/list',array('page' => CPager::getInstance()->getCurrentPage())); ?>" method="get">
                <select name="id" class="float-left">
                    <?php foreach($languages as $lang): ?>
                        <option <?php if($lang->id == $lng_id): ?> selected <?php endif; ?> value="<?php echo $lang->id; ?>"><?php echo $lang->label; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="filter-submit"></button>
            </form>
        </div><!--/translate-actions-->
        <div class="translate-content">
            <div class="translate-row">
                <div class="translate-cell id">#</div>
                <div class="translate-cell labels"><?php echo __a('Label'); ?></div>
                <div class="translate-cell translations"><?php echo __a('Translation'); ?></div>
                <div class="translate-cell actions"><?php echo __a('Actions'); ?></div>
            </div><!--/translate-row-->

            <?php foreach($items as $index => $item): ?>
                <div class="translate-row">
                    <div class="translate-cell id"><?php echo $index + 1; ?></div>
                    <div class="translate-cell labels"><?php echo $item->label; ?></div>
                    <div class="translate-cell translations"><input type="text" id="input_for_<?php echo $item->id; ?>" name="translations[<?php echo $item->id ?>][<?php echo $lng_id; ?>]" value="<?php echo $item->getOrCreateTrl($lng_id)->value; ?>" placeholder=""></div>
                    <div class="translate-cell actions">
                        <a href="<?php echo Yii::app()->createUrl('admin/translations/update') ?>" class="action save save-label" data-save="<?php echo $item->id; ?>"></a>
                        <a href="<?php echo Yii::app()->createUrl('admin/translations/delete',array('id' => $item->id)); ?>" class="action delete delete-label confirm-box"></a>
                    </div><!--/translate-cell actions-->
                </div><!--/translate-row-->
            <?php endforeach; ?>
        </div><!--/translate-content-->

        <?php if(CPager::getInstance()->getTotalPages() > 1): ?>
            <div class="pagination from-labels">
                <?php $controller = Yii::app()->controller->id; ?>
                <?php $action = Yii::app()->controller->action->id; ?>
                <?php $lid = Yii::app()->request->getParam('id',0); ?>
                <?php for($i=0; $i < CPager::getInstance()->getTotalPages(); $i++):
                    $url = Yii::app()->createUrl('admin/'.$controller.'/'.$action,array('id' => $lid,'page' => $i+1));
                    $active = CPager::getInstance()->getCurrentPage() == $i+1;
                    ?>
                    <a href="<?php echo $url; ?>" <?php if($active): ?>class="active"<?php endif;?>><?php echo $i+1; ?></a>
                <?php endfor;?>
            </div><!--/pagination-->
        <?php endif;?>

    </div><!--/content translate-->

    <?php $this->renderPartial('_add_label',array('model' => $model)); ?>
</main>