/* ======================= SCRIPT XU LI PHAN PAGE ======================= */
$(document).ready(function(){
	/*=========== Function Show Option when user Click to button add Page =============*/  
	$('.white-box').on('click','.add-item',function(){
		$.ajax({
			type : 'POST',
			url : 'ajax-processing/CRUD_page.php',
			data :{'request' : 'show_option'},
			success :function(respone){
				var limit = JSON.parse(respone);
				var add_option = '';
				for (var i = 1; i <= parseInt(limit.count)+1; i++) {
                    if(i == parseInt(limit.count)+1){
                        add_option += '<option value="'+i+'" selected = "selected">'+i+'</option>';
                    } else {
                        add_option += '<option value="'+i+'">'+i+'</option>';
                    }                        
                }// End For loop
                $('select[name="page_position"]').html(add_option);
			}
		})
	})
	/*=========== END Function Show Option when user Click to button add Page =============*/  
	/*=========== MODUL Add new page =============*/ 
	$('#addpage').click(function(){//this is button addpage NOT modal addPage
		restoreNotiForm();
		var pname = $('input[name="page_name"]').val();
		var pcat = $('select[name="cat_name"]').val();
		var ppos = $('select[name="page_position"]').val();
		var pcontent = $('textarea[name="content"]').val();
		if(!validateInputForm(pname, pcat, ppos)){
			console.log('Input data is not correct');
		} else {
			$.ajax({
                type : 'POST',
                url : 'ajax-processing/CRUD_page.php',
                data : {
                    'action' : 'add',
                    'pname' : pname,
                    'ppos' : ppos,
                    'pcat' : pcat,
                    'pcontent' : pcontent
                },
                success:function(respone){
                    //respone = {"page_id":"2","page_name":"Lorem","content":"There are many var...","user_id":"1","cat_id":"1","page_position":"2","post_on":"2020-08-04 00:56:55","count":"2","0":"Page was .."}
                    console.log(respone);
                    if (respone == 'sys_error') {
                        $('.text-muted').html('<code>System error. Category was not added !</code>');
                    }
                    if (respone == 'exists') {
                        $('.text-muted').html('<code>Category already exists</code>');
                    } else {
                        var new_page = JSON.parse(respone);
                        //UPDATE STATUS
                        $('.text-muted').html('<code class="code-success">'+new_page[0]+'</code>');
                        //UPDATE VIEW
                        var new_row = '';
                        new_row += '<tr id="'+new_page.page_id+'">';
                        new_row += '<td>'+new_page.page_name+'</td>';
                        new_row += '<td>'+new_page.cat_id+'</td>';
                        new_row += '<td>'+new_page.user_id+'</td>';
                        new_row += '<td>'+new_page.post_on+'</td>';
                        new_row += '<td>'+new_page.page_position+'</td>';
                        new_row += '<td><center><button class="show-item btn btn-info" data-toggle="modal" data-target="#viewPage"><i class="ti-eye"></i> View</button></center></td>';
                        new_row += '<td><center><button class="edit-item btn btn-primary" data-toggle="modal" data-target="#editPage"><i class="ti-pencil-alt"></i> Edit</button></center></td>';
                        new_row += '<td><center><button class="del-item btn btn-danger"><i class="ti-close"></i> Delete</button></center></td>';
                        $('.table').append(new_row);
                        //UPDATE MODAL OPTION
                        var new_position = '';
                        for (var i = 1; i <= parseInt(new_page.count)+1; i++) {
                            if(i == parseInt(new_page.count)+1){
                                new_position += '<option value="'+i+'" selected = "selected">'+i+'</option>';
                            } else {
                                new_position += '<option value="'+i+'">'+i+'</option>';
                            }                        
                        }//END For loop
                        //console.log(new_position);
                        $('select[name="page_position"]').html(new_position);
                    }
                }
            });
		}
	})
	 /* ================= END modul Add new page =====================*/   
     /*=========== MODUL View new page =============*/ 
     $('.table').on('click','.show-item',function(){
        let page_id = $(this).closest('tr').attr('id');
        $.ajax({
            type : 'POST',
            url : 'ajax-processing/CRUD_page.php',
            data : {
                'action' : 'show_page',
                'page_id' : page_id
            },
            success:function(respone){
                //console.log(respone);
                let page = JSON.parse(respone);
                $('.page-title').text(page.page_name);
                $('.author-title').text(page.author);
                $('.date-title').text(page.post_on);
                $('div[name="pcontent"]').html(page.content);
            }
        })
     })
     /*=========== END View new page =============*/ 

	/*================== Function Show delete modal =======================*/
    $('.table').on('click','.del-item',function(){
        var modal = $('#delPage');
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
            if ($(e.target).is('#delPage')) {
                console.log(e.target);
              modal.hide();
            }
        });
    })
    /*================== End Function Show delete modal =======================*/
    function validateInputForm(pname, pcat, ppos){
    	let parttenCharacter = /^[a-zA-z0-9 ]+$/;
    	let parttenNumber = /^\d+$/;
    	let errFlag = new Array;

    	if (!parttenCharacter.test(pname)) {
    		if (errFlag.indexOf('pname')==-1) {
    			errFlag.push('pname');
    		}
    		$('.noti-c1').html('<code>incorrect</code>');
    	}

    	if (!parttenCharacter.test(pcat)) {
    		if (errFlag.indexOf('pcat')==-1) {
    			errFlag.push('pcat');
    		}
    		$('.noti-c2').html('<code>incorrect</code>');
    	}

    	if (!parttenNumber.test(ppos)) {
    		if (errFlag.indexOf('ppos')==-1) {
    			errFlag.push('ppos');
    		}
    		$('.noti-c3').html('<code>incorrect</code>');
    	}

    	if (errFlag === undefined || errFlag.length == 0 ) {
    		return true;
    	} else {
    		return false;
    	}
    }
    function restoreNotiForm(){
    	$('.noti-c1').html('');
        $('.noti-c2').html('');
        $('.noti-c3').html('');
        $('.noti-c4').html('');
        $('#addcat').attr('data-dismiss','modal');
    }
});
