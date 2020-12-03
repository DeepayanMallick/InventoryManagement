$(document).ready(function () {

    /****************************
       Datepicker jQurey
     *****************************/

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    }); 
});

var delay = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();

function searchCustomer() {
    let value = document.getElementById("Customer").value;

    if (!value) {
        document.getElementById('suggestion-box').innerHTML = '';
        document.getElementById('customer-info').innerHTML = '';
    }

    delay(function () {
        $(".CustomerSearch").fadeIn();
        let request = new XMLHttpRequest();
        request.open("GET", base_url + "/customers/search?q=" + value, true);
        request.setRequestHeader("Content-type", "application/json");
        request.send();

        request.onload = () => {
            $(".CustomerSearch").fadeOut();
            if (request.status == 200) {
                let searchResult = JSON.parse(request.response);
                document.getElementById('suggestion-box').innerHTML = searchResult;
            } else {
                console.log(`error ${request.status} ${request.statusText}`);
            }
        };
    }, 1000);
}

function selectCustomer(customerId, customerName, customerPhone) {

    $(".CustomerSearch").fadeIn();
    let request = new XMLHttpRequest();
    request.open("GET", base_url + "/customers/details?cid=" + customerId, true);
    request.setRequestHeader("Content-type", "application/json");
    request.send();

    request.onload = () => {
        $(".CustomerSearch").fadeOut();
        if (request.status == 200) {
            let customerInfo = JSON.parse(request.response);
            document.getElementById("Customer").value = customerName;
            document.getElementById("CustomerId").value = customerId;
            document.getElementById("CustomerName").value = customerName;
            document.getElementById("CustomerPhone").value = customerPhone;
            document.getElementById('suggestion-box').innerHTML = '';
            document.getElementById('customer-info').innerHTML = customerInfo;
        } else {
            console.log(`error ${request.status} ${request.statusText}`);
        }
    };
}

function searchProduct(e) {
    let value = e.value;
    let count = e.getAttribute('count');

    if (!value) {
        document.getElementById('product-suggestion-box-' + count).innerHTML = '';
        document.getElementById('unit' + count).value = '';
        document.getElementById('unitPrice' + count).value = '';
        document.getElementById('amount' + count).value = '';
    }

    delay(function () {
        $("#ProductSearch" + count).fadeIn();
        let request = new XMLHttpRequest();
        request.open("GET", base_url + "/products/search?q=" + value + "&count=" + count, true);
        request.setRequestHeader("Content-type", "application/json");
        request.send();

        request.onload = () => {
            $("#ProductSearch" + count).fadeOut();
            if (request.status == 200) {
                let searchResult = JSON.parse(request.response);
                document.getElementById('product-suggestion-box-' + count).innerHTML = searchResult;
            } else {
                console.log(`error ${request.status} ${request.statusText}`);
            }
        };
    }, 1000);

}

function selectProduct(productId, productTitle, retailPrice, rowCount) {
    $("#ProductSearch" + rowCount).fadeIn();
    let request = new XMLHttpRequest();
    request.open("GET", base_url + "/products/price?pid=" + productId, true);
    request.setRequestHeader("Content-type", "application/json");
    request.send();

    request.onload = () => {
        $("#ProductSearch" + rowCount).fadeOut();
        if (request.status == 200) {
            var result = JSON.parse(request.response);
            var unitPrice = result.sales_price;

            var availableStock = parseInt(result.available_stock);
            document.getElementById("AvailableStock" + rowCount).value = availableStock;

            document.getElementById("Product" + rowCount).value = productTitle;
            document.getElementById("Product" + rowCount).title = retailPrice;
            document.getElementById("ProductId" + rowCount).value = productId;
            document.getElementById("unitPrice" + rowCount).value = unitPrice;
            document.getElementById('product-suggestion-box-' + rowCount).innerHTML = '';
            document.getElementById('unit' + rowCount).readOnly = false;
            document.getElementById('unitPrice' + rowCount).readOnly = false;
        } else {
            console.log(`error ${request.status} ${request.statusText}`);
        }
    };
}

/****************************
Add more input fields on Order form
*****************************/
let count = 1;

