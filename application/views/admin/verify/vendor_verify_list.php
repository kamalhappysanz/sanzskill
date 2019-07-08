<div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Vendor verify list</h4>
              <div class="container">
                  <div class="col-md-12">
                <table id="example" class="table table-striped table-bordered  "  >
        <thead>
            <tr>
                <th >S.no</th>
                <th>Name <br> Phone No <br> Email</th>
                <th>Doc Verify status</th>
                <th>profile_pic</th>
                <th>Company status</th>
                <th>Service Person Count</th>
                <th>Deposit status</th>
                <th>Vendor Display</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
          <?php $i=1; foreach($res as $rows){ ?>


            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $rows->owner_full_name; ?> <br><br> <?php echo $rows->phone_no; ?><br><br> <?php echo $rows->email; ?></td>
                <td><?php echo $rows->document_verify; ?></td>
                <td><?php echo $rows->profile_pic; ?></td>
                <td><?php echo $rows->company_status; ?></td>
                <td><?php echo $rows->no_of_service_person; ?></td>
                <td>
                  <?php if($rows->deposit_status=='Unpaid'){ ?>
                    <button type="button" class="btn btn-danger">Unpaid</button>
                <?php   }else{ ?>
                  <button type="button" class="btn btn-success">Paid</button>
                <?php   }
                   ?>
                </td>

                <td><?php if($rows->serv_prov_display_status=='Inactive'){ ?>
                  <button type="button" class="btn btn-danger ">Inactive</button>
              <?php   }else{ ?>
                <button type="button" class="btn btn-success ">Active</button>
              <?php   }
                 ?></td>
                <td><a href="<?php echo base_url(); ?>verifyprocess/get_vendor_details/<?php echo base64_encode($rows->user_master_id*98765); ?>"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;
                  <a href="<?php echo base_url(); ?>verifyprocess/get_vendor_details/<?php echo base64_encode($rows->user_master_id*98765); ?>"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
          <?php  $i++;  }  ?>


        </tbody>

    </table>
              </div>
            </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->

      </div>

    </div>
    <script>
      $('#example').DataTable({

      });
    </script>
