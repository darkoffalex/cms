<?php /* @var $cur_controller string */ ?>
<?php /* @var $cur_action string */ ?>
<?php /* @var $menu array */ ?>

<ul class="root">
    <?php foreach($menu as $item):
        $title = getif($item['title'],'untitled');
        $class = getif($item['html_class'],'');
        $icon = getif($item['icon'],'');
        $subs = getif($item['sub'],array());
        $url = getif($item['url'],'#');
        ?>
        <li>
            <span class="<?php echo $class ?>"></span><a href="<?php echo $url; ?>"><span><?php echo __a($title); ?></span></a>
            <?php if(!empty($subs)): ?>
                <ul>
                    <?php foreach($subs as $sub):
                        $title = getif($sub['title'],'');
                        $url = getif($sub['url'],'#');
                        ?>
                        <li><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
                    <?php endforeach;?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach;?>
</ul>