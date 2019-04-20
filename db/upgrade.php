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
 * *************************************************************************
 * *                        Room Support System                          **
 * *************************************************************************
 * @package     local                                                     **
 * @subpackage  roomsupport                                               **
 * @name        Room Support System                                      **
 * @copyright   Glendon ITS - York University                             **
 * @link                                                                  **
 * @author      Patrick Thibaudeau                                        **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */
defined('MOODLE_INTERNAL') || die();

/**
 * Execute local_roomsupport upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_local_roomsupport_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2019041900) {

        // Define field buildingid to be added to local_roomsupport_rpi.
        $table = new xmldb_table('local_roomsupport_rpi');
        $field = new xmldb_field('buildingid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'id');

        // Conditionally launch add field buildingid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field roomid to be added to local_roomsupport_rpi.
        $table = new xmldb_table('local_roomsupport_rpi');
        $field = new xmldb_field('roomid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'buildingid');

        // Conditionally launch add field roomid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define table local_roomsupport_buildings to be created.
        $table = new xmldb_table('local_roomsupport_buildings');

        // Adding fields to table local_roomsupport_buildings.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('campusid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('buildingid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('pi_username', XMLDB_TYPE_CHAR, '255', null, null, null, 'pi');
        $table->add_field('pi_password', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('ticketing_url', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('ticketing_email', XMLDB_TYPE_CHAR, '1333', null, null, null, 'askit@yorku.ca');
        $table->add_field('service_hours', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('cell_numbers', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '20', null, null, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '20', null, null, null, '0');

        // Adding keys to table local_roomsupport_buildings.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for local_roomsupport_buildings.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Selfservehd savepoint reached.
        upgrade_plugin_savepoint(true, 2019041900, 'local', 'roomsupport');
    }

    if ($oldversion < 2019041902) {

        // Define field buildingid to be added to local_roomsupport_faq.
        $table = new xmldb_table('local_roomsupport_faq');
        $field = new xmldb_field('buildingid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'id');

        // Conditionally launch add field buildingid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define table local_roomsupport_agent to be created.
        $table = new xmldb_table('local_roomsupport_agent');

        // Adding fields to table local_roomsupport_agent.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, null, null, '0');
        $table->add_field('paramid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('param_type', XMLDB_TYPE_INTEGER, '1', null, null, null, '1');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '20', null, null, null, '0');

        // Adding keys to table local_roomsupport_agent.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for local_roomsupport_agent.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Roomsupport savepoint reached.
        upgrade_plugin_savepoint(true, 2019041902, 'local', 'roomsupport');
    }

    if ($oldversion < 2019042000) {

        // Rename field buildingid on table local_roomsupport_faq to NEWNAMEGOESHERE.
        $table = new xmldb_table('local_roomsupport_faq');
        $field = new xmldb_field('buildingid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'id');

        // Launch rename field buildingid.
        $dbman->rename_field($table, $field, 'campusid');

        // Roomsupport savepoint reached.
        upgrade_plugin_savepoint(true, 2019042000, 'local', 'roomsupport');
    }
    return true;
}
