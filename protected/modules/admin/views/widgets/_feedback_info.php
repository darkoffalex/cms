<?php /* @var $feedback FeedbackEx */ ?>

<?php $info = $feedback->getFieldsInfo(); ?>

<?php if(!empty($info) && !hasJustEmptyKeys($info)): ?>
    <table>
        <?php foreach($info as $field => $value): ?>
        <tr>
            <td><?php echo $field; ?></td>
            <td><?php echo $value; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p><?php echo __a('Nothing to show'); ?></p>
<?php endif; ?>
