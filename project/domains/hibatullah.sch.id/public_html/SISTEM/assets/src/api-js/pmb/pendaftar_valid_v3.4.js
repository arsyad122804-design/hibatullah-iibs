function checkAll() {
	var checkboxes = document.querySelectorAll(".check-item");
	$("#CheckAll").prop("checked", true);
	checkboxes.forEach(function (checkbox) {
		checkbox.checked = true;
	});
}

function uncheckAll() {
	var checkboxes = document.querySelectorAll(".check-item");
	$("#CheckAll").prop("checked", false);
	checkboxes.forEach(function (checkbox) {
		checkbox.checked = false;
	});
}

$(".Dt_Migrasi").on("click", "#CheckAll", function () {
	var checkboxes = document.querySelectorAll(".check-item");
	checkboxes.forEach(function (checkbox) {
		if (checkbox.checked === true) {
			checkbox.checked = false;
		} else {
			checkbox.checked = true;
		}
	});
});
$(function () {
	var groupColumn = 1;
	var table = $("#Table1set").DataTable({
		ajax: url + "pmb_api/pendaftar_valid/get_data",
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
			if (aData[9] == "6") {
				$("td", nRow).css("background-color", "#fff");
			}
			//  else if (aData[9] == "2" || aData[9] == "4") {
			//   $("td", nRow).css("background-color", "#c4ffff");
			// } else if (aData[9] == "1") {
			//   $("td", nRow).css("background-color", "#d4d4d4");
			// }
			else {
				$("td", nRow).css("background-color", "#ccffa6");
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

	$("#CheckAll_Lulus").on("click", function () {
		var cols = table.column(0).nodes(),
			state = this.checked;
		for (var i = 0; i < cols.length; i += 1) {
			if (cols[i].querySelector("input[name='id_pelajar[]']") != null) {
				cols[i].querySelector("input[name='id_pelajar[]']").checked = state;
			}
		}
	});

	$("#Table1set ").on("click", ".radioBtnChk", function () {
		var sel = $(this).data("title");
		var tog = $(this).data("toggle");
		var idt = $(this).data("idset");
		$.ajax({
			url: url + "pmb_api/pendaftar_valid/set_status/" + idt + "/" + sel,
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

				$("#" + tog).prop("value", sel);
				$('a[data-toggle="' + tog + '"]')
					.not('[data-title="' + sel + '"]')
					.removeClass("active")
					.addClass("notActive");
				$('a[data-toggle="' + tog + '"][data-title="' + sel + '"]')
					.removeClass("notActive")
					.addClass("active");
				$("#CheckAll_Lulus").prop("checked", false);
				table.ajax.reload();
			},
		});
	});

	$(".Btn_AllSet").click(function () {
		var st = $(this).data("val");
		var pros = $(this).data("pro");
		var dataCheck = Array();
		$('input[name="id_pelajar[]"]:checked').each(function () {
			dataCheck.push($(this).val());
		});
		if (dataCheck.length > 0) {
			$(".event-icon").html(
				"<i class='fa fa-users'  style='color:#29a400'></i>"
			);
			$(".event-title").html(
				"<h4>" + pros + "</h4>" + dataCheck.length + " Calon Santri"
			);
			$(".event-body").html("Yakin ingin memproses data ini..?");
			$(".event-footer").html(
				"<button class='btn btn-primary btn-sm ProsesAllChecked' data-id='" +
					dataCheck +
					"' data-st='" +
					st +
					"'  data-nm='" +
					pros +
					"'>Yakin!</button> " +
					'<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">Tidak</button>'
			);
			$("#Msg-Notification").modal();
		}
	});

	$("#Msg-Notification").on("click", ".ProsesAllChecked", function () {
		var dataCheck = $(this).data("id");
		var st = $(this).data("st");
		var pros = $(this).data("nm");
		var ids = dataCheck.split(",");
		// console.log(ids, st);
		$.ajax({
			type: "POST",
			url: url + "pmb_api/pendaftar_valid/set_all_status",
			data: {
				ids: ids,
				st: st,
				pros: pros,
			},
			success: function (data) {
				console.log(data);
				$("#CheckAll_Lulus").prop("checked", false);
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

	$("#NmCabang_set").change(function () {
		var cb = $(this).val();
		var pr = $("#Periode_Chek").val();
		if (pr === undefined) {
			pr = null;
		}
		console.log(url + "pmb_api/pendaftar_valid/get_data/" + cb + "/" + pr);
		table.ajax
			.url(url + "pmb_api/pendaftar_valid/get_data/" + cb + "/" + pr)
			.ajax.reload();
	});
	$("#Periode_Chek").change(function () {
		var cb = $("#NmCabang_set").val();
		var pr = $(this).val();
		if (cb === undefined) {
			cb = null;
		}
		console.log(url + "pmb_api/pendaftar_valid/get_data/" + cb + "/" + pr);
		table.ajax
			.url(url + "pmb_api/pendaftar_valid/get_data/" + cb + "/" + pr)
			.ajax.reload();
	});

	$(document).ready(function () {
		$(".Lembaga").select2({
			dropdownParent: $(".FormOpenMigrasi .modal-body"),
			width: "100%",
		});
		$(".Pelajars").select2({
			dropdownParent: $(".FormOpenMigrasi .modal-body"),
			width: "100%",
		});
		//     $(".Jenis").select2({
		//         dropdownParent: $(".FormOpenMigrasi .modal-body"),
		//     });
		//     $(".Murojaah").select2({
		//         dropdownParent: $(".FormOpenMigrasi .modal-body"),
		//     });
		//     $(".Jam_Belajar").select2({
		//         dropdownParent: $(".FormOpenMigrasi .modal-body"),
		//     });
		//     $(".Ruangan").select2({
		//         dropdownParent: $(".FormOpenMigrasi .modal-body"),
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
		$(".FormOpenMigrasi").modal();
		$(".loader").fadeOut(1000);
		$(".Dt_Migrasi").html("");
		$(".Dt_Migrasi").html("");
		$(" .Cabang").val("").trigger("change");
	});

	$(" .Cabang").change(function () {
		var cb = $(this).val();
		var pr = $(".Periode").val();
		GetdataMigration(cb, pr);
	});
	$(" .Periode").change(function () {
		var pr = $(this).val();
		var cb = $(" .Cabang").val();
		GetdataMigration(cb, pr);
	});

	function GetdataMigration(cb, pr) {
		$.ajax({
			url: url + "pmb_api/pendaftar_valid/get_data_migrasi/" + cb + "/" + pr,
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
				// $("#Table1set").DataTable().destroy();
				$(".Dt_Migrasi").html(data.data);
				$("#token").val(data.token);
				$("#TableMigrasi").DataTable({
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
					ordering: false,
				});
			},
		});
	}
	////////////////////////////////////
	////////////////////////////////////
	$("form").on("submit", function (e) {
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
				},
				error: function (x) {
					console.log(x.responseText);
					alert("error!");
				},
				success: function (data) {
					if (data.data === 0) {
					} else {
						table.ajax.reload();
						console.log(data);
						// Mengonversi array ke string JSON
						var jsonString = JSON.stringify(data.notifwa);
						// Menyimpan string JSON ke localStorage
						localStorage.setItem("DataNotifiWA", jsonString);

						if (jsonString) {
							// Cheking Number Json yang akan di notif
							var num = localStorage.getItem("numNotif");
							if (!num) {
								localStorage.setItem("numNotif", 0);
							}
							setTimeout(function () {
								// location.reload();
								processData();
							}, 500);
						}

						$(".FormOpenMigrasi").modal("hide");
					}
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
				},
			});
		}
	});

	$(".ReloadData").click(function () {
		table.ajax.reload();
	});
});
