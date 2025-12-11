$(function(){
    "use strict"

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("keyup", ".qty, .discount, .advance", function(){
        calculateTotal();
    })

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
                dis.parent().parent().find(".price1").val(response.product.selling_price)
                calculateTotal();
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
    let qty = 0;
    let price = 0;
    let discount = 0;
    let tot = 0;
    let total = 0;
    let advance = 0;
    let balance = 0;
    $("#orderForm tbody>tr").each(function(){
        if(parseInt($(this).find(".qty").val()) > 0){
            qty = parseInt($(this).find(".qty").val());
            price = parseFloat($(this).find(".price1").val());
            tot = qty*price;
            $(this).find(".price").val(parseFloat(tot).toFixed(2))
        }        
    })
    discount = (parseFloat($(".discount").val()) > 0) ? parseFloat($(".discount").val()) : 0;
    advance = (parseFloat($(".advance").val()) > 0) ? parseFloat($(".advance").val()) : 0;
    $("#orderForm tbody>tr").each(function(){
        if(parseFloat($(this).find(".price").val()) > 0){
            price = parseFloat($(this).find(".price").val());
            total += price;
        }
    })
    balance = total - (discount + advance);
    $(".total").val(parseFloat(total-discount).toFixed(2))
    $(".balance").val(parseFloat(balance).toFixed(2))
}

function validateOrderForm(){
    let frm = document.forms["orderForm"];
    let pdctLen = 0;
    if(parseFloat(frm['advance'].value) > 0 && frm['advance_pmode'].value == ''){
        failed({
            'error': 'Please select advance payment mode'
        });
        return false;
    }
    if(frm['product_advisor'].value == ''){
        failed({
            'error': 'Please select product advisor'
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