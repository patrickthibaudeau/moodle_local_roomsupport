<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once('../config.php');
global $CFG, $DB, $OUTPUT;
$IP = $_SERVER['REMOTE_ADDR'];
$lang = optional_param('lang', 'en', PARAM_TEXT);

if ($device = $DB->get_record('local_roomsupport_rpi', ['ip' => $IP])) {
    $FAQ = new \local_roomsupport\Faq($device->faqid);

    if (current_language() == 'en') {
        $content = $FAQ->getMessageEn();
    } else {
        $content = $FAQ->getMessageFr();
    }
} else {
    $content = $IP;
}
?>
<html>
    <?php include_once('header.php') ?>
    <body>
        <input type="hidden" id="wwwroot" value="<?php echo $CFG->wwwroot ?>">
        <input type="hidden" id="token" value="<?php echo $CFG->roomsupport_pi_token; ?>">
        <input type="hidden" id="ip" value="<?php echo $IP ?>">
        <div class="container-fluid">
            <div id="displayContainer">
                <div class="card mt-2 mb-5">
                    <div class="card-body">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <a href="index.php" class="btn btn-outline-danger btn-lg mr-3" id="serviceClosed">
                        <?php echo get_string('services_closed', 'local_roomsupport');?>
                    </a>
                    <span class="float-right">
                        <a href="index.php" id="itWorksBtn" class="btn btn-outline-success btn-lg mr-2"><?php echo get_string('it_works', 'local_roomsupport'); ?></a>
                        <a href="javascript:void(0);" class="btn btn-outline-danger btn-lg helpBtn"><?php echo get_string('help', 'local_roomsupport'); ?></a>
                    </span>
                </div>
            </nav>
        </div>

        <!-- Modal used for help call -->
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="helpModalLabel"><?php echo get_string('help', 'local_roomsupport') ?></h5>
                        <!--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>-->
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <h4><?php echo get_string('agent_has_been_called', 'local_roomsupport'); ?></h4>
                        </div>
                        <div id="agentResponded" class="alert alert-success mt-3">
                            <h4><span id="agentName"></span> <?php echo get_string('agent_on_the_way', 'local_roomsupport'); ?></h4>
                        </div>                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="updateStatus" class="btn btn-danger" 
                                data-ip="<?php echo $IP; ?>" 
                                data-token="<?php echo $CFG->roomsupport_pi_token; ?>"
                                data-wwwroot="<?php echo $CFG->wwwroot ?>"><?php echo get_string('close', 'local_roomsupport'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo $CFG->wwwroot; ?>/local/roomsupport/client/js/jquery-3.3.1.min.js" /></script>
    <script src="<?php echo $CFG->wwwroot; ?>/local/roomsupport/client/js/bootstrap.min.js" /></script>
<script src="<?php echo $CFG->wwwroot; ?>/local/roomsupport/client/js/details.js" /></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('img').each(function () {
            $(this).removeAttr('width')
            $(this).removeAttr('height');
            $(this).addClass('img-fluid');
            $(this).removeClass('atto_image_button_text-bottom');
            $(this).removeClass('img-responsive');
        });

        callHelp();
    });
</script>
</body>
</html>
