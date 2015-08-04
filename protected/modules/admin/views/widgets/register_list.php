<?php /* @var $positions WidgetPositionEx[] */ ?>

<main>
    <?php if(!empty($positions)): ?>
        <?php foreach($positions as $position): ?>
            <div class="title-bar">
                <h1><?php echo __a('Position') ?>: <?php echo $position->label; ?> [<?php echo $position->position_name; ?>]</h1>

                <?php $availableReg = $position->availableWidgets(); ?>
                <?php if(!empty($availableReg)): ?>
                    <ul class="actions">
                        <li>
                            <form method="post" action="<?php echo Yii::app()->createUrl('admin/widgets/register'); ?>" class="special-filter-form">
                                <button type="submit" class="reg-widget-submit"></button>
                                <input type="hidden" name="pos_id" value="<?php echo $position->id; ?>">
                                <select name="wid_id" class="float-left filter-drop-down">
                                    <?php foreach($availableReg as $ids => $name): ?>
                                        <option value="<?php echo $ids; ?>"><?php echo $name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </li>
                    </ul>
                <?php endif; ?>

            </div><!--/title-bar-->
            <div class="content list">

                <?php if(!empty($position->widgetRegistrations)): ?>
                    <div class="list-row title">
                        <div class="cell"><?php echo __a('Widget name'); ?></div>
                        <div class="cell type"><?php echo __a('Type'); ?></div>
                        <div class="cell action"><?php echo __a('Actions'); ?></div>
                    </div><!--/list-row-->

                    <?php foreach($position->widgetRegistrations as $wr): ?>
                        <div class="list-row h60">
                            <div class="cell"><?php echo $wr->widget->label; ?></div>
                            <div class="cell type"><?php echo Constants::getWidgetTypeName($wr->widget->type_id); ?></div>
                            <div class="cell action bigger">
                                <a href="<?php echo Yii::app()->createUrl('admin/widgets/moveregistered',array('id' => $wr->id, 'dir' => 'up')); ?>" class="action to-top"></a>
                                <a href="<?php echo Yii::app()->createUrl('admin/widgets/moveregistered',array('id' => $wr->id, 'dir' => 'down')); ?>" class="action to-bottom"></a>
                                <a href="<?php echo Yii::app()->createUrl('admin/widgets/unregister',array('id' => $wr->id)); ?>" class="action delete confirm-box"></a>
                            </div>
                        </div><!--/list-row-->
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="content list">
                        <div class="list-row">
                            <div class="cell"><?php echo __a('No widgets are registered for this position'); ?></div>
                        </div><!--/list-row-->
                    </div>
                <?php endif; ?>

            </div><!--/content-->
        <?php endforeach; ?>
    <?php else: ?>

        <div class="title-bar">
            <h1><?php echo __a('Widget registrations') ?></h1>
        </div>

        <div class="content list">
            <div class="list-row">
                <div class="cell"><?php echo __a('No positions are declared. Please declare at least one position'); ?></div>
            </div><!--/list-row-->
        </div>
    <?php endif; ?>
</main>