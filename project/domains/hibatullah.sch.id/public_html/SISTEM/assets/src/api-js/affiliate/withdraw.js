$(function () {
  var groupColumn = 1;
  var table = $("#Table1set").DataTable({
    ajax: url + "affiliate_api/withdraw/get_data",
    deferRender: true,
    lengthChange: false,
    scrollCollapse: false,
    autoWidth: false,
    responsive: true,
    searching: true,
    initComplete: function () {
      if (lvl_usr == 1) {
        table.column(4).visible(true);
        table.column(6).visible(true);
      } else {
        table.column(4).visible(false);
        table.column(6).visible(false);
      }
    },
  });

  $("#Periode_Chek").change(function () {
    var ta = $(this).val();
    var aff = $("#Affliator").val();
    table.ajax
      .url(url + "affiliate_api/withdraw/get_data/" + ta + "/" + aff)
      .ajax.reload();
    console.log(url + "affiliate_api/withdraw/get_data/" + ta + "/" + aff);
  });
  $("#Affliator").change(function () {
    var aff = $(this).val();
    var ta = $("#Periode_Chek").val();
    table.ajax
      .url(url + "affiliate_api/withdraw/get_data/" + ta + "/" + aff)
      .ajax.reload();
    console.log(url + "affiliate_api/withdraw/get_data/" + ta + "/" + aff);
  });

  $("#Table1set").on("click", ".Confirm", function () {
    var token = $(this).data("dataset");
    // console.log(dataset);
    $.ajax({
      url: url + "affiliate_api/withdraw/confirm",
      method: "POST",
      data: {
        token: token,
      },
      dataType: "json",
      error: function (r) {
        console.log(r.responseText);
        alert("error!");
      },
      beforeSend: function () {
        $(".loader").show(0);
      },
      success: function (data) {
        console.log(data);
        $(".loader").fadeOut(300);
        table.ajax.reload();
        $(".event-icon").html(
          "<i class='fa fa-" +
            data.event.icon +
            "'  style='color:" +
            data.event.color +
            "'></i>"
        );
        $(".event-title").html(data.event.title);
        $(".event-body").html(data.event.description);
        $(".event-footer").html(data.event.footer);
        $("#Msg-Notification").modal("show");
      },
    });
  });

  $(".ReloadData").click(function () {
    table.ajax.reload();
    // console.log("OK");
  });
});
