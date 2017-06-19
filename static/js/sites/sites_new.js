$('#btn_ok').click(function(){
    var promo = $('#combo-promo').val();
    var domain = $.trim($('#txt-domain').val());

    console.info(promo);

    if(!promo) { toastr.warning("请选择推广位", 1000); return; }
    if(domain.length == 0) { toastr.warning("请输入二级域名", 1000); return; }
    if(domain.length > 10) { toastr.warning("二级域名过长, 请输入小于10位", 1000); return; }
    if(!/[a-zA-Z_]/g.test(domain)) { toastr.warning("二级域名含有非法字符，请确认", 1000); return; }

});
