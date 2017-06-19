$(function () {
    $('#table').bootstrapTable({
        idField: 'website_id',
        columns: [
            {
                checkbox: true,
                align: 'center'
            },
            {
                field: 'advertising_spot',
                title: '推广位',
                sortable: true,
                align: 'center'
            },
            {
                field: 'pid',
                title: 'PID',
                sortable: true,
                align: 'center'
            },
            {
                field: 'domain_name',
                title: '域名',
                sortable: true,
                align: 'center'
            },
            {
                field: 'rate_of_yield',
                title: '分成比例',
                sortable: true,
                align: 'center'
            },
            {
                title: '操作',
                align: 'center',
                events: operateEvents,
                formatter: operateFormatter,
            },
        ]
    });
});

function operateFormatter(val, row, index) {
    var html = "";

    html += '<a class="modify"  href="javascript:void(0)">修改分成比例</a>';
    html += '&nbsp;';
    html += '<a class="delete"  href="javascript:void(0)">删除</a>';
    html += '&nbsp;';

    return html;
}

window.operateEvents = {
    'click .edit': function (e, value, row, index) {
        $('#edit_id').val(row.shop_id);

        $('#txt_name').val(row.shop_name);
        // $('#txt_area').html(get_area_fname(row.shop_area_id));
        $('#txt_addr').val(row.shop_addr);
        $('#txt_tel').val(row.shop_tel);
        $('#shop_lat').val(row.shop_lat);
        $('#shop_lng').val(row.shop_lng);
        $('#txt_mgr_name').val(row.shop_manager_name);
        $('#txt_mgr_tel').val(row.shop_manager_tel);
        $('#combo_shop_class').val(row.shop_class_id);
        $('#home_center').val(row.shop_home_center);
        $('#combo_shop_class').selectpicker('render');

        edit_area_opts['area'] = row.shop_area_id;
        bootstrap_reset_province(edit_area_opts);

        get_edit_companies(row.shop_company_id);

        $('#modal_edit').modal('show');
    }, 'click .delete': function (e, value, row, index) {
        if(!confirm("确定要删除此记录吗？")) { return; }

        var site_id = row.website_id;
        $.ajax({
            url:'/ajax/sites/del',
            type:'post',
            dataType:'json',
            data:{ site_id:site_id},
            success:function(data){
                if(data['retcode'] == 0) {
                    toastr.info("操作成功！");
                    $('#table').bootstrapTable('refresh');
                } else {
                    toastr.error(data['msg']);
                }
            },
            error: function(res) {
                toastr.error("操作失败！");
            }
        });
    }
}

$('#btn-add').click(function(){
    // var promo = $('#combo-promo').val();
    var promo  = $('#txt-promo').val().trim();
    var domain = $('#txt-domain').val().trim();
    var pid    = $('#txt-pid').val().trim();
    var ratio  = $('#txt-ratio').val().trim();

    // if(!promo) { toastr.warning("请选择推广位", 1000); return; }
    if(promo.length == 0) { toastr.warning("请输入推广位"); return; }
    if(pid.length == 0) { toastr.warning("请输入PID"); return; }
    if(domain.length == 0) { toastr.warning("请输入二级域名"); return; }
    if(domain.length > 10) { toastr.warning("二级域名过长, 请输入小于10位"); return; }
    if(ratio.length == 0) { toastr.warning("请输入分成比例", 1000); return; }

    if(!/[a-zA-Z_0-9]/g.test(domain)) { toastr.warning("二级域名含有非法字符，请确认"); return; }

    $.ajax({
        url:'/ajax/sites/add',
        type:'post',
        dataType:'json',
        data:{ promo:promo, domain:domain, pid:pid, ratio:ratio },
        success:function(data){
            if(data['retcode'] == 0) {
                toastr.info("操作成功！");
                $('#table').bootstrapTable('refresh');
            } else {
                toastr.error(data['msg']);
            }
        },
        error: function(res) {
            toastr.error("操作失败！");
        }
    });

});
