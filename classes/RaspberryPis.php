<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_roomsupport;

/**
 * Description of RaspberryPis
 *
 * @author patrick
 */
class RaspberryPis extends Devices {

    /**
     * Returns all records in table
     * @var \stdClass   
     */
    private $results;

    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    public function __construct() {
        global $CFG, $DB;

        $this->results = $DB->get_records('local_roomsupport_rpi');
    }

    /**
     * Returns an array of stdClass objects
     * Each object contains the following fields
     * id               int,
     * userid           int,
     * mac              int,
     * ip               string,
     * buildingid       int,
     * lastping         timestamp,
     * timecreated      timestamp,
     * timemodified     timestamp,
     * 
     * @return \stdClass
     */
    function getResults() {
        return $this->results;
    }

    public function getHtml() {
        $results = $this->getResults();

        $html = '<table class="table table-striped">';
        $html .= '    <thead>';
        $html .= '        <tr>';
        $html .= '            <th>';
        $html .= get_string('mac_address', 'local_roomsupport');
        $html .= '            </th>';
        $html .= '            <th>';
        $html .= get_string('ip_address', 'local_roomsupport');
        $html .= '            </th>';
        $html .= '            <th>';
        $html .= get_string('room', 'local_roomsupport');
        $html .= '            </th>';
        $html .= '            <th>';
        $html .= get_string('status', 'local_roomsupport');
        $html .= '            </th>';
        $html .= '            <th>';
        $html .= get_string('actions', 'local_roomsupport');
        $html .= '            </th>';
        $html .= '        </tr>';
        $html .= '    </thead>';
        $html .= '    <tbody>';
        foreach ($results as $pi) {
            $PI = new RaspberryPi($pi->id);
            $html .= '        <tr>';
            $html .= '            <td>';
            $html .= $PI->getMac();
            $html .= '             </td>';
            $html .= '            <td>';
            $html .= $PI->getIp();
            $html .= '            </td>';
            $html .= '            <td>';
            $html .= $PI->getBuildingShortName() . ' ' . $PI->getRoomNumber();
            $html .= '            </td>';
            $html .= '            <td>';
            if ($PI->getIsAlive()) {
            $html .= '<i class="fa fa-circle" style="color: green"></i>';
            } else {
            $html .= '<i class="fa fa-circle" style="color: red"></i>';
            }
            $html .= '            </td>';
            $html .= '            <td>';
            $html .= '<a href="javascript:void(0);" class="editRpi" data-id="' . $PI->getId() . '" title="' . get_string('edit', 'local_roomsupport') . '">';
            $html .= '    <i class="fa fa-edit" ></i>';
            $html .= '</a>';
            $html .= '';
            $html .= '<a href="javascript:void(0);"  class="deleteRpi"  data-id="' . $PI->getId() . '" title="' . get_string('delete', 'local_roomsupport') . '">';
            $html .= '   <i class="fa fa-trash" style="color: red"></i>';
            $html .= '</a>';
            $html .= '';
            $html .= '            </td>';
            $html .= '        </tr>';
        }
        $html .= '    </tbody>';
        $html .= '</table>';

        return $html;
    }

}
