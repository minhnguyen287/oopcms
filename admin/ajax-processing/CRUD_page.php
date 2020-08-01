<?php 
	include('../../includes/function.php');
	/*=== Show option in Add-Modal ===*/
	if (isset($_POST['request']) && $_POST['request']=='show_option') {
		$query = "SELECT COUNT(*) AS count FROM pages";
		$result = $conn -> query($query);
		$position = $result -> fetch_array(MYSQLI_ASSOC);
		echo json_encode($position);
	}
?>