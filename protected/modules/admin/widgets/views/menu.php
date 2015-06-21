<?php /* @var $cur_controller string */ ?>
<?php /* @var $cur_action string */ ?>
<?php /* @var $menu array */ ?>

<ul class="root">
    <?php foreach($menu as $item):
        $title = !empty($item['title']) ? $item['title'] : 'untitled';
        $class = !empty($item['html_class']) ? $item['html_class'] : '';
        $icon = !empty($item['icon']) ? $item['icon'] : '';
        $subs = !empty($item['sub']) ? $item['sub'] : array();
        $url = !empty($item['url']) ? $item['url'] : '#';
        ?>
        <li>
            <span class="<?php echo $class ?>"></span><a href="<?php echo $url; ?>"><span><?php echo __a($title); ?></span></a>
            <?php if(!empty($subs)): ?>
                <ul>
                    <?php foreach($subs as $sub):
                        $title = !empty($sub['title']) ? $sub['title'] : '';
                        $url = !empty($sub['url']) ? $sub['url'] : '#';
                        ?>
                        <li><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
                    <?php endforeach;?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach;?>
</ul>