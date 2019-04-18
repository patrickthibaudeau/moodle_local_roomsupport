define(['jquery', 'jqueryui'], function ($, jqui) {
    "use strict";

    var callInterval;
    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function init() {
        checkIncomingRequests();
        onMyWay();
    }

    /**
     * Update alertsContainer every 2 seconds
     * @returns {undefined}
     */
    function checkIncomingRequests() {
        var wwwroot = M.cfg.wwwroot;        
        $.ajax({
            url: wwwroot + '/local/roomsupport/ajax/agent.php?action=check',
            dataType: 'html',
            success: function (results) {
                $('#alertsContainer').html(results);
                onMyWay();
                clearInterval(callInterval);
                callInterval = setInterval(function () {
                    checkIncomingRequests();
                }, 2000);
            },
            error: function (e) {
                console.log(e);
            }
        });

    }

    function onMyWay() {
        var wwwroot = M.cfg.wwwroot;
        $('.onMyWay').click(function () {
            $('.onMyWay').unbind();
            var id = $(this).data('id');
            $.ajax({
                url: wwwroot + '/local/roomsupport/ajax/agent.php?action=onmyway&id=' + id,
                dataType: 'json',
                success: function (result) {
                    console.log(result);
                    init();
                },
                error: function (e) {
                    console.log(e);
                }
            });
        });
    }


    return {
        init: function () {
            init();
        }
    };
});