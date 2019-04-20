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

    private $buildingId;
    private $campusId;

    public function __construct($campusId, $buildingId = null ) {
        $this->buildingId = $buildingId;
        $this->campusId = $campusId;
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
            'stats' => $this->getLogs(),
            'campusId' => $this->campusId,
            'buildings' => \local_roomsupport\Base::getCampusBuildings($this->campusId, $this->buildingId)
        ];

        return $data;
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    private function getLogs() {
        global $DB;

        $sql = 'Select '
                . 'cl.id as id,'
                . 'cl.rpiid as rpiid, '
                . 'rpi.buildingid as buildingid, '
                . 'b.campusid as campusid '
                . 'From '
                . '{local_roomsupport_call_log} cl Inner Join '
                . '{local_roomsupport_rpi} rpi On rpi.id = cl.rpiid Inner Join '
                . '{local_roomsupport_buildings} b On b.id = rpi.buildingid '
                . 'WHERE b.campusid = ? ';
        $params = [$this->campusId];
        if (!is_null($this->buildingId)) {
            $sql .= ' AND b.id = ?';
            $params = [$this->campusId, $this->buildingId];
        } 

        $results = $DB->get_records_sql($sql, $params);

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
