<?php
/**
 * *************************************************************************
 * *                     Norquest Curriculum Settings                     **
 * *************************************************************************
 * @package     local                                                     **
 * @subpackage  roomsupport                                               **
 * @name        Norquest Curriculum Settings                              **
 * @copyright   Oohoo IT Services Inc.                                    **
 * @link                                                                  **
 * @author      Patrick Thibaudeau                                        **
 * @author      Kais Abid                                                 **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace local_roomsupport\output;
/**
 * Description of renderer
 *
 * @author patrick
 */
class renderer extends \plugin_renderer_base {
    
    public function render_dashboard(\templatable $dashboard) {
        $data = $dashboard->export_for_template($this);
        return $this->render_from_template('local_roomsupport/dashboard', $data);
    }
    
    public function render_faqs(\templatable $faqs) {
        $data = $faqs->export_for_template($this);
        return $this->render_from_template('local_roomsupport/faqs', $data);
    }
    
    public function render_agent(\templatable $agent) {
        $data = $agent->export_for_template($this);
        return $this->render_from_template('local_roomsupport/agent', $data);
    }
    
    public function render_faq_alerts(\templatable $alerts) {
        $data = $alerts->export_for_template($this);
        return $this->render_from_template('local_roomsupport/faq_alerts', $data);
    }
    
    public function render_logs(\templatable $logs) {
        $data = $logs->export_for_template($this);
        return $this->render_from_template('local_roomsupport/logs', $data);
    }
    
    public function render_statistics(\templatable $statistics) {
        $data = $statistics->export_for_template($this);
        return $this->render_from_template('local_roomsupport/statistics', $data);
    }

    
}

