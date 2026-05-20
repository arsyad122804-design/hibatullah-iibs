
            $(document).ready(function() {

                var table1 = $('#Table1').DataTable({
                    lengthChange: false,
                    scrollCollapse: true,
                    autoWidth: false,
                    responsive: true,
                    buttons: [{
                            extend: 'pdf',
                            text: '<i class="ti-printer"> </i> Pdf',
                            className: 'TableButtosPrimary btn-sm rounded-0 border-0 '
                        },
                        {
                            extend: 'excel',
                            text: '<i class="ti-printer"> </i> Excel',
                            className: 'TableButtosPrimary btn-sm rounded-0 border-0 '
                        },
                    ]
                });
                table1.buttons().container()
                    .appendTo('#Table1_wrapper .col-md-6:eq(0)');

                $('.Table_pag').DataTable({
                    "paging": true,
                    "searching": false,
                });
            });

            function reload() {
                document.location.reload(true)
            }
            $(document).ready(function() {
                if ($(document).width() < 500) {
                    $(".loader").addClass("m-load");
                } else {
                    $(".loader").removeClass("m-load");
                }
            });