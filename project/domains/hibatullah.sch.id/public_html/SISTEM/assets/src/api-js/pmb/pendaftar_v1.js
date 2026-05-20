$(function () {
  var groupColumn = 0;
  var table = $("#Table1set").DataTable({
    ajax: url + "pmb_api/pendaftar/get_data",
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
      if (aData[9] == "3") {
        $("td", nRow).css("background-color", "#c1c1ff");
      } else if (aData[9] == "5") {
        $("td", nRow).css("background-color", "#aeff97");
      } else {
        $("td", nRow).css("background-color", "transparan");
      }
    },
    initComplete: function () {
      this.api().columns(9).visible(false);
    },
    columnDefs: [{ visible: false, targets: groupColumn }],
    order: [[groupColumn, "asc"]],
    displayLength: 25,
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
                '<tr class="group"><td colspan="8" style="background-color:#d2d2d2; font-size:12pt"> Lembaga/Cabang : ' +
                  group +
                  "</td></tr>"
              );

            last = group;
          }
        });
    },
  });

  $("#NmCabang_set").change(function () {
    var cb = $(this).val();
    var pr = $("#Periode_Chek").val();
    if (pr === undefined) {
      pr = null;
    }

    $.ajax({
      url: url + "pmb_api/pendaftar/get_periode/" + cb,
      dataType: "json",
      beforeSend: function () {
        $(".loader").show(0);
        clearArray(mycart);
        clearData();
        $("tbody#cartBody").empty();
        $(".DTS").css("display", "none");
      },
      error: function (x) {
        alert("error!");
        console.log(x.responseText);
      },
      success: function (data) {
        // console.log(data);
        var akademik = '<option value="">-Pilih Periode-</option>';
        $.each(data.ta, function (i, val) {
          akademik += `<option value="${val.id_tahun}">${val.tahun_akademik}</option>`;
        });
        $("#Periode_Chek").html(akademik);
        if (data.now != null) {
          $("#Periode_Chek").val(data.now.id_tahun).trigger("change");
          // table.ajax
          //   .url(
          //     url + "pmb_api/pendaftar/get_data/" + cb + "/" + data.now.id_tahun
          //   )
          //   .ajax.reload();
        }

        $(".loader").fadeOut(1000);
      },
    });
    // console.log(url + "pmb_api/pendaftar/get_data/" + cb + "/" + pr);
  });
  $("#Periode_Chek").change(function () {
    var cb = $("#NmCabang_set").val();
    var pr = $(this).val();
    if (cb === undefined) {
      cb = null;
    }
    console.log(url + "pmb_api/pendaftar/get_data/" + cb + "/" + pr);
    table.ajax
      .url(url + "pmb_api/pendaftar/get_data/" + cb + "/" + pr)
      .ajax.reload();
  });

  $(document).ready(function () {
    $(".Lembaga").select2({
      dropdownParent: $(".FormOpenkelompok .modal-body"),
      width: "100%",
    });
    $(".Pelajars").select2({
      dropdownParent: $(".FormOpenkelompok .modal-body"),
      width: "100%",
    });
    //     $(".Jenis").select2({
    //         dropdownParent: $(".FormOpenkelompok .modal-body"),
    //     });
    //     $(".Murojaah").select2({
    //         dropdownParent: $(".FormOpenkelompok .modal-body"),
    //     });
    //     $(".Jam_Belajar").select2({
    //         dropdownParent: $(".FormOpenkelompok .modal-body"),
    //     });
    //     $(".Ruangan").select2({
    //         dropdownParent: $(".FormOpenkelompok .modal-body"),
    //     });
  });

  $("#NmCabang_set").select2({ width: "100%" });
  $("#Periode_Chek").select2({ width: "100%" });
  ///////////////////////
  ///////////////////////
  function NumFormat(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
  }
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
  ///////////////////////
  ///////////////////////

  $(".openform").click(function () {
    var opt = $(this).data("option");
    var id = $(this).data("id");
    var V_lembaga;
    $.ajax({
      url: url + "pmb_api/pendaftar/get_master",
      dataType: "json",
      beforeSend: function () {
        $(".loader").show(0);
        clearArray(mycart);
        clearData();
        $("tbody#cartBody").empty();
        $(".DTS").css("display", "none");
      },
      error: function (x) {
        alert("error!");
        console.log(x.responseText);
      },
      success: function (data) {
        console.log(data);
        var Lembaga;
        if (data.dt.length > 1) {
          Lembaga = '<option value="">- Pilih Lembaga/Cabang -</option>';
        }
        $.each(data.dt, function (i, r) {
          Lembaga +=
            '<option value="' + r.id + '">' + r.nama_cabang + "</option>";
        });
        $(".Lembaga").html(Lembaga);
        $("#new_kelompok_p").html("Simpan");
        $(".options").html('<i class="fa fa-plus-circle"></i> ' + opt);
        $("form .IDkelompok").val(id);
        $(".FormOpenkelompok").modal();
        $(".loader").fadeOut(1000);
      },
    });
  });

  $(".Jenis_infaq").change(function () {
    var ket = $(this).val();
    var cb = $(".Lembaga").val();
    var th = $(".TahunPeriode").val();
    var id = $(".IDkelompok").val();
    if (th === "" || th === null) {
      $(".TahunPeriode").focus();
      $(".Info0").html("ini wajib di Pilih");
      $(".Info1").html("");
      $(this).val("").trigger("change");
    } else if (cb === "" || cb === null) {
      $(".idlembaa").focus();
      $(".Info0").html("");
      $(".Info1").html("ini wajib di Pilih");
    } else {
      $(".Info0").html("");
      $(".Info1").html("");
      $(".Info2").html("");
      if (id == "new") {
        $.ajax({
          url: url + "pmb_api/pendaftar/get_SantriBy",
          method: "POST",
          data: {
            ket: ket,
            th: th,
            cb: cb,
          },
          dataType: "json",
          beforeSend: function () {
            $(".loader").show(0);
            $(".DTS").css("display", "none");
          },
          error: function (x) {
            alert("error!");
            console.log(x.responseText);
          },
          success: function (data) {
            // console.log(data, jen);
            console.log(data);
            $(".loader").fadeOut(1000);
            var pelajars = '<option value=""> - Pilih Santri - </option>';
            $.each(data.data, function (i, row) {
              pelajars +=
                '<option value="' +
                row.id_pelajar +
                '">' +
                row.nama_lengkap +
                "</option>";
            });
            $("form .Pelajars").html(pelajars);
            $(".DTS").css("display", "block");
          },
        });
      } else {
        // console.log("ERROR ID-KELOMPOK");
      }
    }
  });
  ////////////////////////////////////
  ////////////////////////////////////
  ////////////////////////////////////
  $("#Table1set").on("click", ".openform", function () {
    var opt = $(this).data("option");
    var id = $(this).data("id");
    var V_lembaga;
    $.ajax({
      url: url + "pmb_api/pendaftar/get_data_by",
      method: "POST",
      data: {
        id: id,
      },
      dataType: "json",
      beforeSend: function () {
        $(".loader").show(0);
        clearArray(mycart);
        clearData();
        $("tbody#cartBody").empty();
        $(".DTS").css("display", "none");
      },
      error: function (x) {
        alert("error!");
        console.log(x.responseText);
      },
      success: function (data) {
        console.log(data);

        $(".loader").fadeOut(1000);
        var getdate = new Date();
        var set_tahun =
          '<option value="' +
          data.dt.periode +
          '" >' +
          data.dt.periode +
          "</option>";
        $(".TahunPeriode").html(set_tahun);

        var jenis_inf =
          '<option value="' +
          data.dt.jenis +
          '"  >' +
          data.dt.jenis +
          "</option>";
        $(".Jenis_infaq").html(jenis_inf);

        var pelajars = '<option value=""> - Pilih Santri - </option>';
        $.each(data.pelajar, function (i, row) {
          pelajars +=
            '<option value="' +
            row.id_pelajar +
            '">' +
            row.nama_lengkap +
            "</option>";
        });

        if (data.dt.jenis === "INSIDENTIL") {
          $(".Bulan_inset").css("display", "block");
          $("#Bulan_in").prop("disabled", true);
          $("#Bulan_in").val(data.dt.keterangan);
        } else {
          $(".Bulan_inset").css("display", "none");
          $("#Bulan_in").prop("disabled", false);
        }
        $("form .Pelajars").html(pelajars);
        var Lembaga =
          '<option value="' +
          data.dt.cabang_id +
          '">' +
          data.dt.nama_cabang +
          "</option>";
        $(".Lembaga").html(Lembaga);
        $(".Nama_kelompok").val(data.dt.nama_kelompok);
        $(".Nominal").val(data.dt.nominal);

        $(".NumFormat ").prop("disabled", true);
        $(".NumFormat").val(NumFormat(data.dt.nominal));

        $.each(data.dtl, function (y, i) {
          addToCart(i.id_pelajar, i.nama_lengkap, i.gambar, i.id_reg_kelompok);
        });
        $("form .IDkelompok").val(data.dt.id_reg_kelompok);
        $(".DTS").css("display", "block");
        $("#new_kelompok_p").html(" Selesai ");
        $(".Btn-Close_modal").css("display", "none");
        $(".options").html('<i class="fa fa-edit"></i> ' + opt + " Infaq");
        $(".FormOpenkelompok").modal();
      },
    });
  });

  ////////////////////////////////////
  ////////////////////////////////////
  $("form#kelompok").on("submit", function (e) {
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
          $(".FormOpenkelompok").modal("hide");
        },
        error: function (x) {
          console.log(x.responseText);
          alert("error!");
        },
        success: function (data) {
          table.ajax.reload();

          $(".loader").fadeOut(1000);
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
          $("#Msg-Notification").modal("show");
        },
      });
    }
  });

  //////////////////
  //////////////////

  $("#Table1set").on("click", ".deletedata", function () {
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
      url: url + "pmb_api/pendaftar/delete_data",
      method: "POST",
      data: {
        id: id,
        nm: nm,
      },
      dataType: "json",
      error: function () {
        alert("error!");
      },
      success: function (data) {
        // /console.log(data);
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

  //////////////////
  //////////////////

  $(".ReloadData").click(function () {
    table.ajax.reload();
  });

  function clearData() {
    $("form .Lembaga").html("");
    $("form .JamBelajar").val("");
    $("form .IDkelompok").val("");
    $("form .Nama_kelompok").val("");
    $("form .Nominal").val("");
    $("form .NumFormat ").val("");
    $(".NumFormat").prop("disabled", false);

    $("#Bulan_in").val("");
    $(".Bulan_inset").css("display", "none");
    var getdate = new Date();
    var yrf = getdate.getFullYear() + 2;
    var yrs = getdate.getFullYear() - 1;
    var set_tahun = '<option value="">-Pilih Tahun Peljaran-</option>';
    for (let yr = yrs; yr <= yrf; yr++) {
      var yre = yr + 1;
      set_tahun +=
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
    $(".TahunPeriode").html(set_tahun);

    var Keterangan =
      '<option value="">- Pilih Keterangan -</option><option value="BULANAN">BULANAN</option><option value="INSIDENTIL">INSIDENTIL</option>';
    $(".Jenis_infaq").html(Keterangan);

    $(".Btn-Close_modal").css("display", "block");
  }

  $(".Jenis_infaq").change(function () {
    var jenis = $(this).val();
    $(".Bulan_inset").css("display", "none");
    $("#Bulan_in").prop("disabled", false);
    if (jenis === "INSIDENTIL") {
      $(".Bulan_inset").css("display", "block");
    }
  });

  ////////////////////////////////////
  ////////////////////////////////////
  ////////////////////////////////////
  ////////////////////////////////////
  ////////////////////////////////////
  ////////////////////////////////////

  $("#Table1set").on("click", ".ViewData", function () {
    var id = $(this).data("id");
    var nm = $(this).data("nm");
    $.ajax({
      url: url + "pmb_api/pendaftar/view_list_data",
      method: "POST",
      data: {
        id: id,
      },
      dataType: "json",
      beforeSend: function () {
        $(".loader").show(0);
      },
      error: function (x) {
        alert("ERROR!");
        console.log(x.responseText);
      },
      success: function (e) {
        $(".loader").fadeOut(1000);
        //    console.log(e);
        $(".NMKLS").html(nm);
        $(".datakls").html(e.data);
        $(".dataDtlkls").html(e.pelajar);
        $(".FormOpenDTLkelompok").modal("show");
      },
    });
  });

  $("form .Pelajars").change(function () {
    var id = $(this).val();
    $.ajax({
      url: url + "pmb_api/pendaftar/get_data_pelajar_by_ids",
      method: "POST",
      data: {
        id: id,
      },
      dataType: "json",
      beforeSend: function () {
        setTimeout(function () {
          $(".loader").show(0).fadeOut(1000);
        }, time);
        $("form .Show_Data_SS").html("");
      },
      error: function () {
        alert("ERROR!");
      },
      success: function (e) {
        if (e.result) {
          $("form .Show_Data_SS").html(e.data);
        }
      },
    });
  });

  ////////////////////////////////////
  ////////////////////////////////////
  $("form#add_pelajar").on("submit", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
      url: $(this).attr("action"),
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",

      error: function () {
        alert("error!");
      },
      success: function (data) {
        // console.log(data);
        var idk = data.data.kelompok_id;
        var cb = data.cb;
        NewDataPelajar(idk);
        getmaster_Pelajar(cb);
        $("form .Show_Data_santri").html("");
        table.ajax.reload();
      },
    });
  });

  function getmaster_Pelajar(cb) {
    $.ajax({
      url: url + "pmb_api/pendaftar/get_master_pelajar",
      method: "POST",
      data: {
        cb: cb,
      },
      dataType: "json",
      beforeSend: function () {
        setTimeout(function () {
          $(".loader").show(0).fadeOut(1000);
        }, time);
        $("form .Pelajar_set").html("");
      },
      error: function () {
        alert("error!");
      },
      success: function (data) {
        var PLJ;
        if (data.data.length > 0) {
          PLJ += '<option value=""> - Pilih Nama Santri - </option>';
          $.each(data.data, function (i, row) {
            PLJ +=
              '<option value="' +
              row.id_pelajar +
              '">' +
              row.nama_lengkap +
              "</option>";
          });
          $("form .Pelajar_set").select2({
            dropdownParent: $(".FormOpenMurid"),
          });
          return $("form .Pelajar_set").html(PLJ);
        }
      },
    });
  }

  function NewDataPelajar(id) {
    var newtable = $("#Table2set").DataTable({
      destroy: true,
      ajax: {
        url: url + "pmb_api/pendaftar/get_data_pelajar",
        method: "POST",
        data: {
          id: id,
        },
        dataType: "json",
      },
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
      paging: true,
    });

    return newtable;
  }

  $(".ChekZiyadah").click(function () {
    var jf = $(".JamZiyadah2").val();
    var js = $(".JamZiyadah1").val();
    var zy = $(".Ziyadah").val();
    var ru = $(".Ruangan").val();
    $(".Info0").html("");
    $(".Info1").html("");
    $(".Info2").html("");
    $(".Info3").html("");
    $(".Info4").html("");
    $(".Info5").html("");

    // console.log(ru);
    if (ru === "") {
      $(".Ruangan").focus();
      $(".Info0").html("Data ini wajib!");
      $(".JamZiyadah2").val("");
      $(".JamZiyadah1").val("");
    } else if (zy === "") {
      $(".Ziyadah").focus();
      $(".Info1").html("Data ini wajib!");
      $(".JamZiyadah2").val("");
      $(".JamZiyadah1").val("");
    } else if (js === "") {
      $(".Info2").html("Data jam wajib!");
    } else if (js > jf) {
      $(".Info2").html("Data jam tidak valid!");
    } else {
      $.ajax({
        url: url + "pmb_api/pendaftar/cekkelompokziyadah",
        method: "POST",
        data: {
          ru: ru,
          zy: zy,
          js: js,
          jf: jf,
        },
        dataType: "json",
        error: function () {
          alert("error!");
        },
        success: function (data) {
          $(".event-icon").html();
          $(".event-title").html(data.title + "<hr>");
          $(".event-body").html(data.body);
          $(".event-footer").html(
            '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
          );
          $("#Msg-Notification").modal("show");
        },
      });
    }
  });

  $(".ChekMurojaah").click(function () {
    var jf = $(".JamFNMurojaah").val();
    var js = $(".JamSTMurojaah").val();
    var zy = $(".Murojaah").val();
    var ru = $(".Ruangan").val();
    $(".Info0").html("");
    $(".Info1").html("");
    $(".Info2").html("");
    $(".Info4").html("");
    $(".Info5").html("");
    if (ru === "") {
      $(".Ruangan").focus();
      $(".Info0").html("Data ini wajib!");
      $(".JamFNMurojaah").val("");
      $(".JamSTMurojaah").val("");
    } else if (zy === "") {
      $(".Murojaah").focus();
      $(".Info4").html("Data ini wajib!");
      $(".JamFNMurojaah").val("");
      $(".JamSTMurojaah").val("");
    } else if (js === "") {
      $(".Info5").html("Data jam wajib!");
    } else if (js > jf) {
      $(".Info5").html("Data jam tidak valid!");
    } else {
      $.ajax({
        url: url + "pmb_api/pendaftar/cekkelompokmurojaah",
        method: "POST",
        data: {
          ru: ru,
          zy: zy,
          js: js,
          jf: jf,
        },
        dataType: "json",
        error: function () {
          alert("error!");
        },
        success: function (data) {
          $(".event-icon").html();
          $(".event-title").html(data.title + "<hr>");
          $(".event-body").html(data.body);
          $(".event-footer").html(
            '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
          );
          $("#Msg-Notification").modal("show");
        },
      });
    }
  });
});
$(document).ready(function () {
  $(".Show_Data_SS").on("click", ".AddSantri", function () {
    var iddt = "new";
    var idp = $(this).data("ids");
    var nm = $(this).data("nm");
    var pict = $(this).data("pict");
    addToCart(idp, nm, pict, iddt);
    $(".Show_Data_SS").html("");
    $("#Pelajars option[value='" + idp + "']").remove();
  });

  $("#cartBody").on("click", ".deleteItem", function () {
    var index = $(this).data("id");
    var iddt = $(this).data("iddt");
    if (iddt !== "new") {
      var nm = $(this).data("nm");
      var id = $(this).data("idp");

      $(".event-icon").html(
        "<i class='fa fa-trash'  style='color:#ff0000'></i>"
      );
      $(".event-title").html(nm);
      $(".event-body").html("Yakin ingin menghapus data ini..?");
      $(".event-footer").html(
        "<button class='btn btn-primary btn-sm DeleteDataSantri' data-id='" +
          id +
          "' data-iddt='" +
          iddt +
          "' data-ind='" +
          index +
          "'   data-nm='" +
          nm +
          " '>Yakin!</button> " +
          '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">Tidak</button>'
      );
      $("#Msg-Notification").modal();
    } else {
      mycart.splice(index, 1);
      showCart();
      saveCart();
    }
  });

  $("#Msg-Notification").on("click", ".DeleteDataSantri", function () {
    var id = $(this).data("id");
    var nm = $(this).data("nm");
    var iddt = $(this).data("iddt");
    var index = $(this).data("ind");
    $.ajax({
      url: url + "pmb_api/pendaftar/hapus_data_pelajar_by_kelompok",
      method: "POST",
      data: {
        iddt: iddt,
        id: id,
      },
      dataType: "json",
      error: function () {
        alert("error!");
      },
      success: function (data) {
        mycart.splice(index, 1);
        showCart();
        saveCart();
        $(".event-icon").html(
          "<i class='fa fa-thumbs-up'  style='color:#a4cc00'></i>"
        );
        $(".event-title").html("Hapus Santri");
        $(".event-body").html("Hapus <b>" + nm + "</b> Dari kelompok Berhasil");
        $(".event-footer").html(
          '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
        );
        $("#Msg-Notification").modal("show");
        table.ajax.reload();
      },
    });
  });

  $("form#kelompok").validate({
    // initialize the plugin
    rules: {
      Nama_kelompok: {
        required: true,
      },
      Pengajar: {
        required: true,
      },
    },
  });
});

