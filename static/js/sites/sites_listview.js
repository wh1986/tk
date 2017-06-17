$(function () {
    $('#table').bootstrapTable({
        idField: 'shop_id',
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
                field: 'domain_name',
                title: '域名',
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

    html += '<a class="delete"  href="javascript:void(0)">解除绑定</a>';
    html += '&nbsp;';
    html += '<a class="modify"  href="javascript:void(0)">修改分成比例</a>';
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
    }, 'click .verify': function (e, value, row, index) {
        $('#verify_id').val(row.shop_id);

        $('#lb_name').html(row.shop_name);
        $('#lb_area').html(get_area_fname(row.shop_area_id));
        $('#lb_addr').html(row.shop_addr);
        $('#lb_tel').html(row.shop_tel);
        $('#lb_class').html(row.shop_class_name);
        $('#lb_company').html(row.shop_company_name);
        $('#lb_state').html(row.shop_state);
        $('#lb_reason').html(row.shop_refuse_reason);

        $('#img-left').attr('src', row.shop_photo1);
        $('#img-center').attr('src', row.shop_photo2);
        $('#img-right').attr('src', row.shop_photo3);

        $('#modal_verify').modal('show');
    }, 'click .merge': function (e, value, row, index) {
        $('#merge_id_from').val(row.shop_id);

        var html = "";

        html += " ID：" + row.shop_id;
        html += " 地区：" + get_area_fname(row.shop_area_id);
        html += " 名称：" + row.shop_name;
        html += " 地址：" + row.shop_addr;

        merge_area_opts['area'] = row.shop_area_id;
        bootstrap_reset_province(merge_area_opts);

        get_merge_shops();

        $('#merge_shop_info').html(html);
        $('#modal_merge').modal('show');
    },'click .shop_add_group': function (e, value, row, index) {
        $('#group_id_from').val(row.shop_id);

        var html = "";

        html += " ID：" + row.shop_id;
        html += " 地区：" + get_area_fname(row.shop_area_id);
        html += " 名称：" + row.shop_name;

        $('#group_shop_info').html(html);
        $('#modal_group').modal('show');
    }
}


