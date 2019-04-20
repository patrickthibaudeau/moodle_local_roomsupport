<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_roomsupport;

/**
 * Description of RaspberryPi
 *
 * @author patrick
 */
class Faq extends Device {

    /**
     *
     * @var int 
     */
    private $id;

    /**
     *
     * @var int 
     */
    private $userId;

    /**
     *
     * @var int 
     */
    private $campusId;

    /**
     *
     * @var string 
     */
    private $userName;

    /**
     *
     * @var string 
     */
    private $name;

    /**
     *
     * @var string 
     */
    private $messageEn;

    /**
     *
     * @var string 
     */
    private $messageFr;

    /**
     *
     * @var int 
     */
    private $timeCreated;

    /**
     * Human readable
     * @var string 
     */
    private $timeCreatedHr;

    /**
     *
     * @var int 
     */
    private $timeModified;

    /**
     * Human readable
     * @var string 
     */
    private $timeModifiedHr;

    /**
     *
     * @var string 
     */
    private $dbTable;

    /**
     *
     * @var bool 
     */
    private $isAlive;

    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \stdClass $USER
     * @param $id int
     */
    public function __construct($id = 0) {
        global $CFG, $DB, $USER;
        include_once($CFG->dirroot . '/lib/filelib.php');

        $this->dbTable = 'local_roomsupport_faq';
        $context = \context_system::instance();

        if ($id) {
            $results = $DB->get_record($this->dbTable, ['id' => $id]);
        } else {
            $results = new \stdClass();
        }

        $this->id = $id;
        $this->campusId = $results->campusid ?? 0;
        $this->name = $results->name ?? '';
        if (isset($results->message_en)) {
            $contentEnUrls = file_rewrite_pluginfile_urls($results->message_en,
                    'pluginfile.php', $context->id, 'local_roomsupport', 'faqen',
                    $results->id);
            $contentEn = format_text($contentEnUrls, $results->message_en,
                    \local_roomsupport\Base::getEditorOptions($context),
                    $context);
            $this->messageEn = $contentEn;
        } else {
            $this->messageEn = '';
        }
        
        if (isset($results->message_fr)) {
            $contentFrUrls = file_rewrite_pluginfile_urls($results->message_fr,
                    'pluginfile.php', $context->id, 'local_roomsupport', 'faqfr',
                    $results->id);
            $contentFr = format_text($contentFrUrls, $results->message_fr,
                    \local_roomsupport\Base::getEditorOptions($context),
                    $context);
            $this->messageFr = $contentFr;
        } else {
            $this->messageFr = '';
        }

        $this->userId = $results->userid ?? 0;

        if (isset($results->userid)) {
            $user = $DB->get_record('user', ['id' => $results->userid]);
            $this->userName = fullname($user);
        } else {
            $this->userName = '';
        }

        $this->timeCreated = $results->timecreated ?? 0;
        if (isset($results->timecreated)) {
            $this->timeCreatedHr = date('F d, Y', $results->timecreated);
        } else {
            $this->timeCreatedHr = '';
        }

        $this->timeModified = $results->timemodified ?? 0;
        if (isset($results->timemodified)) {
            $this->timeModifiedHr = date('F d, Y', $results->timemodified);
        } else {
            $this->timeModifiedHr = '';
        }
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function insert($data) {
        global $DB;

        $data['timecreated'] = time();
        $data['timemodified'] = time();

        $DB->insert_record($this->dbTable, $data);
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function update($data) {
        global $DB;

        $data['timemodified'] = time();

        $DB->update_record($this->dbTable, $data);
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function delete() {
        global $DB;

        $DB->delete_records($this->dbTable, ['id' => $this->id]);
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getName() {
        return $this->name;
    }

    public function getMessageEn() {
        return $this->messageEn;
    }

    public function getMessageFr() {
        return $this->messageFr;
    }

    public function getTimeCreated() {
        return $this->timeCreated;
    }

    public function getTimeCreatedHr() {
        return $this->timeCreatedHr;
    }

    public function getTimeModified() {
        return $this->timeModified;
    }

    public function getTimeModifiedHr() {
        return $this->timeModifiedHr;
    }

    public function getDbTable() {
        return $this->dbTable;
    }

    public function getIsAlive() {
        return $this->isAlive;
    }

    public function getCampusId() {
        return $this->campusId;
    }

}
