<?php 
require_once '../php.lib/constants.php';
require_once PHP_LIB_PATH.'default_setting.php';
require_once PHP_LIB_PATH.'mysqli_conn.php';
require_once PHP_LIB_PATH.'functions.php';
require_once PHP_LIB_PATH.'acex.php';

$stmt 	= $link->stmt_init();

$newid 	= isset($_POST['newid'])?FUNCS::inputFilter('newid','POST',3):'';
$oldid 	= isset($_POST['oldid'])?FUNCS::inputFilter('oldid','POST',3):'';

$newid  = explode(',',$newid);
$oldid  = explode(',',$oldid);
// $result = array_diff($newid,$oldid);

foreach ($newid as $k => $v) {
	if($newid[$k]!=$oldid[$k]){
		$query = 'UPDATE toepashu SET sort=? where id=?';
		update($query,array('ii',&$k,&$newid[$k]));				
	}
}


$stmt->close();
$link->close();
?>