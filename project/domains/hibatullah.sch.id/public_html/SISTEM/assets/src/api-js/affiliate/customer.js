$(function () {
  var groupColumn = 1;
  var table = $("#Table1set").DataTable({
    ajax: url + "affiliate_api/customer/get_data",
    deferRender: true,
    lengthChange: false,
    scrollCollapse: false,
    autoWidth: false,
    responsive: true,
    searching: true,
    initComplete: function () {
      if (lvl_usr == 1) {
        table.column(4).visible(true);
      } else {
        table.column(4).visible(false);
      }
    },
  });

  $("#Affliator").change(function () {
    var aff = $(this).val();
    table.ajax
      .url(url + "affiliate_api/customer/get_data/" + aff)
      .ajax.reload();
    console.log(url + "affiliate_api/customer/get_data/" + aff);
  });
});
