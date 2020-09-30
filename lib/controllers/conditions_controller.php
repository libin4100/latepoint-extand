<?php
if(!defined('ABSPATH')) {
    exit;
}

if(!class_exists('OsConditionsController')):
class OsConditionsController extends OsController {
    public function __construct() {
        parent::__construct();

        $this->views_folder = plugin_dir_path( __FILE__ ) . '../views/conditions/';
    }

    public function index() {
        $conditions = $this->_getFromSettings();

        $this->_vars();
        $this->vars['page_header'] = 'Conditions';
        $this->vars['conditions'] = $conditions;
        $this->format_render(__FUNCTION__);
    }

    public function new_form() {
        $this->_vars();
        $this->vars['condition'] = [
            'id' => $this->_genId(), 
            'label' => '', 
            'type' => '', 
            'placeholder' => '',
            'agents' => []
        ];
        $this->set_layout('none');
        $this->format_render(__FUNCTION__);
    }

    public function save() {
        if($condition = $this->params['condition']) {
            $condition['custom_fields'] = array_filter($condition['custom_fields']);
            if(!$condition['custom_fields']) {
                $status = LATEPOINT_STATUS_ERROR;
                $response = __('Invalid Custom Fields', 'latepoint-conditions');
            } else {
                $agents = [];
                foreach($condition['agents'] as $agentId => $v) {
                    if($v == 'yes') $agents[] = $agentId;
                }
                if(!$agents) {
                    $status = LATEPOINT_STATUS_ERROR;
                    $response = __('Invalid Agents', 'latepoint-conditions');
                } else {
                    $condition['agents'] = $agents;

                    $conditions = $this->_getFromSettings();
                    if(!isset($condition['id']) || !$condition['id']) {
                        $condition['id'] = $this->_genId($conditions);
                    }

                    $conditions[$condition['id']] = $condition;

                    if(OsSettingsHelper::save_setting_by_name('latepoint-conditions', json_encode($conditions))) {
                        $status = LATEPOINT_STATUS_SUCCESS;
                        $response = __('Condition Saved', 'latepoint-conditions');
                    } else {
                        $status = LATEPOINT_STATUS_ERROR;
                        $response = __('Error Saving Condition', 'latepoint-conditions');
                    }
                }
            }
        } else {
            $status = LATEPOINT_STATUS_ERROR;
            $response = __('Invalid Params', 'latepoint-conditions');
        }
        if($this->get_return_format() == 'json') {
            $this->send_json(['status' => $status, 'message' => $response]);
        }
    }

    public function delete() {
        if(isset($this->params['id']) && !empty($this->params['id'])) {
            $conditions = $this->_getFromSettings();
            if(isset($conditions[$this->params['id']])) {
                unset($conditions[$this->params['id']]);
                
                if(OsSettingsHelper::save_setting_by_name('latepoint-conditions', json_encode($conditions))) {
                    $status = LATEPOINT_STATUS_SUCCESS;
                    $response = __('Condition Removed', 'latepoint-conditions');
                } else {
                    $status = LATEPOINT_STATUS_ERROR;
                    $response = __('Error Removing Condition', 'latepoint-conditions');
                }
            } else {
                $status = LATEPOINT_STATUS_ERROR;
                $response = __('Invalid Field ID', 'latepoint-conditions');
            }
        } else {
            $status = LATEPOINT_STATUS_ERROR;
            $response = __('Invalid Field ID', 'latepoint-conditions');
        }
        if($this->get_return_format() == 'json') {
            $this->send_json(['status' => $status, 'message' => $response]);
        }
    }

    protected function _vars() {
        $this->vars['custom_fields_for_booking'] = OsCustomFieldsHelper::get_custom_fields_arr('booking', 'customer');

        $agents = new OsAgentModel();
        $this->vars['agents'] = $agents->get_results_as_models();
    }

    protected function _getFromSettings() {
        $conditions = [];
        $setting = OsSettingsHelper::get_settings_value('latepoint-conditions', false);
        if($setting) {
            $conditions = json_decode($setting, true);
        }
        return $conditions;
    }

    protected function _genId($conditions = null) {
        !$conditions && $conditions = $this->_getFromSettings();
        do {
            $id = OsCustomFieldsHelper::generate_custom_field_id();
        } while(isset($conditions[$id]));

        return $id;
    }
}
endif;