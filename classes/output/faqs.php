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
class faqs implements \renderable, \templatable {

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
            'faqs' => $this->getFaqs()
        ];
        
       
        return $data;
    }

    /**
     * Returns all FAQs
     * @global \moodle_database $DB
     */
    private function getFaqs() {
        global $DB;
        
        $FAQS = new  \local_roomsupport\Faqs();
        $faqs = $FAQS->getResults();
        
        //If lang is french, then lang=true otherwise false
        if (current_language() == 'en') {
            $lang = false;
        } else {
            $lang = true;
        }
        $faqsArray = [];
        $i = 0;
        foreach ($faqs as $faq) {
            $FAQ = new \local_roomsupport\Faq($faq->id);
            $faqsArray[$i]['id'] = $FAQ->getId();
            $faqsArray[$i]['name'] = $FAQ->getName();
            $faqsArray[$i]['message_en'] = $FAQ->getMessageEn();
            $faqsArray[$i]['message_fr'] = $FAQ->getMessageFr();
            $faqsArray[$i]['user'] = $FAQ->getUserName();
            $faqsArray[$i]['lang'] = $lang;
            $i++;
            unset($FAQ);
        }
        
        return $faqsArray;
    }
}
