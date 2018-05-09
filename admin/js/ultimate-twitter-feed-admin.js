jQuery(function($) {
	'use strict';

	// Cache
	$(".utf_cache_option").change(function(){
		if(this.checked){
			$('.utf_cache_div').show();
		}else{
			$('.utf_cache_div').hide();
		}
	});

	// Shortcodes and Search
	 $(".utf_type_of_feed").change(function(){
	 	if($(this).val() == "by_name"){
	 		$("#div_by_name").show();
	 		$("#generate_button").show();
	 		$("#div_by_search").hide();
	 		$("#pro_version").hide();
	 	}

	 	if($(this).val() == "by_search"){
	 		$("#div_by_search").show();
	 		$("#generate_button").hide();
	 		$("#pro_version").show();
	 		$("#div_by_name").hide();
	 	}

	 	if($(this).val() == ""){
	 		$("#div_by_name").hide();
	 		$("#generate_button").hide();
	 		$("#div_by_search").hide();
	 		$("#pro_version").hide();
	 	}
	 });

	 // Datepircker
	 $(".utf_since,.utf_until").datepicker({
	 	"dateFormat": 'yy-mm-dd',
	 	"minDate": "-7D",
	 	"maxDate":"0D",
	 });


	// Widget
	$(document).ajaxSuccess(function() {
	 $(".utf_widget_type_of_feed").change(function(){
	 	if($(this).val() == "by_name"){
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_name').show();
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_search').hide();
	 	}

	 	if($(this).val() == "by_search"){
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_name').hide();
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_search').show();
	 	}

	 	if($(this).val() == ""){
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_name').hide();
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_search').hide();
	 	}
	 });
	});


	 // Widget
	 $(".utf_widget_type_of_feed").change(function(){
	 	if($(this).val() == "by_name"){
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_name').show();
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_search').hide();
	 	}

	 	if($(this).val() == "by_search"){
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_name').hide();
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_search').show();
	 	}

	 	if($(this).val() == ""){
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_name').hide();
	 		$(this).closest('.utf_widget_div').find('.utf_widget_by_search').hide();
	 	}
	 });




	 // SHORTCODES
	 $("#utf_shortcode_form").submit(function(event){
	 	event.preventDefault();
	 	if($(".utf_type_of_feed option:selected").val() == 'by_name'){
		 	var utf_username = $("#utf_username").val();
		 	var utf_tweets_number = $("#utf_tweets_number").val();
		 	if($("#utf_replies").is(":checked")){
		 		var utf_replies = "yes";
		 	}else{
		 		var utf_replies = "no";
		 	}
		 	var shortcode = "[UTF_BY_USER username='"+utf_username+"' number='"+utf_tweets_number+"' include_retweets='"+utf_replies+"']";
	 	}


		jQuery.ajax({
		type: "POST",
		url: ajaxurl,
		data: { action: 'utf_save_shortcodes', shortcode: shortcode},
		success: function(response){
			$("#utf_shortcode_div").html(response);
		},
		error: function(error){
			console.log("bad");
		}
		});
	 });

	 // FUNCTIONS
	 $("#utf_url_form").submit(function(event){
	 	event.preventDefault();
	 	var site_url = utf_ajax_object.site_url;
	 	if($(".utf_type_of_feed option:selected").val() == 'by_name'){
		 	var utf_username = $("#utf_username").val();
		 	var utf_tweets_number = $("#utf_tweets_number").val();
		 	if($("#utf_replies").is(":checked")){
		 		var utf_replies = "yes";
		 	}else{
		 		var utf_replies = "no";
		 	}
		 	var url = site_url+"/?rest_route=/utf/utf_by_name/"+utf_username+"/"+utf_tweets_number+"/"+utf_replies+"/";
	 	}

	 	if($(".utf_type_of_feed option:selected").val() == 'by_search'){

	 	}


		jQuery.ajax({
		type: "POST",
		url: ajaxurl,
		data: { action: 'utf_save_urls', url: url},
		success: function(response){
			$("#utf_urls_div").html(response);
		},
		error: function(error){
			console.log("bad");
		}
		});
	 });



});