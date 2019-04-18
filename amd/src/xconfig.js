define([], function () {
    window.requirejs.config({
        paths: {
            "moment": M.cfg.wwwroot + '/local/roomsupport/js/daterangepicker/moment.min',
            "DataTable": M.cfg.wwwroot + '/local/roomsupport/js/datatable_1_10_18/DataTables-1.10.18/js/jquery.dataTables.min',
            "dtbuttons": M.cfg.wwwroot + '/local/roomsupport/js/datatable_1_10_18/Buttons-1.5.2/js/dataTables.buttons.min',
            "html5buttons": M.cfg.wwwroot + '/local/roomsupport/js/datatable_1_10_18/Buttons-1.5.2/js/buttons.html5.min',
            "jszip": M.cfg.wwwroot + '/local/roomsupport/js/datatable_1_10_18/JSZip-2.5.0/jszip.min',
            "pdfmake": M.cfg.wwwroot + '/local/roomsupport/js/datatable_1_10_18/pdfmake-0.1.36/pdfmake.min',
            "vfs": M.cfg.wwwroot + '/local/roomsupport/js/datatable_1_10_18/pdfmake-0.1.36/vfs_fonts.min',
            "daterangepicker": M.cfg.wwwroot + '/local/roomsupport/js/daterangepicker/daterangepicker.min',
            "select2": M.cfg.wwwroot + '/local/roomsupport/js/select2-4.0.3/dist/js/select2.min',
        },
        shim: {
            'moment': {exports: 'moment'},
            'DataTable': {exports: 'DataTable'},
            'dtbuttons': {exports: 'dtbuttons'},
            'html5buttons': {exports: 'html5buttons'},
            'jszip': {exports: 'jszip'},
            'pdfmake': {exports: 'pdfmake'},
            'vfs': {exports: 'vfs'},
            'daterangepicker': {exports: 'daterangepicker'},
            'select2': {exports: 'select2'}
        }
    });
});
