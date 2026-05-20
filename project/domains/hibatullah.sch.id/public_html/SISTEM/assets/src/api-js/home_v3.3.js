$(function () {
  $("#Periode_Chek").change(function () {
    var ta = $(this).val();
    $.ajax({
      url: url + "dashboard/get_data_ta/" + ta,
      dataType: "json",
      success: function (data) {
        console.log(data);
        $("#AllPendaftar").html(data.pendaftar);
        $("#LunaFromulir").html(data.valid);
        $("#LunasTes").html(data.migrasi);
        $("#Periode").html("(" + data.periode + ")");
      },
    });
  });
});

$(".BtnABS").click(function () {
  var abs = $(this).data("absen");
  var pkt = $(this).data("piket");
  $.ajax({
    url: url + "absensi/getdata_abs",
    method: "POST",
    data: {
      abs: abs,
      pkt: pkt,
    },
    dataType: "json",
    success: function (data) {
      //console.log(data);
      $(".ABSSHOW").html(data.html);
      $(".ModalABS").modal("show");
    },
  });
});
$(".ABSSHOW").on("click", "button.BTNABSNOW", function () {
  // 	if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
  // 		console.log("Let's get this party started");
  // 		navigator.mediaDevices.getUserMedia({video: true})
  // }
  var dtabs = $(this).data("abstoken");

  $.ajax({
    url: url + "absensi/absen_now",
    method: "POST",
    data: {
      dtabs: dtabs,
    },
    dataType: "json",
    success: function (data) {
      console.log(data);
      $(".ModalABS").modal("hide");
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
