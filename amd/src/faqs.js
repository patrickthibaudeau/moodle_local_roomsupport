define(['jquery', 'jqueryui', 'local_roomsupport/select2'], function ($, jqui, select2) {
    "use strict";

    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function initFaqs() {
        initDeleteModal();
    }

    

    function initDeleteModal() {
        var wwwroot = M.cfg.wwwroot;

        $('.deleteFaq').click(function () {
            var id = $(this).data('id');
            console.log(id);
            var content = M.util.get_string('delete_faq_confirmation', 'local_roomsupport');
            $('#delete-content').html(content);
            $("#deleteModal").modal({
                show: true,
                focus: true
            });
            $('#deleteBtn').click(function () {
                $.ajax({
                    url: wwwroot + '/local/roomsupport/ajax/faq.php?action=delete&id=' + id,
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

    return {
        init: function () {
            initFaqs();
        }
    };
});