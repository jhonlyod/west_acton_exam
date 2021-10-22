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
              <!-- <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal" data-target="#sellproduct_modal">Sell</button></li>
            <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal" data-target="#addproduct_modal">Add product</button></li> -->

            <li class="breadcrumb-item"><a href="<?=base_url()?>" >HOME</a></li>
            <li class="breadcrumb-item active"><a href="<?=base_url()?>sales">SALES</a></li>
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
              <table class="table table-hover text-nowrap" id="total_sales">
                <thead>
                  <tr>
                    <th>Purchase Id.</th>
                    <th>Products</th>
                    <th>Price</th>
                    <th>Qty.</th>
                    <th>Date purchased</th>
                  </tr>
                </thead>
                <tbody>

                    <?php foreach ($sales as $key => $sval): ?>
                      <tr>
                        <td><?=$sval['sale_id'];?></td>
                        <td><?=$sval['name'];?></td>
                        <td><?=$sval['price'];?></td>
                        <td><?=$sval['qty'];?></td>
                        <td><?=date("jS F, Y", strtotime($sval['date_added']));?></td>
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
