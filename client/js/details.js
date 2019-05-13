var callInterval;
var wwwroot = $('#wwwroot').val();
var token = $('#token').val();
var ip = $('#ip').val();
var mac = $('#mac').val();

function callHelp() {
    //Check to see if service hours are open
    isServiceOpen();

    $('.helpBtn').click(function () {
        $('.helpBtn').unbind();
        $.ajax({
            url: wwwroot + '/webservice/rest/server.php?wstoken=' + token,
            data: '&wsfunction=roomsupport_get_help_call&mac=' + mac + '&moodlewsrestformat=json',
            dataType: 'json',
            success: function (results) {
                $('#helpModal').modal({
                    backdrop: 'static',
                    show: true
                });
                //Only show the close button once an agent has answered.
                $('#updateStatus').hide();
                $('#agentResponded').hide();
                checkStatus(wwwroot, token, mac);

            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('#updateStatus').click(function () {
        var wwwroot = $(this).data('wwwroot');
        var token = $(this).data('token');
        var ip = $(this).data('ip');
        var mac = $(this).data('mac');
        $.ajax({
            url: wwwroot + '/webservice/rest/server.php?wstoken=' + token,
            data: '&wsfunction=roomsupport_update_status&mac=' + mac + '&moodlewsrestformat=json',
            dataType: 'json',
            success: function (results) {
                document.location = 'index.php?mac=' + mac;
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

}

function checkStatus(wwwroot, token, mac) {
    $.ajax({
        url: wwwroot + '/webservice/rest/server.php?wstoken=' + token,
        data: '&wsfunction=roomsupport_check_status&mac=' + mac + '&moodlewsrestformat=json',
        dataType: 'json',
        success: function (results) {
            console.log(results);
            if (results[0].agent == "false") {
                clearInterval(callInterval);
                callInterval = setInterval(function () {
                    checkStatus(wwwroot, token, mac);
                }, 2000);
            } else {
                var data = results[0];
                $('#agentName').html(data.agent);
                $('#updateStatus').show();
                $('#agentResponded').show();
                clearInterval(callInterval);
            }
        },
        error: function (e) {
            console.log(e);
        }
    });
}

function isServiceOpen() {
    console.log(wwwroot + '/webservice/rest/server.php?wstoken=' + token + '&wsfunction=roomsupport_service_open&mac=' + mac + '&moodlewsrestformat=json');
    $.ajax({
        url: wwwroot + '/webservice/rest/server.php?wstoken=' + token,
        data: '&wsfunction=roomsupport_service_open&mac=' + mac + '&moodlewsrestformat=json',
        dataType: 'json',
        success: function (results) {
            console.log(results[0].open)
            if (results[0].open == "1") {
                $('.helpBtn').show();
                $('#itWorksBtn').show();
                $('#serviceClosed').hide();
            } else {
                $('.helpBtn').hide();
                $('#itWorksBtn').hide();
                $('#serviceClosed').show();
            }
        },
        error: function (e) {
            console.log(e);
        }
    });
}