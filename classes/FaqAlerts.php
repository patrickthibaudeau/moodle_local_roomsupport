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
class FaqAlerts extends Devices {

    /**
     * Returns all records in table
     * @var \stdClass   
     */
    private $results;

    /**
     * Returns records with status open
     * @var \stdClass   
     */
    private $resultsOpen;

    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    public function __construct() {
        global $CFG, $DB, $USER;

        $this->results = $DB->get_records('local_roomsupport_call_log');
        $this->resultsOpen = $DB->get_records('local_roomsupport_call_log', ['status' => false]);
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

    public function getOpenCallsPerAgent() {
        global $DB, $USER;

        $sql = 'Select '
                . '    cl.id, '
                . '    cl.rpiid, '
                . '    cl.agentid, '
                . '    cl.status, '
                . '    cl.timecreated, '
                . '    cl.timereplied, '
                . '    cl.timeclosed '
                . 'From '
                . '    {local_roomsupport_call_log} cl Inner Join '
                . '    {local_roomsupport_rpi} rpi On rpi.id = cl.rpiid Inner Join '
                . '    {local_roomsupport_agent} a On a.paramid = rpi.buildingid '
                . 'Where '
                . '    a.userid = ? And '
                . '    a.param_type = ? And '
                . '    cl.status = 0 ';
        
        $openCalls = $DB->get_records_sql($sql,[$USER->id, PARAM_TYPE_BUILDING]);
        return $openCalls;
    }

    function getResultsOpen() {
        return $this->resultsOpen;
    }

        public function getHtml() {
        
    }

}
