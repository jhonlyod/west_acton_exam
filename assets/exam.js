var Exam = {
  base_url: 'http://localhost/Exam/',
  sell_product:function(el){
    const pval = $('#product_list_dropdown').val();
    const text =$( "#product_list_dropdown option:selected" ).text();

    $.ajax({
      url: Exam.base_url + '/get_product_per_id',
      type: 'POST',
      data: {
        id:pval,
      },
      success:function(response)
        {
          // console.log(response);
          var data = JSON.parse(response);
          var pdetails = data.data;
          console.log(pdetails);
          if (data.error != '') {
            alert('Something went wrong. Contact Administrator');
          }else {
             $('#add_multple_product_container').append('<div class="row selected_product_per_id'+pdetails.id+'"> <input type="text" class="form-control" name="product_id[]" value="'+pdetails.id+'" readonly required style="display:none""><div class="col-md-3"> <label for="">Name:</label> <input type="text" class="form-control" name="name[]" value="'+pdetails.name+'" readonly required> </div><div class="col-md-3"> <label for="">Price:</label> <input type="number" id="price_per_product_id'+pdetails.id+'" readonly class="form-control" name="price[]" value="'+pdetails.price+'" required> </div><div class="col-md-3"> <label for="">Quantity:</label> <input type="number" class="form-control sell_qty" name="qty[]" value="" required onKeyup=Exam.get_total_sales(this,'+pdetails.id+')> </div><div class="col-md-3"> <label for="">Total:</label> <input type="number" class="form-control total_per_product total_per_product'+pdetails.id+'" name="total" value="" readonly > </div></div>')
          }
        }
    });


  },update_price_per_product:function(id,el){
      const price = el.value;
      $.ajax({
        url: Exam.base_url + '/update_price_per_product',
        type: 'POST',
        data: {
          price:price,
          product_id:id,
        },
        success:function(response)
          {
            if (response == 'success') {
              return true;
            }else {
              alert('something went wrong.');
            }
          }
      });

  },update_stock_per_product:function(id,el){
      const qty = el.value;
      $.ajax({
        url: Exam.base_url + '/update_qty_per_product',
        type: 'POST',
        data: {
          qty:qty,
          product_id:id,
        },
        success:function(response)
          {
            if (response == 'success') {
              return true;
            }else {
              alert('something went wrong.');
            }
          }
      });

  },get_total_sales:function(el,id){
    $('#total_sales_cont').show();
    var qty = el.value;
    var price = $('#price_per_product_id'+id+'').val();
    var total_per_product = qty * price ;
    $('.total_per_product'+id).val(total_per_product);

    var sum = 0;
      $(".total_per_product").each(function() {
          var val = $.trim( $(this).val() );

          if ( val ) {
              val = parseFloat( val.replace( /^\$/, "" ) );

              sum += !isNaN( val ) ? val : 0;
          }
      });

        $('#total_sales').val(sum)
  }
}
