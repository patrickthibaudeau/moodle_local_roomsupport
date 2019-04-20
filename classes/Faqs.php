<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_roomsupport;

/**
 * Description of RaspberryPis
 *
 * @author patrick
 */
class Faqs extends Devices {

    /**
     * Returns all records in table
     * @var \stdClass   
     */
    private $results;

    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    public function __construct($campusId) {
        global $CFG, $DB;
        $this->results = $DB->get_records('local_roomsupport_faq', [ 'campusid' => $campusId]);
    }

    /**
     * Returns an array of stdClass objects
     * Each object contains the following fields
     * id               int,
     * userid           int,
     * mac              int,
     * ip               string,
     * buildingid       int,
     * lastping         timestamp,
     * timecreated      timestamp,
     * timemodified     timestamp,
     * 
     * @return \stdClass
     */
    public function getResults() {
        return $this->results;
    }

    public function getHtml() {
        
    }

}
