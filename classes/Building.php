<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_roomsupport;

/**
 * Description of RaspberryPi
 *
 * @author patrick
 */
class Building extends Device {

    /**
     *
     * @var int 
     */
    private $id;

    /**
     *
     * @var int 
     */
    private $campusId;

    /**
     * Id from local_buildings_building table
     * @var int 
     */
    private $buildingId;

    /**
     *
     * @var string 
     */
    private $buildingFullName;

    /**
     *
     * @var string 
     */
    private $buildingShortName;

    /**
     *
     * @var string 
     */
    private $piUsername;

    /**
     *
     * @var string 
     */
    private $piPassword;

    /**
     *
     * @var string 
     */
    private $ticketingUrl;

    /**
     *
     * @var string 
     */
    private $ticketingEmail;

    /**
     *
     * @var string 
     */
    private $serviceHours;

    /**
     *
     * @var string 
     */
    private $cellNumbers;

    /**
     *
     * @var int 
     */
    private $timeCreated;

    /**
     * Human readable
     * @var string 
     */
    private $timeCreatedHr;

    /**
     *
     * @var int 
     */
    private $timeModified;

    /**
     * Human readable
     * @var string 
     */
    private $timeModifiedHr;

    /**
     *
     * @var string 
     */
    private $dbTable;
    private $agentPhones;

    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \stdClass $USER
     * @param $id int
     */
    public function __construct($id = 0) {
        global $CFG, $DB, $USER;
        include_once($CFG->dirroot . '/lib/filelib.php');

        $this->dbTable = 'local_roomsupport_buildings';
        $context = \context_system::instance();

        if ($id) {
            $results = $DB->get_record($this->dbTable, ['id' => $id]);
        } else {
            $results = new \stdClass();
            $results->buildingid = 0;
        }

        $this->id = $id;
        $this->campusId = $results->campusid ?? 0;
        $this->buildingId = $results->buildingid ?? 0;
        //Get building name
        if ($results->buildingid) {
            $BUILDING = new \local_buildings\Building($results->buildingid);
            $this->buildingFullName = $BUILDING->getName();
            $this->buildingShortName = $BUILDING->getShortname();
        }

        $this->piUsername = $results->pi_username ?? '';
        $this->piPassword = $results->pi_password ?? '';
        $this->ticketingUrl = $results->ticketing_url ?? '';
        $this->ticketingEmail = $results->ticketing_email ?? '';
        $this->serviceHours = $results->service_hours ?? '';
        $this->cellNumbers = $results->cell_numbers ?? '';

        $this->timeCreated = $results->timecreated ?? 0;
        if (isset($results->timecreated)) {
            $this->timeCreatedHr = date('F d, Y', $results->timecreated);
        } else {
            $this->timeCreatedHr = '';
        }

        $this->timeModified = $results->timemodified ?? 0;
        if (isset($results->timemodified)) {
            $this->timeModifiedHr = date('F d, Y', $results->timemodified);
        } else {
            $this->timeModifiedHr = '';
        }

        //Get agent Phones
        $agents = $DB->get_records('local_roomsupport_agent', ['paramid' => $id, 'param_type' => PARAM_TYPE_BUILDING]);

        $agentsArray = [];
        $i = 0;
        foreach ($agents as $a) {
            $user = $DB->get_record('user', ['id' => $a->userid]);
            if ($user->phone1) {
                $agentsArray[$i] = $user->phone1;
                $i++;
            }
            if ($user->phone2) {
                $agentsArray[$i] = $user->phone2;
                $i++;
            }
        }
        $this->agentPhones = $agentsArray;
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function insert($data) {
        global $DB;

        if (is_object($data)) {
            $data->timecreated = time();
            $data->timemodified = time();
        } else {
            $data['timecreated'] = time();
            $data['timemodified'] = time();
        }

        $id = $DB->insert_record($this->dbTable, $data);
        return $id;
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function update($data) {
        global $DB;

        if (is_object($data)) {
            $data->timemodified = time();
        } else {
            $data['timemodified'] = time();
        }

        $DB->update_record($this->dbTable, $data);
    }

    /**
     * Verifies if the services are available or not
     * @global \stdClass $CFG
     * @return boolean
     */
    public function getServiceHours() {
        global $CFG;
        $serviceHours = $this->serviceHours;
        $serviceHoursArray = explode("\n", $serviceHours);
        print_object($serviceHoursArray);
        //Days of the week numeric value (array key)
        $days = ['U', 'M', 'T', 'W', 'R', 'F', 'S'];

        for ($i = 0; $i < count($serviceHoursArray); $i++) {
            //create array for days and hours
            $split = explode('=', $serviceHoursArray[$i]);
            //Split days based on delimiter
            if (strstr($split[0], '-')) {
                $daySplit = explode('-', $split[0]);
                //Get days
                $firstDay = array_search($daySplit[0], $days);
                $lastDay = array_search($daySplit[1], $days);
                //Create dayRange array
                $dayRange = [];
                for ($x = $firstDay; $x <= $lastDay; $x++) {
                    $dayRange[] = $days[$x];
                }
            } elseif (strstr($split[0], ',')) {
                $dayRange = explode(',', $split[0]);
            } else {
                $dayRange = [$split[0]];
            }
            //Get todays day
            $today = $days[date('w', time())];

            //Get times
            if (strstr($split[1], ',')) {
                $timeSplit = explode(',', $split[1]);
                $availableTimes = [];
                for ($z = 0; $z < count($timeSplit); $z++) {
                    //seperate the start and end time
                    $startFinishTimes = explode('-', $timeSplit[$z]);
                    $availableTimes[$z]['start'] = strtotime(date('m/d/Y', time()) . trim($startFinishTimes[0]) . ":00");
                    $availableTimes[$z]['finish'] = strtotime(date('m/d/Y', time()) . trim($startFinishTimes[1]) . ":00");
                }
            } else {
                //seperate the start and end time
                $startFinishTimes = explode('-', $split[1]);
                $availableTimes = [];
                $availableTimes[0]['start'] = strtotime(date('m/d/Y', time()) . " $startFinishTimes[0]:00");
                $availableTimes[0]['finish'] = strtotime(date('m/d/Y', time()) . " $startFinishTimes[1]:00");
            }
            //By default services are closed
            $open = false;
            //Find out if service desk is open
            if (in_array($today, $dayRange)) {
                foreach ($availableTimes as $key => $time) {
                    if ($time['start'] <= time() && time() <= $time['finish']) {
                        $open = true;
                        break;
                    }
                }
            }
        }

        return $open;
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function delete() {
        global $DB, $USER;
        //Get all Dervices and unaasign the building
        $devices = $DB->get_records('local_roomsupport_rpi', ['buildingid' => $this->id]);
        
        foreach ($devices as $d) {
            $data['id'] = $d->id;
            $data['buildingid'] = 0;
            $data['roomid'] = 0;
            $data['userid'] = $USER->id;
            $data['timemodified'] = time();
            $DB->update_record('local_roomsupport_rpi', $data);
        }
        //Remove all call logs
        $DB->delete_records('local_roomsupport_call_log', ['buildingid' => $this->id]);
        //Remove building
        $DB->delete_records($this->dbTable, ['id' => $this->id]);
    }

    function getId() {
        return $this->id;
    }

    function getCampusId() {
        return $this->campusId;
    }

    function getBuildingId() {
        return $this->buildingId;
    }

    function getBuildingFullName() {
        return $this->buildingFullName;
    }

    function getBuildingShortName() {
        return $this->buildingShortName;
    }

    function getPiUsername() {
        return $this->piUsername;
    }

    function getPiPassword() {
        return $this->piPassword;
    }

    function getTicketingUrl() {
        return $this->ticketingUrl;
    }

    function getTicketingEmail() {
        return $this->ticketingEmail;
    }

    function getCellNumbers() {
        return $this->cellNumbers;
    }

    function getTimeCreated() {
        return $this->timeCreated;
    }

    function getTimeCreatedHr() {
        return $this->timeCreatedHr;
    }

    function getTimeModified() {
        return $this->timeModified;
    }

    function getTimeModifiedHr() {
        return $this->timeModifiedHr;
    }

    function getDbTable() {
        return $this->dbTable;
    }

    function getAgentPhones() {
        return $this->agentPhones;
    }

}
