<?php 
    include('../includes/admin/header.php');
    include('../includes/admin/sidebar.php');
    require_once('../includes/connection.php');
 ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-12">
                    <h4 class="page-title">Blank</h4>
                    <ol class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li class="active">Blank Page</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- row -->
            <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3>Category Manager</h3>
                            <div class="noti">
                                <p class="text-muted">Notification for <code>.category</code></p>
                                <button type="button" class="add-item btn btn-success" data-toggle='modal' data-target='#addCat'>
                                    <i class="ti-plus"></i> New category
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category name</th>
                                            <th>Author</th>
                                            <th>Create date</th>
                                            <th>Position</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $query = "SELECT * FROM categories";
                                            $result = $conn -> query($query);
                                            while($rows = $result -> fetch_array(MYSQLI_ASSOC)){
                                                echo "<tr id=".$rows['cat_id'].">
                                                        <td>".$rows['cat_id']."</td>
                                                        <td>".$rows['cat_name']."</td>
                                                        <td>".$rows['user_id']."</td>
                                                        <td>".$rows['creat_date']."</td>
                                                        <td>".$rows['cat_position']."</td>
                                                        <td><i class='ti-pencil-alt' data-toggle='modal' data-target='#editCat'></i></td>
                                                        <td><i class='ti-close'></i></td>
                                                    </tr>";
                                                }//END While                                            
                                         ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
<?php 
    include('../includes/admin/footer.php')
 ?>
<!-- Modal add Cat -->
<div id="addCat" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title' name ="edit_title">Add a new category</h4>
        <span class="hid"></span>
      </div>
        
        <div class='modal-body'>                
            <form class='form-horizontal form-material'>
                <div class='form-group'>
                    <label id='fn' class='col-md-12'>Category name <span class="noti-c1"></span></label>
                    <div class='col-md-12'>
                        <input type='text' name='cat_name' class='form-control form-control-line'> 
                    </div>
                </div>
                <div class='form-group'>                    
                    <label id='ln' class='col-md-12'>Position <span class="noti-c2"></span></label>
                    <div class='col-md-12'>
                        <select name='cat_position' class='form-control form-control-line'>
                        </select>                                          
                    </div>
                </div>
                <div class='form-group'>
                    <div class='col-sm-12'>
                        <input id="addcat" type = 'button' data-dismiss='modal' class='btn btn-success' value='Creat'>
                    </div>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal edit Cat -->
<div id="editCat" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title' name ="edit_title">Edit category</h4>
        <span class="hid"></span>
      </div>
        
        <div class='modal-body'>                
            <form class='form-horizontal form-material'>
                <div class='form-group'>
                    <label id='fn' class='col-md-12'>Category name <span class="noti-c1"></span></label>
                    <div class='col-md-12'>
                        <input type='text' name='Ecat_name' class='form-control form-control-line'> 
                    </div>
                </div>
                <div class='form-group'>                    
                    <label id='ln' class='col-md-12'>Position <span class="noti-c2"></span></label>
                    <div class='col-md-12'>
                        <select name='Ecat_position' class='form-control form-control-line'>
                        </select>                                            
                    </div>
                </div>
                <div class='form-group'>
                    <div class='col-sm-12'>
                        <input id="editcat" type = 'button' data-dismiss='modal' class='btn btn-warning' value='Update'>
                    </div>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal delete Cat -->
<div id="delCat">
  <div class="content">
    <button type='button' class='close'>&times;</button>
    <h4 name ="del_title">Delete category</h4>
    <span class="hid"></span>               
        <form>
            <input name="confirmDel" type = 'button' class='btn btn-danger' value='Delete'>
            <input type = 'button' name="cancelDel" class='btn btn-info' value='Cancel'>
        </form>
  </div>
</div>
<script language="javascript" src= 'js/categories.js'></script>