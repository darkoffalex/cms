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
        </ul>
    </div><!--/title-bar-->

    <div class="content translation">
        <div class="header">
            <span><?php echo __('Translated labels'); ?></span>
        </div><!--/header-->
        <div class="translate-actions">
            <p><?php echo __a('You have no languages. Please add language to continue'); ?></p>
        </div><!--/translate-actions-->
    </div><!--/content translate-->
</main>