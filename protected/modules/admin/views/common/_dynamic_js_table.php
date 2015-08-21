<?php /* @var $tableId string */ ?>
<?php /* @var $data array */ ?>
<?php /* @var $fieldBaseName string */ ?>
<?php /* @var $fields array */ ?>
<?php /* @var $actions bool */ ?>

<?php $stringNames = ""; ?>
<?php $stringClasses = ""; ?>
<?php $stringPlaceholders = "";?>
<?php $stringOptions = ""; ?>

<?php foreach($fields as $index => $field): ?>
    <?php if($index > 0): $stringNames .= ","; $stringClasses .= ","; $stringPlaceholders .= ","; $stringOptions .= "|"; endif; ?>
    <?php $stringNames .= $fieldBaseName."[".$field['name']."]" ?>
    <?php $stringClasses .= !empty($field['numeric']) ? ($field['numeric'] == 'price' ? 'numeric-input-price' : 'numeric-input-block') : ''; ?>
    <?php $stringPlaceholders .= !empty($field['placeholder']) ? $field['placeholder'] : ""; ?>
    <?php $stringOptions .= !empty($field['options']) ? json_encode($field['options']) : "";  ?>
<?php endforeach; ?>

<div class="content list smaller" id="<?php echo $tableId; ?>">
    <div class="list-row title h36">
        <?php foreach($fields as $index => $field): ?>
            <div class="cell"><?php echo __a($field['title']); ?></div>
        <?php endforeach; ?>
        <?php if(!empty($actions)): ?>
            <div class="cell"></div>
        <?php endif; ?>
    </div><!--/list-row-->
    <?php if(empty($data)): ?>
        <div class="list-row h36 editable-row">
            <?php foreach($fields as $index => $field): ?>
                <?php $numericClass = !empty($field['numeric']) ? ($field['numeric'] == 'price' ? 'numeric-input-price' : 'numeric-input-block') : ''; ?>
                <div class="cell no-padding">
                    <?php if(empty($field['options']) || !is_array($field['options'])): ?>
                        <input class="in-table-input <?php echo $numericClass; ?>" type="text" placeholder="<?php echo isset($field['placeholder']) ? $field['placeholder'] : ''; ?>" value="" name="<?php echo $fieldBaseName; ?>[<?php echo $field['name'] ?>][]">
                    <?php else: ?>
                        <select class="in-table-input <?php echo $numericClass; ?>" name="<?php echo $fieldBaseName; ?>[<?php echo $field['name'] ?>][]">
                            <?php foreach($field['options'] as $oid => $oval): ?>
                                <option value="<?php echo $oid; ?>"><?php echo $oval; ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <?php if(!empty($actions)): ?>
            <div class="cell no-padding smallest-min"><a href="#" class="spec-icon delete editable-table row-del"></a></div>
            <?php endif; ?>
        </div><!--/list-row-->
    <?php else: ?>
        <?php foreach($data as $row): ?>
            <div class="list-row h36 editable-row">
                <?php foreach($fields as $index => $field): ?>
                    <?php $numericClass = !empty($field['numeric']) ? ($field['numeric'] == 'price' ? 'numeric-input-price' : 'numeric-input-block') : ''; ?>
                    <div class="cell no-padding">
                        <?php if(empty($field['options']) || !is_array($field['options'])): ?>
                            <input class="in-table-input <?php echo $numericClass; ?>" type="text" placeholder="<?php echo isset($field['placeholder']) ? $field['placeholder'] : ''; ?>" value="<?php echo $row[$field['name']]; ?>" name="<?php echo $fieldBaseName; ?>[<?php echo $field['name'] ?>][]">
                        <?php else: ?>
                            <select class="in-table-input <?php echo $numericClass; ?>" name="<?php echo $fieldBaseName; ?>[<?php echo $field['name'] ?>][]">
                                <?php foreach($field['options'] as $oid => $oval): ?>
                                    <option <?php if($row[$field['name']] == $oid): ?> selected <?php endif; ?> value="<?php echo $oid; ?>"><?php echo $oval; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <div class="cell no-padding smallest-min"><a href="#" class="spec-icon delete editable-table row-del"></a></div>
            </div><!--/list-row-->
        <?php endforeach; ?>
    <?php endif; ?>
</div><!--/content-->
<a href='#' class='spec-icon add editable-table row-add' data-table='#<?php echo $tableId; ?>' data-action='<?php echo !empty($actions) ? 'yes' : 'no' ?>' data-names='<?php echo $stringNames; ?>' data-classes='<?php echo $stringClasses; ?>' data-placeholders='<?php echo $stringPlaceholders; ?>' data-options='<?php echo $stringOptions ?>'></a>