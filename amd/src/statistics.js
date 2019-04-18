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

        $('#dateRange').change(function () {
            var dateRange = $(this).val();
            window.location = wwwroot + '/local/roomsupport/reports/statistics.php?daterange=' + dateRange;
//            $.ajax({
//                url: wwwroot + '/local/roomsupport/ajax/statistics.php?action=changeDate',
//                data: '&daterange=' + dateRange,
//                dataType: 'html',
//                success: function (results) {
//                    console.log(results);
//                },
//                error: function (e) {
//                    console.log(e);
//                }
//            });
        });
    }
    
    return {
        init: function () {
            init();
        }
    };
});