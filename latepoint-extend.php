<?php
/**
 * Plugin Name: Latepoint Addon - Conditions
 * Plugin URI: http://www.mywebsite.com/my-first-plugin
 * Description: Latepoint extension for custom setting
 * Version: 1.0
 * Author: Your Name
 * Author URI: http://www.mywebsite.com
 */

if(!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


if(!class_exists('LatePointExt')):
/**
 * Main Class.
 *
 */
final class LatePointExt {
    public $version = '1.0.0';
    public $dbVersion = '1.0.0';
    public $addonName = 'latepoint-extend';

    public function __construct() {
        $this->defines();
        $this->hooks();
    }

    public function defines() {
    }

    public function hooks() {
        add_action('latepoint_includes', [$this, 'includes']);
        add_action('latepoint_load_step', [$this, 'loadStep'], 10, 3);
        add_action('latepoint_process_step', [$this, 'processStep'], 10, 2);
        add_action('latepoint_admin_enqueue_scripts', [$this, 'adminScripts']);
        add_action('latepoint_model_save', [$this, 'saveAgent']);
        add_action('latepoint_booking_quick_edit_form_after',[$this, 'outputQuickForm']);
        add_action('latepoint_step_confirmation_head_info_before',[$this, 'confirmationInfoBefore']);
        add_action('latepoint_step_confirmation_head_info_after',[$this, 'confirmationInfoAfter']);

        add_filter('latepoint_installed_addons', [$this, 'registerAddon']);
        add_filter('latepoint_side_menu', [$this, 'addMenu']);

        register_activation_hook(__FILE__, [$this, 'onActivate']);
        register_deactivation_hook(__FILE__, [$this, 'onDeactivate']);
    }

    public function includes() {
        include_once(dirname( __FILE__ ) . '/lib/controllers/conditions_controller.php');
    }

    public function loadStep($stepName, $bookingObject, $format = 'json') {
        if($stepName == 'contact') {
            if(OsSettingsHelper::get_settings_value('latepoint-disabled_customer_login'))
                OsAuthHelper::logout_customer();
        }
        if($stepName == 'confirmation') {
            $defaultAgents = OsAgentHelper::get_agents_for_service_and_location($bookingObject->service_id, $bookingObject->location_id);
            $availableAgents = [];
            if($bookingObject->start_date && $bookingObject->start_time) {
                foreach($defaultAgents as $agent) {
                    if(OsAgentHelper::is_agent_available_on($agent,
                        $bookingObject->start_date,
                        $bookingObject->start_time,
                        $bookingObject->get_total_duration(),
                        $bookingObject->service_id,
                        $bookingObject->location_id,
                        $bookingObject->total_attendies)) {

                        $availableAgents[] = $agent;
                    }
                }
            }
            $availableAgents = $availableAgents ?: $defaultAgents;

            $agents = [];
            $setting = OsSettingsHelper::get_settings_value('latepoint-conditions', false);
            if($setting) {
                $conditions = json_decode($setting);
                if($conditions) {
                    foreach($conditions as $condition) {
                        if($condition->operator == 'and') {
                            $check = true;
                            foreach($condition->custom_fields as $key => $cf) {
                                if($bookingObject->custom_fields[$key] != $cf) $check = false;
                            }
                        } elseif($condition->operator == 'or') {
                            $check = false;
                            foreach($condition->custom_fields as $key => $cf) {
                                if($bookingObject->custom_fields[$key] == $cf) $check = true;
                            }
                        }
                        if($check == true) {
                            $agents += $condition->agents;
                        }
                    }
                }
            }
            if($availableAgents)
                $agents = array_intersect($agents, $availableAgents);

            if($agents) {
                $bookingObject->agent_id = array_shift($agents);
                if($agents) $bookingObject->agents = json_encode($agents);
            }
        }
    }

    public function saveAgent($model) {
        if($model->is_new_record()) return;

        if($model instanceof OsBookingModel) {
            if($model->agents) {
                $model->save_meta_by_key('extra_agents', $model->agents);

                foreach($model->agents as $id) {
                    $agent = new OsAgentModel($id);

                    if((OsSettingsHelper::get_settings_value('notifications_email') == 'on') &&
                        (OsSettingsHelper::get_settings_value('notification_agent_confirmation') == 'on')) {

                        $agentMailer = new OsAgentMailer();
                        $agentMailer->new_booking_notification($agent, $model);
                    }
                    if(OsSettingsHelper::is_sms_notifications_enabled() &&
                        (OsSettingsHelper::get_settings_value('notification_sms_agent_confirmation') == 'on')) {

                        $agentSmser = new OsAgentSmser();
                        $agentSmser->new_booking_notification($agent, $model);
                    }
                }
            }
        }
    }

    public function outputQuickForm($booking) {
        echo '<div class="os-row">';
        $agents = $booking->get_meta_by_key('extra_agents');
        if($agents) {
            echo '<div class="os-col-12"><h3>' . __('Extra Agents', 'latepoint-conditions') . '</h3></div>';
            $agents = json_decode($agents);
            foreach($agents as $id) {
                $agent = new OsAgentModel($id);
                echo '<div class="os-col-12">' . OsAgentHelper::get_full_name($agent) . '</div>';
            }
        }
        echo '</div>';
    }

    public function confirmationInfoBefore($booking) {
    }

    public function confirmationInfoAfter($booking) {
        $button = json_decode(OsSettingsHelper::get_settings_value('latepoint-button_confirmation', '[]'));
        if($button && $button->text && $button->link) {
            echo '<a href="' . $button->link . '" target="_blank" class="latepoint-btn latepoint-btn-primary" data-label="' . $button->text . '"><span>' . $button->text . '</span></a>';
        }
    }

    public function adminScripts() {
        $jsFolder = plugin_dir_url( __FILE__ ) . 'public/js/';
        wp_enqueue_script('latepoint-conditions',  $jsFolder . 'admin.js', array('jquery'), $this->version);
    }

    public function registerAddon($installedAddons) {
        $installedAddons[] = ['name' => $this->addonName, 'db_version' => $this->dbVersion, 'version' => $this->version];
        return $installedAddons;
    }

    public function addMenu($menus) {
        if(!OsAuthHelper::is_admin_logged_in()) return $menus;
        $menus[] = ['id' => 'condition_filter', 'label' => __('Conditions', 'latepoint-extend'), 'icon' => 'latepoint-icon latepoint-icon-layers', 'link' => OsRouterHelper::build_link(['conditions', 'index'])];
        return $menus;
    }
    public function onDeactivate() {
    }

    public function onActivate() {
        if(class_exists('OsDatabaseHelper')) OsDatabaseHelper::check_db_version_for_addons();
    }
}
endif;

if(in_array('latepoint/latepoint.php', get_option('active_plugins', [])) || array_key_exists('latepoint/latepoint.php', get_site_option('active_sitewide_plugins', []))) {
    $LATEPOINTEXT = new LatePointExt();
}
