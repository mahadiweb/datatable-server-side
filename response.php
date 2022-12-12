
<?php
	//include connection file 
	include_once("connection.php");
	 
	// initilize all variable
	$params = $columns = $totalRecords = $data = array();

	$params = $_REQUEST;

	//define index of column
	$columns = array( 
		0 =>'id',
		1 =>'employee_name', 
		2 => 'employee_salary',
		3 => 'employee_age'
	);

	$where = $sqlTotal = $sqlRecord = "";


	// check search value exist
	if( !empty($params['search']['value']) ) {   
		$where .=" WHERE ";
		$where .=" ( employee_name LIKE '".$params['search']['value']."%' ";    
		$where .=" OR employee_salary LIKE '".$params['search']['value']."%' ";
		$where .=" OR employee_age LIKE '".$params['search']['value']."%' )";
	}

	// getting total number records without any search
	$sql = "SELECT * FROM `employee` ";
	$sqlTotal .= $sql;
	$sqlRecord .= $sql;
	//concatenate search sql if value exist
	if(isset($where) && $where != '') {
		$sqlTotal .= $where;
		$sqlRecord .= $where;
	}


 	$sqlRecord .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";

	$queryTotal = mysqli_query($conn, $sqlTotal) or die("database error:". mysqli_error($conn));


	$totalRecords = mysqli_num_rows($queryTotal);

	$queryRecords = mysqli_query($conn, $sqlRecord) or die("error to fetch employees data");

	//iterate on results row and create new index array of data
	while( $row = mysqli_fetch_row($queryRecords) ) { 
		$data[] = $row;
	}	

	$json_data = array(
			"draw"            => intval( $params['draw'] ),   
			"recordsTotal"    => intval( $totalRecords ),  
			"recordsFiltered" => intval( $totalRecords ),
			"data"            => $data   // total data array
			);

	echo json_encode($json_data);  // send data as json format














// /////////////////100,000 data load 2nd method///////////////

// $conn = mysqli_connect("localhost","root","","long");

// // initilize all variable
// 	$params = $columns = $totalRecords = $data = array();

// 	$params = $_REQUEST;

// 	//define index of column
// 	$columns = array( 
// 		0 =>'user_id',
// 		1 =>'username', 
// 		2 => 'gender',
// 		3 => 'password'
// 	);

// 	$where = $sqlTotal = $sqlRecord = "";

// 	// check search value exist
// 	if( !empty($params['search']['value']) ) {   
// 		$where .=" WHERE ";
// 		$where .=" ( username LIKE '".$params['search']['value']."%' ";    
// 		$where .=" OR gender LIKE '".$params['search']['value']."%' ";
// 		$where .=" OR password LIKE '".$params['search']['value']."%' )";
// 	}

// 	// getting total number records without any search
// 	$sql = "SELECT * FROM `user_details` ";
// 	$sqlTotal .= $sql;
// 	$sqlRecord .= $sql;
// 	//concatenate search sql if value exist
// 	if(isset($where) && $where != '') {
// 		$sqlTotal .= $where;
// 		$sqlRecord .= $where;
// 	}


//  $sqlRecord .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";

// 	$queryTotal = mysqli_query($conn, $sqlTotal) or die("database error:". mysqli_error($conn));


// 	$totalRecords = mysqli_num_rows($queryTotal);

// 	$queryRecords = mysqli_query($conn, $sqlRecord) or die("error to fetch employees data");

// 	//$data = [];
// 	//iterate on results row and create new index array of data
// 	while( $row = mysqli_fetch_assoc($queryRecords) ) { 
// 		$custom["user_id"] = $row['user_id'];
// 		$custom["username"] = $row['username'];
// 		$custom["gender"] = $row['gender'];
// 		$custom["password"] = $row['password'];
// 		$data[] = $custom;
// 	}	

// 	$json_data = array(
// 			"draw"            => intval( $params['draw'] ),   
// 			"recordsTotal"    => intval( $totalRecords ),  
// 			"recordsFiltered" => intval( $totalRecords ),
// 			"data"            => $data   // total data array
// 			);

// 	echo json_encode($json_data);  // send data as json format
?>
	