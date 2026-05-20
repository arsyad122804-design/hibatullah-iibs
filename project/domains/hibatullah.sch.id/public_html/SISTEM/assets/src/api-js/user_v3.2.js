$(function () {
  var groupColumn = 1;
  var table = $("#Table1set").DataTable({
    ajax: url + "user/getdatauser",
    deferRender: true,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "pdf",
        text: '<i class="ti-printer"> </i> Pdf',
        className: "TableButtosPrimary btn-sm rounded-0 border-0 ",
      },
      {
        extend: "excel",
        text: '<i class="ti-printer"> </i> Excel',
        className: "TableButtosPrimary btn-sm rounded-0 border-0 ",
      },
    ],
    lengthChange: false,
    scrollCollapse: false,
    autoWidth: false,
    responsive: true,
    searching: true,
    columnDefs: [{ visible: false, targets: groupColumn }],
    order: [[groupColumn, "asc"]],
    drawCallback: function (settings) {
      var api = this.api();
      var rows = api.rows({ page: "current" }).nodes();
      var last = null;

      api
        .column(groupColumn, { page: "current" })
        .data()
        .each(function (group, i) {
          if (last !== group) {
            $(rows)
              .eq(i)
              .before(
                '<tr class="group"><td colspan="10" style="background-color:#d2d2d2; font-size:12pt"> CABANG : ' +
                  group +
                  "</td></tr>"
              );

            last = group;
          }
        });
    },
  });

  $("#NmCabang_set").change(function () {
    var id = $(this).val();
    table.ajax.url(url + "user/getdatauser/" + id).ajax.reload();
  });
  $("#NmCabang_set").select2({ width: "100%" });
  $(".openform").click(function () {
    var opt = $(this).data("option");
    var id = $(this).data("id");
    var V_lembaga;
    var lvls;
    $.ajax({
      url: url + "user/GetMaster",
      dataType: "json",
      error: function (x) {
        console.log(x.responseText);
        alert("error!");
      },
      success: function (data) {
        // console.log(data);
        if (data.lvl == 1) {
          V_lembaga = '<option value="0">-Pilih Lembaga / Cabang-</option>';
          // V_lembaga += '<option value="0">- Pusat -</option>';
        }
        $.each(data.dt, function (i, row) {
          V_lembaga +=
            '<option value="' + row.id + '">' + row.nama_cabang + "</option>";
        });

        lvls = '<option value="0">- Pilih Level -</option>';
        $.each(data.level, function (i, r) {
          lvls += '<option value="' + r.id_level + '">' + r.level + "</option>";
        });
        $("form .Username").prop("readonly", false);
        $("form .Password2").attr("required", false);
        $("form .Password1").attr("required", false);
        $("form .Lembaga").html(V_lembaga);
        $("form .Level").html(lvls);
        $(".Username").val("");
        $(".Password1").val("");
        $(".Password2").val("");
        $(".Nama").val("");
        $(".Email").val("");
        $(".Ket").html("");
        $("#new_User_p").val("Proses New User");
        $("form .Password2").attr("required", true);
        $("form .Password1").attr("required", true);
        $(".options").html(
          '<i class="fa fa-plus-circle"></i> ' + opt + " User Akses"
        );
        $("form .idUser").val("new");
        $(".FormOpenUser").modal();
      },
    });
  });

  $(".Lembaga").change(function () {
    var lvls;
    $.ajax({
      url: url + "user/GetMaster",
      dataType: "json",
      error: function () {
        alert("error!");
      },
      success: function (data) {
        if (data.result) {
          lvls = '<option value="0">- Pilih Level -</option>';
          $.each(data.level, function (i, r) {
            lvls +=
              '<option value="' + r.id_level + '">' + r.level + "</option>";
          });
        } else {
          lvls = '<option value="0">No Result</option>';
        }

        $(".Username")
          .removeClass("form-control-success")
          .removeClass("form-control-danger");
        $("form .Username").val("");
        $("form .Password2").val("");
        $("form .Password1").val("");
        $("form .Level").html(lvls);
      },
    });
  });

  $(".Username").on("change ", function () {
    $.ajax({
      url: url + "user/chekinguser",
      method: "POST",
      data: {
        usn: $(this).val(),
      },
      success: function (data) {
        if (data.rs === 200) {
          $(".Username")
            .removeClass("form-control-success")
            .addClass("form-control-danger");
          $(".Username").focus();
          $("form .Password1").prop("readonly", true);
          $("form .Password2").prop("readonly", true);
          $("#UserInfo").html(
            '<small class="text-danger"> Username sudah ada!</small>'
          );
        } else {
          $(".Username")
            .removeClass("form-control-danger")
            .addClass("form-control-success");
          $("form .Password1").prop("readonly", false);
          $("form .Password2").prop("readonly", false);
          $("#UserInfo").html("");
        }
      },
    });
  });

  $(".FormOpenUser").on("change", "#Level", function () {
    if ($(this).val() < 1) {
      $("form #Relation_id").html('<option value="0"> No Data</option>');
    } else {
      $.ajax({
        url: url + "user/getdatausers",
        method: "POST",
        data: {
          id: $(this).val(),
          cb: $("form .Lembaga").val(),
        },
        dataType: "json",
        beforeSend: function () {
          $(".loader").show(0);
        },
        error: function (x) {
          alert("error!");
          console.log(x);
        },
        success: function (data) {
          // console.log(data);
          var rsuser;
          $(".loader").fadeOut(1000);
          if (data.result.length > 0) {
            rsuser += '<option value="0"> Pilih Nama</option>';
            $.each(data.result, function (i, row) {
              rsuser +=
                '<option value="' +
                row.idk +
                '" data-attr="' +
                row.nama +
                '">' +
                row.nama +
                "</option>";
            });
          } else {
            rsuser = '<option value="0"> No Data</option>';
          }
          $("form #Relation_id").html(rsuser);
        },
      });
    }
  });
  $("form #Relation_id").change(function () {
    $(".Nama").val($(this).children("option:selected").data("attr"));
  });
  $("#Table1set").on("click", ".openform", function () {
    var opt = $(this).data("option");
    var nm = $(this).data("nm");
    var lvl = $(this).data("lvl");
    var id = $(this).data("id");
    $.ajax({
      url: url + "user/getFormOpenUserbyid",
      method: "POST",
      data: {
        id: id,
        lvl: lvl,
      },
      dataType: "json",
      beforeSend: function () {
        $("form .Username").val("");
        $("form .Password1").val("");
        $("form .Password2").val("");
        $("form .Nama").val("");
        $("form .Email").val("");
        $("form .Ket").html("");
        $(".loader").show(0);
      },
      error: function () {
        alert("error!");
      },
      success: function (data) {
        $(".loader").fadeOut(1000);
        console.log(data);
        var V_lembaga =
          '<option value="' +
          data.dt.fid_cabang +
          '">' +
          data.dt.nama_cabang +
          "</option>";
        var lvl =
          '<option value="' +
          data.dt.id_level +
          '">' +
          data.dt.level +
          "</option>";
        var Ket;
        if (data.dt.fid_keterangan != 0) {
          Ket =
            '<option value="' +
            data.dt.fid_keterangan +
            '">' +
            data.dt.namauser +
            "</option>";
        } else {
          Ket = '<option value=""> No Data</option>';
        }
        $.each(data.level, function (i, row) {
          if (row.id_level !== data.dt.id_level) {
            lvl +=
              '<option value="' + row.id_level + '">' + row.level + "</option>";
          }
        });
        var aktif;
        if (data.dt.aktif === "Y") {
          aktif =
            '<option value="Y"> Aktif </option><option value="T"> Tidak Aktif </option>';
        } else {
          aktif =
            '<option value="T"> Tidak Aktif </option><option value="Y"> Aktif </option>';
        }
        $("form .Lembaga").html(V_lembaga);
        $("form .Level").html(lvl);
        $("form .Ket").html(Ket);
        $("form .Aktif").html(aktif);
        $("form .Username").val(data.dt.username);
        $("form .Nama").val(data.dt.nama_asli);
        $("form .Email").val(data.dt.email);
        $("form .Username").prop("readonly", true);
        $("form .Password2").attr("required", false);
        $("form .Password1").attr("required", false);
        $("form .Password2").val(data.dt.password);
        $("form .Password1").val(data.dt.password);
        $("form .Password2").removeAttr("required");
        $("form .Password1").removeAttr("required");
        $("#new_FormOpenUser_p").val("Edit  FormOpenUser");
        $(".options").html(
          '<i class="fa fa-plus-circle"></i> ' + opt + " User " + nm
        );
        $("form .idUser").val(id);
        $(".FormOpenUser").modal();
      },
    });
  });
  ////////////////////////////////////
  ////////////////////////////////////
  $("form").on("submit", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
      url: $(this).attr("action"),
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      beforeSend: function () {
        $(".loader").show(0);
        $(".FormOpenUser").modal("hide");
      },
      error: function () {
        alert("error!");
      },
      success: function (data) {
        table.ajax.reload();
        $(".loader").fadeOut(1000);
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
        $("#Msg-Notification").modal("show");
      },
    });
  });
  $("form .Password2").on("change keyup keydown", function () {
    var p1 = $("form .Password1").val();
    var p2 = $(this).val();

    $(this).removeClass("form-control-success");

    $(this).removeClass("form-control-danger");
    if (p1 === p2) {
      $(this)
        .removeClass("form-control-danger")
        .addClass("form-control-success");
      $(".ProsesData").html(
        '<button type="submit" class="btn btn-primary btn-lg btn-block">Proses Data</button>'
      );
    } else {
      $(this)
        .removeClass("form-control-success")
        .addClass("form-control-danger");
      $(".ProsesData").html(
        '<button type="button" class="btn btn-primary btn-lg btn-block Btn-ProsesData">Proses Data</button>'
      );
    }
  });
  $(".ProsesData").on("click", ".Btn-ProsesData", function () {
    var usn = $("form .Username").val();
    var ps1 = $("form .Password1").val();
    var ps2 = $("form .Password2").val();
    var lvl = $("form .Level").val();
    var nm = $("form .Nama").val();
    if (usn === "") {
      $("form .Username").focus();
    } else if (ps1 === "") {
      $("form .Password1").focus();
    } else if (ps2 !== ps1) {
      $("form .Password2").focus();
    } else if (lvl === "") {
      $("form .Password2").focus();
    } else if (nm === "") {
      $("form .Nama").focus();
    } else {
      $("form").submit();
    }
  });
  $(".Level").select2({
    dropdownParent: $(".FormOpenUser .modal-body .Level_box"),
  });
  $(".Lembaga").select2({
    dropdownParent: $(".FormOpenUser .modal-body "),
  });
  $(".Ket").select2({
    dropdownParent: $(".FormOpenUser .modal-body .Ket_box"),
  });
  $(".ReloadData").click(function () {
    table.ajax.reload();
  });
  $("#Table1set").on("click", ".deleteUser", function () {
    var nm = $(this).data("nm");
    var id = $(this).data("id");
    $(".event-icon").html("<i class='fa fa-trash'  style='color:#ff0000'></i>");
    $(".event-title").html(nm);
    $(".event-body").html("Yakin ingin menghapus data ini..?");
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
      url: url + "user/delete_data",

      method: "POST",

      data: {
        id: id,

        nm: nm,
      },

      dataType: "json",

      beforeSend: function () {
        $(".loader").show(0);
      },
      error: function () {
        alert("error!");
      },

      success: function (data) {
        ///console.log(data);

        $(".loader").fadeOut(1000);
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
        table.ajax.reload();
      },
    });
  });
});
