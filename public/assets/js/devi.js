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
    });
})

function calculateTotal(){

}

function validateOrderForm(){
    let frm = document.forms["orderForm"];
    let pdctLen = 0;
    if(parseFloat(frm['advance'].value) > 0 && frm['pmode'].value == ''){
        failed({
            'error': 'Please select advance payment mode'
        });
        return false;
    }    
    $("#orderForm .selectPdct").each(function(){
        if($(this).val() > 0){
            pdctLen += 1;
        }
    });
    if(pdctLen === 0){
        failed({
            'error': 'Please select a product'
        });
        return false;
    }      
    return true;
}