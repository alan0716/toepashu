<?php
if(isset($stmt)&&$stmt->id>0){
	$stmt->close();
	unset($stmt);
}
if(isset($link)){
	$link->close();
	unset($link);
}
?>