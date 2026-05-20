$(function () {
  var groupColumn = 1;
  var table = $("#Table1set").DataTable({
    ajax: url + "pmb_api/pembayaran_seleksi/get_data",
    deferRender: true,
    processing: true,
    language: {
      loadingRecords: "&nbsp;",
      processing: "Loading...",
    },
    lengthChange: false,
    scrollCollapse: false,
    autoWidth: false,
    responsive: true,
    searching: true,
    fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
      if (aData[3] == "Aktif") {
        $("td", nRow).css("background-color", "#aaff55");
      } else {
        $("td", nRow).css("background-color", "#fff");
      }
    },
  });

  $("#Periode_Chek").change(function () {
    var pr = $(this).val();
    console.log(url + "pmb_api/pembayaran_seleksi/get_data/" + pr);
    table.ajax
      .url(url + "pmb_api/pembayaran_seleksi/get_data/" + pr)
      .ajax.reload();
  });
  function clearData() {
    $(".Tingkat").val("").trigger("change");
    var tahun_periode = '<option value="">-Pilih Tahun Angkatan-</option>';
    $.ajax({
      url: url + "pmb_api/pembayaran_seleksi/get_master",
      method: "GET",
      dataType: "json",
      beforeSend: function () {
        $(".loader").show(0);
      },
      error: function (x) {
        alert(x.responseText);
        console.log(x.responseText);
      },
      success: function (data) {
        $.each(data.result, function (i, r) {
          tahun_periode +=
            '<option value="' +
            r.id_tahun +
            '">' +
            r.tahun_akademik +
            "</option>";
        });
        $(".Periode").html(tahun_periode);
        $(".loader").fadeOut(1000);
      },
    });

    $("#Aktif").val(1).trigger("change");
    $(".Nominal").val(0);
    $(".NumFormat").val("");
    $(".Jenis").val("");
  }

  $(".openform").click(function () {
    var opt = $(this).data("option");
    var id = $(this).data("id");
    clearData();
    $(".idTes").val("new");

    $("#new_Akademik_p").val("Simpan");
    $(".options").html(
      '<i class="fa fa-plus-circle"></i> ' + opt + " Pembayaran"
    );
    $("form .idTes").val(id);
    $(".FormOpenAkademik").modal();
  });

  $(".Tingkat").change(function () {
    var id = $(this).val();
    console.log(url + "pmb_api/pembayaran_seleksi/get_master/" + id);
    $.ajax({
      url: url + "pmb_api/pembayaran_seleksi/get_master/" + id,
      dataType: "json",
      beforeSend: function () {
        $(".loader").show(0);
      },
      error: function (x) {
        alert(x.responseText);
        console.log(x.responseText);
      },
      success: function (data) {
        // console.log(data);
        $(".loader").fadeOut(1000);

        var tahun_periode = '<option value="">-Pilih Tahun Angkatan-</option>';
        $.each(data.result, function (i, r) {
          tahun_periode +=
            '<option value="' +
            r.id_tahun +
            '">' +
            r.tahun_akademik +
            "</option>";
        });
        $(".Periode").html(tahun_periode);
      },
    });
  });

  $(".Periode").change(function () {
    var id = $(this).val();
    var data = $(".idTes").val();
    if (data === "new") {
      $.ajax({
        url: url + "pmb_api/pembayaran_seleksi/get_data_periode",
        method: "POST",
        data: {
          id: id,
        },
        dataType: "json",
        beforeSend: function () {
          $(".loader").show(0);
        },
        error: function (x) {
          alert(x.responseText);
          console.log(x.responseText);
        },
        success: function (data) {
          // console.log(data);
          $(".loader").fadeOut(1000);
          if (data.result > 0) {
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
            $("#Msg-Notification").modal();
            clearData();
          }
        },
      });
    }
  });

  $("#Table1set").on("click", ".openform", function () {
    var opt = $(this).data("option");
    var nm = $(this).data("nm");
    var id = $(this).data("id");
    $.ajax({
      url: url + "pmb_api/pembayaran_seleksi/get_data_by",
      method: "POST",
      data: {
        id: id,
      },
      dataType: "json",
      beforeSend: function () {
        $(".loader").show(0);

        $(".Periode").html("");
        $("#Aktif").val(1);
        $(".Nominal").val(0);
        $(".NumFormat").val("");
        $(".Jenis").val("");
      },
      error: function (x) {
        alert(x.responseText);
        console.log(x.responseText);
      },
      success: function (data) {
        $(".loader").fadeOut(1000);
        console.log(data);
        // $(".idTes").val(data.id_pembayaran_seleksi);
        $(".Jenis").val(data.jenis);
        $(".NumFormat").val(NumFormat(data.pembayaran));
        $(".Nominal").val(data.pembayaran);
        $("#Periode").html(
          '<option value="' +
            data.tahun_id +
            '">' +
            data.tahun_akademik +
            "</option>"
        );
        $(".Aktif").val(data.active).trigger("change");
        $("#new_Akademik_p").val("Edit Data");
        $(".options").html(
          '<i class="fa fa-plus-circle"></i> ' + opt + " Biaya Tes"
        );
        $("form .idTes").val(id);
        $(".FormOpenAkademik").modal();
      },
    });
  });

  $(".NumFormat").keyup(function () {
    var id = $(this).data("id");
    var nominal = $(this).val();
    if (nominal != "") {
      var nominal_string = numeral().unformat(nominal);
      var number = numeral(nominal_string);
      var nominal_number = number.format("0,0");
      $(".NS" + id).val(nominal_number);
      $(".N" + id).val(nominal_string);
    } else {
      $(".NS" + id).val(0);
      $(".N" + id).val("");
    }
  });
  $("form#periodik").on("submit", function (e) {
    if (!$(this).valid()) {
      e.preventDefault();
    } else {
      e.preventDefault();
      e.stopImmediatePropagation();
      $.ajax({
        url: $(this).attr("action"),
        method: "POST",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function () {
          $(".loader").show(0);
          $(".FormOpenAkademik").modal("hide");
        },
        error: function (x) {
          alert(x.responseText);
          console.log(x.responseText);
        },
        success: function (data) {
          table.ajax.reload();
          $(".loader").show(0).fadeOut(1000);
          // console.log(data);
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
          $("#Msg-Notification").modal();
        },
      });
    }
  });

  $("#Table1set").on("click", ".deletedata", function () {
    var nm = $(this).data("nm");
    var id = $(this).data("id");
    $(".event-icon").html("<i class='fa fa-trash'  style='color:#ff0000'></i>");
    $(".event-title").html(nm);
    $(".event-body").html("Yakin ingin menghapus data ini...?");
    $(".event-footer").html(
      "<button class='btn btn-primary btn-sm prosesdelete' data-id='" +
        id +
        "'  data-nm='" +
        nm +
        "'>Yakin!</button> " +
        '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">Tidak</button>'
    );
    $("#Msg-Notification").modal();
  });
  $("#Msg-Notification").on("click", ".prosesdelete", function () {
    var nm = $(this).data("nm");
    var id = $(this).data("id");
    $.ajax({
      url: url + "pmb_api/pembayaran_seleksi/hapusdata",
      method: "POST",
      data: {
        id: id,
        nm: nm,
      },
      dataType: "json",
      beforeSend: function () {
        setTimeout(function () {
          $(".loader").show(0).fadeOut(1000);
        }, time);
        $("#Msg-Notification").modal("hide");
      },
      error: function () {
        alert("error!");
      },
      success: function (data) {
        //console.log(data);
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
        $("#Msg-Notification").modal();
        table.ajax.reload();
      },
    });
  });

  $(".ReloadData").click(function () {
    table.ajax.reload();
  });
});

function NumFormat(num) {
  var result = "";
  if (num != null) {
    result = num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
  }
  return result;
}
function formarDate(e) {
  var date = new Date(e);

  var month = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",

    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ][date.getMonth()];

  var day = date.getDate();

  var FullDate = day + " " + month + " " + date.getFullYear();

  return FullDate;
}

$("form .Akademik").select2({
  dropdownParent: $(".FormOpenAkademik .modal-body"),
});

$("form .Lembaga").select2({
  dropdownParent: $(".FormOpenAkademik .modal-body"),
});
