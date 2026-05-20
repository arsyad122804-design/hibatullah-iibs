
$(function(){
    var table = $('#Table1set').DataTable({
        ajax: url + "lembaga/datalembaga",
        deferRender: true,
        processing: true,
        language: {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        
        lengthChange: false,
        scrollCollapse: false,
        autoWidth: false,
        responsive: true,
        searching: true,
        ordering :true,
    });          

$('.openform').click(function () {
    var opt = $(this).data('option');
    var id = $(this).data('id');
    $('form .lembaga').prop('readonly', false);  
    $('form .idlembaga').val('');
    $('form .lembaga').val('');
    $('form .pimpinan').val('');
    $('form .alamat').val('');
    $('form .kota').val('');
    $('form .telepon').val('');
    $('form .email').val('');
    $('form .website').val('');
    $('form .kode_l').val('-');
    $('form .kode_d').val('-');

    $('#new_lembaga_p').val("Simpan")
    $('.options').html('<i class="fa fa-plus-circle"></i> ' + opt);
    $('form .idlembaga').val(id);
    $('.FormOpenLembaga').modal();
});

$('#Table1set').on('click', '.openform', function () {
    var opt = $(this).data('option'); 
    var id = $(this).data('id');     
    $.ajax({
        url: url+'lembaga/getdatalembaga',
        method: "POST",
        data: {
            id:id
        },
        dataType: "json",
        beforeSend:function() {
            setTimeout(function () {
            $(".loader").show(0).fadeOut(1000);
            }, time);
            if (lvl_usr>1) {
                $('form .lembaga').prop('readonly',true);  
            } else {
                $('form .lembaga').prop('readonly',false);  
            }
            $('form .idlembaga').val('');
            $('form .lembaga').val('');
            $('form .pimpinan').val('');
            $('form .alamat').val('');
            $('form .kota').val('');
            $('form .telepon').val('');
            $('form .email').val('');
            $('form .website').val('');
            $('form .kode_l').val('-');
            $('form .kode_d').val('-');
        },
        error: function () {
            alert("error!");
        },
        success: function (data) {
            console.log(data);
            $('form .lembaga').val(data.data.nama);
            $('form .pimpinan').val(data.data.pengurus);
            $('form .alamat').val(data.data.alamat);
            $('form .kota').val(data.data.kota);
            $('form .telepon').val(data.data.telepon);
            $('form .email').val(data.data.email);
            $('form .website').val(data.data.website);
            $('form .kode_l').val(data.data.cabang);
            $('form .kode_d').val(data.data.donatur);
            $('form .paket').html(data.data.paket);
            $('#new_lembaga_p').val("Edit")
            $('.options').html('<i class="fa fa-pencil-square"></i> ' + opt);
            $('form .idlembaga').val(id);
            $('.FormOpenLembaga').modal();
        }
    })
});


$('#Table1set').on('click', '.deletedata', function () {
    var nm = $(this).data('nm'); 
    var id = $(this).data('id');

    $('.event-icon').html("<i class='fa fa-trash'  style='color:#ff0000'></i>");
    $('.event-title').html(nm);
    $('.event-body').html("Yakin ingin menghapus data ini...?");
    $('.event-footer').html("<button class='btn btn-primary btn-sm prosesdelete' data-id='"+id+"'  data-nm='"+nm+"'>Yakin!</button> "+'<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">Tidak</button>');
    $('#Msg-Notification').modal();
});
    
$('#Msg-Notification').on('click','.prosesdelete',function() {
    var nm = $(this).data('nm'); 
    var id = $(this).data('id');
    $.ajax({
        url: url+'lembaga/deletedatalembaga',
        method: "POST",
        data: {
            id:id,
            nm:nm,
        },
        dataType: "json",
        beforeSend: function () {
            setTimeout(function () {
            $(".loader").show(0).fadeOut(1000);
          }, time);
            $('#Msg-Notification').modal('hide');
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
            $('#Msg-Notification').modal();
        }
    })
})

$('form#lembaga').on('submit', function (e) {
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
            $('.FormOpenLembaga').modal('hide');
        },
        error: function () {
            alert("error!");
        },
        success: function (data) {
            table.ajax.reload();
            $('form .idlembaga').val('');
            $('form .lembaga').val('');
            $('form .pimpinan').val('');
            $('form .kota').val('');
            $('form .alamat').val('');
            $('form .telepon').val('');
            $('form .website').val('');
            $('form .kode_l').val('-');
            $('form .kode_d').val('-');
            //console.log(data);
            $('.event-icon').html("<i class='fa fa-" + data.event.icon + "'  style='color:" + data.event.color + "'></i>");
            $('.event-title').html(data.event.title);
            $('.event-body').html(data.event.description);
            $('.event-footer').html(data.event.footer);
            $('#Msg-Notification').modal();
        }
    });

});
    
    $(".ReloadData").click(function() {
        table.ajax.reload();
    })
                   
}) 
                