$(function(){
    "use strict"

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("change", ".selectPdct", function(){
        let dis = $(this);
        let pdctId = dis.val();
        $.ajax({
                type:'GET',
                url: '/ajax/product/',
                data: {'pdctId': pdctId},
                dataType:'json',
                success: (response) => {
                    dis.parent().parent().find(".qty").val(1)
                    dis.parent().parent().find(".price").val(response.product.selling_price)
                },
                error: function(response){
                    /*$('#ajax-form').find(".print-error-msg").find("ul").html('');
                    $('#ajax-form').find(".print-error-msg").css('display','block');
                    $.each( response.responseJSON.errors, function( key, value ) {
                        $('#ajax-form').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    });*/
                }
           });
    })
})

function calculateTotal(){

}