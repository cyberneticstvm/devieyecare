t$(function(){
    "use strict"

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("click", ".orderStatusUpdateDrawer", function(){
        let mrn = $(this).data("mrn");
        let oid = $(this).data("oid");
        $(".mrn").html(mrn);
        $("#oid").val(oid);
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

function validatePurchaseForm(){
    let frm = document.forms["purchaseForm"];
    let frm1 = document.forms["purchaseItemsForm"];
    let pdctLen = 0;
    if(!frm['supplier_id'].value){
        failed({
            'error': 'Please select supplier'
        });
        return false;
    }
    if(!frm['invoice'].value){
        failed({
            'error': 'Please enter Purchase Invoice'
        });
        return false;
    }
    $("#purchaseItemsForm .slctdPct").each(function(){
        if($(this).val() > 0){
            pdctLen += 1;
        }
    });
    if(pdctLen === 0){
        failed({
            'error': 'Please add at least one item to the table!'
        });
        return false;
    }
    $('<input>', {
        type: 'hidden',
        name: 'supplier_id',
        value: frm['supplier_id'].value
    }).appendTo(frm1);
    $('<input>', {
        type: 'hidden',
        name: 'invoice',
        value: frm['invoice'].value
    }).appendTo(frm1);
    $('<input>', {
        type: 'hidden',
        name: 'pdate',
        value: frm['pdate'].value
    }).appendTo(frm1);
    $('<input>', {
        type: 'hidden',
        name: 'notes',
        value: frm['notes'].value
    }).appendTo(frm1);
    return true;     
}

function validateTransferForm(){
    let frm = document.forms["transferForm"];
    let frm1 = document.forms["transferItemsForm"];
    let pdctLen = 0;
    if(!frm['from_branch'].value){
        failed({
            'error': 'Please select From Branch'
        });
        return false;
    }
    if(!frm['to_branch'].value){
        failed({
            'error': 'Please select To Branch'
        });
        return false;
    }
    if(frm['to_branch'].value == frm['from_branch'].value){
        failed({
            'error': 'From and To Branch should not be same!'
        });
        return false;
    }
    $("#transferItemsForm .slctdPct").each(function(){
        if($(this).val() > 0){
            pdctLen += 1;
        }
    });
    if(pdctLen === 0){
        failed({
            'error': 'Please add at least one item to the table!'
        });
        return false;
    }
    $('<input>', {
        type: 'hidden',
        name: 'from_branch',
        value: frm['from_branch'].value
    }).appendTo(frm1);
    $('<input>', {
        type: 'hidden',
        name: 'to_branch',
        value: frm['to_branch'].value
    }).appendTo(frm1);
    $('<input>', {
        type: 'hidden',
        name: 'tdate',
        value: frm['tdate'].value
    }).appendTo(frm1);
    $('<input>', {
        type: 'hidden',
        name: 'notes',
        value: frm['notes'].value
    }).appendTo(frm1);
    return true;     
}

function addItem(type){
    if(type == 'purchase'){
        let frm = document.forms["purchaseItemForm"];
        if(!frm['product_id'].value){
            failed({
                'error': 'Please select a product'
            });
            return false;
        }
        if(!frm['qty'].value){
            failed({
                'error': 'Please enter Qty'
            });
            return false;
        }
        if(!frm['purchase_price'].value){
            failed({
                'error': 'Please enter Purchase Price'
            });
            return false;
        }
        let pdct = $(".selPdct option:selected").text();
        let tot = (parseFloat(frm['purchase_price'].value) && parseInt(frm['qty'].value)) ? parseFloat(frm['purchase_price'].value) * parseInt(frm['qty'].value) : 0;
        $(".purchaseItem").append(`<tr><td><input type="hidden" name="product_id[]" value="${frm['product_id'].value}" class="slctdPct"><input type="text" name="product[]" value="${pdct}" class="border-0 w-100" readonly></td><td><input type="text" name="batch[]" value="${frm['batch'].value}" class="border-0 w-100" readonly></td><td><input type="text" name="expiry[]" value="${frm['expiry'].value}" class="border-0 w-100" readonly></td><td><input type="text" name="qty[]" value="${frm['qty'].value}" class="border-0 w-100" readonly></td><td><input type="text" name="purchase_price[]" value="${frm['purchase_price'].value}" class="border-0 w-100" readonly></td><td><input type="text" name="selling_price[]" value="${frm['selling_price'].value}" class="border-0 w-100" readonly></td><td><input type="text" name="total[]" value="${tot}" class="border-0 w-100" readonly></td><td><a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Remove</a></td></tr>`);
        frm.reset();
        $(".selPdct").select2();            
    }
    if(type == 'transfer'){
        let frm = document.forms["transferItemForm"];
        if(!frm['product_id'].value){
            failed({
                'error': 'Please select a product'
            });
            return false;
        }
        if(!frm['qty'].value){
            failed({
                'error': 'Please enter Qty'
            });
            return false;
        }
        let pdct = $(".selPdct option:selected").text();
        $(".transferItem").append(`<tr><td><input type="hidden" name="product_id[]" value="${frm['product_id'].value}" class="slctdPct"><input type="text" name="product[]" value="${pdct}" class="border-0 w-100" readonly></td><td><input type="text" name="batch[]" value="${frm['batch'].value}" class="border-0 w-100" readonly></td><td><input type="text" name="qty[]" value="${frm['qty'].value}" class="border-0 w-100" readonly></td><td><a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Remove</a></td></tr>`);
        frm.reset();
        $(".selPdct").select2();
    }   
}