<?php

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_roomsupport', get_string('pluginname', 'local_roomsupport'));

    $ADMIN->add('localplugins', $settings);
    $settings->add(new admin_setting_heading('defaults_heading', get_string('default_settings', 'local_roomsupport'), ''));

//Use automatic redirection
    $name = 'roomsupport_auto_redirect';
    $text = get_string('redirect_users', 'local_roomsupport');
    $help = get_string('redirect_users_help', 'local_roomsupport');
    $params = '';
    $settings->add(new admin_setting_configcheckbox($name, $text, $help, '0'));
    
    //Get campuses
    $campuses = $DB->get_records('buildings_campus');
    $campusArray = [];
    foreach ($campuses as $c) {
        $campusArray[$c->id] = $c->name;
    }
    $name = 'roomsupport_default_campus';
    $text = get_string('default_campus', 'local_roomsupport');
    $help = get_string('default_campus_help', 'local_roomsupport');
    $params = '';
    $settings->add(new admin_setting_configselect($name, $text, $help, null, $campusArray));
    
    $settings->add(new admin_setting_heading('raspberrypi_heading', get_string('raspberry_pi_settings', 'local_roomsupport'), ''));

    //Pi User name
    $name = 'roomsupport_pi_username';
    $text = get_string('username', 'local_roomsupport');
    $help = get_string('username_help', 'local_roomsupport');
    $params = '';
    $settings->add(new admin_setting_configtext($name, $text, $help, 'pi', PARAM_TEXT));

//Pi password
    $name = 'roomsupport_pi_password';
    $text = get_string('password', 'local_roomsupport');
    $help = get_string('password_help', 'local_roomsupport');
    $params = '';
    $settings->add(new admin_setting_configpasswordunmask($name, $text, $help, '', PARAM_TEXT));

//Token
    $name = 'roomsupport_pi_token';
    $text = get_string('token', 'local_roomsupport');
    $help = get_string('token_help', 'local_roomsupport');
    $params = '';
    $settings->add(new admin_setting_configtext($name, $text, $help, '', PARAM_TEXT));

//Heading
    $name = get_string('ticketing_system', 'local_roomsupport');
    $settings->add(new admin_setting_heading('roomsupport_ticketing', $name, ''));

//Agent iframe site
    $name = 'roomsupport_agent_site';
    $text = get_string('ticketing_system_url', 'local_roomsupport');
    $help = get_string('ticketing_system_url_help', 'local_roomsupport');
    $params = '';
    $settings->add(new admin_setting_configtext($name, $text, $help, '', PARAM_TEXT));

//Agent iframe site
    $name = 'roomsupport_email_send';
    $text = get_string('ticket_system_email', 'local_roomsupport');
    $help = get_string('ticket_system_email_help', 'local_roomsupport');
    $params = '';
    $settings->add(new admin_setting_configtext($name, $text, $help, '', PARAM_TEXT));

//Heading
    $name = get_string('service_hours', 'local_roomsupport');
    $settings->add(new admin_setting_heading('roomsupport_service_hours', $name, ''));

//Agent Service hours
    $name = 'roomsupport_service_hours';
    $text = get_string('service_hours', 'local_roomsupport');
    $help = get_string('service_hours_help', 'local_roomsupport');
    $params = '';
    $settings->add(new admin_setting_configtextarea($name, $text, $help, '', PARAM_RAW));

//Heading
    $name = get_string('sms_settings', 'local_roomsupport');
    $settings->add(new admin_setting_heading('roomsupport_sms_settings', $name, ''));

//SMS service url
    $name = 'roomsupport_sms_apikey';
    $text = get_string('sms_apikey', 'local_roomsupport');
    $help = get_string('sms_apikey_help', 'local_roomsupport');
    $params = '';
    $settings->add(new admin_setting_configtextarea($name, $text, $help, '', PARAM_RAW));

//SMS agent numbers
    $name = 'roomsupport_sms_agent_numbers';
    $text = get_string('agent_phone_numbers', 'local_roomsupport');
    $help = get_string('agent_phone_numbers_help', 'local_roomsupport');
    $params = '';
    $settings->add(new admin_setting_configtextarea($name, $text, $help, '', PARAM_RAW));
}