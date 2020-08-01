/* ======================= SCRIPT XU LI ======================= */
    $(document).ready(function(){
    /*=========== Function Show Option when user Click to button add category =============*/    
    $('.white-box').on('click','.add-item',function(){
        $.ajax({
            type:'POST',
            url:'ajax-processing/CRUD_category.php',
            data:{'action':'show_position'},
            success:function(respone){
                var new_option ='';
                var limit_position =JSON.parse(respone);
                for (var i = 1; i <= parseInt(limit_position.count)+1; i++) {
                    if(i == parseInt(limit_position.count)+1){
                        new_option += '<option value="'+i+'" selected = "selected">'+i+'</option>';
                    } else {
                        new_option += '<option value="'+i+'">'+i+'</option>';
                    }                        
                }// End For loop
                $('select[name="cat_position"]').html(new_option);
            }
        })
    })
    /*=========== End Function Show Option when user Click to button add category =============*/ 

    /*=========== MODUL Add new category =============*/ 
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

    /*================== Function validate text and number =======================*/
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
    }
    /*================== End Function validate text and number =======================*/

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
    /*================== Function Show delete modal =======================*/
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
    /*================== End Function Show delete modal =======================*/

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
