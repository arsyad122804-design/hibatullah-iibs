$(function () {
    function formarDate(e) {
		var date = new Date(e);
		var month = ["January", "February", "March", "April", "May", "June",
			"July", "August", "September", "October", "November", "December"
		][date.getMonth()];
		var day = date.getDate();
		var FullDate = day + ' ' + month + ' ' + date.getFullYear();
		return FullDate;
	}
	$(".Kota_alamat").change(function () {
		var id = $(this).val();
		var V_kec;
		$.ajax({
			url: url + 'data_api/wilayah/get_kecamatan',
			method: 'POST',
			data: {
				id: id
			},
			dataType: 'json',
			error: function () {
				alert("ERROR");
			},
			success: function (data) {
				if (data.kec.length > 0) {
					V_kec = '<option value=""> -Pilih Kecamatan -</option>'
					$.each(data.kec, function (i, row) {
						V_kec += '<option value="' + row.id + '">' + row.kecamatan + '</option>';
					});
				} else {
					V_kec = '<option value=""> No Result Data</option>'
				};

				$('form .kecamatan').html(V_kec);
			}
		})
	})
	$(".kecamatan").change(function () {
		var id = $(this).val();
		var V_kel;
		$.ajax({
			url: url + 'data_api/wilayah/get_kelurahan',
			method: 'POST',
			data: {
				id: id
			},
			dataType: 'json',
			error: function () {
				alert("ERROR");
			},
			success: function (data) {
				if (data.kel.length > 0) {
					V_kel = '<option value=""> -Pilih Kelurahan -</option>'
					$.each(data.kel, function (i, row) {
						V_kel += '<option value="' + row.id + '">' + row.kelurahan + '</option>';
					});
				} else {
					V_kel = '<option value=""> No Result Data</option>'
				};

				$('form .Kelurahan').html(V_kel);
			}
		})
	})

	function clearDta() {
		$(".tab-wizard").steps("reset");
		$('form .Nama_lengkap').val("");
		$('form .Nama_Panggilan').val("");
		$('form .Tlahir').val("");
		$('form .NIK').val("");
		$('form .NIS').val("");
		$('form .Alamat_rumah').val("");
		$('form .kecamatan').html("");
		$('form .Kelurahan').html("");
		$('form .Hafalan').val("");

		$('form .TK').val("");
		$('form .SD').val("");
		$('form .SMP').val("");
		$('form .SMA').val("");
		$('form .S1').val("");
		$('form .S2').val("");
		$('form .S3').val("");

		$('form .THTK').val("");
		$('form .THSD').val("");
		$('form .THSMP').val("");
		$('form .THSMA').val("");
		$('form .THS1').val("");
		$('form .THS2').val("");
		$('form .THS3').val("");


		$('form .Nama_Ayah').val("");
		$('form .Telepon_Ayah').val("");
		$('form .Pendidikan_Ayah').val("");
		$('form .Pekerjaan_Ayah').val("");
		$('form .NIK_Ayah').val("");
		$('form .TLAyah').val("");
		$('form .TlahirAyah').val("");
		$('form .Penghasilan_Ayah').html(PenghasilanSet());

		$('form .Nama_Ibu').val("");
		$('form .Telepon_Ibu').val("");
		$('form .Pendidikan_Ibu').val("");
		$('form .Pekerjaan_Ibu').val("");
		$('form .NIK_Ibu').val("");
		$('form .TLIbu').val("");
		$('form .TlahirIbu').val("");
		$('form .Penghasilan_Ibu').html(PenghasilanSet());

		$('form .Nama_Wali').val("");
		$('form .Telepon_Wali').val("");
		$('form .Pendidikan_Wali').val("");
		$('form .Pekerjaan_Wali').val("");
		$('form .NIK_Wali').val("");
		$('form .TLWali').val("");
		$('form .TlahirWali').val("");
		$('form .Penghasilan_Wali').html(PenghasilanSet());


		$('form .Taktif').val("");
		$('form .Jabatan').val("");
		$('form .Kontak').val("");
		$.ajax({
			url: url + 'data_api/pelajar/get_status',
			dataType: "json",
			beforeSend: function () {
				setTimeout(function () {
					$(".loader").show(0).fadeOut(1000);
				}, time);
			},
			error: function () {
				alert("error ambil status!");
			},
			success: function (data) { 
				var sts = '<option value=""> -Pilih Status -</option>';
				$.each(data,function(i,r) {
					sts += '<option value="'+r.id+'">'+r.set_active+'</option>';
				})
		$('form .Status').html(sts);
			}
		});
		$('form .jns_kelamin').html(
			'<option option value = "" > -Pilih Jenis -</option > ' +
			'<option value="1">Laki - Laki</option>' +
			'<option value="2">Perempuan</option>');
		$('form .file').val("");
		$('form .Image').val("null");
		$(".picture-src").attr("src", url + "img_pelajar/default.png");
	}
	///////////////////////
	///////////////////////


	////////////////////////////////////
	////////////////////////////////////

	$('.formopen').on('click', function () {
		var opt = $(this).data('option');
		var id = $(this).data('id');
		var V_lembaga;
		$.ajax({
			url: url + 'data_api/pelajar/get_data_by',
			method: "POST",
			data: {
				id: id,
			},
			dataType: "json",
			beforeSend: function () {
				setTimeout(function () {
					$(".loader").show(0).fadeOut(1000);
				}, time);
				clearDta()
			},
			error: function () {
				alert("error!");
			},
			success: function (data) {
				console.log(data);
				V_lembaga = '<option value="' + data.dt1.cabang_id + '">' + data.dt1.nama_cabang + '</option>';
				$.each(data.cabang, function (i, row) {
					if (data.dt1.cabang_id === row.id) {} else {
						V_lembaga += '<option value="' + row.id + '">' + row.nama_cabang + '</option>';
					}
				});

				var V_Kota = '<option value="' + data.dt1.id_kota + '">' + data.dt1.kota_lahir + '</option>'
				$.each(data.kota, function (i, row) {
					if (data.dt1.id_kota === row.id) {} else {
						V_Kota += '<option value="' + row.id + '">' + row.kota + '</option>';
					}
				});
				var iddesa = data.dt1.id_kelurahan;
				var iddset1, iddset2;
				if (iddesa > 0) {
					iddset1 = iddesa.substring(0, 4);
					iddset2 = iddesa.substring(0, 7);
				} else {

					iddset1 = '';
					iddset2 = '';
				}
				var V_Kota2 = '<option value="' + iddset1 + '">' + data.dt1.kota + '</option>'
				$.each(data.kota, function (i, row) {
					if (iddset1 === row.id) {} else {
						V_Kota2 += '<option value="' + row.id + '">' + row.kota + '</option>';
					}
				});
				var V_kec = '<option value="' + iddset2 + '">' + data.dt1.kecamatan + '</option>'
				$.each(data.kota, function (i, row) {
					if (iddset2 === row.id) {} else {
						V_kec += '<option value="' + row.id + '">' + row.kota + '</option>';
					}
				});
				var V_kel = '<option value="' + iddesa + '">' + data.dt1.kelurahan + '</option>'
				$.each(data.kota, function (i, row) {
					if (iddesa === row.id) {} else {
						V_kel += '<option value="' + row.id + '">' + row.kota + '</option>';
					}
				});

				var V_bl = '<option value="' + data.dt1.infaq_bulanan + '">' + data.dt1.bulanan + '</option>'
				$.each(data.bulanan, function (i, row) {
					if (data.dt1.infaq_bulanan === row.id_nominal) {} else {
						V_bl += '<option value="' + row.id_nominal + '">' + row.infaq_bulanan + '</option>';
					}
				});
				var V_th = '<option value="' + data.dt1.infaq_tahunan + '">' + data.dt1.tahunan + '</option>'
				$.each(data.tahunan, function (i, row) {
					if (data.dt1.infaq_tahunan === row.id_nominal) {} else {
						V_th += '<option value="' + row.id_nominal + '">' + row.infaq_tahunan + '</option>';
					}
				});
				var V_gr = '<option value="' + data.dt1.managenent + '">' + data.dt1.nama_guru + '</option>'
				$.each(data.guru, function (i, row) {
					if (data.dt1.managenent === row.id_karyawan) {} else {
						V_gr += '<option value="' + row.id_karyawan + '">' + row.nama_lengkap + '</option>';
					}
				});
				var jns;
				if (data.dt1.jns_kelamin == 1) {
					jns = ' <option value="1">Laki - Laki</option>' +
						'<option value="2">Perempuan</option>'
				} else {
					jns = ' <option value="2">Perempuan</option>' +
						'<option value="1">Laki - Laki</option>'
				}
				
					
				
				var T_lahir = formarDate(data.dt1.tgl_lahir);
				var T_Aktif = formarDate(data.dt1.tgl_pendaftaran);
				$('form .Nama_lengkap').val(data.dt1.nama_lengkap);
				$('form .Nama_Panggilan').val(data.dt1.nama_panggilan);
				$('form .jns_kelamin').html(jns);
				$('form .NIK').val(data.dt1.nik_santri);
				$('form .NIS').val(data.dt1.nis);
				$('form .Tlahir').val(T_lahir);
				$('form .Alamat_rumah').val(data.dt1.alamat);
				$('form .Lembaga').html(V_lembaga);
				$('form .KotaLahir').html(V_Kota);
				$('form .Kota_alamat').html(V_Kota2);
				$('form .kecamatan').html(V_kec);
				$('form .Kelurahan').html(V_kel);
				$('form .Nama_Guru').html(V_gr);
				$('form .Anak_ke').val(data.dt1.anak_ke);
				$('form .Dari_saudara').val(data.dt1.dari);
				$('form .Hafal').val(data.dt1.hafal);
				$('form .Lacar').val(data.dt1.lancar);
				$('form .Jilid').val(data.dt1.baca);
				$('form .Sekolah').val(data.dt1.nama_sekolah);
				$('form .Alamat_Sekolah').val(data.dt1.alamat_sekolah);
				$('form .Kelas_Sekolah').val(data.dt1.kelas);

				$('form .Nama_Ayah').val(data.dt1.nama_ayah);
				$('form .Telepon_Ayah').val(data.dt1.nomor_hp_ayah);
				$('form .Pendidikan_Ayah').val(data.dt1.pendidikan_ayah);
				$('form .Pekerjaan_Ayah').val(data.dt1.pekerjaan_ayah);
				$('form .NIK_Ayah').val(data.dt1.nik_ayah);
				$('form .TLAyah').val(data.dt1.tempat_lahir_ayah);
				$('form .TlahirAyah').val(data.dt1.tgl_lahir_ayah);

				var ph_AYAH = '<option value="' + data.dt1.penghasilan_ayah + '">' + data.dt1.penghasilan_ayah + '</option>';
				$('form .Penghasilan_Ayah').html(ph_AYAH + PenghasilanSet());

				$('form .Nama_Ibu').val(data.dt1.nama_ibu);
				$('form .Telepon_Ibu').val(data.dt1.nomor_hp_ibu);
				$('form .Pendidikan_Ibu').val(data.dt1.pendidikan_ibu);
				$('form .Pekerjaan_Ibu').val(data.dt1.pekerjaan_ibu);
				$('form .NIK_Ibu').val(data.dt1.nik_ibu);
				$('form .TLIbu').val(data.dt1.tempat_lahir_ibu);
				$('form .TlahirIbu').val(data.dt1.tgl_lahir_ibu);
				var ph_IBU = '<option value="' + data.dt1.penghasilan_ibu + '">' + data.dt1.penghasilan_ibu + '</option>';
				$('form .Penghasilan_Ibu').html(ph_IBU + PenghasilanSet());
				$('form .Penghasilan_Ayah').html(ph_AYAH + PenghasilanSet());

				$('form .Nama_Wali').val(data.dt1.nama_wali);
				$('form .Telepon_Wali').val(data.dt1.nomor_hp_wali);
				$('form .Pendidikan_Wali').val(data.dt1.pendidikan_wali);
				$('form .Pekerjaan_Wali').val(data.dt1.pekerjaan_wali);
				$('form .NIK_Wali').val(data.dt1.nik_wali);
				$('form .TLWali').val(data.dt1.tempat_lahir_wali);
				$('form .TlahirWali').val(data.dt1.tgl_lahir_wali);
				var ph_Wali = '<option value="' + data.dt1.penghasilan_wali + '">' + data.dt1.penghasilan_wali + '</option>';
				$('form .Penghasilan_Wali').html(ph_Wali + PenghasilanSet());

				if (data.dt1.st_anak === 'KANDUNG') {
					btn1 = "active";
					btn2 = "notActive";
				} else {
					btn1 = "notActive";
					btn2 = "active";
				}

				$('form #ST_ANAK').val(data.dt1.st_anak);

				var ANAK_ST = '<a class="btn btn-primary radioBtnChk btn-sm ' + btn1 + ' " data-toggle="ST_ANAK" data-title="KANDUNG">KANDUNG</a>' +
					'<a class="btn btn-primary radioBtnChk btn-sm ' + btn2 + '" data-toggle="ST_ANAK" data-title="ANGKAT">ANGKAT</a>'
				$('form #radioBtn').html(ANAK_ST);
				$(".picture-src").attr("src", url + "img_pelajar/" + data.dt1.gambar);

					$(".Image").val(data.dt1.gambar);
					$('form .Tdaftar').val(T_Aktif);
					
				$('form .Status option[value='+data.dt1.status_pelajar+']').attr('selected','selected');
				var pic = '<img src="' + url + 'assets/img_pelajar/' + data.dt1.gambar + '" style="width:140px">';
				$('form .Data_photo').html(pic);
				$('form .File_Old').val(data.dt1.gambar);
				$('.options').html('<i class="fa fa-plus-circle"></i> ' + opt);
				$('form .idPelajar').val(id);
				$('.FormOpenPelajar').modal();
			}
		})
	});

	function PenghasilanSet() {
		var Result = '<option value="">- pilih -</option>' +
			' <option value="Rp.0 - Rp.1,000,000">Rp.0 - Rp.1,000,000</option>' +
			'<option value="Rp.1,000,000 - Rp.2,000,000">Rp.1,000,000 - Rp.2,000,000</option>' +
			'<option value="Rp.2,000,000 - Rp.3,000,000">Rp.2,000,000 - Rp.3,000,000</option>' +
			'<option value="Rp.3,000,000-5,000,000">Rp.3,000,000-5,000,000</option>' +
			'<option value="> Rp.5,000,000"> > Rp.5,000,000</option>';
		return Result;

	}
	////////////////////////////////////
	////////////////////////////////////
	$('form').on('submit', function (e) {
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
				$('.FormOpenPelajar').modal("hide");
			},
			error: function () {
				alert("error!");
			},
			success: function (data) {
				//console.log(data);
				table.ajax.reload();
				$('.event-icon').html("<i class='fa fa-" + data.event.icon + "'  style='color:" + data.event.color + "'></i>");
				$('.event-title').html(data.event.title);
				$('.event-body').html(data.event.description);
				$('.event-footer').html(data.event.footer);
				$('#Msg-Notification').modal('show');
			}
		});

	});



	//////////////////
	//////////////////

	$('#Table1set').on('click', '.deletedata', function () {
		var nm = $(this).data('nm');
		var id = $(this).data('id');

		$('.event-icon').html("<i class='fa fa-trash'  style='color:#ff0000'></i>");
		$('.event-title').html(nm);
		$('.event-body').html("Yakin ingin menghapus data ini..?");
		$('.event-footer').html("<button class='btn btn-primary btn-sm prosesdelete' data-id='" + id + "'  data-nm='" + nm + "'>Yakin!</button> " + '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">Tidak</button>');
		$('#Msg-Notification').modal();
	});
	$('#Msg-Notification').on('click', '.prosesdelete', function () {
		var nm = $(this).data('nm');
		var id = $(this).data('id');
		$.ajax({
			url: url + 'data_api/pelajar/delete_data',
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
			},
			error: function () {
				alert("error!");
			},
			success: function (data) {
				// console.log(data);
				if (data.result) {
					$('.event-icon').html("<i class='fa fa-" + data.event.icon + "'  style='color:" + data.event.color + "'></i>");
					$('.event-title').html(data.event.title);
					$('.event-body').html(data.event.description);
					$('.event-footer').html(data.event.footer);
					$('#Msg-Notification').modal();
				}
				table.ajax.reload();

			}
		})
	})

	//////////////////
	//////////////////

	$('#Table1set').on('click', '.ViewData', function () {
		var opt = $(this).data('option');
		var id = $(this).data('id');
		var V_lembaga;
		$.ajax({
			url: url + 'data_api/pelajar/profile',
			method: "POST",
			dataType: "text",
			data: {
				id: id,
			},
			error: function () {
				alert("error!");
			},
			success: function (data) {
				$(".OpenViewPelajar .modal-body").html(data)
				$(".OpenViewPelajar").modal()
				$('.options').html("View ");
			}
		})
	});

	$(".ReloadData").click(function () {
		table.ajax.reload();
	})



	$(".imgf").change(function () {
		var id = $(this).data("row");
		var fd = new FormData();
		var files = $('#imgf' + id)[0].files;
		if (files.length > 0) {
			fd.append('file', files[0]);
			$.ajax({
				url: url + 'data_api/pelajar/uploads_img',
				type: 'post',
				data: fd,
				contentType: false,
				processData: false,
				beforeSend: function () {
					setTimeout(function () {
						$(".loader").show(0).fadeOut(1000);
					}, time);
					$("#imgv" + id).attr("src", url + "assets/images/spin.svg");
					$("#imgv" + id).show();
				},

				dataType: "json",
				success: function (response) {
					if (response != 0) {
						$(".text" + id).val(response.nimg);
						$("#imgv" + id).attr("src", response.img);
						$("#imgv" + id).show();
						//console.log(response)
					} else {
						alert('file not uploaded');
					}

				},

			});

		} else {

			alert("Please select a file.");

		}

	});

});


