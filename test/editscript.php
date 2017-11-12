<script>
	$(document).ready(function() {

	var data = {}; 
	$("#browsers option").each(function(i,el) {  
	   data[$(el).data("value")] = $(el).val();
	});
	// `data` : object of `data-value` : `value`
	console.log(data, $("#browsers option").val());


		$('#submit').click(function()
		{
			var value = $('#selected').val();
			alert($('#browsers [value="' + value + '"]').data('value'));
		});
	});
</script>