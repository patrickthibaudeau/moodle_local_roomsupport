<?php

require_once('../config.php');
include("building_form.php");

/**
 * Display the content of the page
 * @global stdClass $CFG
 * @global moodle_database $DB
 * @global core_renderer $OUTPUT
 * @global moodle_page $PAGE
 * @global stdClass $SESSION
 * @global stdClass $USER
 */
function display_page() {
    // CHECK And PREPARE DATA
    global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $USER;
    $COURSE;

    require_login(1, FALSE);

    //Set principal parameters
    $context = CONTEXT_SYSTEM::instance();

    if (!has_capability('local/roomsupport:admin', $context)) {
        redirect($CFG->wwwroot, get_string('no_permission', 'local_room_support'), 5);
    }

    $id = optional_param('id', 0, PARAM_INT);
    $campusid = optional_param('campusid', 0, PARAM_INT);

    if ($id) {
        $formdata = $DB->get_record('local_roomsupport_buildings', array('id' => $id), '*', MUST_EXIST);        
        //Get agents
        $agents = $DB->get_records('local_roomsupport_agent',['paramid' => $id, 'param_type' => PARAM_TYPE_BUILDING]);
        $agentArray = [];
        foreach ($agents as $a) {
            $agentArray[] = $a->userid;
        }
        $formdata->agents = $agentArray;
    } else {
        $formdata = new stdClass();
        $formdata->campusid = $campusid;
        $formdata->pi_username = 'pi';
        $formdata->service_hours = $CFG->roomsupport_service_hours;
    }

    $BUILDING = new \local_roomsupport\Building($id);
    $CAMPUS = new \local_buildings\Campus($formdata->campusid);

    if ($id == 0) {        
        $pageHeader = get_string('adding_building_to', 'local_roomsupport') . $CAMPUS->getName();
    } else {
        $pageHeader = get_string('editing_building', 'local_roomsupport') . ' - ' . $BUILDING->getBuildingFullName() . ' - ' . $CAMPUS->getName();
    }

    echo \local_roomsupport\Base::page($CFG->wwwroot . '/local/roomsupport/admin/building.php', get_string('pluginname', 'local_roomsupport'), $pageHeader, $context);

    $mform = new building_form(null, array('formdata' => $formdata));

// If data submitted, then process and store.
    if ($mform->is_cancelled()) {
        redirect($CFG->wwwroot . '/local/roomsupport/index.php?campusid=' . $formdata->campusid);
    } else if ($data = $mform->get_data()) {

        
        if ($data->id) {
            //update record
            $BUILDING->update($data);
        } else {
            $data->id = $BUILDING->insert($data);
        }
        
        //Delete current agents
        $DB->delete_records('local_roomsupport_agent', ['paramid' => $data->id, 'param_type' => PARAM_TYPE_BUILDING]);
        //Add agents to table
        for ($i = 0; $i < count($data->agents); $i++) {
            $agentData = [];
            $agentData['userid'] = $data->agents[$i];
            $agentData['paramid'] = $data->id;
            $agentData['param_type'] = PARAM_TYPE_BUILDING;
            $DB->insert_record('local_roomsupport_agent', $agentData);
        }
        
        redirect($CFG->wwwroot . '/local/roomsupport/index.php?campusid=' . $formdata->campusid);
    }
    //--------------------------------------------------------------------------    
    //**********************
    //*** DISPLAY HEADER ***
    //**********************
    echo $OUTPUT->header();

    //***********************
    //*** DISPLAY CONTENT ***
    //***********************
    $mform->display();
    
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>