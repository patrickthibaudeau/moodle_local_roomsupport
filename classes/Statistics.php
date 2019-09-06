<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_roomsupport;

/**
 * Description of Statistics
 *
 * @author patrick
 */
class Statistics {

    /**
     * Returns array of devices and the number of calls returned by the device.
     * @global type $DB
     */
    public static function getDeviceCalls($campusId, $buildingId, $from = null, $to = null) {
        global $DB;
        $deviceSql = "SELECT DISTINCT(rpiid) as id FROM {local_roomsupport_call_log} WHERE campusid = ? AND buildingid=? AND ignoredevice = 0";

        $params = [$campusId, $buildingId];        
        $timeSql = ''; 

        if (!is_null($from)) {
            if (is_null($to)) {
                $to = time();
            }
            $timeSql .= ' AND (timecreated BETWEEN ? AND ?)';
            $params = [$campusId, $buildingId, $from, $to];
        }

        $deviceSql . $timeSql;
        $devices = $DB->get_records_sql($deviceSql, $params);

        $dataSets = [];
        $labels = [];
        foreach ($devices as $d) {
            $countSql = "SELECT COUNT(rpiid) as total FROM {local_roomsupport_call_log} WHERE campusid=? AND buildingid=? AND rpiid = ?  $timeSql";
            $params = [$campusId, $buildingId, $d->id,  $from, $to];
            $RPI = new \local_roomsupport\RaspberryPi($d->id);
            $count = $DB->get_record_sql($countSql, $params);

            $labels[] = $RPI->getRoomNumber();
            $dataSets[] = $count->total;
        }
        $data = ['data' => new \core\chart_series(get_string('calls_per_room', 'local_roomsupport'), $dataSets), 'labels' => $labels];

        return $data;
    }

    /**
     * Returns array of agents and the number of calls answered.
     * @global type $DB
     */
    public static function getAgents($campusId, $buildingId, $from = null, $to = null) {
        global $DB;

        
        $params = [$campusId];
        $betweenTime = '';

        if (!is_null($from)) {
            if (is_null($to)) {
                $to = time();
            }
            $betweenTime = " AND (timecreated BETWEEN  ?  AND  ?)";
            $params = [$campusId, $buildingId, $from, $to];
        }
        
        $agentsSql = "SELECT DISTINCT(agentid) as id FROM {local_roomsupport_call_log} WHERE campusid=? AND buildingid= ? $betweenTime";
        $agents = $DB->get_records_sql($agentsSql, $params);

        $dataSets = [];
        $labels = [];
        foreach ($agents as $a) {
            $countSql = "SELECT COUNT(agentid) as total FROM {local_roomsupport_call_log} WHERE campusid=? AND buildingid=? AND agentid = ?";
            $params = [$campusId, $buildingId, $a->id];
            if ($user = $DB->get_record('user', ['id' => $a->id])) {
                $name = fullname($user);
            } else {
                $name = get_string('unanswered', 'local_roomsupport');
            }
            $count = $DB->get_record_sql($countSql, $params);

            $labels[] = $name;
            $dataSets[] = $count->total;
        }
        $data = ['data' => new \core\chart_series(get_string('number_of_calls_answered', 'local_roomsupport'), $dataSets), 'labels' => $labels];

        return $data;
    }

    public static function getDifferenceTimeCreatedTimeReplied($campusId, $buildingId, $from = null, $to = null) {
        global $DB;

        $params = [$campusId, $buildingId];
        $betweenTime = '';

        if (!is_null($from)) {
            if (is_null($to)) {
                $to = time();
            }
            $betweenTime = " AND timecreated BETWEEN  $from  AND  $to";
            $params = [$campusId, $buildingId, $from, $to];
        }

        $averageSql = "SELECT AVG(diff) as average_time FROM "
                . "(SELECT timereplied-timecreated as diff FROM {local_roomsupport_call_log} WHERE campusid=? AND buildingid=? $betweenTime AND timereplied != 0) count ";

        $minimumSql = "SELECT MIN(timereplied-timecreated) as total FROM {local_roomsupport_call_log} WHERE campusid=? AND buildingid=? $betweenTime AND timereplied != 0";

        $maximumSql = "SELECT MAX(timereplied-timecreated) as total FROM {local_roomsupport_call_log} WHERE campusid=? AND buildingid=? $betweenTime AND timereplied != 0";

        $totalCallsSql = "SELECT COUNT(id) as total FROM {local_roomsupport_call_log} WHERE campusid=? AND buildingid=? $betweenTime AND timereplied != 0";

        $average = $DB->get_record_sql($averageSql, $params);
        $minimum = $DB->get_record_sql($minimumSql, $params);
        $maximum = $DB->get_record_sql($maximumSql, $params);
        $totalCalls = $DB->get_record_sql($totalCallsSql, $params);

        $respondTime = [
            'numberOfCalls' => $totalCalls->total,
            'avg' => $average->average_time,
            'shortest' => $minimum->total,
            'longest' => $maximum->total
        ];

        return $respondTime;
    }

}