$('div#radioBtn ').on('click', '.radioBtnChk', function () {
	var sel = $(this).data('title');
	var tog = $(this).data('toggle');
	$('#' + tog).prop('value', sel);
	$('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
	$('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
})

$('#BtnWali a').on('click', function () {

	var sel = $(this).data('title');

	var tog = $(this).data('toggle');

	$('#' + tog).prop('value', sel);



	$('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');

	$('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');



	if (sel == 'N') {
		$(".Nama_Wali").prop('required', true);
		$(".NIK_Wali").prop('required', true);
		$(".Telepon_Wali").prop('required', true);
		$(".Pekerjaan_Wali").prop('required', true);
		$(".Penghasilan_Wali").prop('required', true);
		$(".CRWALI").show();

	} else {

		$(".Nama_Wali").prop('required', false);
		$(".NIK_Wali").prop('required', false);
		$(".Telepon_Wali").prop('required', false);
		$(".Pekerjaan_Wali").prop('required', false);
		$(".Penghasilan_Wali").prop('required', false);

		$(".Nama_Wali").removeAttr('required');
		$(".NIK_Wali").removeAttr('required');
		$(".Telepon_Wali").removeAttr('required');
		$(".Pekerjaan_Wali").removeAttr('required');
		$(".Penghasilan_Wali").removeAttr('required');
		$(".CRWALI").hide();

	}



});