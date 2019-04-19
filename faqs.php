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
require_once('config.php');

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
    $buildingId = required_param('buildingid', PARAM_INT); //List id

    require_login(1, false); //Use course 1 because this has nothing to do with an actual course, just like course 1

    $context = context_system::instance();
    
    if ((!has_capability('local/roomsupport:admin', $context))) {
        redirect($CFG->wwwroot,
                get_string('no_permission', 'local_roomsupport'), 5);
    }

    $pagetitle = get_string('faqs', 'local_roomsupport');
    $pageheading = get_string('faqs', 'local_roomsupport');

    echo \local_roomsupport\Base::page($CFG->wwwroot . '/local/roomsupport/faqs.php',
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
    $faqs = new \local_roomsupport\output\faqs($buildingId);

    echo '<div id="faqsContainer">';
    echo $output->render_faqs($faqs);
    echo '</div>';
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>