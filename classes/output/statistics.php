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
class statistics implements \renderable, \templatable {
    
    /**
     *
     * @var int
     */
    private $from;
    
    /**
     *
     * @var int 
     */
    private $buildingId;
    
    /**
     *
     * @var int 
     */
    private $campusId;
    
    /**
     *
     * @var int 
     */
    private $to;

    public function __construct($campusId, $buildingId = null, $from = null, $to = null) {
        $this->from = $from;
        $this->to = $to;
        $this->campusId = $campusId;
        $this->buildingId = $buildingId;
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

        $responseTimes = \local_roomsupport\Statistics::getDifferenceTimeCreatedTimeReplied($this->campusId, $this->buildingId, $this->from, $this->to); 
               
        $data = [
            'wwwroot' => $CFG->wwwroot,
            'callsToRoom' => $this->callsToRoom(),
            'agents' => $this->agents(),
            'averageResponse' => $this->convertToReadableTime($responseTimes['avg']),
            'longestResponse' => $this->convertToReadableTime($responseTimes['longest']),
            'shortestResponse' => $this->convertToReadableTime($responseTimes['shortest']),
            'totalCalls' => $responseTimes['numberOfCalls'],
            'startDate' => $this->convertToDate($this->from),
            'endDate' => $this->convertToDate($this->to),
            'campusId' => $this->campusId,
            'buildings' => \local_roomsupport\Base::getCampusBuildings($this->campusId, $this->buildingId)
        ];
        return $data;
    }

    private function callsToRoom() {
        global $OUTPUT;
        $stats = \local_roomsupport\Statistics::getDeviceCalls($this->campusId, $this->buildingId, $this->from, $this->to);
        $chart = new \core\chart_bar();
        $chart->set_horizontal(true);
        $chart->add_series($stats['data']);
        $chart->set_labels($stats['labels']);
        
        return $OUTPUT->render($chart);
    }
    
    private function agents() {
        global $OUTPUT;
        $stats = \local_roomsupport\Statistics::getAgents($this->campusId, $this->buildingId, $this->from, $this->to);
        $chart = new \core\chart_pie();
        $chart->add_series($stats['data']);
        $chart->set_labels($stats['labels']);
        
        return $OUTPUT->render($chart);
    }

    private function convertToReadableTime($valueInSeconds) {
        return gmdate('H:i:s', $valueInSeconds);
    }
    
    private function convertToDate($valueInSeconds) {
        return date('m/d/Y', $valueInSeconds);
    }
}
