<?php /* @var $menu array */ ?>
<?php /* @var $current array */ ?>

<div class="langlist">
    <?php $cur_url = !empty($current['url']) ? $current['url'] : ''; ?>
    <?php $cur_title = !empty($current['title']) ? $current['title'] : '--'; ?>
    <a href="<?php echo $cur_url; ?>"><?php echo $cur_title; ?></a>
    <ul>
        <?php foreach($menu as $item):
            $title = !empty($item['title']) ? $item['title'] : '';
            $url = !empty($item['url']) ? $item['url'] : '';
            ?>
            <li><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div><!--/langlist-->