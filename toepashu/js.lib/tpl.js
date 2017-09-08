var showPage = function(data_count,page,data_limit,show_limit){
	var limit = show_limit!=null?show_limit:10;
	var total_page = Math.ceil(data_count/data_limit);	
	var r_string = '<br/>'+page+' / '+total_page+'&nbsp;&nbsp;共'+data_count+'筆資料&nbsp;&nbsp;';
	var search_url = window.location.search;
	if(search_url != ''){
		var searchs = search_url.split('&');
		var newsearchs = [];
		for(var idx in searchs){
			if(searchs[idx].indexOf('page') == -1 && searchs[idx].indexOf('keyword') == -1){
				newsearchs.push(searchs[idx]);
			}
		}	
		if(newsearchs.length == 0){
			var page_url = '?';
		}
		else{
			var page_url = newsearchs.join('&')+'&';
		}
		
	}
	else{
		var page_url = '?';
	}
	if(total_page > 1){
		if(page != 1){
			r_string+= '<a href="'+page_url+'page=1">首頁</a>&nbsp;&nbsp;';
			r_string+= '<a href="'+page_url+'page='+(page-1)+'">上一頁</a>&nbsp;&nbsp;';
		}			
		for(var i=(page-Math.floor(limit/2)>0?page-Math.floor(limit/2):1),j=i;i<=page+limit && i-j<10 && i<=total_page;i++){
			if(i == page){
				r_string+= i+'&nbsp;&nbsp;';
			}
			else{
				r_string+= '<a href="'+page_url+'page='+i+'">'+i+'</a>&nbsp;&nbsp;';
			}
		}
		if(page != total_page){
			r_string+= '<a href="'+page_url+'keyword=1&page='+(page+1)+'">下一頁</a>&nbsp;&nbsp;';
			r_string+= '<a href="'+page_url+'page='+total_page+'">末頁</a>';
		}
	}	
	return r_string;
};

var showPage2 = function(data_count,page,data_limit){
	var total_page = Math.ceil(data_count/data_limit);
	var search_url = window.location.search;
	var r_string = '';
	
	if(search_url != ''){
		var searchs = search_url.split('&');
		var newsearchs = [];
		for(var idx in searchs){
			if(searchs[idx].indexOf('page') == -1 && searchs[idx].indexOf('keyword') == -1){
				newsearchs.push(searchs[idx]);
			}
		}	
		if(newsearchs.length == 0){
			var page_url = '?';
		}
		else{
			var page_url = newsearchs.join('&')+'&';
		}
		
	}
	else{
		var page_url = '?';
	}
	
	if(total_page >= 1){
		r_string+= '<a href="'+page_url+'page=1">首頁</a>&nbsp;&nbsp;';
		if(page != 1){
			r_string+= '<a href="'+page_url+'page='+(page-1)+'">上一頁</a>&nbsp;&nbsp;';
		}			
		for(var i=1;i<=total_page;i++){
			if(i == page){
				r_string+= i+'&nbsp;&nbsp;';
			}
			else{
				r_string+= '<a href="'+page_url+'page='+i+'">['+i+']</a>&nbsp;&nbsp;';
			}
		}
		if(page != total_page){
			r_string+= '<a href="'+page_url+'keyword=1&page='+(page+1)+'">下一頁</a>&nbsp;&nbsp;';
		}
		r_string+= '<a href="'+page_url+'page='+total_page+'">末頁</a>';
	}
	return r_string;
};

$(document).ready(function(){
	
	var getDate = function(){
		var date    = new Date();
		var year    = date.getFullYear();
		var month   = date.getMonth()+1;
		var day     = date.getDate();
		var hour    = date.getHours();
		var minute  = date.getMinutes();
		var seconds = date.getSeconds();
		
		month       = checkTime(month);
		day         = checkTime(day);
		hour        = checkTime(hour);
		minute      = checkTime(minute);
		seconds     = checkTime(seconds);
		function checkTime(i){
			if (i<10){
			  i="0" + i;
			}
			return i;
		};
		var dstring = year+'-'+month+'-'+day+'&nbsp;&nbsp;'+hour+':'+minute+':'+seconds;
		$('#system_date').html(dstring);
		setTimeout(getDate,1000);
	};	
	getDate();
	
	checkHeight();
	
	if($('#treeviewSection').length > 0){
		$('#treeviewSection').treeview();
	}
	
	
});
var checkHeight = function(){
	var height = getBrowserHeight()-90;
	var originalHeight = $('#mainContent').outerHeight();
	if(originalHeight < height){
		$('#mainContent').css('minHeight',height+'px');
	}
	
};

$(window).resize(checkHeight);