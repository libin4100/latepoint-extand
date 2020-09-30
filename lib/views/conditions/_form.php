<form data-os-custom-field-id="<?php echo $condition['id']; ?>" 
    data-os-action="<?php echo OsRouterHelper::build_route_name('conditions', 'save'); ?>" 
    data-os-after-call="latepoint_condition_saved" 
    class="os-custom-field-form">
	<div class="os-custom-field-form-i">
		<div class="os-custom-field-form-info">
			<div class="os-custom-field-drag"></div>
			<div class="os-custom-field-name"><?php echo !empty($condition['label']) ? $condition['label'] : __('New Condition', 'latepoint-conditions'); ?></div>
			<div class="os-custom-field-edit-btn"><i class="latepoint-icon latepoint-icon-edit-3"></i></div>
		</div>
		<div class="os-custom-field-form-params">
			<div class="os-row">
				<div class="os-col-12">
					<?php echo OsFormHelper::text_field('condition[label]', __('Name', 'latepoint-conditions'), $condition['label'], ['class' => 'os-custom-field-name-input', 'id' => 'label_' . $condition['id']]); ?>
				</div>
				<div class="os-col-6 os-form-w">
                    <div class="white-box">
                        <div class="white-box-header">
                            <div class="os-form-sub-header">
                                <h3><?php _e('Conditions', 'latepoint-conditions'); ?></h3>
                                <div class="os-form-sub-header-actions"]>
                                    <?php echo OsFormHelper::select_field('condition[operator]', '', ['and' => __('All of below', 'latepoint-conditions'), 'or' => __('Any of below', 'latepoint-conditions')], false, ['id' => 'operator_' . $condition['id']]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="white-box-content">
                            <?php include('_custom_fields.php') ?>
                        </div>
                    </div>
				</div>
				<div class="os-col-6 os-form-w">
                    <div class="white-box">
                        <div class="white-box-header">
                            <div class="os-form-sub-header">
                                <h3><?php _e('Agents', 'latepoint'); ?></h3>
                                <div class="os-form-sub-header-actions">
                                    <?php echo OsFormHelper::checkbox_field('select_all_agents', __('Select All', 'latepoint'), 'off', false, ['class' => 'os-select-all-toggler', 'id' => 'all_agents_' . $condition['id']]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="white-box-content">
                            <div class="os-complex-agents-selector">
                            <?php if($agents) {
                                foreach($agents as $agent) {
                                    $is_active_agent = in_array($agent->id, $condition['agents']);
                                    $is_active_agent_value = $is_active_agent ? 'yes' : 'no';
                                    $active_class = $is_active_agent ? 'active' : ''; 
                            ?>
                                <div class="agent <?php echo $active_class; ?>">
                                    <div class="agent-i selector-trigger">
                                        <?php echo OsFormHelper::hidden_field('condition[agents][' . $agent->id . ']', $is_active_agent_value, ['class' => 'agent-service-connection', 'id' => 'agents_' . $agent->id . $condition['id']]); ?>
                                        <div class="agent-avatar"><img src="<?php echo $agent->get_avatar_url(); ?>"/></div>
                                        <h3 class="agent-name"><?php echo $agent->full_name; ?></h3>
                                    </div>
                                </div>
                            <?php
                                }
                            }
                            ?>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		  <button type="submit" class="os-custom-field-save-btn latepoint-btn latepoint-btn-primary"><span><?php _e('Save', 'latepoint-conditions'); ?></span></button>
		</div>
	</div>
	<?php echo OsFormHelper::hidden_field('condition[id]', $condition['id'], ['class' => 'os-custom-field-id', 'id' => 'id_' . $condition['id']]); ?>
    <a href="#" data-os-prompt="<?php _e('Are you sure you want to remove this field?', 'latepoint-conditions'); ?>"  data-os-after-call="latepoint_custom_field_removed" data-os-pass-this="yes" data-os-action="<?php echo OsRouterHelper::build_route_name('conditions', 'delete'); ?>" data-os-params="<?php echo OsUtilHelper::build_os_params(['id' => $condition['id']]) ?>" class="os-remove-custom-field"><i class="latepoint-icon latepoint-icon-cross"></i></a>
</form>
