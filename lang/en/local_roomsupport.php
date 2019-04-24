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

$string['actions'] = 'Actions';
$string['add_building'] = 'Add building';
$string['adding_building_to'] = 'Adding a building to campus: ';
$string['agent'] = 'Agent';
$string['agents'] = 'Agents';
$string['agents_help'] = 'Select agents that will be service rooms in this building';
$string['agent_has_been_called'] = 'A notification has been sent to the call center. Waiting for an agent to reply.';
$string['agent_on_the_way'] = 'will be serving you within 5 minutes.';
$string['agent_panel'] = 'Agent panel';
$string['agent_phone_numbers'] = 'Agent cell phone numbers';
$string['agent_phone_numbers_help'] = 'Enter you agents cell phone numers. Seperate each numer with a comma.';
$string['assign_to_building'] = 'Assign to building';
$string['assign_to_room'] = 'Assign to room';
$string['associated_faq'] = 'Associated FAQ';
$string['average_time_to_reply'] = 'Average time to reply';
$string['building'] = 'Building';
$string['building_help'] = 'Select a building form the list of buildings.';
$string['buildings'] = 'Buildings';
$string['building_abbreviation'] = 'Build short name';
$string['building_name'] = 'Building name';
$string['calls_per_room'] = 'Calls per room';
$string['cancel'] = 'Cancel';
$string['cannotaccesssystem'] = 'You don have permission to access this system.';
$string['change'] = 'Change';
$string['change_campus'] = 'Change campus';
$string['close'] = 'Close';
$string['dashboard'] = 'Dashboard';
$string['default_campus'] = 'Default campus';
$string['default_campus_help'] = 'Select a default campus to be used when logging into the system.';
$string['default_settings'] = 'Default settings';
$string['delete'] = 'Delete';
$string['delete_building_confirmation'] = 'Are you sure you want to delete this building? '
        . 'This will unassign all devices and delete all logs associated with this building. '
        . '<span style="color:red; font-weight: bold;">The data will be lost and unrecoverable.</span>';
$string['delete_confirmation'] = 'Are you sure you want to delete this device? If it is still on the network and communicationg with this server, it will be recreated.';
$string['delete_faq_confirmation'] = 'Are you sure you want to delete this faq entry? This cannot be undone.';
$string['details'] = 'Details';
$string['edit'] = 'Edit';
$string['editing_building'] = 'Editing building: ';
$string['end_time'] = 'End time';
$string['end_time_help'] = 'WRITE ACTUAL INSTRUCTIONS';
$string['faqs'] = 'FAQs';
$string['faq'] = 'FAQ';
$string['help'] = 'Help!';
$string['id'] = 'Id #';
$string['in_coming_requests'] = 'Incoming requests';
$string['ip_address'] = 'IP Address';
$string['it_works'] = 'It works!';
$string['logs'] = 'Logs';
$string['longest_time_to_reply'] = 'Longest';
$string['mac_address'] = 'MAC Address';
$string['message'] = 'Message';
$string['message_en'] = 'Message (English)';
$string['message_fr'] = 'Message (Français)';
$string['name'] = 'Name';
$string['new_template'] = 'New template';
$string['no_agent_assigned'] = 'No agent assign';
$string['no_permission'] = 'You do not have the permission to view this page.';
$string['no_site_url_defined'] = 'No site url defined';
$string['number_of_calls_answered'] = 'Number of calls answered by agent';
$string['on_my_way'] = 'On my way';
$string['password'] = 'Password';
$string['password_help'] = 'Your Raspberry pi user password';
$string['pluginname'] = 'Room Support System';
$string['raspberry_pi_settings'] = 'Raspberry Pi Settings';
$string['reboot'] = 'Reboot';
$string['redirect_users'] = 'Redirect users';
$string['redirect_users_help'] = 'If checked, users will be automatically redirected to the Self Serve dashboard page when they log in.';
$string['required_field'] = 'This field is required';
$string['requires_assistance'] = 'Requires assistance';
$string['request_help_fr'] = 'Aide';
$string['request_help_en'] = 'Help';
$string['requested_at'] = 'Requested at';
$string['response_times'] = 'Response times';
$string['room'] = 'Room';
$string['room_number'] = 'Room number';
$string['room_not_set'] = 'Room not set';
$string['save'] = 'Save';
$string['search'] = 'Search';
$string['service_hours'] = 'Service hours';
$string['statistics'] = 'Statistics';
$string['status'] = 'Status';
$string['roomsupport:admin'] = 'Room Support System Administrator';
$string['roomsupport:agent'] = 'Room Support System Agent';
$string['roomsupport:rpi'] = 'Raspberry PI access';
$string['service_hours'] = 'Service hours';
$string['service_hours_help'] = 'You can add the hours your service is available here. When your services are not available, the "help button'
        . ' On the Raspberry Pi will not be available either. To write your hours, you must follow the naming convention:<br>'
        . 'Days are identified as letters: U=Sunday, M=Monday, T=Tuesday,W=Wednesday,R=Thursday,F=Friday,S=Saturday<br><br>'
        . 'Example 1. Open Monday to Friday from 8:30 AM to 12:30 PM, 1:30 PM to 5:30 PM and 6:00PM to 9:00 PM and again on Saturday from 9:00 AM to 3:00 PM<br>'
        . '<br><code>'
        . 'M-F=8:30-12:30,13:30-17:30,18:00-21:00<br>'
        . 'S=9:00-15:00'
        . '</code><br><br>'
        . 'Note that must write the time using the 24 hour format. Also, add a new line for each new day<br><br>'
        . 'Example 2. Open Monday, Wednesday and Friday from 8:30 AM to 4:30 PM. Open Tuesday and Thursday from 10:00 AM to 9:00 PM'
        . ' and Saturday from 9:00 AM to 3:00 PM<br>'
        . '<br><code>'
        . 'M,W,F=8:30-16:30<br>'
        . 'T,R,F=10:00-21:00<br>'
        . 'S=9:00-15:00'
        . '</code><br><br>'
        . 'Note the commas seperating the days.';
$string['services_closed'] = 'Service desk is currently closed.';
$string['shortest_time_to_reply'] = 'Fastest';
$string['sms_settings'] = 'SMS Settings';
$string['sms_apikey'] = 'API Key';
$string['sms_apikey_help'] = 'Enter the API Key for Swith SMS Gateway (https://smsgateway.ca)';
$string['ticket_system_email'] = 'Ticketing system email';
$string['ticket_system_email_help'] = 'Enter the email used by your ticketing system to recieve/open tickets.';
$string['ticketing_system'] = 'Ticketing system';
$string['ticketing_system_url'] = 'Ticketing system url';
$string['ticketing_system_url_help'] = 'AThis site is used on the agent page. Usually, this would be a ticketing system.';
$string['timeclosed'] = 'Time closed';
$string['timecreated'] = 'Time created';
$string['timereplied'] = 'Time replied';
$string['token'] = 'Token';
$string['token_help'] = 'Enter the token for the web service created in this instance of Moodle';
$string['total_calls'] = 'Total calls made';
$string['unanswered'] = 'Unanswered';
$string['unassigned_devices'] = 'Unassigned devices';
$string['username'] = 'Username';
$string['username_help'] = 'Raspberry Pi username. Please use the same name/password combination for all your Raspberry Pi\'s';
$string['view_all'] = 'View all';
$string['view_campus'] = 'View campus';

