$('form#login').on('submit', function(e) {

    $(".TextLogin").html('<span class="alert-danger btn-block p-3"  >LOGIN</span>');

    e.preventDefault();

    e.stopImmediatePropagation();

    $.ajax({

        url: $(this).attr('action'),

        method: "POST",

        data: $(this).serialize(),

        dataType: "json",

        beforeSend: function() {

            setTimeout(function () {

            $(".loader").show(0).fadeOut(1000);

          }, time);

            $(".TextLogin").html('<span  class="btn-block p-3 loginproses">LOADING...</span>');

        },

        error: function() {
            $(".TextLogin").html('<span class="alert-danger btn-block p-3" >ERROR!</span>');
            $("form#login #pss").val('');
        },

        success: function(data) {
            if (data.result) {

                $(".TextLogin").html('<span class="btn-block p-3 alert-success" >' + data.status + '</span>');

                 window.location.href = urls+data.url;;

            } else {

                $("form#login #pass").val('');

                $(".TextLogin").html('<span class="alert-danger btn-block p-3" >' + data.status + '</span>');

            }

        }

    });



})