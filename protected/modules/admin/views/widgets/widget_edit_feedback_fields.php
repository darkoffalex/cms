<?php /* @var $languages Language[] */ ?>
<?php /* @var $templates array */ ?>
<?php /* @var $categories array */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $model WidgetEx */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo __a('Widgets');?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/widgets/list'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content page-content">

        <div class="header">
            <?php $title = $model->isNewRecord ? 'Add feedback form' : 'Edit feedback form'; ?>
            <span><?php echo __a($title); ?></span>

            <a href="<?php echo Yii::app()->createUrl('admin/widgets/feedbacksincoming',array('id' => $model->id)); ?>"><?php echo __a('Incoming messages'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/widgets/feedbackfields',array('id' => $model->id)); ?>" class="active"><?php echo __a('Form fields'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/widgets/edit',array('id' => $model->id)); ?>"><?php echo __a('General'); ?></a>
        </div><!--/header-->

        <div class="inner-content">
            <form method="post" action="">
                <table>
                    <tr>
                        <td class="label top-aligned"><?php echo __a('List of form fields'); ?></td>
                        <td class="value">
                            <?php $this->renderPartial('/common/_dynamic_js_table',array(
                                'tableId' => 'feedback_fields_form',
                                'data' => array(),
                                'actions' => true,
                                'fieldBaseName' => 'FeedbackFields',
                                'fields' => array(
                                    array('name' => 'field_name','title' => 'Field name', 'placeholder' => 'Field name'),
                                    array('name' => 'field_type','title' => 'Field type', 'options' => Constants::feedbackFieldTypes()),
                                ),
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value"><?php echo CHtml::submitButton(__a('Save')); ?></td>
                    </tr>
                </table>
            </form>
        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>