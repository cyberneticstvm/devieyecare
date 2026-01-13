$(function(){
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

    $(document).on("click", ".orderDetailsDrawer", function(){
        let rid = $(this).data('rid');
        let type = $(this).data('type');
        $.ajax({
            type:'GET',
            url: '/ajax/order/details',
            data: {'rid': rid, 'type': type},
            dataType:'json',
            success: (response) => {
                $(".orderDetails").html(response.data);
            }
        });
    });

    $(document).on("click", ".expensesDrawer", function(){
        let ddate = $(this).data('ddate');
        let bid = $(this).data('branch');
        $.ajax({
            type:'GET',
            url: '/ajax/expense/details',
            data: {'branch': bid, 'ddate': ddate},
            dataType:'json',
            success: (response) => {
                $(".expenseDetails").html(response.data);
            }
        });
    });

    $(document).on("click", ".vPaymentDrawer", function(){
        let ddate = $(this).data('ddate');
        let bid = $(this).data('branch');
        $.ajax({
            type:'GET',
            url: '/ajax/vpayment/details',
            data: {'branch': bid, 'ddate': ddate},
            dataType:'json',
            success: (response) => {
                $(".vPaymentsDetails").html(response.data);
            }
        });
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

    $(document).on("change", ".selPdct", function(){
        let frm = document.forms["transferForm"];
        if(frm['ftype'].value == 'transfer' && !frm['from_branch'].value){
            failed({
                'error': 'Please select from branch'
            });
            $(".selPdct").val('').select2();
            return false;
        }
        let fromBr = (frm['ftype'].value == 'transfer') ? frm['from_branch'].value : 0;
        let pdctId = $(this).val();
        $.ajax({
            type:'GET',
            url: '/ajax/batch/',
            data: {'frombr': fromBr, 'pdct': pdctId},
            dataType:'json',
            success: (response) => {
                var xdata = $.map(response.batch, function (obj) {
                    obj.id = obj.batch;
                    obj.text = obj.batchwqty;
                    return obj;
                });             
                if(response.is_expiry === 1){
                    $('.selBatch').html("<option value=''>Select</option>").select2({
                        data: xdata,
                    });                    
                }else{
                    $('.selBatch').select2().html(new Option("Not Applicable", 'NA'));
                }
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
            },
            beforeSend: () => {
                //$('.selBatch').val(null).trigger('change');
            }
        });
    });
});

function addRow(type){
    if(type == 'medicine'){
        $.ajax({
            type:'GET',
            url: '/ajax/products/',
            data: {'type': type},
            dataType:'json',
            success: (response) => {
                var xdata = $.map(response.products, function (obj) {
                    obj.id = obj.id;
                    obj.text = obj.name;
                    return obj;
                });
                let uid = Math.floor(Math.random() * 100) + 1;
                $(".medicineRow").append(`<tr><td><select class='select2' name='product_ids[]' id='pid${uid}'></select></td><td><input type='text' name='dosage1[]' class='form-control' placeholder='0' /></td><td><input type='text' name='dosage2[]' class='form-control' placeholder='0' /></td><td><input type='text' name='dosage3[]' class='form-control' placeholder='0' /></td><td><input type='text' name='days[]' class='form-control' placeholder='0' /></td></tr>`);
                $(".medicineRow tr:last").find('.select2').html("<option value=''>Select</option>").select2({
                    data: xdata,
                });    
            }
        });
    }
    if(type == 'status'){
        $.ajax({
            type:'GET',
            url: '/ajax/products/',
            data: {'type': type},
            dataType:'json',
            success: (response) => {
                var xdata = $.map(response.products, function (obj) {
                    obj.id = obj.id;
                    obj.text = obj.name;
                    return obj;
                });
                let uid = Math.floor(Math.random() * 100) + 1;
                $(".orderStatusRow").append(`<tr><td><input type='text' name='mrns[]' class='form-control' placeholder='Mrn' /></td><td><select class='select2' name='status_ids[]' id='sid${uid}'></select></td><td><input type='text' name='comments[]' class='form-control' placeholder='Comment' /></td><td><a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Remove</a></td></tr>`);
                $(".orderStatusRow tr:last").find('.select2').html("<option value=''>Select</option>").select2({
                    data: xdata,
                });    
            }
        });
    }
}

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

function validatePharmacyForm(){
    let frm = document.forms["pharmacyItemsForm"];
    let pdctLen = 0;
    $("#pharmacyItemsForm .slctdPct").each(function(){
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
    if(!frm['pmode'].value){
        failed({
            'error': 'Please select payment mode'
        });
        return false;
    }
}

function validatePharmacyItem(){
    let frm = document.forms["transferForm"];
    if(!frm['product_id'].value){
        failed({
            'error': 'Please select a product'
        });
        return false;
    }
    if(!frm['batch'].value){
        failed({
            'error': 'Please select Batch'
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
    $.ajax({
        type:'GET',
        url: '/ajax/batch/price',
        data: {'pdct': frm['product_id'].value, 'batch': frm['batch'].value},
        dataType:'json',
        success: (response) => {
            if(response.status == 1){
                let total = parseInt(frm['qty'].value) * parseFloat(response.product.selling_price);
                $(".pharmacyItem").append(`<tr><td><input type="hidden" name="product_id[]" value="${frm['product_id'].value}" class="slctdPct"><input type="text" name="product[]" value="${pdct}" class="border-0 w-100" readonly></td><td><input type="text" name="batch[]" value="${frm['batch'].value}" class="border-0 w-100" readonly></td><td><input type="text" name="expiry[]" value="${response.product.expiry}" class="border-0 w-100" readonly></td><td><input type="text" name="qty[]" value="${frm['qty'].value}" class="border-0 w-100" readonly></td><td><input type="text" name="price[]" value="${response.product.selling_price}" class="border-0 w-100" readonly></td><td><input type="text" name="total[]" value="${total.toFixed(2)}" class="border-0 w-100" readonly></td><td><a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Remove</a></td></tr>`);
                frm.reset();
                $(".selPdct").select2();
                $('.selBatch').select2();
            }else{
                failed({
                    'error': 'Unable to fetch data',
                });
                return false;
            }            
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText);
        },
        beforeSend: () => {
            $(".addButton").attr("disabled", true);
            $(".addButton").html("Loading...<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>")
        },
        complete: () => {
            $(".addButton").html("Add");
            $(".addButton").attr("disabled", false);
        }
    });    
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
        if(!frm['batch'].value){
            failed({
                'error': 'Please select Batch'
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
        $('.selBatch').select2();
    }   
}