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
class dashboard implements \renderable, \templatable {

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
            'devices' => $this->getRaspberryPis(),
            'faqs' => $this->getFaqs()
        ];
        return $data;
    }

    /**
     * Returns all Raspberry Pi's in the system
     * @global \moodle_database $DB
     */
    private function getRaspberryPis() {
        global $DB;
        
        $RPIS = new  \local_roomsupport\RaspberryPis();
        $rpis = $RPIS->getResults();
        
        $rpiArray = [];
        $i = 0;
        foreach ($rpis as $pi) {
            $PI = new \local_roomsupport\RaspberryPi($pi->id);
            $rpiArray[$i]['id'] = $PI->getId();
            $rpiArray[$i]['mac'] = $PI->getMac();
            $rpiArray[$i]['ip'] = $PI->getIp();
            $rpiArray[$i]['room'] = $PI->getBuildingShortName() . ' ' . $PI->getRoomNumber();
            $rpiArray[$i]['status'] = $PI->getIsAlive();
            $i++;
            unset($PI);
        }
        
        return $rpiArray;
    }
    
    /**
     * Returns all Raspberry Pi's in the system
     * @global \moodle_database $DB
     */
    private function getFaqs() {
        global $DB;
        
        $FAQS = new  \local_roomsupport\Faqs();
        $faqs = $FAQS->getResults();
        
        $faqArray = [];
        $i = 0;
        foreach ($faqs as $faq) {
            $FAQ = new \local_roomsupport\Faq($faq->id);
            $faqArray[$i]['id'] = $FAQ->getId();
            $faqArray[$i]['name'] = $FAQ->getName();
            $i++;
            unset($FAQ);
        }
        
        return $faqArray;
    }
}
