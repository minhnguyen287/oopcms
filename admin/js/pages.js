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
	/*=========== MODUL Add new category =============*/ 
	$('.add-item').click(function(){
		var pname = $('input[name="page_name"]').val();
		var pcat = $('select[name="cat_name"]').val();
		var ppos = $('select[name="page_position"]').val();
		var pcontent = $('textarea[name="content"]').val();
		console.log(pname);
		console.log(pcat);
		console.log(ppos);
		console.log(pcontent);


	})
	 /* ================= END modul Add new category =====================*/   

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
});