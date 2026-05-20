<div class="modal fade Msg-Notification" id="Msg-Notification" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class=" modal-content">
            <div class="modal-body">
                <h4 class="h4-notif"><span class="event-icon weight-auto mr-3" style="font-size: 40px;"></span></h4>
                <h4 class="h4-notif"><span class="event-title"></span></h4>
                <div class="event-body text-center mb-1"></div>
                <hr>
                <div class="text-center event-footer mt-1">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- js -->
<script src="<?= base_url("assets/") ?>vendors/scripts/core.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets/') ?>src/scripts/daterangepicker.min.js"></script>
<script src="<?= base_url("assets/") ?>vendors/scripts/bootstrap-select.js"></script>
<script src="<?= base_url("assets/") ?>src/plugins/bootstrap/bootstrap.js"></script>
<script src="<?= base_url("assets/") ?>vendors/scripts/script_v1.js"></script>
<!-- <script src="<?= base_url("assets/") ?>src/scripts/setting.js"></script> -->
<script src="<?= base_url("assets/") ?>vendors/scripts/process.js"></script>
<script src="<?= base_url("assets/") ?>vendors/scripts/layout-settings.js"></script>
<script src="<?= base_url("assets/") ?>src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url("assets/") ?>src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url("assets/") ?>src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url("assets/") ?>src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url("assets/") ?>src/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?= base_url("assets/") ?>src/scripts/jquery.validate.min.js"></script>
<script src="<?= base_url("assets/") ?>src/plugins/switchery/switchery.min.js"></script>
<script src="<?= base_url("assets/") ?>src/scripts/jquery.steps.js"></script>
<script src="<?= base_url("assets/") ?>src/scripts/step_setting.js"></script>
<script src="<?= base_url("assets/") ?>src/plugins/jquery-asColor/dist/jquery-asColor.js"></script>
<script src="<?= base_url("assets/") ?>src/plugins/jquery-asGradient/dist/jquery-asGradient.js"></script>
<script src="<?= base_url('assets/') ?>src/plugins/jquery-asColorPicker/jquery-asColorPicker.js"></script>
<script src="<?= base_url('assets/') ?>vendors/scripts/colorpicker.js"></script>
<script>
    var cabang_usr = '<?= $this->session->userdata("fid_cabang"); ?>';
    var lvl_usr = '<?= $this->session->userdata("idlevel"); ?>';
</script>
<?php if (!empty($data_plug) && !empty($action)) : ?>
    <script>
        var url = '<?= base_url(); ?>';
    </script>
    <?php if ($data_plug == 'datatable') : ?>
        <!-- buttons for Export datatable -->
        <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/dataTables.buttons.min.js"></script>
        <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
        <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/dataTables.select.min.js"></script>
        <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/buttons.print.min.js"></script>
        <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/buttons.html5.min.js"></script>
        <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/buttons.flash.min.js"></script>
        <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/pdfmake.min.js"></script>
        <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/vfs_fonts.js"></script>
        <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/jszip.min.js"></script>
        <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/buttons.colVis.min.js"></script>
        <script src="<?= base_url('assets/') ?>src/plugins/datatables/js/dataTables.fixedColumns.min.js"></script>
        <script src="<?= base_url('assets/') ?>src/scripts/Table-data.js"></script>
        <?php if ($action != null) : ?>
            <script src="<?= base_url('assets/') ?>src/scripts/numeral.js"></script>
            <script src="<?= base_url('assets/') ?>src/api-js/<?= $action ?>.js"></script>
        <?php endif; ?>
    <?php endif ?>
<?php endif ?>
<script>
    $('#Table1setA').DataTable({
        deferRender: true,
        processing: true,
        language: {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        lengthChange: false,
        scrollCollapse: false,
        autoWidth: false,
        responsive: false,
        searching: true,
    });
    $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format(' D MMMM, YYYY') + ' - ' + end.format(' D MMMM, YYYY'));
            $('#DS').val(start.format('YYYY-MM-DD'));
            $('#DE').val(end.format('YYYY-MM-DD'));
        }
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
    });
</script>
</body>

</html>