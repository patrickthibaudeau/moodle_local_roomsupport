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
?>
<html>
    <?php include_once('header.php')?>
    <body>
        <div class="container-fluid mt-10">
            <div class="row">
                <div class="col">
                    <a href="details.php?lang=fr" class="btn btn-primary btn-fullscreen" ><?php echo get_string('request_help_fr', 'local_roomsupport'); ?></a>
                </div>
                <div class="col">
                    <a href="details.php?lang=en" class="btn btn-primary btn-fullscreen" ><?php echo get_string('request_help_en', 'local_roomsupport'); ?></a>
                </div>
            </div>
        </div>
        <script src="js/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
    </body>
</html>