function addMoreProduct() {
    $("#AddMoreProduct").fadeIn();
    count++;
    document.getElementById("TotalRowCount").value = count;
    let request = new XMLHttpRequest();
    request.open("GET", base_url + "/orders/add-more?count=" + count, true);
    request.setRequestHeader("Content-type", "application/json");
    request.send();

    request.onload = () => {
        $("#AddMoreProduct").fadeOut();
        if (request.status == 200) {
            let inputFieldsView = JSON.parse(request.response);
            // document.getElementById('input_fields_wrap').innerHTML += inputFieldsView;
            $("#input_fields_wrap").append(inputFieldsView);
        } else {
            console.log(`error ${request.status} ${request.statusText}`);
        }
    };
}

function removeProduct(count) {
    document.getElementById("product-input-wrap-" + count).remove();
    var TotalRowCount = document.getElementById("TotalRowCount").value;
    let TaxAmount = parseFloat(document.getElementById("TaxAmount").value);

    var i;
    var subTotal = 0;
    for (i = 1; i <= TotalRowCount; i++) {
        if (document.getElementById('amount' + i)) {
            var amount = document.getElementById('amount' + i).value;
            if (amount) {
                var subTotal = subTotal + parseFloat(amount.replace(/,/g, ''));
            }
        }
    }

    var tax = (TaxAmount * subTotal / 100);
    var total = (subTotal + tax);

    document.getElementById('subTotal').value = subTotal;
    document.getElementById('tax').value = tax;
    document.getElementById('total').value = total;
}


function calculatePrice(e) {
    var rowCount = e.getAttribute('count');
    var unit = parseInt(e.value);

    var availableStock = parseInt(document.getElementById("AvailableStock" + rowCount).value);

    if (unit > availableStock) {
        document.getElementById("OutOfStockError" + rowCount).classList.remove("d-none");
        document.getElementById("OutOfStockError" + rowCount).innerHTML = "Available stock is " + availableStock;
        document.getElementById('amount' + rowCount).value = '';
    } else {
        document.getElementById("OutOfStockError" + rowCount).classList.add("d-none");
        let productId = document.getElementById("ProductId" + rowCount).value;
        var TotalRowCount = document.getElementById("TotalRowCount").value;
        $("#CalculatePrice" + rowCount).fadeIn();
        let request = new XMLHttpRequest();
        request.open("GET", base_url + "/orders/calculate-price?pid=" + productId + "&unit=" + unit, true);
        request.setRequestHeader("Content-type", "application/json");
        request.send();

        request.onload = () => {
            $("#CalculatePrice" + rowCount).fadeOut();
            if (request.status == 200) {
                var result = JSON.parse(request.response);
                // document.getElementById('amount' + rowCount).value = result.productPrice;  

                var unitPrice = document.getElementById('unitPrice' + rowCount).value;
                var productPrice = parseFloat(unitPrice.replace(/,/g, '')) * unit;

                document.getElementById('amount' + rowCount).value = productPrice;

                var i;
                var subTotal = 0;
                for (i = 1; i <= TotalRowCount; i++) {
                    if (document.getElementById('amount' + i)) {
                        var amount = document.getElementById('amount' + i).value;
                        if (amount) {
                            var subTotal = subTotal + parseFloat(amount.replace(/,/g, ''));
                        }
                    }
                }

                var tax = (result.tax * subTotal / 100);
                var total = (subTotal + tax);

                document.getElementById('subTotal').value = subTotal;
                document.getElementById('tax').value = tax;
                document.getElementById('total').value = total;

            } else {
                console.log(`error ${request.status} ${request.statusText}`);
            }
        };
    }
}

function resetUnit(e){
    var rowCount = e.getAttribute('count');
    document.getElementById('unit' + rowCount).value = '';
}

function calculateDiscount(e) {
    var discount = parseFloat(e.value);
    if (discount) {
        var subTotal = parseFloat(document.getElementById('subTotal').value);
        var tax = parseFloat(document.getElementById('tax').value);

        var total = (subTotal + tax) - parseFloat(discount);
        document.getElementById('total').value = total;
    }

}

function searchOrder(e) {
    var value = e.value;

    if (!value) {
        document.getElementById('order-suggestion-box').innerHTML = '';
    }

    delay(function () {
        $(".OrderSearch").fadeIn();
        var request = new XMLHttpRequest();
        request.open("GET", base_url + "/orders/return/search-invoice?q=" + value, true);
        request.setRequestHeader("Content-type", "application/json");
        request.send();

        request.onload = () => {
            if (request.status == 200) {
                $(".OrderSearch").fadeOut();
                var searchResult = JSON.parse(request.response);
                document.getElementById('order-suggestion-box').innerHTML = searchResult;
            } else {
                console.log(`error ${request.status} ${request.statusText}`);
            }
        };
    }, 1000);

}

