
    $.ajax({
        url: urls,
        method: "POST",
        dataType: "text",
        data: {
            id: id,
        },
        beforeSend: function () {
            setTimeout(function () {
                $(".loader").show(0).fadeOut(1000);
            }, time);
        },
        error: function() {
            alert("error!");
        },
        success: function(data) {
            $(".profile-tab").html(data)
        }
    });
    $(".imgf").change(function() {
        var id = $(this).data("row");
        var fd = new FormData();
        var files = $('#imgf' + id)[0].files;
        if (files.length > 0) {
            fd.append('file', files[0]);
            $.ajax({
                url: url + 'profile/uploads_img',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                        $(".loader").show(0);
                    $("#imgv" + id).attr("src", url + "assets/images/spin.svg");
                    $("#imgv" + id).show();
                },
                dataType: "json",
                success: function(response) {
                    if (response != 0) {
                        $(".text" + id).val(response.nimg);
                        $("#imgv" + id).attr("src", response.img);
                        $("#imgv" + id).show();
                        $(".ProsesIcon").html('<button type="button" class="btn btn-primary GantiIcon">Update</button>')
                        //console.log(response)
                    } else {
                        alert('file not uploaded');
                        $(".ProsesIcon").html(' <div class="btn btn-secondary btn-lg btn-block Btn-ProsesData">Update</div>')
                    }
                    
                    $(".loader").fadeOut(1000);
                },
            });
        } else {
            alert("Please select a file.");
            $(".ProsesIcon").html(' <div class="btn btn-secondary btn-lg btn-block Btn-ProsesData">Update</div>')
        }
    });
$(".ProsesIcon ").on("click", ".GantiIcon", function () {
        
    var img = $(".Image").val()
        if (img == 'null') {
            alert("Please select a file.");
        } else {
            $.ajax({
                url: url+'profile/updateicon',
                method: "POST",
                dataType: "json",
                data: {
                    img: img,
                },
                beforeSend: function () {
                        $(".loader").show(0);
                    
				$('#modalIcon').modal('hide');
                },
                error: function() {
                    alert("error!");
                },
                success: function (data) {
                    console.log(data);
                    $('.event-icon').html("<i class='fa fa-" + data.event.icon + "'  style='color:" + data.event.color + "'></i>");
                    $('.event-title').html(data.event.title);
                    $('.event-body').html(data.event.description);
                    $('.event-footer').html(data.event.footer);
                    $('#Msg-Notification').modal('show');
                    $(".loader").fadeOut(1000);
                    setTimeout(function () {
                        location.reload();
                    }, time);
                }
            });
        }
    })
    
	$('form .Password2').keyup(function () {
		var p1 = $('form .Password1').val()
		var p2 = $(this).val()
		if (p1 === p2) {
			$(this).removeClass("form-control-danger").addClass("form-control-success")
			$(".ProsesData").html('<input type="submit" value="Update" class="btn btn-primary GantiPassword">')
		} else {
			$(this).removeClass("form-control-success").addClass("form-control-danger")
			$(".ProsesData").html('<div class="btn btn-secondary btn-lg btn-block Btn-ProsesData">Prose Data</div>')
		}
    })
    ////////////////////////////////////
	$('form#UpdatePass').on('submit', function (e) {
        if (!$(this).valid()) {
            e.preventDefault();
        } else {
		e.preventDefault();
		e.stopImmediatePropagation();
		$.ajax({
			url: $(this).attr('action'),
			method: "POST",
			data: $(this).serialize(),
			dataType: "json",
			beforeSend: function () {
                setTimeout(function () {
                $(".loader").show(0).fadeOut(1000);
              }, time);
				$('#modalpass').modal('hide');
			},
			error: function () {
				alert("error!");
			},
			success: function (data) {
				$('.event-icon').html("<i class='fa fa-" + data.event.icon + "'  style='color:" + data.event.color + "'></i>");
				$('.event-title').html(data.event.title);
				$('.event-body').html(data.event.description);
				$('.event-footer').html(data.event.footer);
                $('#Msg-Notification').modal('show');
                setTimeout(function () {
                    window.location.replace(url+"auth/relogin");
                }, time);
			}
		});
    }
	});