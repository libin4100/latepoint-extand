<div class="os-form-sub-header"><h3><?php _e('Disabled Customer Login', 'latepoint-extends'); ?></h3></div>
<div class="os-default-fields" data-route="<?php echo OsRouterHelper::build_route_name('conditions', 'disabled_customer') ?>">
	<form>
		<div class="os-default-field <?php echo $disabledCustomer ? '' : 'is-disabled'; ?>">
            <div class="os-toggler<?php echo $disabledCustomer ? '' : ' off' ?>" data-for="disabled_customer_login"><div class="toggler-rail"><div class="toggler-pill"></div></div></div>
            <?php echo OsFormHelper::hidden_field('disabled_customer_login', $disabledCustomer); ?>
			<div class="os-field-name"><?php _e('Disabled Customer Login', 'latepoint-extends'); ?></div>
		</div>
	</form>
</div>

<div class="os-form-sub-header"><h3><?php _e('Conditions', 'latepoint-extends'); ?></h3></div>
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