function selectOrder(order_id) {
    document.getElementById('OrderId').value = order_id;
    document.getElementById('ReturnOrderForm').submit();
}


function ReturnUnit(e, unit, unitPrice, key, range, tax) {
    var returnUnit = e.value;
    var AmountValue = unitPrice * (unit - returnUnit);

    document.getElementById('amount-' + key).innerHTML = AmountValue;
    document.getElementById('AmountValue' + key).value = AmountValue;

    document.getElementById('UnitValue' + key).value = unit - returnUnit;


    var subTotal = 0;
    var returnAmount = 0;
    for (var i = 0; i < range; i++) {
        var amount = document.getElementById('amount-' + i).textContent;
        subTotal = subTotal + parseFloat(amount.replace(/,/g, ''));

        var ReturnUnit = document.getElementById('ReturnUnit' + i).value;
        if (ReturnUnit) {
            var unitPrice = document.getElementById('unit-price-' + i).textContent;
            returnAmount = returnAmount + parseFloat(ReturnUnit.replace(/,/g, '')) * parseFloat(unitPrice.replace(/,/g, ''));
        }

    }
    var discount = document.getElementById('discount').textContent;
    var taxAmount = (tax * subTotal / 100);
    var total = (subTotal + taxAmount) - parseFloat(discount.replace(/,/g, ''));

    document.getElementById('taxAmount').innerHTML = taxAmount;
    document.getElementById('taxAmountValue').value = taxAmount;

    document.getElementById('subTotal').innerHTML = subTotal;
    document.getElementById('subTotalValue').value = subTotal;

    document.getElementById('total').innerHTML = total;
    document.getElementById('totalValue').value = total;

    document.getElementById('ReturnAmount').innerHTML = `<p><strong>Return Amount: </strong>${returnAmount}</p>`;
    document.getElementById('ReturnAmountValue').value = returnAmount;
}

function isFullPay() {
    var total = document.getElementById("total").value;
    var isFullPay = document.getElementById("IsFullPay").checked;
    if (isFullPay == true) {
        document.getElementById('payment').value = total;
        document.getElementById('due').value = 0;
        document.getElementById('DueAmount').classList.add("d-none");
        document.getElementById('payment').readOnly = true;
    } else {
        document.getElementById('payment').value = '';
        document.getElementById('payment').readOnly = false;
    }
}


function makePayment(e) {
    var total = document.getElementById("total").value;
    var payment = e.value;
    if (payment) {
        delay(function () {
            var due = total - payment;
            document.getElementById('due').value = due;
            document.getElementById('DueAmount').classList.remove("d-none");
        }, 500);
    } else {
        document.getElementById('due').value = total;
    }
}


function deleteCustomer(customer_id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-danger waves-effect waves-light',
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
    },
        function (isConfirm) {
            if (isConfirm) {
                $('#DeleteCustomerForm-' + customer_id).submit();
            }
        });
}

function deleteSupplier(supplier_id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-danger waves-effect waves-light',
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
    },
        function (isConfirm) {
            if (isConfirm) {
                $('#DeleteSupplierForm-' + supplier_id).submit();
            }
        });
}


function deleteProduct(product_id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-danger waves-effect waves-light',
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
    },
        function (isConfirm) {
            if (isConfirm) {
                $('#DeleteProductForm-' + product_id).submit();
            }
        });
}


function deleteExpense(expense_id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-danger waves-effect waves-light',
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
    },
        function (isConfirm) {
            if (isConfirm) {
                $('#DeleteExpenseForm-' + expense_id).submit();
            }
        });
}


function deleteExtraProfit(extra_profit_id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-danger waves-effect waves-light',
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
    },
        function (isConfirm) {
            if (isConfirm) {
                $('#DeleteExtraProfitForm-' + extra_profit_id).submit();
            }
        });
}


function deleteOrder(order_id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-danger waves-effect waves-light',
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
    },
        function (isConfirm) {
            if (isConfirm) {
                $('#DeleteOrderForm-' + order_id).submit();
            }
        });
}

function formSubmit(e) {
    $(e).attr('disabled','disabled');
    $(e).parents('form').submit();
}