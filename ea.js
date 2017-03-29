$(function(){
	var referrer = document.referrer;
	var ajax = $.ajax({
		//url: "//ana.newnius.com/hi.php",
		url: "hi.php",
		type: 'GET',
		dataType: "jsonp",
		data:{ ref:referrer }
	});
	ajax.done(function(json){
		$(".cr_count_pv").each(function(){
			$(this).text(json.pv);
		});
		$(".cr_count_site_pv").each(function(){
			$(this).text(json.site_pv);
		});
		$(".cr_count_site_vv").each(function(){
			$(this).text(json.site_vv);
		});
	});
});
