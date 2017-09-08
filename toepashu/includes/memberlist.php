<?php
require_once PHP_LIB_PATH.'functions.php';
require_once PHP_LIB_PATH.'mysqli_conn.php';
$stmt = $link->stmt_init();

$page 	= isset($_GET['page'])?FUNCS::inputFilter('page','GET',1):1;
$limit	= 20;
$from 	= ($page-1)*$limit;



$query = 'SELECT count(id) as count FROM toepashu';
$row = row($query);
$all_count = $row['count'];

$query = 'SELECT count(id) as count FROM toepashu'.(!empty($search_ary)?' WHERE '.join(' AND ',$search_ary):'');
$row = row($query,!empty($param_ary)?array_merge((array)$param_str,$param_ary):$param_ary);
$count = $row['count'];

$param_ary[] = &$from;
$param_ary[] = &$limit;
$param_str .= 'ii';

$query = 'SELECT * FROM toepashu'.(!empty($search_ary)?' WHERE '.join(' AND ',$search_ary):'').' ORDER BY sort ASC LIMIT ?,?';
$all_data = rows($query,!empty($param_ary)?array_merge((array)$param_str,$param_ary):$param_ary);

echo '<script>';
echo 'var count = '.$count.';';
echo 'var limit = '.$limit.';';
echo 'var page = '.$page.';';
echo '</script>';
?>