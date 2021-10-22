<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Home</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal" data-target="#sellproduct_modal">Sell</button></li>
            <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal" data-target="#addproduct_modal">Add product</button></li>

            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
            <!-- <li class="breadcrumb-item active">Exam</li> -->
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Product Lists</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0 mt-2">
              <table class="table table-hover text-nowrap" id="product_table">
                <thead>
                  <tr>
                    <th>Products</th>
                    <th>Stock</th>
                    <th>Price</th>
                  </tr>
                </thead>
                <tbody>

                    <?php foreach ($product_list as $key => $pval): ?>
                      <tr>
                        <td><?=$pval['name'];?></td>
                        <td><input style="background-color:#969191;color:white" value='<?=$pval['qty'];?>' class="mr-2" readonly onkeyup=Exam.update_stock_per_product(<?=$pval['id']?>,this)></input><button style="color:white" class="btn-success edit_stock_btn" ><i class="fa fa-pencil" aria-hidden="true"></i></button></td>
                        <td><input style="background-color:#969191;color:white" value='<?=$pval['price'];?>' class="mr-2" readonly onkeyup=Exam.update_price_per_product(<?=$pval['id']?>,this)></input><button style="color:white" class="btn-success edit_price_btn" ><i class="fa fa-pencil" aria-hidden="true"></i></button></td>
                      </tr>
                    <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<!-- for modals section -->

<div class="modal fade" id="addproduct_modal" tabindex="-1" aria-labelledby="addproduct_modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addproduct_modalLabel">ADD PRODUCT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?=base_url()?>saveproduct" method="post">
      <div class="modal-body">
              <label for="">Name:</label>
              <input type="text" class="form-control" name="name" value="" required>
              <label for="">Quantity:</label>
              <input type="number" class="form-control" name="qty" value="" required>
              <label for="">Price:</label>
              <input type="number" class="form-control" name="price" value="" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
    </form>
    </div>
  </div>
</div>
<div class="modal fade" id="sellproduct_modal" tabindex="-1" aria-labelledby="sellproduct_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sellproduct_modalLabel">Sell Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?=base_url()?>sellproduct" method="post">
      <div class="modal-body">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-11">
                <select class="form-control" name="product_list_dropdown" id="product_list_dropdown">
                      <option value="" disabled selected> SELECT PRODUCT</option>
                        <?php foreach ($product_list_dropdown as $key => $pld): ?>
                            <option value="<?=$this->encrypt->encode($pld['id'])?>"><?=$pld['name']?></option>
                        <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-1">
                <button type="button" class="btn btn-success" onClick=Exam.sell_product()>Add</button>
              </div>
            </div>

          </div>
          <div class="col-md-12" id="add_multple_product_container">

          </div>
          <div class="col-md-12" id="total_sales_cont" style="display:none">
            <div class="row">
              <div class="col-md-8"></div>
              <div class="col-md-4">
                <label for="">Total sales:</label>
                <input type="text" class="form-control" name="" value="" readonly id="total_sales">

              </div>
            </div>

          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
<?php if (!empty($this->session->flashdata('item'))): ?>
      swal("Good job!", "New product added.", "success");
<?php endif; ?>
<?php if (!empty($this->session->flashdata('error'))): ?>
        swal("Error!", "Something went wrong.", "error");
<?php endif; ?>
// for updating stocks
<?php if (!empty($this->session->flashdata('stupdate'))): ?>
      swal("Good job!", "Sales added.", "success");
<?php endif; ?>
<?php if (!empty($this->session->flashdata('error'))): ?>
        swal("Error!", "Something went wrong.", "error");
<?php endif; ?>
</script>



<!-- <script src="assets/plugins/jquery.min.js" type="text/javascript"></script> -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>


<script type="text/javascript">
    var table = $('#product_table').DataTable({lengthMenu:[[ 10, 25, 50, -1],[ 10, 25, 50, "ALL"]],});
  $(document).ready(function(){

    $('.edit_stock_btn').on('click',function(){
      if (confirm("Are you sure you want to update stock ?")) {
          $(this).prev().removeAttr('readonly').css({'background-color':'unset','color':'unset'});
      }else {
        return false;
      }

    })
    $('.edit_price_btn').on('click',function(){
      if (confirm("Are you sure you want to update price ?")) {
          $(this).prev().removeAttr('readonly').css({'background-color':'unset','color':'unset'});
      }else {
        return false;
      }

    })
  })
</script>
