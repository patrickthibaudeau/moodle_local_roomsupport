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
    public static function getDeviceCalls($from = null, $to = null) {
        global $DB;

        if (!is_null($from)) {
            if (is_null($to)) {
                $to = time();
            }
            $deviceSql = 'SELECT DISTINCT(rpiid) as id FROM {local_roomsupport_call_log}'
                    . ' WHERE timecreated BETWEEN ' . $from . ' AND ' . $to;
        } else {
            $deviceSql = 'SELECT DISTINCT(rpiid) as id FROM {local_roomsupport_call_log}';
        }

        $devices = $DB->get_records_sql($deviceSql);

        $dataSets = [];
        $labels = [];
        foreach ($devices as $d) {
            $countSql = 'SELECT COUNT(rpiid) as total FROM {local_roomsupport_call_log} WHERE rpiid = ?';
            $RPI = new \local_roomsupport\RaspberryPi($d->id);
            $count = $DB->get_record_sql($countSql, [$d->id]);

            $labels[] = $RPI->getBuildingShortName() . ' ' . $RPI->getRoomNumber();
            $dataSets[] = $count->total;
        }
        $data = ['data' => new \core\chart_series('Calls to rooms', $dataSets), 'labels' => $labels];

        return $data;
    }

    /**
     * Returns array of agents and the number of calls answered.
     * @global type $DB
     */
    public static function getAgents($from = null, $to = null) {
        global $DB;

        if (!is_null($from)) {
            if (is_null($to)) {
                $to = time();
            }
            $agentsSql = 'SELECT DISTINCT(agentid) as id FROM {local_roomsupport_call_log}'
                    . ' WHERE timecreated BETWEEN ' . $from . ' AND ' . $to;
        } else {
            $agentsSql = 'SELECT DISTINCT(agentid) as id FROM {local_roomsupport_call_log}';
        }
        $agents = $DB->get_records_sql($agentsSql);

        $dataSets = [];
        $labels = [];
        foreach ($agents as $a) {
            $countSql = 'SELECT COUNT(agentid) as total FROM {local_roomsupport_call_log} WHERE agentid = ?';
            if ($user = $DB->get_record('user', ['id' => $a->id])) {
                $name = fullname($user);
            } else {
                $name = get_string('unanswered', 'local_roomsupport');
            }
            $count = $DB->get_record_sql($countSql, [$a->id]);

            $labels[] = $name;
            $dataSets[] = $count->total;
        }
        $data = ['data' => new \core\chart_series(get_string('number_of_calls_answered', 'local_roomsupport'), $dataSets), 'labels' => $labels];

        return $data;
    }

    public static function getDifferenceTimeCreatedTimeReplied($from = null, $to = null) {
        global $DB;

        if (!is_null($from)) {
            if (is_null($to)) {
                $to = time();
            }
            $averageSql = "SELECT AVG(diff) as average_time FROM "
                    . "(SELECT timereplied-timecreated as diff FROM {local_roomsupport_call_log} WHERE timereplied != 0"
                    . " AND timecreated BETWEEN  $from  AND  $to ) count ";

            $minimumSql = "SELECT MIN(timereplied-timecreated) as total FROM {local_roomsupport_call_log} WHERE timereplied != 0"
                    . " AND timecreated BETWEEN  $from  AND  $to";

            $maximumSql = "SELECT MAX(timereplied-timecreated) as total FROM {local_roomsupport_call_log} WHERE timereplied != 0"
                    . " AND timecreated BETWEEN $from  AND  $to";

            $totalCallsSql = "SELECT COUNT(id) as total FROM {local_roomsupport_call_log} WHERE timereplied != 0"
                    . " AND timecreated BETWEEN $from  AND $to";
        } else {
            $averageSql = "SELECT AVG(diff) as average_time FROM "
                    . "(SELECT timereplied-timecreated as diff FROM {local_roomsupport_call_log} WHERE timereplied != 0) count ";

            $minimumSql = "SELECT MIN(timereplied-timecreated) as total FROM {local_roomsupport_call_log} WHERE timereplied != 0";

            $maximumSql = "SELECT MAX(timereplied-timecreated) as total FROM {local_roomsupport_call_log} WHERE timereplied != 0";

            $totalCallsSql = "SELECT COUNT(id) as total FROM {local_roomsupport_call_log} WHERE timereplied != 0";
        }
        $average = $DB->get_record_sql($averageSql);
        $minimum = $DB->get_record_sql($minimumSql);
        $maximum = $DB->get_record_sql($maximumSql);
        $totalCalls = $DB->get_record_sql($totalCallsSql);

        $respondTime = [
            'numberOfCalls' => $totalCalls->total,
            'avg' => $average->average_time,
            'shortest' => $minimum->total,
            'longest' => $maximum->total
        ];

        return $respondTime;
    }

}
