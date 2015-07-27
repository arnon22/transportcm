/**
 * Created with JetBrains PhpStorm.
 * User : sadoknet@gmail.com
 * Date: 26/11/12
 * Time: 16:59
 * To change this template use File | Settings | File Templates.
 */
jQuery(document).ready(function () {
    _CSVExport.init();
});

var _CSVExport = (function () {

    function _init() {
        $("#exported_table_csv").change(function () {
            var _this = $(this);
            $.ajax({
                type:'POST',
                url:URL + '/export/csv_fields',
                data:'tableName=' + _this.val(),
                success:function (msg) {
                    $("#field-list-div").html(msg);
                }
            })
        });
        $("#exported_table_xls").change(function () {
            var _this = $(this);
            $.ajax({
                type:'POST',
                url:URL + '/export/excel_fields',
                data:'tableName=' + _this.val(),
                success:function (msg) {
                    $("#field-list-div").html(msg);
                }
            })
        });
        $("#exported_table_pdf").change(function () {
            var _this = $(this);
            $.ajax({
                type:'POST',
                url:URL + '/export/pdf_fields',
                data:'tableName=' + _this.val(),
                success:function (msg) {
                    $("#field-list-div").html(msg);
                }
            })
        });
        $("#imported_table").change(function () {
            var _this = $(this);
            $.ajax({
                type:'POST',
                url:URL + '/import/csv_fields',
                data:'tableName=' + _this.val(),
                success:function (msg) {
                    $("#field-list-div").html(msg);
                    $("#update_query_1").click(function () {
                        $(".update-query-notice").fadeIn('slow');
                    });

                    $("#update_query_2").click(function () {
                        $(".update-query-notice").fadeOut('slow');
                    });
                }
            })
        });

        $("#imported_table_xls").change(function () {
            var _this = $(this);
            $.ajax({
                type:'POST',
                url:URL + '/import/excel_fields',
                data:'tableName=' + _this.val(),
                success:function (msg) {
                    $("#field-list-div").html(msg);
                    $("#update_query_1").click(function () {
                        $(".update-query-notice").fadeIn('slow');
                    });

                    $("#update_query_2").click(function () {
                        $(".update-query-notice").fadeOut('slow');
                    });
                }
            })
        });

    }

    return {init:_init}
})();