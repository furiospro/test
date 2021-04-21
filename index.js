function sendAjax(order) {

	$.ajax({
		type: 'POST',
		url:'index.php',
		headers:{"X-Requested-With": "XMLHttpRequest"},
		data:{pageAjax: order},
		success: function (response) {
			console.log(response);
			if(response === true){
				location.reload();
			}else{
				alert('Изменений нет!');
			}
		}
	,error: function(error1,error2,error3){
			console.log(error1);
			console.log(error2);
			console.log(error3);
		},
		dataType:'json'
	});
}