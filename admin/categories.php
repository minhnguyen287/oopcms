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
<div id=".table" class="modal fade" role="dialog">
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
<!-- ======================= SCRIPT XU LI ======================= -->
<script> 
    $(document).ready(function(){
    /*=========== MODUL Add new category =============*/    
    $('#addCat').on('click','.add-item',function(){
        $.ajax({
            type:'POST',
            url:'ajax-processing/CRUD_category.php',
            data:{'action':'show_position'},
            success:function(respone){
                var new_option ='';
                var limit_posiotion =JSON.parse(respone);
                for (var i = 1; i <= parseInt(limit_posiotion.count)+1; i++) {
                    if(i == parseInt(limit_posiotion.count)+1){
                        new_option += '<option value="'+i+'" selected = "selected">'+i+'</option>';
                    } else {
                        new_option += '<option value="'+i+'">'+i+'</option>';
                    }                        
                }// End For loop
                $('select[name="cat_position"]').append(new_option);
            }
        })
    })

    $('#addcat').click(function(){ 
        var cat_name = $('input[name="cat_name"]').val();
        var cat_position = $('select[name="cat_position"]').val();
        restoreNoti();
        if(!validateInput(cat_name,cat_position)) {
            console.log('Input data is correct !');
        }
        else{
            var result = validateInput(cat_name,cat_position);
            var cat_name = result[0];
            var cat_position = result[1];            
            $.ajax({
                type : 'POST',
                url : 'ajax-processing/CRUD_category.php',
                data : {
                    'action' : 'add',
                    'cat_name' : cat_name,
                    'cat_position' : cat_position
                },
                success:function(respone){
                    //respone = {"cat_id":"72","cat_name":"League","user_id":"1","creat_date":"2020-07-06 20:06:48","cat_position":"6","COUNT(*)":"4","0":"Category was added succesfully"}
                    console.log(respone);
                    if (respone == 'sys_error') {
                        $('.text-muted').html('<code>System error. Category was not added !</code>');
                    }
                    if (respone == 'exists') {
                        $('.text-muted').html('<code>Category already exists</code>');
                    } else {
                        var new_cat = JSON.parse(respone);
                        //UPDATE STATUS
                        $('.text-muted').html('<code class="code-success">'+new_cat[0]+'</code>');
                        //UPDATE VIEW
                        var new_row = '';
                        new_row += '<tr id="'+new_cat.cat_id+'">';
                        new_row += '<td>'+new_cat.cat_id+'</td>';
                        new_row += '<td>'+new_cat.cat_name+'</td>';
                        new_row += '<td>'+new_cat.user_id+'</td>';
                        new_row += '<td>'+new_cat.creat_date+'</td>';
                        new_row += '<td>'+new_cat.cat_position+'</td>';
                        new_row += '<td><i class="ti-pencil-alt" data-toggle="modal" data-target="#editCat"></i></td>';
                        new_row += '<td><i class="ti-close"></i></td></tr>';
                        $('.table').append(new_row);
                        //UPDATE MODAL OPTION
                        var new_position = '';
                        for (var i = 1; i <= parseInt(new_cat.count)+1; i++) {
                            if(i == parseInt(new_cat.count)+1){
                                new_position += '<option value="'+i+'" selected = "selected">'+i+'</option>';
                            } else {
                                new_position += '<option value="'+i+'">'+i+'</option>';
                            }                        
                        }//END For loop
                        //console.log(new_position);
                        $('select[name="cat_position"]').html(new_position);
                    }
                }
            });//END ajax
        }
    });
    /* ================= END modul Add new category =====================*/    

    /*========= MODUL Show fill data ==============*/
    /*Sử dụng event delegation, https://www.codetot.net/javascript-delegation-event/ */
    $('.table').on('click','.ti-pencil-alt',function(){
        var td = $(this).closest('tr');
        var edit_id = td.attr('id');// Chọn ra cat_id
        console.log(edit_id);
        $.ajax({
            type : 'POST',
            url : 'ajax-processing/CRUD_category.php',
            data : {
                'edit_id':edit_id,
                'action' :'show'
            },
            success:function(respone){
                console.log(respone);/*Ví dụ trả về của 1 TH,tổng số posiotion trong bảng sẽ nằm ở vị trí số 4 tương đương với giá trị key = 0 
                {"cat_id":"59","cat_name":"Legend never die","cat_position":"3","0":"4"}*/
                 let obj = JSON.parse(respone);
                 $('input[name="Ecat_name"]').val(obj.cat_name);
                 $('#editcat').attr('location',obj.cat_id);
                 var edit_option ='';
                 if(obj.cat_position < obj[0]){
                    for (var i = 1; i <= obj[0]; i++) {
                         if(i == obj.cat_position){
                            edit_option += '<option value ="'+i+'" selected="selectted">'+i+'</option>';
                         } else{
                            edit_option += '<option value ="'+i+'">'+i+'</option>';
                         }
                     }// End for loop
                 } else {
                    for (var i = 1; i <= obj[0]; i++) {
                         if(i == obj[0]){
                            edit_option += '<option value ="'+i+'" selected="selectted">'+i+'</option>';
                         } else{
                            edit_option += '<option value ="'+i+'">'+i+'</option>';
                         }
                     }// End for loop
                 }
                 $('select[name="Ecat_position"]').html(edit_option);
            }
        })//END ajax editCat
    });
    /*================== END modul Show fill data =======================*/

    /*================== Modul Edit category =======================*/
     $('#editcat').click(function(){
        var Ecat_id = $(this).attr('location');// Vị trí cat_id sẽ chỉnh sửa
        var Ecat_name = $('input[name="Ecat_name"]').val();
        var Ecat_position = $('select[name="Ecat_position"]').val();
        restoreNoti();
        if(!validateInput(Ecat_name,Ecat_position)) {
            console.log('Input data is correct !');
        }
        else{
            var result = validateInput(Ecat_name,Ecat_position);
            var Ecat_name = result[0];
            var Ecat_position = result[1];
            $.ajax({
                type : 'POST',
                url : 'ajax-processing/CRUD_category.php',
                data : {
                    'action' : 'update',
                    'Ecat_id' : Ecat_id,
                    'Ecat_name' : Ecat_name,
                    'Ecat_position' : Ecat_position
                },
                success:function(respone){
                    var update_cat = JSON.parse(respone);
                    //UPDATE STATUS
                    $('.text-muted').html('<code class="code-success">'+update_cat[0]+'</code>');
                    //UPDATE VIEW
                    var new_row = '';                    new_row += '<td>'+update_cat.cat_id+'</td>';
                    new_row += '<td>'+update_cat.cat_name+'</td>';
                    new_row += '<td>'+update_cat.user_id+'</td>';
                    new_row += '<td>'+update_cat.creat_date+'</td>';
                    new_row += '<td>'+update_cat.cat_position+'</td>';
                    new_row += '<td><i class="ti-pencil-alt" data-toggle="modal" data-target="#editCat"></i></td>';
                    new_row += '<td><i class="ti-close"></i></td>';
                    $('tr[id="'+update_cat.cat_id+'"]').html(new_row);
                }
            });//END ajax

        } 
    })
    /*================== END modul Edit category =======================*/

    function validateInput(cat_name,cat_position){
        var partten_name = /^[a-zA-Z0-9 ]+$/;
        var partten_number = /^\d+$/;
        var addFlag = new Array();
        var result = new Array();

        if(!partten_name.test(cat_name)){
            if (addFlag.indexOf('cat_name')==-1) {
                addFlag.push('cat_name');
            }
            $('.noti-c1').html('<code>incorrect</code>');
        }

         if(!partten_number.test(cat_position)){
            if (addFlag.indexOf('cat_position')==-1) {
                addFlag.push('cat_position');
            }
            $('.noti-c2').html('<code>incorrect</code>');
        }

        if (addFlag === undefined || addFlag.length == 0) {
            restoreForm();
            result.push(cat_name,cat_position);
            return result;
        } else {
            return false;
        }
    } // END function validate

    function restoreForm(){
        $('.noti-c1').html('');
        $('.noti-c2').html('');
        $('#addcat').attr('data-dismiss','modal');
    }

    function restoreNoti(){
        $('.noti').on('change','.text-muted',function(){
            $('.text-muted').html('');
        });
    }
    var del_id;
    //Function show Modal Delete
    $('.table').on('click','.ti-close',function(){
        var modal = $('#delCat');
        var close = $('.close');
        del_id = $(this).closest('tr').attr('id');
        //Gán ID vào button delete
        $('input[name="confirmDel"]').attr('del_id',del_id);
        modal.show();

        close.click(function(){
            modal.hide();
        });

        $('input[name="cancelDel"]').click(function(){
            modal.hide()
        });

        $('input[name="confirmDel"]').click(function(){
            modal.hide()
        });

        $(window).on('click', function (e) {
            if ($(e.target).is('#delCat')) {
                console.log(e.target);
              modal.hide();
            }
        });
    })
    //Function show Modal Delete

    /*================== Modul Delete category =======================*/
    $('input[name="confirmDel"]').click(function(){
        var del_id = $(this).attr('del_id');
        $.ajax({
            type: 'POST',
            url: 'ajax-processing/CRUD_category.php',
            data : {
                'action' : 'delete',
                'Dcat_id' :del_id
            },
            success:function(respone){
                if (respone == 'complete') {
                    $('tr[id="'+del_id+'"]').fadeOut();
                    $('.text-muted').html('<code class="code-success">Category was deleted succesfully</code>');
                } else{
                    $('.text-muted').html('<code class="code">System error ! Category was not delete !</code>');
                }
            }
        })
    })
     /*================== END Modul Delete category =======================*/

        
})

</script> 