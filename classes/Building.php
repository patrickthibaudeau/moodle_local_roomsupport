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
class Building extends Device {

    /**
     *
     * @var int 
     */
    private $id;

    /**
     *
     * @var int 
     */
    private $campusId;

    /**
     * Id from local_buildings_building table
     * @var int 
     */
    private $buildingId;

    /**
     *
     * @var string 
     */
    private $buildingFullName;

    /**
     *
     * @var string 
     */
    private $buildingShortName;

    /**
     *
     * @var string 
     */
    private $piUsername;

    /**
     *
     * @var string 
     */
    private $piPassword;

    /**
     *
     * @var string 
     */
    private $ticketingUrl;

    /**
     *
     * @var string 
     */
    private $ticketingEmail;

    /**
     *
     * @var string 
     */
    private $serviceHours;

    /**
     *
     * @var string 
     */
    private $cellNumbers;

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
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \stdClass $USER
     * @param $id int
     */
    public function __construct($id = 0) {
        global $CFG, $DB, $USER;
        include_once($CFG->dirroot . '/lib/filelib.php');

        $this->dbTable = 'local_roomsupport_buildings';
        $context = \context_system::instance();

        if ($id) {
            $results = $DB->get_record($this->dbTable, ['id' => $id]);
        } else {
            $results = new \stdClass();
        }

        $this->id = $id;
        $this->buildingId = $results->buildingid ?? 0;
        //Get building name
        if ($results->buildingid) {
            $BUILDING = new \local_buildings\Building($results->buildingid);
            $this->buildingFullName = $BUILDING->getName();
            $this->buildingShortName = $BUILDING->getShortname();
        }

        $this->piUsername = $results->pi_username ?? '';
        $this->piPassword = $results->pi_password ?? '';
        $this->ticketingUrl = $results->ticketing_url ?? '';
        $this->ticketingEmail = $results->ticketing_email ?? '';
        $this->serviceHours = $results->service_hours ?? '';
        $this->cellNumbers = $results->cell_numbers ?? '';

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

        if (is_object($data)) {
            $data->timecreated = time();
            $data->timemodified = time();
        } else {
            $data['timecreated'] = time();
            $data['timemodified'] = time();
        }

        $id = $DB->insert_record($this->dbTable, $data);
        return $id;
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function update($data) {
        global $DB;

        if (is_object($data)) {
            $data->timemodified = time();
        } else {
            $data['timemodified'] = time();
        }

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

    function getId() {
        return $this->id;
    }

    function getCampusId() {
        return $this->campusId;
    }

    function getBuildingId() {
        return $this->buildingId;
    }

    function getBuildingFullName() {
        return $this->buildingFullName;
    }

    function getBuildingShortName() {
        return $this->buildingShortName;
    }

    function getPiUsername() {
        return $this->piUsername;
    }

    function getPiPassword() {
        return $this->piPassword;
    }

    function getTicketingUrl() {
        return $this->ticketingUrl;
    }

    function getTicketingEmail() {
        return $this->ticketingEmail;
    }

    function getServiceHours() {
        return $this->serviceHours;
    }

    function getCellNumbers() {
        return $this->cellNumbers;
    }

    function getTimeCreated() {
        return $this->timeCreated;
    }

    function getTimeCreatedHr() {
        return $this->timeCreatedHr;
    }

    function getTimeModified() {
        return $this->timeModified;
    }

    function getTimeModifiedHr() {
        return $this->timeModifiedHr;
    }

    function getDbTable() {
        return $this->dbTable;
    }

}
