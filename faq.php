<?php

require_once('config.php');
include("faq_form.php");

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

    if ((!has_capability('local/roomsupport:admin', $context))) {
        redirect($CFG->wwwroot,
                get_string('no_permission', 'local_roomsupport'), 5);
    }

    $id = optional_param('id', 0, PARAM_INT);
    $buildingId = required_param('buildingid', PARAM_INT);

    if ($id) {
        $formdata = $DB->get_record('local_roomsupport_faq', array('id' => $id), '*',
                MUST_EXIST);

        $draftid_en = file_get_submitted_draft_itemid('message_field_en');
        $currentTextEn = file_prepare_draft_area($draftid_en, $context->id,
                'local_roomsupport', 'faqen', $id,
                \local_roomsupport\Base::getEditorOptions($context),
                $formdata->message_en);
        $formdata->message_field_en = array('text' => $currentTextEn, 'format' => FORMAT_HTML,
            'itemid' => $draftid_en);
        
        $draftid_fr = file_get_submitted_draft_itemid('message_field_fr');
        $currentTextFr = file_prepare_draft_area($draftid_fr, $context->id,
                'local_roomsupport', 'faqfr', $id,
                \local_roomsupport\Base::getEditorOptions($context),
                $formdata->message_fr);
        $formdata->message_field_fr = array('text' => $currentTextFr, 'format' => FORMAT_HTML,
            'itemid' => $draftid_fr);
    } else {
        $formdata = new stdClass();
        $formdata->id = 0;
        $formdata->buildingid = $buildingId;
    }

    echo \local_roomsupport\Base::page($CFG->wwwroot . '/local/roomsupport/faq.php',
            get_string('pluginname', 'local_roomsupport'),
            get_string('faq', 'local_roomsupport'), $context);

    $mform = new faq_form(null, array('formdata' => $formdata));

// If data submitted, then process and store.
    if ($mform->is_cancelled()) {
        redirect($CFG->wwwroot . '/local/roomsupport/faqs.php?buildingid=' . $formdata->buildingid);
    } else if ($data = $mform->get_data()) {
        if ($data->id) {
            $data->userid = $USER->id;
            $data->timemodified = time();
            $DB->update_record('local_roomsupport_faq', $data);
            $recordId = $id;
        } else {
            $data->userid = $USER->id;
            $data->timecreated = time();
            $data->timemodified = time();
            $recordId = $DB->insert_record('local_roomsupport_faq', $data);
        }

        //Saving editor text and files
        $draftid_en = file_get_submitted_draft_itemid('message_field_en');
        $messageTextEn = file_save_draft_area_files($draftid_en, $context->id,
                'local_roomsupport', 'faqen', $recordId,
                \local_roomsupport\Base::getEditorOptions($context),
                $data->message_field_en['text']);
        $data->message_en = $messageTextEn;
        
        $draftid_fr = file_get_submitted_draft_itemid('message_field_fr');
        $messageTextFr = file_save_draft_area_files($draftid_fr, $context->id,
                'local_roomsupport', 'faqfr', $recordId,
                \local_roomsupport\Base::getEditorOptions($context),
                $data->message_field_fr['text']);
        $data->message_fr = $messageTextFr;

        $data->id = $recordId;

        $DB->update_record('local_roomsupport_faq', $data);

        redirect($CFG->wwwroot . '/local/roomsupport/faqs.php?buildingid=' . $formdata->buildingid);
    }
    //--------------------------------------------------------------------------
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY HEADER ***

    $mform->display();
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>