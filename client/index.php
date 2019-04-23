<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
global $CFG;
include_once('../config.php');
$IP = $_SERVER['REMOTE_ADDR'];
$rpi = $DB->get_record('local_roomsupport_rpi', ['ip' => $IP]);
$RPI = new \local_roomsupport\RaspberryPi($rpi->id);
?>
<html>
    <?php include_once('header.php') ?>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="#"><strong><?php echo $RPI->getRoomNumber(); ?></strong></a>
        </nav>
        <main class="container-fluid mt-10" role="main">            
            <div class="row">
                <div class="col">
                    <a href="details.php?lang=fr" class="btn btn-primary btn-fullscreen" ><?php echo get_string('request_help_fr', 'local_roomsupport'); ?></a>
                </div>
                <div class="col">
                    <a href="details.php?lang=en" class="btn btn-primary btn-fullscreen" ><?php echo get_string('request_help_en', 'local_roomsupport'); ?></a>
                </div>
            </div>
        </main>
        <script src="js/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
    </body>
</html>
