<?php /* @var $model WidgetEx */ ?>
<?php /* @var $items FeedbackEx[] */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Widgets');?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/widgets/list'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content page-content">

        <div class="header">
            <?php $title = $model->isNewRecord ? 'Add form widget' : 'Edit form widget'; ?>
            <span><?php echo __a($title); ?></span>

            <?php if($model->form_type_id == Constants::FORM_WIDGET_FEEDBACK): ?>
                <a class="active" href="<?php echo Yii::app()->createUrl('admin/widgets/feedbackincoming',array('id' => $model->id)); ?>"><?php echo __a('Incoming messages'); ?></a>
                <?php if(!empty($model->filtrationByType)): ?>
                    <a href="<?php echo Yii::app()->createUrl('admin/widgets/feedbackvalidation',array('id' => $model->id)); ?>"><?php echo __a('Field validation'); ?></a>
                <?php endif; ?>
            <?php endif; ?>

            <a href="<?php echo Yii::app()->createUrl('admin/widgets/edit',array('id' => $model->id)); ?>"><?php echo __a('General'); ?></a>
        </div><!--/header-->

        <?php if(!empty($items)): ?>
        <div class="inner-content">
            <div class="content list">
                <div class="list-row title h36">
                    <div class="cell"><?php echo __a('Sender email'); ?></div>
                    <div class="cell type"><?php echo __a('IP'); ?></div>
                    <div class="cell type"><?php echo __a('Added time'); ?></div>
                    <div class="cell type"><?php echo __a('Sent'); ?></div>
                    <div class="cell type"><?php echo __a('Sent time'); ?></div>
                    <div class="cell action"><?php echo __a('Actions'); ?></div>
                </div><!--/list-row-->

                <?php foreach($items as $feedback): ?>
                    <div class="list-row h36">
                        <div class="cell"><?php echo $feedback->email; ?></div>
                        <div class="cell type"><?php echo $feedback->ip; ?></div>
                        <div class="cell type"><?php echo date('Y-m-d H:i:s',$feedback->created_time); ?></div>
                        <div class="cell type"><?php echo !empty($feedback->sent) ? __a('Yes') : __a('No'); ?></div>
                        <div class="cell type"><?php echo !empty($feedback->sent) ? date('Y-m-d H:i:s',$feedback->sent_time) : '-'; ?></div>
                        <div class="cell action">
                            &nbsp;<a title="<?php echo __a('View'); ?>" class="view load-to-light-box" href="<?php echo Yii::app()->createUrl('admin/widgets/viewfeedback',array('id' => $feedback->id)); ?>"><span class="ficoned eye"></span></a>&nbsp;
                            &nbsp;<a title="<?php echo __a('Delete'); ?>" class="delete confirm-box" href="<?php echo Yii::app()->createUrl('admin/widgets/delfeedback',array('id' => $feedback->id)); ?>"><span class="ficoned trash-can"></span></a>&nbsp;
                            <?php if($feedback->sent): ?>
                                &nbsp;<a title="<?php echo __a('Resend'); ?>" href="#"><span class="ficoned refresh"></span></a>&nbsp;
                            <?php else: ?>
                                &nbsp;<a title="<?php echo __a('Send'); ?>" href="#"><span class="ficoned email"></span></a>&nbsp;
                            <?php endif; ?>
                        </div>
                    </div><!--/list-row-->
                <?php endforeach;?>

            </div><!--/content-->

            <?php if(CPager::getInstance()->getTotalPages() > 1): ?>
                <div class="pagination">
                    <?php $controller = Yii::app()->controller->id; ?>
                    <?php $action = Yii::app()->controller->action->id; ?>
                    <?php $cid = Yii::app()->request->getParam('cid',0); ?>
                    <?php $tid = Yii::app()->request->getParam('tid',0); ?>
                    <?php for($i=0; $i < CPager::getInstance()->getTotalPages(); $i++):
                        $url = Yii::app()->createUrl('admin/'.$controller.'/'.$action, array('page' => $i+1, 'id' => $model->id));
                        $active = CPager::getInstance()->getCurrentPage() == $i+1;
                        ?>
                        <a href="<?php echo $url; ?>" <?php if($active): ?>class="active"<?php endif;?>><?php echo $i+1; ?></a>
                    <?php endfor;?>
                </div><!--/pagination-->
            <?php endif;?>

        </div><!--/inner-content-->
        <?php else: ?>
            <p style="padding: 10px;"><?php echo __a('List is empty'); ?></p>
        <?php endif; ?>

    </div><!--/content translate-->

    <div class="lightbox add-box">
        <div class="wrap">
            <div class="middle">
                <div class="content">
                    <span class="header"><?php echo __a('Feedback message'); ?></span>
                    <div style="height: 200px; overflow-y: scroll;" class="in-content"></div>
                    <input type="button" value="<?php echo __a('Close'); ?>" class="float-right light-box-close">
                </div><!--/content-->
            </div>
        </div><!--/wrap/middle-->
    </div><!--/lightbox-->

</main>