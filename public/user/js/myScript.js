function xacnhanxoa(str){
    if(!confirm(str)){
        return false;
    }
    else return true;
}



function delProduct(idSp){
                var url = 'http://localhost:8080/project/xoasanpham/';

                $.ajax({
                        url: url + idSp ,
                        type : 'GET',
                        cache : false,
                        data : {'idSp':idSp},
                        success: function(data, textStatus){
                            if(textStatus=="success"){
                                $("tr#"+idSp).remove();
                                $("span#total").html(data);
                                bootbox.alert('Xóa sản phẩm thành công!');
                            }
                            else{
                                bootbox.alert('Đã có lỗi xảy ra. Xin vui lòng kiểm tra lại');
                            }
                        }
                    }
                );
}

function updateProduct(idSp, value, single_total){
    var url = 'http://localhost:8080/project/capnhatsp/';
    var qty = $("td.quantity").find("input[id="+value+"]").val();
    if(qty<=0){
        bootbox.alert('Số lượng sản phẩm phải lớn hơn 0 . Xin vui lòng kiểm tra lại');

        return false;
    }
    $.ajax({
        url : url + idSp,
        type : 'GET',
        cache : false,
        data : {'qty':qty, 'single_total':single_total},
        success : function (data, textStatus) {
            if(textStatus=='success'){
                $("span#total").html(data['total']);
                $("td.total").html(data['single_total']);
                bootbox.alert('Cập nhật thành công');
            }
            else  bootbox.alert('Cập nhật thất bại');
        }
    });
}


function resetSearch(obj)
{
    $(obj).parent().find("input").each(function(){
        $(this).val(0);
    });
    
    $(obj).parent().find("select").each(function(){
        $(this).find("option:fist-child").attr('selected','');
    });
    
    $(obj).parent().find("input[type=checkbox]").each(function(){
        $(this).prop('checked', false);
    });
    
}

function resetChild(obj)
{
  $(obj).parent().parent().find("input[type=checkbox]").each(function(){
    $(this).prop('checked', false);
  });   
}

function buyAcc(idSp){
        bootbox.confirm({
            title: "Xác nhận mua",
            message: "Bạn đã chắc chắn muốn mua tài khoản này?",
            buttons: {
                confirm: {
                    label: '<i class="fa fa-check"></i> Đồng ý',
                    className: 'btn-success'
                },
                cancel: {
                    label: '<i class="fa fa-times"></i> Bỏ qua',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result)
                {
                    var url = 'http://localhost/project/buyacc/';
                    $.ajax({
                        url : url + idSp,
                        type : 'GET',
                        cache : false,
                        data : {},
                        success : function (data, textStatus) {
                            if(textStatus=='success'){
                                if(data['msg']==1)
                                {
                                    bootbox.alert({
                                        title: "Thành công!",
                                        message: "Chúng tôi sẽ chuyển bạn đến trang 'Lịch sử mua bán' để nhận thông tin Tài khoản. </br> Cảm ơn bạn đã ủng hộ chúng tôi! Chúc bạn chơi game vui vẻ :)",
                                        backdrop: true,
                                        className: 'bb-alternate-modal'
                                    });
                                }
                                else if(data['msg']==0)
                                {
                                    bootbox.alert({
                                        title: "Thất bại!",
                                        message: "Số tiền còn lại trong tài khoản không đủ để trả!",
                                        backdrop: true,
                                        className: 'bb-alternate-modal'
                                    });
                                }
                                else if(data['msg']==2)
                                {
                                    bootbox.alert({
                                        title: "Thất bại!",
                                        message: "Tài khoản này đã có người mua rồi! Bạn vui lòng tìm tài khoản khác nhé! </br> Cảm ơn bạn đã ủng hộ chúng tôi! Chúc bạn chơi game vui vẻ :)",
                                        backdrop: true,
                                        className: 'bb-alternate-modal'
                                    });
                                }
                                else if(data['msg']==3)
                                {
                                    bootbox.alert({
                                        title: "Thất bại!",
                                        message: "Bạn phải đăng nhập để thực hiện giao dịch này!",
                                        backdrop: true,
                                        className: 'bb-alternate-modal'
                                    });
                                }
                            }
                            else  bootbox.alert('Đã có lỗi xảy ra! Xin vui lòng thử lại');
                        }
                    });
                }
            }
        });    
}