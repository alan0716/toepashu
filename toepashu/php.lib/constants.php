<?php
ini_set('display_errors',false);
define('AB_DIR',dirname(__FILE__),true);                                                   //php.lib絕對路徑
define('DS', DIRECTORY_SEPARATOR,true);                                                    //資料夾分隔符號  unix /  window \
$documentRoot = ucfirst($_SERVER['DOCUMENT_ROOT']);
$rpath = str_replace($documentRoot, '', AB_DIR);
$rpath = str_replace(basename(AB_DIR), '', $rpath);
$rpath_web = str_replace(DS, '/', $rpath);
define('REPLACE_PATH',$rpath,true);
define('WEBSITE_URL', 'http://'. $_SERVER['HTTP_HOST'].$rpath_web,true);                   //網址
define('CURR_URL', 'http://'. $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'],true);         //現在檔案所在的網址
define('CURR_URL_PARAM', 'http://'. $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],true);   //現在檔案所在的網址 include parameter
define('ROOT_PATH',  $_SERVER['DOCUMENT_ROOT'].REPLACE_PATH ,true);                        //專案開始根目錄
define('PHP_LIB_PATH', AB_DIR.DS,true);                                                    //php.lib路徑
define('MEDIA_PATH',REPLACE_PATH.'images/',true);                                          //媒體檔路徑
define("UPLOAD_PATH",REPLACE_PATH."upload/",true);                                         //上傳路徑

define("WEBX","engv2",true);

//DB const
define("DB_SERVER",'127.0.0.1',true);
define("DB_USER",'alan',true);
define("DB_PSWD",'94xjp6',true);
define("DB_NAME",'alan',true);

$colors = array('#e90e8b','rgb(251,176,60)','','','','');
?>