var mycart = [];
$(function () {
  if (localStorage.mycart) {
    mycart = JSON.parse(localStorage.mycart);
    showCart();
  }
});

function addToCart(idp, nm, pict, iddt) {
  var item = {
    iddt: iddt,
    idp: idp,
    nm: nm,
    pict: pict,
  };
  mycart.push(item);
  saveCart();
  showCart();
}

function saveCart() {
  if (window.localStorage) {
    localStorage.mycart = JSON.stringify(mycart);
  }
}

function showCart() {
  $("tbody#cartBody").empty();
  for (var i in mycart) {
    var item = mycart[i];
    var row =
      "<tr>" +
      '<td style="text-align:center"><img  src="' +
      url +
      "img_pelajar/" +
      item.pict +
      '" alt="' +
      item.pict +
      '" style="width:40px"></td>' +
      '<td style="text-align:left"><input type="hidden" name="idp[]" value="' +
      item.idp +
      '" ><input type="hidden" name="iddt[]" value="' +
      item.iddt +
      '" >' +
      item.nm +
      "</td>" +
      '<td style="text-align:center"><button type="button" class="badge badge-danger deleteItem" data-id="' +
      i +
      '" data-iddt="' +
      item.iddt +
      '" data-idp="' +
      item.idp +
      '" data-nm="' +
      item.nm +
      '">' +
      "&times;</button></td>" +
      "</tr>";
    $("tbody#cartBody").append(row);
  }
}

function clearArray(array) {
  while (array.length) {
    array.pop();
  }
}
