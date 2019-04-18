<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_roomsupport;

/**
 * Description of AgentStats
 *
 * @author patrick
 */
class AgentStats {

    private $results;

    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    public function __construct($startTime = null, $endTime = null) {
        global $CFG, $DB;

        if (is_null($startTime)) {
            $sql = 'SELECT * FROM {local_roomsupport_call_log}';
        } else {
            if (is_null($endTime)) {
                $endTime = time();
            }
            $sql = 'SELECT * FROM {local_roomsupport_call_log} WHERE timecreated BETWEEN ? AND ?';
        }

        $this->results = $DB->get_records_sql($sql, [$startTime, $endTime]);
    }
    
    public function getResults() {
        return $this->results;
    }
}
