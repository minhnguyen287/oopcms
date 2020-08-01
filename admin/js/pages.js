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
});