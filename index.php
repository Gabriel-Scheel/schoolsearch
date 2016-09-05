
<html>
<head>
<?php wp_head(); ?>

<script type="text/javascript">
	var globals = {};
	globals.ajaxUrl = '<?php echo admin_url('admin-ajax.php');?>';


	jQuery(document).ready(function($) {
	 		 
		//This does the ajax request
		$.ajax({
			url: globals.ajaxUrl,
			data: {
				'action':'score_search',
				'score' : 300
			},
			success:function(data) {
				// This outputs the result of the ajax request
				console.log(data);
			},
			error: function(errorThrown){
				console.log(errorThrown);
			}
		});  
				  
	});

</script>


</head>

<body>

</body>

</html> 