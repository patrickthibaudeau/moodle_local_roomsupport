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
require_once('../config.php');

/**
 * Display the content of the page
 * @global stdobject $CFG
 * @global moodle_database $DB
 * @global core_renderer $OUTPUT
 * @global moodle_page $PAGE
 * @global stdobject $SESSION
 * @global stdobject $USER
 */
function display_page() {
    // CHECK And PREPARE DATA
    global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

    $id = optional_param('id', 0, PARAM_INT); //List id
    $campusId = required_param('campusid', PARAM_INT); //List id
    $buildingId = optional_param('buildingid', null, PARAM_INT); //List id
    $from = null;
    $to = null;
    $dateRange = optional_param('daterange', null, PARAM_TEXT);
    if (strstr($dateRange, ' - ')) {
        $dateRange = explode(' - ', $dateRange);
        $from = strtotime($dateRange[0] . ' 00:00:00');
        $to = strtotime($dateRange[1] . ' 23:59:59');
    } else {
        //Show whole month
        $month = date('m', time());
        $year = date('Y', time());
        $from = strtotime($month . '/01/' . $year . ' 00:00:00') ;
        $to = strtotime($month . '/28/' . $year . ' 23:58:59') ;
    }


    require_login(1, false); //Use course 1 because this has nothing to do with an actual course, just like course 1

    $context = context_system::instance();

    $pagetitle = get_string('pluginname', 'local_roomsupport');
    $pageheading = get_string('pluginname', 'local_roomsupport');

    echo \local_roomsupport\Base::page($CFG->wwwroot . '/local/roomsupport/index.php',
            $pagetitle, $pageheading, $context);

    $HTMLcontent = '';
    //**********************
    //*** DISPLAY HEADER ***
    //**********************
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY CONTENT **
    //**********************
    $output = $PAGE->get_renderer('local_roomsupport');
    $statistics = new \local_roomsupport\output\statistics($campusId, $buildingId, $from, $to);
    echo '<div id="statisticsContainer">';
    echo $output->render_statistics($statistics);
    echo '</div>';
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>
