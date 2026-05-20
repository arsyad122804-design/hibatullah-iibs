$(function () {
    var groupColumn=1;
	var table = $('#Table1set').DataTable({
		ajax: url + "slider/get_data",
		deferRender: true,
        processing: true,
        language: {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
		lengthChange: false,
		scrollCollapse: false,
		autoWidth: true,
		searching: false,
		paging: false,
		ordering: false,
		info: false,   
		bAutoWidth: false,
		responsive: {
		  details: {
			type: 'column',
			target: 'tr'
		  }
		},
	});
	 ////////////////////////////////////
	 $('form').on('submit', function (e) {
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
                    $('.FormOpenUser').modal('hide');
					$(".loader").show(0); 
                },
                error: function () {
                    alert("error!");
                },
                success: function (data) {
                    table.ajax.reload();
                    $('.event-icon').html("<i class='fa fa-" + data.event.icon + "'  style='color:" + data.event.color + "'></i>");
                    $('.event-title').html(data.event.title);
                    $('.event-body').html(data.event.description);
                    $('.event-footer').html(data.event.footer);
                    $('#Msg-Notification').modal('show');
					$(".loader").fadeOut(1000); 
                }
            });
        }
	});
});

$('#Table1set').on('click','.openform',function () {
	var opt = $(this).data('option');
	var id = $(this).data('id');
	$.ajax({
		url: url + 'slider/get_data_by',
		method: "POST",
		data: {
			id: id
		},
		dataType: "json",
		beforeSend:function() {
			$(".loader").show(0);
			if ($("form .Set_Active").is(':checked')) {
				$("form .Set_Active").click();
			}
			if ($("form .Set_Current").is(':checked')) {
				$("form .Set_Current").click();
			}
			if ($("form .Set_Link").is(':checked')) {
				$("form .Set_Link").click();
				$(".Link_set").css('display','none')
			}
		},
		error: function (x) {
			console.log(x.responseText);
			alert("error!");
		},
		success: function (data) {
			console.log(data);
			
			if (data.active>0) {
				$("form .Set_Active").click();
			}
			if (data.current>0) {
				$("form .Set_Current").click();
			}
			if (data.red>0) {
				$("form .Set_Link").click();
				$(".Link_set").css('display','block');
			}
			$("#Url").val(data.url);
			$(".picture-src").attr("src", url + "assets/slider/" + data.img);
			$('form .Image').val(data.img);
			$('.options').html('<i class="fa fa-plus-circle"></i> ' + opt + ' Slider');
			$('form .idUser').val(data.id_slide);
			$('.FormOpenUser').modal();
			$(".loader").fadeOut(1000);
		}
	})
});

var switchStatus = false;
$("form .Set_Link").change(function() {
	if ($(this).is(':checked')) {
        switchStatus = $(this).is(':checked');
    }
    else {
       switchStatus = $(this).is(':checked');
    }
	if (switchStatus) {
		$(".Link_set").css('display','block');
	}else{
		$(".Link_set").css('display','none');
	}
});

$(".imgf").change(function() {
	var id = $(this).data("row");
	var fd = new FormData();
	var files = $('#imgf' + id)[0].files;
	if (files.length > 0) {
		fd.append('file', files[0]);
		$.ajax({
			url: url + 'slider/uploads_img',
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
					console.log(response)
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