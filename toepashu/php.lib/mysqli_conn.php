<?php
$link = @new mysqli(DB_SERVER, DB_USER, DB_PSWD, DB_NAME);

if($link->connect_error){
	echo '資料庫連線失敗:'.$link->connect_error;
	exit();
}
else{
	$link->query("SET NAMES UTF8");
	$link->query("SET CHARACTER_SET_CLIENT=utf8;");
	$link->query("SET CHARACTER_SET_RESULTS=utf8;");
	//echo '連線成功';
}

function mysqliFetchAssoc($result){
	$array = array();

	if($result instanceof mysqli_stmt)
	{
		$result->store_result();

		$variables = array();
		$data = array();
		$meta = $result->result_metadata();

		while($field = $meta->fetch_field())
			$variables[] = &$data[$field->name]; 

		call_user_func_array(array($result, 'bind_result'), $variables);

		$i=0;
		while($result->fetch())
		{
			$array[$i] = array();
			foreach($data as $k=>$v)
				$array[$i][$k] = $v;
			$i++;
		}
	}
	elseif($result instanceof mysqli_result)
	{
		while($row = $result->fetch_assoc()){
			$array[] = $row;
		}
	}

	return $array;
};

function insert($query,$param=array(),$stmt=null){
	if($stmt==null)
		global $stmt;

	$id = 0;
	$stmt->prepare($query);
	if(!empty($param))
		call_user_func_array(array($stmt, 'bind_param'), $param);
	$stmt->execute();
	$stmt->store_result();
	if($stmt->affected_rows > 0)
		$id = $stmt->insert_id;

	return $id;
}

function row($query,$param=array(),$stmt=null){
	if($stmt==null)
		global $stmt;

	$result = array();
	$stmt->prepare($query);
	if(!empty($param))
		call_user_func_array(array($stmt, 'bind_param'), $param);
	$stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows > 0){
		$r = mysqliFetchAssoc($stmt);
		$result = $r[0];
	}

	return $result;
}

function rows($query,$param=array(),$stmt=null){
	if($stmt==null)
		global $stmt;

	$result = array();
	$stmt->prepare($query);
	if(!empty($param))
		call_user_func_array(array($stmt, 'bind_param'), $param);
	$stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows > 0){
		$result = mysqliFetchAssoc($stmt);
	}

	return $result;
}

function delete($query,$param=array(),$stmt=null){
	if($stmt==null)
		global $stmt;

	$succ = 0;
	$stmt->prepare($query);
	if(!empty($param))
		call_user_func_array(array($stmt, 'bind_param'), $param);
	$stmt->execute();
	$stmt->store_result();
	$succ = $stmt->affected_rows;

	return $succ;
}

function update($query,$param=array(),$stmt=null){
	if($stmt==null)
		global $stmt;

	$succ = 0;
	$stmt->prepare($query);
	if(!empty($param))
		call_user_func_array(array($stmt, 'bind_param'), $param);
	$stmt->execute();
	$stmt->store_result();
	$succ = $stmt->affected_rows;

	return $succ;
}
?>