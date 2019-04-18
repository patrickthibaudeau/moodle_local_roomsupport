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
$PAGE->set_url("$CFG->wwwroot/local/roomsupport/ajax/agent.php");

$action = required_param('action', PARAM_TEXT);

switch ($action) {
    case 'check' :
        $output = $PAGE->get_renderer('local_roomsupport');
        $faq_alerts = new \local_roomsupport\output\faq_alerts();
        echo $output->render_faq_alerts($faq_alerts);
        break;
    case 'onmyway':
        $id = required_param('id', PARAM_INT);
        $data = [];
        $data['id'] = $id;
        $data['agentid'] = $USER->id;
        $data['timereplied'] = time();
        echo json_encode($data);
        $FAQALERT = new \local_roomsupport\FaqAlert($id);
        $FAQALERT->update($data);
        break;
                
}


