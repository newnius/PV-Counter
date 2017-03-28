$(function(){
	var ajax = $.ajax({
		url: "//cdn.newnius.com/ana/hi.php",
		type: 'GET',
		dataType: "jsonp",
		data:{ }
	});
	ajax.done(function(json){
		$(".cr_count_pv").each(function(){
			$(this).text(json.pv);
		});
		$(".cr_count_site_pv").each(function(){
			$(this).text(json.site_pv);
		});
	});
});
