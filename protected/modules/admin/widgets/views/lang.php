<?php /* @var $menu array */ ?>
<?php /* @var $current array */ ?>

<div class="langlist">
    <?php $cur_url = getif($current['url'],'#'); ?>
    <?php $cur_title = getif($current['title'],'--'); ?>
    <a href="<?php echo $cur_url; ?>"><?php echo $cur_title; ?></a>
    <ul>
        <?php foreach($menu as $item):
            $title = getif($item['title'],'');
            $url = getif($item['url'],'');
            ?>
            <li><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div><!--/langlist-->