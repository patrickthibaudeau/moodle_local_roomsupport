<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_roomsupport\output;

/**
 * 
 * @global \stdClass $USER
 * @param \renderer_base $output
 * @return array
 */
class logs implements \renderable, \templatable {

    public function __construct() {
        
    }

    /**
     * 
     * @global \stdClass $USER
     * @global \moodle_database $DB
     * @param \renderer_base $output
     * @return array
     */
    public function export_for_template(\renderer_base $output) {
        global $CFG, $USER, $DB;

        $data = [
            'wwwroot' => $CFG->wwwroot,
            'stats' => $this->getLogs()
        ];

        return $data;
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    private function getLogs() {
        global $DB;

        $results = $DB->get_records('local_roomsupport_call_log');

        $returnArray = [];
        $i = 0;
        foreach ($results as $r) {
            $RPI = new \local_roomsupport\RaspberryPi($r->rpiid);
            $FA = new \local_roomsupport\FaqAlert($r->id);
            $returnArray[$i]['id'] = $r->id;
            $returnArray[$i]['room'] = $RPI->getBuildingShortName() . ' ' . $RPI->getRoomNumber();
            $returnArray[$i]['agent'] = $FA->getUserName();
            $returnArray[$i]['timecreated'] = $FA->getTimeCreatedHr();
            $returnArray[$i]['timereplied'] = $FA->getTimeRepliedHr();
            $returnArray[$i]['timeclosed'] = $FA->getTimeClosedHr();
            $returnArray[$i]['status'] = $FA->getStatus();
            $i++;
        }

        return $returnArray;
    }

}
