$(function () {
  var groupColumn = 1;
  var table = $("#Table1set").DataTable({
    ajax: url + "pmb_api/tahun_pmb/get_data",
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

  function clearData() {
    var getdate = new Date();
    var yrf = getdate.getFullYear() + 2;
    var yrs = getdate.getFullYear() - 1;
    var tahun_periode = '<option value="">-Pilih Periode Angkatan-</option>';
    for (let yr = yrs; yr <= yrf; yr++) {
      var yre = yr + 1;
      tahun_periode +=
        '<option value="' +
        yr +
        "-" +
        yre +
        '">' +
        yr +
        "-" +
        yre +
        "</option>";
    }

    $(".Periode").html(tahun_periode);
    $("#Aktif").val(1).trigger("change");

    $(".Nominal").val(0);
    $(".NumFormat").val("");
  }
  $("#Periode").select2({
    width: "100%",
    dropdownParent: $(".FormOpenAkademik .modal-body"),
  });
  $("#Tingkat").select2({
    width: "100%",
    dropdownParent: $(".FormOpenAkademik .modal-body"),
  });

  $(".openform").click(function () {
    var opt = $(this).data("option");
    var id = $(this).data("id");
    clearData();
    $(".idAkademik").val("new");

    $(".Tingkat").val("").trigger("change");
    $("#new_Akademik_p").val("Simpan");
    $(".options").html('<i class="fa fa-plus-circle"></i> ' + opt + " Tahun");
    $("form .idAkademik").val(id);
    $(".FormOpenAkademik").modal();
  });

  $(".Periode").change(function () {
    var id = $(this).val();
    var data = $(".idAkademik").val();
    var cb = $(".Tingkat").val();
    if (data === "new") {
      $.ajax({
        url: url + "pmb_api/tahun_pmb/get_data_periode",
        method: "POST",
        data: {
          id: id,
          cb: cb,
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
      url: url + "pmb_api/tahun_pmb/get_data_by",
      method: "POST",
      data: {
        id: id,
      },
      dataType: "json",
      beforeSend: function () {
        $(".loader").show(0);
        clearData();
      },
      error: function (x) {
        alert(x.responseText);
        console.log(x.responseText);
      },
      success: function (data) {
        $(".loader").fadeOut(1000);
        // console.log(data);
        $(".idAkademik").val(data.id_tahun);

        var tahun_periode =
          '<option value="' +
          data.tahun_akademik +
          '">' +
          data.tahun_akademik +
          "</option>";
        $(".Periode").html(tahun_periode);
        $(".Nominal").val(data.nominal);
        $(".Tingkat").val(data.cabang_id).trigger("change");
        $(".Nominal2").val(data.registrasi);
        $(".NS2").val(NumFormat(data.nominal));
        $(".NS3").val(NumFormat(data.registrasi));
        $("#Aktif").val(data.active).trigger("change");

        $("#new_Akademik_p").val("Edit Data");
        $(".options").html(
          '<i class="fa fa-plus-circle"></i> ' + opt + " Tahun"
        );
        $("form .idAkademik").val(id);
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
      url: url + "pmb_api/tahun_pmb/hapusdata",
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
