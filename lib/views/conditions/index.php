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
<div class="os-form-sub-header"><h3><?php _e('Button on Confirmation', 'latepoint-extends'); ?></h3></div>
<div class="os-conditions-w os-conditions-ordering-w">
<form data-os-custom-field-id="button-confirmation" 
    data-os-action="<?php echo OsRouterHelper::build_route_name('conditions', 'confirmation'); ?>" 
    data-os-after-call="latepoint_condition_saved" 
    class="os-custom-field-form">
	<div class="os-custom-field-form-i">
		<div class="os-custom-field-form-info">
			<div class="os-custom-field-drag"></div>
			<div class="os-name"><?php echo __('Button on Confirmation', 'latepoint-conditions'); ?></div>
			<div class="os-custom-field-edit-btn"><i class="latepoint-icon latepoint-icon-edit-3"></i></div>
		</div>
		<div class="os-custom-field-form-params">
			<div class="os-row">
				<div class="os-col-12">
					<?php echo OsFormHelper::text_field('text', __('Button Text', 'latepoint-conditions'), $buttonConfirm['text'], ['class' => 'os-custom-field-name-input', 'id' => 'confirmation-button-text']); ?>
				</div>
				<div class="os-col-12">
					<?php echo OsFormHelper::text_field('link', __('Button Link', 'latepoint-conditions'), $buttonConfirm['link'], ['class' => 'os-custom-field-name-input', 'id' => 'confirmation-button-link']); ?>
				</div>
            </div>
            <button type="submit" class="os-custom-field-save-btn latepoint-btn latepoint-btn-primary"><span><?php _e('Save', 'latepoint-conditions'); ?></span></button>
        </div>
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
