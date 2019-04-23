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
class faq_alerts implements \renderable, \templatable {

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
            'alerts' => $this->getFaqAlerts()
        ];

        return $data;
    }
    
    private function getFaqAlerts() {
        $FAQALERTS = new \local_roomsupport\FaqAlerts();
        $results = $FAQALERTS->getOpenCallsPerAgent();
        $i = 0;
        $resultsArray = [];
        foreach ($results as $r) {
            $FAQALERT = new \local_roomsupport\FaqAlert($r->id);
            $RPI = new \local_roomsupport\RaspberryPi($r->rpiid);
            
            $resultsArray[$i]['id'] = $FAQALERT->getId();
            $resultsArray[$i]['status'] = $FAQALERT->getStatus();
            $resultsArray[$i]['agent'] = $FAQALERT->getUserName();
            $resultsArray[$i]['timecreated'] = $FAQALERT->getTimeCreatedHr();
            $resultsArray[$i]['timereplied'] = $FAQALERT->getTimeRepliedHr();
            $resultsArray[$i]['timeclosed'] = $FAQALERT->getTimeClosedHr();
            $resultsArray[$i]['room'] = $RPI->getRoomNumber();
            $i++;
            unset($FAQALERT);
            unset($RPI);           
        }
        unset($FAQALERTS);
        
        return $resultsArray;
    }
}
