$(function () {
  $(".OpenNota").click(function () {
    var img = $(this).data("img");
    $("#ImgNota").attr("src", img);
    $(".FormOpenNota").modal("show");
  });
  $(".Proses").click(function () {
    var id = $(this).data("id");
    $.ajax({
      url: url + "pmb_api/pendaftar/get_data_reg2",
      method: "POST",
      data: {
        id: id,
      },
      dataType: "json",
      beforeSend: function () {
        $(".loader").show(0);
      },
      error: function (x) {
        console.log(x.responseText);
        alert("error!");
      },
      success: function (data) {
        $(".loader").fadeOut(1000);
        // console.log(data);
        $("#DTshow").html(data.data);
        $("#idred").val(data.dt.id_red);
        $("#noregister").val(data.dt.nomor_reg);
        $("#jns").val(data.dt.jns);
        $(".FormOpenProses").modal("show");
      },
    });
  });
});

$(document).ready(function () {
  // Menggunakan jQuery untuk menangani klik pada tombol copy
  $(".CopyData").click(function () {
    // Pilih teks yang akan di-copy
    var copys = $(this).data("val");
    var temp = $("<input>").val(copys);
    $("body").append(temp);
    temp.select();
    document.execCommand("copy");
    temp.remove();

    var notificationTag = $("div.copy-notification");
    notificationTag = $("<div/>", {
      class: "copy-notification",
      text: "Copy : " + copys,
    });
    $("body").append(notificationTag);

    notificationTag.fadeIn("slow", function () {
      setTimeout(function () {
        notificationTag.fadeOut("slow", function () {
          notificationTag.remove();
        });
      }, 1000);
    });
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
      $(".FormOpenProses").modal("hide");
    },
    error: function (x) {
      alert("error!");
      console.log(x.responseText);
    },
    success: function (data) {
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
      location.reload();
    },
  });
});
$(".imgf").change(function () {
  var id = $(this).data("row");
  var fd = new FormData();
  var files = $("#imgf" + id)[0].files;
  if (files.length > 0) {
    fd.append("file", files[0]);
    // console.log(fd);
    $.ajax({
      url: url + "pmb/uploads_img",
      type: "post",
      data: fd,
      contentType: false,
      processData: false,
      dataType: "json",
      beforeSend: function () {
        $(".BTN_SET").css("display", "none");
        $(".loader").show(0);
        $("#imgv" + id).attr("src", url + "assets/images/spin.svg");
        $("#imgv" + id).show();
      },
      onerror: function (x) {
        console.log(x.responseText);
      },
      success: function (response) {
        $(".loader").fadeOut(1000);
        console.log(response);
        if (response.nimg != undefined) {
          $(".text" + id).val(response.nimg);
          $("#imgv" + id).attr("src", url + response.img);
          $("#imgv" + id).show();
          $(".BTN_SET").css("display", "block");
        } else {
          $(".BTN_SET").css("display", "none");
          alert("file not uploaded");
        }
      },
    });
  } else {
    alert("Please select a file.");
  }
});
