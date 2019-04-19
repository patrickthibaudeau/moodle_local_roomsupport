<?php
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

require_once(dirname(__FILE__) . '../../../config.php');
//require_once('locallib.php');
define('PARAM_TYPE_BUILDING', 1);
define('PARAM_TYPE_DEVICE', 2);

require_once($CFG->dirroot . '/local/roomsupport/classes/Base.php');
require_once($CFG->dirroot . '/local/roomsupport/classes/Building.php');
require_once($CFG->dirroot . '/local/roomsupport/classes/Buildings.php');
require_once($CFG->dirroot . '/local/roomsupport/classes/Device.php');
require_once($CFG->dirroot . '/local/roomsupport/classes/Devices.php');
require_once($CFG->dirroot . '/local/roomsupport/classes/Faq.php');
require_once($CFG->dirroot . '/local/roomsupport/classes/Faqs.php');
require_once($CFG->dirroot . '/local/roomsupport/classes/FaqAlert.php');
require_once($CFG->dirroot . '/local/roomsupport/classes/FaqAlerts.php');
require_once($CFG->dirroot . '/local/roomsupport/classes/RaspberryPi.php');
require_once($CFG->dirroot . '/local/roomsupport/classes/RaspberryPis.php');
require_once($CFG->dirroot . '/local/roomsupport/classes/Statistics.php');
