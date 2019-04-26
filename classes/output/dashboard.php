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

    private $campusId;

    public function __construct($campusId) {
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

        $campus = $DB->get_record('buildings_campus', ['id' => $this->campusId]);
        $unassignedDevices = $this->getUnassignedRaspberryPis();
        $numberOfCampuses = count($this->getCampuses());
        $showChangeCampusButton = false;
        if ($numberOfCampuses > 1) {
            $showChangeCampusButton = true;
        }
        $data = [
            'wwwroot' => $CFG->wwwroot,
            'unassignedDevices' => $unassignedDevices['devices'],
            'unassignedDeviceCount' => $unassignedDevices['count'],
            'buildings' => $this->getBuildings(),
            'campusId' => $this->campusId,
            'campuses' => $this->getCampuses(),
            'showChangeCampusButton' => $showChangeCampusButton,
            'campusName' => $campus->name
        ];

//        print_object($data);
        return $data;
    }

    /**
     * Returns all Raspberry Pi's in the system
     * @global \moodle_database $DB
     */
    private function getRaspberryPis($buildingId) {
        global $DB;

        $RPIS = new \local_roomsupport\RaspberryPis($buildingId);
        $rpis = $RPIS->getResults();
        
        $rpiArray = [];
        $i = 0;
        foreach ($rpis as $pi) {
            $PI = new \local_roomsupport\RaspberryPi($pi->id);
            $rpiArray[$i]['id'] = $PI->getId();
            $rpiArray[$i]['mac'] = $PI->getMac();
            $rpiArray[$i]['ip'] = $PI->getIp();
            $rpiArray[$i]['room'] = $PI->getRoomNumber();
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
    private function getUnassignedRaspberryPis() {
        global $DB;

        $RPIS = new \local_roomsupport\RaspberryPis();
        $rpis = $RPIS->getResults();

        $rpiArray = [];
        $i = 0;
        foreach ($rpis as $pi) {
            if ($pi->buildingid == false) {
                $PI = new \local_roomsupport\RaspberryPi($pi->id);
                $rpiArray[$i]['id'] = $PI->getId();
                $rpiArray[$i]['mac'] = $PI->getMac();
                $rpiArray[$i]['ip'] = $PI->getIp();
                $rpiArray[$i]['room'] = $PI->getRoomNumber();
                $rpiArray[$i]['status'] = $PI->getIsAlive();
                $i++;
                unset($PI);
            }
        }
        
        $data = [];
        $data['count'] = count($rpiArray);
        $data['devices'] = $rpiArray;

        return $data;
    }

    /**
     * Returns all Raspberry Pi's in the system
     * @global \moodle_database $DB
     */
    private function getFaqs($buildingId) {
        global $DB;

        $FAQS = new \local_roomsupport\Faqs($buildingId);
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

    /**
     * Returns all buildings for the campus
     * @global \moodle_database $DB
     */
    private function getBuildings() {
        global $CFG, $DB;

        $BUILDINGS = new \local_roomsupport\Buildings($this->campusId);
        $buildings = $BUILDINGS->getResults();

        $buildingArray = [];
        $i = 0;
        foreach ($buildings as $b) {
            $BUILDING = new \local_roomsupport\Building($b->id);
            $buildingArray[$i]['id'] = $b->id;
            $buildingArray[$i]['buildingId'] = $BUILDING->getBuildingId();
            $buildingArray[$i]['fullName'] = $BUILDING->getBuildingFullName();
            $buildingArray[$i]['shortName'] = $BUILDING->getBuildingShortName();
            $buildingArray[$i]['devices'] = $this->getRaspberryPis($BUILDING->getId());
            $buildingArray[$i]['faqs'] = $this->getFaqs($BUILDING->getId());
            $buildingArray[$i]['rooms'] = $this->getRooms($BUILDING->getBuildingId());
            $i++;
        }

        return $buildingArray;
    }

    /**
     * Returns rooms in a building
     * @global \moodle_database $DB
     */
    private function getRooms($buildingId) {
        global $CFG, $DB;

        return \local_roomsupport\Base::getRooms($buildingId);
    }

    /**
     * Returns all Raspberry Pi's in the system
     * @global \moodle_database $DB
     */
    private function getCampuses() {
        global $CFG, $DB;

        $CAMPUSES = new \local_buildings\Campuses();
        $campuses = $CAMPUSES->getCampuses();

        $campusArray = [];
        $i = 0;
        foreach ($campuses as $c) {
            $campusArray[$i]['id'] = $c['id'];
            $campusArray[$i]['name'] = $c['name'];
            if ($c['id'] == $this->campusId) {
                $campusArray[$i]['selected'] = true;
            }

            $i++;
        }

        return $campusArray;
    }

}
