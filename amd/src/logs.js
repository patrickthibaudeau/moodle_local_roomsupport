define(['jquery', 'jqueryui', 'local_roomsupport/select2'], function ($, jqui, select2) {
    "use strict";

    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function initLogs() {
        var wwwroot = M.cfg.wwwroot;
        $('#buildingId').change(function () {
            var buildingId = $(this).val();
            var campusId = $(this).data('campusid');
            window.location = wwwroot + '/local/roomsupport/reports/logs.php?buildingid=' + buildingId + '&campusid=' + campusId;
        });
    }

    return {
        init: function () {
            initLogs();
        }
    };
});