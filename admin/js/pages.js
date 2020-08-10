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
                $('select[name="Apage_position"]').html(add_option);
			}
		})
	})
	/*=========== END Function Show Option when user Click to button add Page =============*/  
	/*=========== MODUL Add new page =============*/ 
	$('#addpage').click(function(){//this is button addpage NOT modal addPage
		restoreNotiForm();
		var pname = $('input[name="Apage_name"]').val();
		var pcat = $('select[name="Acat_name"]').val();
		var ppos = $('select[name="Apage_position"]').val();
		var pcontent = $('textarea[name="Acontent"]').val();
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
                        $('select[name="Apage_position"]').html(new_position);
                    }
                }
            });
		}
	})
	 /* ================= END modul Add new page =====================*/   
     /*=========== MODUL modul View new page =============*/ 
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
     /*=========== END modul View page =============*/ 
    /*=========== MODUL modul Update page =============*/ 
    /* PART 1 - LOAD DATA*/
    $('.table').on('click','.edit-item',function(){
        let page_id = $(this).closest('tr').attr('id');
        $.ajax({
            type : 'POST',
            url : 'ajax-processing/CRUD_page.php',
            data : {
                'action' : 'load_page',
                'page_id' : page_id
            },
            success:function(respone){
                //console.log(respone);
                let load_Edata = JSON.parse(respone);
                console.log(load_Edata);
                // Load data cho input và textarea
                $('input[name="Epage_name"]').val(load_Edata.page_name);
                $('textarea[name="Econtent"]').val(load_Edata.content);
                //Load data cho các thẻ select
                let cat_option = '';
                let pos_option = '';
                for (var i = 0; i < parseInt(load_Edata.count); i++) {//Phần category option
                	if (parseInt(load_Edata[i].cat_id) == parseInt(load_Edata.cat_id)) {
                		cat_option += '<option value="'+load_Edata[i].cat_id+'" selected = "selected">'+load_Edata[i].cat_name+'</option>';
                	} else {
                		cat_option += '<option value="'+load_Edata[i].cat_id+'">'+load_Edata[i].cat_name+'</option>';
                	}
                }//End for loop
                $('select[name="Ecat_name"]').html(cat_option);
                //Phần posiotion option
                for (var i = 1; i <= parseInt(load_Edata.count); i++) {
                	if (i == parseInt(load_Edata.page_position)) {
                		pos_option += '<option value="'+i+'" selected = "selected">'+i+'</option>';
                	} else {
                		pos_option += '<option value="'+i+'">'+i+'</option>';
                	}
                }// End for loop
                $('#editcat').attr('pid',load_Edata.page_id);
                $('select[name="Epage_position"]').html(pos_option);               
            }
        })
    })
    /* PART 2 - PROCESS UPDATE*/
    $('#editcat').click(function(){
        let pid = $(this).attr('pid');
    	let pname = $('input[name="Epage_name"]').val();
		let pcat = $('select[name="Ecat_name"]').val();
		let ppos = $('select[name="Epage_position"]').val();
		let pcontent = $('textarea[name="Econtent"]').val();
		if(!validateInputForm(pname, pcat, ppos)){
			console.log('Input data is not correct');
		} else {
			$.ajax({
				type : 'POST',
				url : 'ajax-processing/CRUD_page.php',
				data : {
					'action' : 'update_page',
                    'page_id' : pid,
					'pname' : pname,
					'pcat' : pcat,
					'ppos' : ppos,
					'pcontent' : pcontent
				},
				success:function(respone){
                    let update_row ='';
                    if (respone != 'sys_error') {
                        Udata = JSON.parse(respone);
                        update_row += ""
                    }
                }
			})
		}
    })

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
