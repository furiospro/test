function sendAjax(order) {

	$.ajax({
		type: 'POST',
		url:'index.php',
		headers:{"X-Requested-With": "XMLHttpRequest"},
		data:{pageAjax: order},
		success: function (response) {
			console.log(response);
			if(response === false){
				alert('А не менялось ничче!');
			}else{
				location.reload();
			}
		}
	,error: function(error1,error2,error3){
			console.log(error1);
			console.log(error2);
			console.log(error3);

			alert('Хрень Однако');
		},
		dataType:'json'
	});
}