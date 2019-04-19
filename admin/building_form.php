<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The main location configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package    buildings
 * @copyright  2013 Oohoo IT Services Inc.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->dirroot/lib/formslib.php");

/**
 * Module instance settings form
 */
class building_form extends moodleform {

    function definition() {

        global $CFG, $USER, $DB;
        $formdata = $this->_customdata['formdata'];
        $mform = & $this->_form;

        $buildings = $DB->get_records('buildings_building', ['campusid' => $formdata->campusid]);
        
        $buildingsArray = [];
        foreach($buildings as $b) {
            $buildingsArray[$b->id] = $b->name . ' (' . $b->shortname . ')';
        }

//-------------------------------------------------------------------------------
// Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('building', 'local_roomsupport'));
        $mform->addElement("hidden", "id");
        $mform->setType("id", PARAM_INT);
        $mform->addElement("hidden", "campusid");
        $mform->setType("campusid", PARAM_INT);
        
        //Building select
        $mform->addElement('select', 'buildingid', get_string('building', 'local_roomsupport'),$buildingsArray);
        $mform->addHelpButton("buildingid", 'building','local_roomsupport');
        $mform->setType("buildingid", PARAM_INT);
        $mform->addRule('buildingid', get_string('required_field', 'local_roomsupport'), 'required');
        
        //Pi settings
        $mform->addElement('header', 'pi_settings', get_string('raspberry_pi_settings', 'local_roomsupport'));
        //Pi username
        $mform->addElement('text', 'pi_username', get_string('username', 'local_roomsupport'),$buildingsArray);
        $mform->addHelpButton("pi_username", 'username','local_roomsupport');
        $mform->setType("pi_username", PARAM_TEXT);
        
        //Pi Password
        $mform->addElement('passwordunmask', 'pi_password', get_string('password', 'local_roomsupport'),$buildingsArray);
        $mform->addHelpButton("pi_password", 'password','local_roomsupport');
        $mform->setType("pi_password", PARAM_TEXT);
            
         //Service hours settings
        $mform->addElement('header', 'service_hours_settings', get_string('service_hours', 'local_roomsupport'));
        $mform->setExpanded('service_hours_settings');
        //Service hours
        $mform->addElement('textarea', 'service_hours', get_string('service_hours', 'local_roomsupport'),$buildingsArray);
        $mform->addHelpButton("service_hours", 'service_hours','local_roomsupport');
        $mform->setType("service_hours", PARAM_TEXT);
        $mform->addRule('service_hours', get_string('required_field', 'local_roomsupport'), 'required');
        
         //Agent  settings
        $mform->addElement('header', 'agent_settings', get_string('agents', 'local_roomsupport'));
        $mform->setExpanded('service_hours_settings');
        //Agent
        $agentSelect = $mform->addElement('select', 'agents', get_string('agents', 'local_roomsupport'), \local_roomsupport\Base::getListOfAgents());
        $agentSelect->setMultiple(true);
        $mform->addHelpButton("agents", 'agents','local_roomsupport');
        $mform->setType("agents", PARAM_INT);
        $mform->addRule('agents', get_string('required_field', 'local_roomsupport'), 'required');


//-------------------------------------------------------------------------------
// add standard buttons, common to all modules
        $this->add_action_buttons();

// set the defaults
        $this->set_data($formdata);
    }

}
