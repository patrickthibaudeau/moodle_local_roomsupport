<?php

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
 * Web service local plugin template external functions and service definitions.
 *
 * @package    local_faculty_profile
 * @copyright  2015 Glendon
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// We defined the web service functions to install.
$functions = array(
    'roomsupport_get_raspberry_pi' => array(
        'classname' => 'local_roomsupport_external',
        'methodname' => 'get_raspberry_pi',
        'classpath' => 'local/roomsupport/externallib.php',
        'description' => 'Set MAC address',
        'type' => 'read',
        'capabilities' => 'local/roomsupport:rpi'
    ),
    'roomsupport_get_help_call' => array(
        'classname' => 'local_roomsupport_external',
        'methodname' => 'get_help_call',
        'classpath' => 'local/roomsupport/externallib.php',
        'description' => 'Call help',
        'type' => 'read',
        'capabilities' => 'local/roomsupport:rpi'
    ),
    'roomsupport_call_answered' => array(
        'classname' => 'local_roomsupport_external',
        'methodname' => 'call_answered',
        'classpath' => 'local/roomsupport/externallib.php',
        'description' => 'Agent pressed the button to answer the call',
        'type' => 'read',
        'capabilities' => 'local/roomsupport:rpi'
    ),
    'roomsupport_update_status' => array(
        'classname' => 'local_roomsupport_external',
        'methodname' => 'update_status',
        'classpath' => 'local/roomsupport/externallib.php',
        'description' => 'Agent pressed the button at the raspberry pi',
        'type' => 'read',
        'capabilities' => 'local/roomsupport:rpi'
    ),
    'roomsupport_check_status' => array(
        'classname' => 'local_roomsupport_external',
        'methodname' => 'check_status',
        'classpath' => 'local/roomsupport/externallib.php',
        'description' => 'Verifies if agent has replied to the call',
        'type' => 'read',
        'capabilities' => 'local/roomsupport:rpi'
    ),
    'roomsupport_service_open' => array(
        'classname' => 'local_roomsupport_external',
        'methodname' => 'service_open',
        'classpath' => 'local/roomsupport/externallib.php',
        'description' => 'Verifies call centre is open',
        'type' => 'read',
        'capabilities' => 'local/roomsupport:rpi'
    ),
);
