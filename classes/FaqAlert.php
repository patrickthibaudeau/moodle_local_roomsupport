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
class FaqAlert extends Device {

    /**
     *
     * @var int 
     */
    private $id;

    /**
     * RaspberryPi Id
     * @var int 
     */
    private $rpiId;

    /**
     *
     * @var int 
     */
    private $agentId;

    /**
     *
     * @var string 
     */
    private $userName;

    /**
     *
     * @var int 
     */
    private $status;

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
    private $timeReplied;

    /**
     * Human readable
     * @var string 
     */
    private $timeRepliedHr;

    /**
     *
     * @var int 
     */
    private $timeClosed;

    /**
     * Human readable
     * @var string 
     */
    private $timeClosedHr;

    /**
     *
     * @var string 
     */
    private $dbTable;


    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \stdClass $USER
     * @param $id int
     */
    public function __construct($id = 0) {
        global $CFG, $DB, $USER;


        $this->dbTable = 'local_roomsupport_call_log';
        $context = \context_system::instance();

        if ($id) {
            $results = $DB->get_record($this->dbTable, ['id' => $id]);
        } else {
            $results = new \stdClass();
        }

        $this->id = $id;
        

        $this->agentId = $results->agentid ?? 0;

        if (isset($results->agentid)) {
            $user = $DB->get_record('user', ['id' => $results->agentid]);
            $this->userName = fullname($user);
        } else {
            $this->userName = '';
        }

        $this->timeCreated = $results->timecreated ?? 0;
        if (isset($results->timecreated)) {
            $this->timeCreatedHr = date('F d, Y H:i', $results->timecreated);
        } else {
            $this->timeCreatedHr = '';
        }

        $this->timeReplied= $results->timereplied ?? 0;
        if (isset($results->timereplied)) {
            $this->timeRepliedHr = date('F d, Y H:i', $results->timereplied);
        } else {
            $this->timeRepliedHr = '';
        }

        $this->timeClosed= $results->timeclosed ?? 0;
        if (isset($results->timeclosed)) {
            $this->timeClosedHr = date('F d, Y H:i', $results->timeclosed);
        } else {
            $this->timeClosedHr = '';
        }
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function insert($data) {
        global $DB;

        $data['timecreated'] = time();

        $DB->insert_record($this->dbTable, $data);
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function update($data) {
        global $DB;

        $DB->update_record($this->dbTable, $data);
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function delete() {
        global $DB;

        //Logs should not be deleted
    }

    public function getId() {
        return $this->id;
    }

    public function getRpiId() {
        return $this->rpiId;
    }

    public function getAgentId() {
        return $this->agentId;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getTimeCreated() {
        return $this->timeCreated;
    }

    public function getTimeCreatedHr() {
        return $this->timeCreatedHr;
    }

    public function getTimeReplied() {
        return $this->timeReplied;
    }

    public function getTimeRepliedHr() {
        return $this->timeRepliedHr;
    }

    public function getTimeClosed() {
        return $this->timeClosed;
    }

    public function getTimeClosedHr() {
        return $this->timeClosedHr;
    }

    public function getDbTable() {
        return $this->dbTable;
    }

}
