define(['jquery', 'jqueryui', 'local_roomsupport/select2'], function ($, jqui, select2) {
    "use strict";

    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function initDashboard() {
        initEditModal();
        initDeleteModal();
        rebootPi();
        reloadContents();
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
                    $('#piId').val(id);
                    $('#buildingLongName').val(results.building_longname);
                    $('#buildingShortName').val(results.building_shortname);
                    $('#roomNumber').val(results.room_number);
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

            $('#savePiBtn').click(function () {
                var formData = $('#editPiForm').serialize();
                console.log(formData);
                $.ajax({
                    url: wwwroot + '/local/roomsupport/ajax/dashboard.php?action=save',
                    data: formData,
                    dataType: 'html',
                    success: function (results) {
                        console.log(results);
                        $('#raspberryPiContainer').html(results);
                        $("#editModal").modal('hide');
                        initDashboard();
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