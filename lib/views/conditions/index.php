<div class="os-conditions-w os-conditions-ordering-w">
    <?php foreach($conditions as $condition): ?>
        <?php include('_form.php'); ?>
    <?php endforeach; ?>
</div>
<div class="os-add-box add-condition-box add-condition-trigger" data-os-action="<?php echo OsRouterHelper::build_route_name('conditions', 'new_form'); ?>" data-os-output-target-do="append" data-os-output-target=".os-conditions-w">
    <div class="add-box-graphic-w">
        <div class="add-box-plus"><i class="latepoint-icon latepoint-icon-plus4"></i></div>
    </div>
    <div class="add-box-label"><?php _e('Add Condition', 'latepoint-conditions'); ?></div>
</div>
