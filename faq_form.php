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
class faq_form extends moodleform {

    function definition() {

        global $CFG, $USER, $DB;
        $formdata = $this->_customdata['formdata'];
        $mform = & $this->_form;
        
        $context = context_system::instance();

//-------------------------------------------------------------------------------
// Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'local_buildings'));
        $mform->addElement("hidden", "id");
        $mform->setType("id", PARAM_INT);
        
        /** Name **/
        $mform->addElement('text', 'name', get_string('name', 'local_roomsupport'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', get_string('required_field', 'local_roomsupport'),  'required');
        
        /** Message English**/
        $mform->addElement('editor', 'message_field_en', get_string('message_en', 'local_roomsupport'), null,\local_roomsupport\Base::getEditorOptions($context));
        $mform->setType('message_field_en', PARAM_RAW);
        $mform->addRule('message_field_en', get_string('required_field', 'local_roomsupport'),  'required');
        
        /** MessageFrench **/
        $mform->addElement('editor', 'message_field_fr', get_string('message_fr', 'local_roomsupport'), null,\local_roomsupport\Base::getEditorOptions($context));
        $mform->setType('message_field_fr', PARAM_RAW);
        $mform->addRule('message_field_fr', get_string('required_field', 'local_roomsupport'),  'required');


//-------------------------------------------------------------------------------
// add standard buttons, common to all modules
        $this->add_action_buttons();

// set the defaults
        $this->set_data($formdata);
    }

}
