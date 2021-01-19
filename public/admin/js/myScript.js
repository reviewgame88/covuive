$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});
$("div.alert").delay(3000).slideUp();

function xacnhanxoa(){
	if(!confirm('Bạn có muốn xóa mục này không?')){
		return false;
	}
	else return true;
}

$(document).ready(function(){
	$("#fImage").click(function(){
		$("#insert").append('<div class="form-group"><input type="file" name="fEditDetail[]"><br/></div>');
	});
});

$(document).ready(function(){
	$("button.btn-close").on('click',function(){
		var url = 'http://localhost:8080/project/admin/product/delImg/';
		var _token = $("form#frmEditProduct").find("input[name=_token]").val();
		var idHinh = $(this).parent().find("img").attr('id');
		var srcHinh = $(this).parent().find("img").attr('src');

		$.ajax({
			url: url + idHinh,
			type: 'GET',
			cache: false,
			data: {"_token" : _token, "idHinh" : idHinh, "srcHinh" : srcHinh },
			success: function(data){
				if(data=="ok"){
					$("div#"+idHinh).remove();
				}
				else{
					alert("Đã có lỗi xảy ra");
				}
			}
		});	

	});
});