define(['jquery', 'jqueryui', 'local_roomsupport/daterangepicker'], function ($, jqui, daterangepicker) {
    "use strict";

    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function init() {
        datePicker();
    }

    /**
     * Update alertsContainer every 2 seconds
     * @returns {undefined}
     */
    function datePicker() {
        var wwwroot = M.cfg.wwwroot;
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        console.log(startDate);
        $('#dateRange').daterangepicker({
            opens: 'left',
            startDate: startDate,
            endDate: endDate,
        });

        $('#dateRange, #buildingId').change(function () {
            var dateRange = $('#dateRange').val();
            var campusId = $("#campusId").val();
            var buildingId = $("#buildingId").val();
            window.location = wwwroot + '/local/roomsupport/reports/statistics.php?daterange=' + dateRange
                    + '&campusid=' + campusId + '&buildingid=' + buildingId;

        });
    }
    
    return {
        init: function () {
            init();
        }
    };
});