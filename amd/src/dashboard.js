define(['jquery', 'jqueryui', 'local_roomsupport/select2'], function ($, jqui, select2) {
    "use strict";

    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function initDashboard() {
        load();
        initEditModal();
        initDeleteModal();
        rebootPi();
        reloadContents();
    }

    function load() {
        $('#changeCampusSelectContainer').hide();
        $('#changeCampus').click(function () {
            $(this).hide();
            $('#changeCampusSelectContainer').show();
        });

        $('#campusId').change(function () {
            var campusId = $(this).val();
            window.location = 'index.php?campusid=' + campusId;
        });
    }

    /**
     * Holds all functionality for the user select box
     * @returns {undefined}
     */
    function initEditModal() {
        var wwwroot = M.cfg.wwwroot;

        $(".editRpi").click(function () {
            $('#savePiBtn').unbind();
            var id = $(this).data('id');
            $.ajax({
                url: wwwroot + '/local/roomsupport/ajax/dashboard.php?action=getInfo&id=' + id,
                dataType: 'json',
                success: function (results) {
                    console.log(results);
                    var faqs = results.faqs;
                    $('#piId').val(id);
                    $('#buildingId').val(results.buildingid);
                    $('#roomId').val(results.roomid);
                    $('#faqId').empty();
                        for(var i=0; i < Object.keys(faqs).length; i++) {
                            $("<option value='" + faqs[i].id + "'>" + faqs[i].name + "</option>").appendTo("#faqId");
                        }
                    $('#faqId').val(results.faqid);
                    
                },
                error: function (e) {
                    console.log(e);
                }
            });

            $("#editModal").modal({
                show: true,
                focus: true
            });

            $('#buildingId').change(function () {
                var buildingId = $(this).val();
                //Get rooms
                $.ajax({
                    url: wwwroot + '/local/roomsupport/ajax/dashboard.php?action=getRooms&buildingid=' + buildingId,
                    dataType: 'json',
                    success: function (results) {
                        console.log(results[1]['number']);
                        $('#roomId').empty();
                        for(var i=0; i < Object.keys(results).length; i++) {
                            $("<option value='" + results[i].id + "'>" + results[i].number + "</option>").appendTo("#roomId");
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
                //Get FAQs
                $.ajax({
                    url: wwwroot + '/local/roomsupport/ajax/dashboard.php?action=getFaqs&buildingid=' + buildingId,
                    dataType: 'json',
                    success: function (results) {
                        console.log(results[0]['name']);
                        $('#faqId').empty();
                        for(var i=0; i < Object.keys(results).length; i++) {
                            $("<option value='" + results[i].id + "'>" + results[i].name + "</option>").appendTo("#faqId");
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });

            $('#savePiBtn').click(function () {
                var formData = $('#editPiForm').serialize();
                console.log(formData);
                $.ajax({
                    url: wwwroot + '/local/roomsupport/ajax/dashboard.php?action=save',
                    data: formData,
                    dataType: 'html',
                    success: function (results) {
                        location.reload();
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });

            });
        });

    }

    function initDeleteModal() {
        var wwwroot = M.cfg.wwwroot;

        $('.deleteRpi').click(function () {
            var id = $(this).data('id');
            console.log(id);
            var content = M.util.get_string('delete_confirmation', 'local_roomsupport');
            $('#delete-content').html(content);
            $("#deleteModal").modal({
                show: true,
                focus: true
            });
            $('#deleteBtn').click(function () {
                $.ajax({
                    url: wwwroot + '/local/roomsupport/ajax/dashboard.php?action=delete&id=' + id,
                    dataType: 'text',
                    success: function (deleted) {
                        location.reload();
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });
        });
    }

    function rebootPi() {
        var wwwroot = M.cfg.wwwroot;

        $('.rebootRpi').click(function () {
            $('.rebootRpi').unbind();
            var id = $(this).data('id');
            console.log(id);

            $.ajax({
                url: wwwroot + '/local/roomsupport/ajax/dashboard.php?action=reboot&id=' + id,
                dataType: 'text',
                success: function (rebooted) {
                    alert('System is rebooting');
                    initDashboard();
                },
                error: function (e) {
                    console.log(e);
                }
            });

        });
    }

    /**
     * This will reload through ajax the devices
     * every 2 minutes.
     */
    function reloadContents() {
        var wwwroot = M.cfg.wwwroot;

        setInterval(function () {
            $('.modal').modal('hide');
            $.ajax({
                url: wwwroot + '/local/roomsupport/ajax/dashboard.php?action=reload',
                dataType: 'html',
                success: function (result) {
                    $('#deviceContainer').html(result);
                    initDashboard();
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }, 1000 * 60 * 2);

    }

    return {
        init: function () {
            initDashboard();
        }
    };
});