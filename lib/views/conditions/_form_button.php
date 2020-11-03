<form data-os-custom-field-id="<?php echo $buttonConfirm['id'] ?>" 
    data-os-action="<?php echo OsRouterHelper::build_route_name('conditions', 'confirmation'); ?>" 
    data-os-after-call="latepoint_condition_saved" 
    class="os-custom-field-form">
	<div class="os-custom-field-form-i">
		<div class="os-custom-field-form-info">
			<div class="os-custom-field-drag"></div>
			<div class="os-custom-field-name"><?php echo !empty($buttonConfirm['label']) ? $buttonConfirm['label'] : __('New Button on Confirmation', 'latepoint-conditions'); ?></div>
			<div class="os-custom-field-edit-btn"><i class="latepoint-icon latepoint-icon-edit-3"></i></div>
		</div>
		<div class="os-custom-field-form-params">
			<div class="os-row">
				<div class="os-col-12">
					<?php echo OsFormHelper::text_field('button[label]', __('Name', 'latepoint-conditions'), $buttonConfirm['label'], ['class' => 'os-custom-field-name-input', 'id' => 'confirmation-button-label' . $buttonConfirm['id']]); ?>
				</div>
				<div class="os-col-12">
					<?php echo OsFormHelper::text_field('button[link]', __('Button Link', 'latepoint-conditions'), $buttonConfirm['link'], ['id' => 'confirmation-button-link' . $buttonConfirm['id']]); ?>
				</div>
				<div class="os-col-6">
					<?php echo OsFormHelper::select_field('button[target]', __('Open Link', 'latepoint-conditions'), ['_self' => __('Current Page', 'latepoint-conditions'), '_blank' => __('New Page', 'latepoint-conditions')], $buttonConfirm['target'], ['id' => 'confirmation-button-target']); ?>
				</div>
				<div class="os-col-12">
					<?php echo OsFormHelper::text_field('button[referer]', __('Reference Link', 'latepoint-conditions'), $buttonConfirm['referer'], ['id' => 'confirmation-button-referer' . $buttonConfirm['id']]); ?>
				</div>
            </div>
            <?php echo OsFormHelper::hidden_field('button[id]', $buttonConfirm['id'], ['class' => 'os-custom-field-id', 'id' => 'id_' . $buttonConfirm['id']]); ?>
            <button type="submit" class="os-custom-field-save-btn latepoint-btn latepoint-btn-primary"><span><?php _e('Save', 'latepoint-conditions'); ?></span></button>
        </div>
    </div>
    <a href="#" data-os-prompt="<?php _e('Are you sure you want to remove this field?', 'latepoint-conditions'); ?>"  data-os-after-call="latepoint_custom_field_removed" data-os-pass-this="yes" data-os-action="<?php echo OsRouterHelper::build_route_name('conditions', 'delete_button'); ?>" data-os-params="<?php echo OsUtilHelper::build_os_params(['id' => $buttonConfirm['id']]) ?>" class="os-remove-custom-field"><i class="latepoint-icon latepoint-icon-cross"></i></a>
</form>
