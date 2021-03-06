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
global $CFG, $USER, $DB, $PAGE, $OUTPUT;
require_once('../config.php');

$PAGE->set_context(CONTEXT_SYSTEM::instance());
$PAGE->set_url("$CFG->wwwroot/local/roomsupport/ajax/dashboard.php");

$action = required_param('action', PARAM_TEXT);

switch ($action) {
    case 'getInfo':
        $id = required_param('id', PARAM_INT);
        $campusId = required_param('campusid', PARAM_INT);
        $PI = new \local_roomsupport\RaspberryPi($id);
        $FAQS = new \local_roomsupport\Faqs($campusId);

        If ($PI->getIgnoreDevice() == true) {
            $ignoreYes = true;
            $ignoreNo = false;
        } else {
            $ignoreYes = false;
            $ignoreNo = true;
        }

        $faqs = $FAQS->getResults();
        $faqArray = [];
        $i = 0;
        foreach ($faqs as $f) {
            $faqArray[$i]['id'] = $f->id;
            $faqArray[$i]['name'] = $f->name;
            $i++;
        }
        $data = [];
        $data['buildingid'] = $PI->getBuildingId();
        $data['roomid'] = $PI->getRoomId();
        $data['faqid'] = $PI->getFaqId();
        $BUILDING = new \local_roomsupport\Building($PI->getBuildingId());
        $data['rooms'] = \local_roomsupport\Base::getRooms($BUILDING->getBuildingId());
        $data['faqs'] = $faqArray;
        $data['ignoreno'] = $ignoreNo;
        $data['ignoreyes'] = $ignoreYes;

        echo json_encode($data);
        break;

    case 'save':
        $id = required_param('id', PARAM_INT);
        $buildingId = optional_param('buildingid', '', PARAM_TEXT);
        $roomId = optional_param('roomid', '', PARAM_TEXT);
        $faqId = required_param('faqid', PARAM_INT);
        $ignoreDevice = required_param('ignoredevice', PARAM_INT);

        $data = [];
        $data['id'] = $id;
        $data['userid'] = $USER->id;
        $data['buildingid'] = $buildingId;
        $data['roomid'] = $roomId;
        $data['faqid'] = $faqId;
        $data['ignoredevice'] = $ignoreDevice;

        $PI = new \local_roomsupport\RaspberryPi($id);
        $PI->update($data);

        $PIS = new \local_roomsupport\RaspberryPis();
        break;
    case 'delete' :
        $id = required_param('id', PARAM_INT);
        $PI = new \local_roomsupport\RaspberryPi($id);
        $PI->delete();
        break;
    case 'reboot':
        $id = required_param('id', PARAM_INT);
        $PI = new \local_roomsupport\RaspberryPi($id);
        $connection = ssh2_connect($PI->getIp());
        ssh2_auth_password($connection, trim($PI->getPiUserName()), trim($PI->getPiPassword()));
        ssh2_exec($connection, '/sbin/reboot');
        echo true;
        break;
    case 'reload':
        $output = $PAGE->get_renderer('local_roomsupport');
        $dashboard = new \local_roomsupport\output\dashboard();
        echo $output->render_dashboard($dashboard);
        break;
    case 'getRooms':
        $buildingId = optional_param('buildingid', 0, PARAM_INT);
        $BUILDING = new \local_roomsupport\Building($buildingId);
        echo json_encode(\local_roomsupport\Base::getRooms($BUILDING->getBuildingId()));
        break;
    case 'getFaqs':
        $buildingId = optional_param('buildingid', 0, PARAM_INT);
        $FAQS = new \local_roomsupport\Faqs($buildingId);
        $faqs = $FAQS->getResults();
        $faqArray = [];
        $i = 0;
        foreach ($faqs as $f) {
            $faqArray[$i]['id'] = $f->id;
            $faqArray[$i]['name'] = $f->name;
            $i++;
        }
        echo json_encode($faqArray);
        break;
    case 'deleteBuilding' :
        $id = required_param('id', PARAM_INT);
        $BUILDING = new \local_roomsupport\Building($id);
        $BUILDING->delete();
        break;
}


