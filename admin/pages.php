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
                            <h3>Pages Manager</h3>
                            <div class="noti">
                                <p class="text-muted">Notification for <code>.page</code></p>
                                <button type="button" class="add-item btn btn-success" data-toggle='modal' data-target='#addPage'>
                                    <i class="ti-plus"></i> New page
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Page name</th>
                                            <th>Category</th>
                                            <th>Author</th>
                                            <th>Create date</th>
                                            <th>Position</th>
                                            <th><center>View</center></th>
                                            <th><center>Edit</center></th>
                                            <th><center>Delete</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $query = "SELECT * FROM pages";
                                            $result = $conn -> query($query);
                                            while($rows = $result -> fetch_array(MYSQLI_ASSOC)){
                                                echo "<tr id=".$rows['page_id'].">
                                                        <td>".$rows['page_name']."</td>
                                                        <td>".$rows['cat_id']."</td>
                                                        <td>".$rows['user_id']."</td>
                                                        <td>".$rows['post_on']."</td>
                                                        <td>".$rows['page_position']."</td>
                                                        <td>
                                                            <center><button class='show-item btn btn-info' data-toggle='modal' data-target='#viewPage'>
                                                            <i class='ti-eye'></i> View</button></center>
                                                        </td>
                                                        <td>
                                                            <center><button class='edit-item btn btn-primary' data-toggle='modal' data-target='#editPage'>
                                                            <i class='ti-pencil-alt'></i> Edit</button></center>
                                                        </td>
                                                        <td>
                                                            <center><button class='del-item btn btn-danger'><i class='ti-close'></i> Delete</button></center>
                                                        </td>
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
<!-- Modal add Page -->
<div id="addPage" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title' name ="edit_title">Add a new page</h4>
        <span class="hid"></span>
      </div>
        
        <div class='modal-body'>                
            <form class='form-horizontal form-material'>
                <div class='form-group'>
                    <label id='pn' class='col-md-12'>Page name <span class="noti-c1"></span></label>
                    <div class='col-md-12'>
                        <input type='text' name='Apage_name' class='form-control form-control-line' placeholder="Please enter a Page name"> 
                    </div>                
                    <label id='cat' class='col-md-12'>Category <span class="noti-c2"></span></label>
                    <div class='col-md-12'>
                        <select name='Acat_name' class='form-control form-control-line'>
                            <?php
                                $query = "SELECT cat_id, cat_name FROM categories";
                                $result = $conn -> query($query);
                                while ($cat = $result -> fetch_array(MYSQLI_NUM)) {
                                     echo "<option value ='".$cat[0]."'>".$cat[1]."</option>";
                                 } 
                             ?>
                        </select>                                          
                    </div>               
                    <label id='pos' class='col-md-12'>Position <span class="noti-c3"></span></label>
                    <div class='col-md-12'>
                        <select name='Apage_position' class='form-control form-control-line'>
                        </select>                                          
                    </div>
                    <label id='content' class='col-md-12'>Content <span class="noti-c4"></span></label>
                    <div class='col-md-12'>
                        <textarea class="form-control" name="Acontent" rows="7" placeholder="Please write somethings"></textarea>
                    </div>
                    <div class='col-sm-12'>
                        <input id="addpage" type = 'button' data-dismiss='modal' class='btn btn-success' value='Creat'>
                    </div>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal View Page -->
<div id="viewPage" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content" style="border-radius:20px">
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h2 class='page-title'><!-- Title --></h2>
        <h5 class='author-title'><!-- Author --></h5>
        <h5 class='date-title'><!-- Date --></h5>
      </div>
        
        <div class='modal-body' name='pcontent'>                
            <!-- Content -->
      </div>
    </div>
  </div>
</div>
<!-- Modal edit Page -->
<div id="editPage" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title' name ="edit_title">Edit Page</h4>
        <span class="hid"></span>
      </div>
        
        <div class='modal-body'>                
            <form class='form-horizontal form-material'>
                <div class='form-group'>
                    <label id='pn' class='col-md-12'>Page name <span class="noti-c1"></span></label>
                    <div class='col-md-12'>
                        <input type='text' name='Epage_name' class='form-control form-control-line' placeholder="Please enter a Page name"> 
                    </div>                
                    <label id='cat' class='col-md-12'>Category <span class="noti-c2"></span></label>
                    <div class='col-md-12'>
                        <select name='Ecat_name' class='form-control form-control-line'></select>                                          
                    </div>               
                    <label id='pos' class='col-md-12'>Position <span class="noti-c3"></span></label>
                    <div class='col-md-12'>
                        <select name='Epage_position' class='form-control form-control-line'>
                        </select>                                          
                    </div>
                    <label id='content' class='col-md-12'>Content <span class="noti-c4"></span></label>
                    <div class='col-md-12'>
                        <textarea class="form-control" name="Econtent" rows="7" placeholder="Please write somethings"></textarea>
                    </div>
                    <div class='col-sm-12'>
                        <input id="editcat" type = 'button' data-dismiss='modal' class='btn btn-warning' value='Update'>
                    </div>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal delete Page -->
<div id="delPage">
  <div class="content">
    <button type='button' class='close'>&times;</button>
    <h4 name ="del_title">Delete Page</h4>
    <span class="hid"></span>               
        <form>
            <input name="confirmDel" type = 'button' class='btn btn-danger' value='Delete'>
            <input type = 'button' name="cancelDel" class='btn btn-info' value='Cancel'>
        </form>
  </div>
</div>
<script language="javascript" src= 'js/pages.js'></script>