<?php 
require_once 'php.lib/constants.php';
require_once PHP_LIB_PATH.'default_setting.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<?php 
	require_once 'includes/memberlist.php';
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Administration of Web Service</title>
	<link type='text/css' rel='stylesheet' href='css/basic_setting.css' />
	<link type='text/css' rel='stylesheet' href='css/jquery_treeview.css' />

	<script src="js.lib/jquery-1.8.3.js" type="text/javascript"></script>
	<script src="js.lib/jquery_cookie.js" type="text/javascript"></script>
	<script src="js.lib/jquery_treeview.js" type="text/javascript"></script>
	<script src="js.lib/parameters.js" type="text/javascript"></script>
	<script src="js.lib/functions.js" type="text/javascript"></script>
	<script src="js.lib/tpl.js" type="text/javascript"></script>
	<script src="js.lib/jquery-ui.min.js" type="text/javascript"></script>
<!-- 	<script src="js/memberlist.js" type="text/javascript"></script> -->

	<script>
	$(function(){


		// 按鍵儲存排序
		// 
	  	var old_order = []; 
	    $('#t1 tbody').children('tr').each(function() { 
	        old_order.push($(this).data('id')); 
	    }); 
	    var oldid = old_order.join(','); 
	    console.log(oldid);
	    var newid;
	    $('#t1 tbody').sortable({
	    	opacity: 0.6, //设置拖动时候的透明度 
	        cursor: 'move' //拖动的时候鼠标样式 
	    });
	    $('#save1').click(function(){
            var new_order = []; 
            $('#t1 tbody').children('tr').each(function() { 
                new_order.push($(this).data('id')); 
            }); 
            newid = new_order.join(','); 
            console.log(newid);

	    	$('#ldr1').show(); 

    		$.ajax({ 
                type: "post", 
                url: "ajax/toepashu.php", //服务端处理程序 
                data: {
                	newid: newid,
                	oldid: oldid
                },success: function() { 
                    $('#ldr1').hide();
                }
            }); 
	    });

//-----------------------------------------------------------------------------------------
	    // 拖曳儲存排序
	     
	    $('#t2 tbody').sortable({
	    	opacity: 0.6, //设置拖动时候的透明度 
	        cursor: 'move', //拖动的时候鼠标样式 
	        update: function(){ 
	        	var new_order = []; 
	            $('#t2 tbody').children('tr').each(function() { 
	                new_order.push($(this).data('id')); 
	            }); 
	            newid = new_order.join(','); 
	            console.log(newid);

	            $.ajax({ 
	                type: "post", 
	                url: "ajax/toepashu.php", //服务端处理程序 
	                data: { newid: newid, oldid: oldid },   //id:新的排列对应的ID,order：原排列顺序 
	                beforeSend: function() { 
	                    $('#ldr2').show(); 
	                }, 
	                success: function() { 
	                    $('#ldr2').hide();
	                    oldid = newid ;
	                } 
	            }); 
	        }       
	    });	    


	});
	</script>
	<style>
		.loader {
		    border: 3px solid #f3f3f3 ; /* Light grey */
		    border-top: 3px solid #3498db ; /* Blue */
		    border-right: 3px solid #3498db ; /* Blue */
		    border-left: 3px solid #3498db ; /* Blue */
		    border-radius: 50%;
		    width: 8px;
		    height: 8px;
		    display: inline-block;
		    margin-top: 1.5px;
		    animation: spin .75s linear infinite;
		    float:left;
		    left: 50%;
		   	position: relative;
		}

		@keyframes spin {
		    0% { transform: rotate(0deg); }
		    100% { transform: rotate(360deg); }
		}
	</style>
</head>
<body>
<div id="mainPageLayout" class="comRange">
	<div id="header" class="comRange">
		<div id="headerTitle"><b>Administration of Web Service</b></div>
		<div id="system_date"></div>
	</div>
	<div id="mainMenu"><?php require_once 'menu.php';?></div>
	<div id="mainContent">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#e1e4e9" style="font-size:12px;">
			<tr>
				<td height="30" width="90%" valign="middle" align="left" style="PADDING-LEFT: 8px;">
					<img src="images/url_01.gif" />&nbsp;拖曳排序</font>
					
				</td>
			</tr>
		</table>

		<!-- 一鍵儲存 -->
		<br>
		<div class="loader" id="ldr1" style="display:none;"></div>
		<input type="button" value="儲存排序" id="save1" style="float:left;left: 50%;position: relative;">
		<br>
		<table class="datatable" id="t1" align="center" width="100%" style="border: 0px;">
			<?php foreach($all_data as $key=>$data){?>
			<tr data-id="<?php echo $data['id'];?>" class="ui-state-default" >
				<td class="portlet-header"  style="text-align:center;"><?php echo $data['id'];?></td>
				<td class="portlet-content" style="text-align:center;"><?php echo $data['title'];?></td>
				<td class="portlet-content" style="text-align:center;">排序<?php echo $data['sort'];?></td>
			</tr>
			<?php }?>
		</table>

		<!-- 自動儲存 -->
		<br><br><br>
		<div class="loader" id="ldr2" style="display:none;"></div>
		<input type="button" value="自動儲存" id="save2" style="float:left;left: 50%;position: relative;" disabled="false">
		<br>
		<table class="datatable" id="t2" align="center" width="100%" style="border: 0px;">
			<?php foreach($all_data as $key=>$data){?>
			<tr data-id="<?php echo $data['id'];?>" class="ui-state-default" >
				<td class="portlet-header"  style="text-align:center;"><?php echo $data['id'];?></td>
				<td class="portlet-content" style="text-align:center;"><?php echo $data['title'];?></td>
				<td class="portlet-content" style="text-align:center;">排序<?php echo $data['sort'];?></td>
			</tr>
			<?php }?>
		</table>		
	</div>	
</div>
<?php require_once 'footer.php';?>
<div class="clearboth"></div>
</body>
</html>