$(document).ready(function () {
    
    //add product btn
    $('.add-product-btn').on('click', function (e) {

        e.preventDefault();
        var name = $(this).data('name');
        var id = $(this).data('id');
        
        var price = $.number($(this).data('price'), 2);

        $(this).removeClass('btn-success').addClass('btn-default disabled');

        var html =
            `<tr>
                <td>${name}</td>
                <td><input type="number" name="products[${id}][quantity]" data-price="${price}" class="form-control input-sm product-quantity" min="1" value="1"></td>
                <td class="product-price">${price}</td>               
                <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}"><span class="fa fa-trash"></span></button></td>
            </tr>`;

        $('.purchace-list').append(html);

        //to calculate total price
        calculateTotal();
    });

    //disabled btn
    $('body').on('click', '.disabled', function(e) {

        e.preventDefault();

    });//end of disabled

    //remove product btn
    $('body').on('click', '.remove-product-btn', function(e) {

        e.preventDefault();
        var id = $(this).data('id');

        $(this).closest('tr').remove();
        $('#product-' + id).removeClass('btn-default disabled').addClass('btn-success');

        //to calculate total price
        calculateTotal();

    });//end of remove product btn

    //change product quantity
    $('body').on('keyup change', '.product-quantity', function() {

        var quantity = Number($(this).val()); //2
        var unitPrice = parseFloat($(this).data('price').replace(/,/g, '')); //150
        console.log(unitPrice);
        $(this).closest('tr').find('.product-price').html($.number(quantity * unitPrice, 2));
        calculateTotal();

    });//end of product quantity change

    //list all purchace products
    $('.purchace-products').on('click', function(e) {

        e.preventDefault();

        $('#loading').css('display', 'flex');
        
        var url = $(this).data('url');
        var method = $(this).data('method');
        $.ajax({
            url: url,
            method: method,
            success: function(data) {

                $('#loading').css('display', 'none');
                $('#purchace-product-list').empty();
                $('#purchace-product-list').append(data);

            }
        })

    });//end of purchace products click

    //print purchace
    $(document).on('click', '.print-btn', function() {

        $('#print-area').printThis({
            debug: false,               // show the iframe for debugging

            importCSS: true,            // import parent page css
            base: true,                // preserve the BASE tag or accept a string for the URL
            printContainer: false,       // print outer container/$.selector

            pageTitle: "**",              // add title to print page
            // header: "<h1 style=' text-align:center;'>محلات العنود للمواد الغذائية </h1> <br> <h3 style=' border: 2px solid black;border-radius: 5px; text-align:center;'>فاتورة مشتريات</h3>",
            // footer: " <div style='  position: fixed; bottom: 0;'> <h5> العنوان : غزة الزيتون / لفة السوافيري </h5> <h5> ابو عثمان السرحي ٠٥٩٧٤٤١٠٥٤ <br> سلطان السرحي ٠٥٩٧٧٦٤٢٨٤</h5> </div>",
                });

    });//end of click function

});//end of document ready

//calculate the total
function calculateTotal() {

    var price = 0;

    $('.purchace-list .product-price').each(function(index) {
        
        price += parseFloat($(this).html().replace(/,/g, ''));

    });//end of product price

    $('.total-price').html($.number(price, 2));

    //check if price > 0
    if (price > 0) {

        $('#add-purchace-form-btn').removeClass('disabled')

    } else {

        $('#add-purchace-form-btn').addClass('disabled')

    }//end of else

}//end of calculate total
