$(function () {
    $('#table').bootstrapTable({
        idField: 'GoodsID',
        columns: [
            {
                checkbox: true,
                align: 'center'
            },
            {
                field: 'GoodsID',
                title: '产品编号',
                sortable: true,
                align: 'center'
            },
            {
                field: 'D_title',
                title: '标题',
                sortable: true,
                align: 'center'
            },
            {
                field: 'Org_Price',
                title: '正常价',
                sortable: true,
                align: 'center'
            },
            {
                field: 'Price',
                title: '折后价',
                sortable: true,
                align: 'center'
            },
            {
                field: 'Sales_num',
                title: '销量',
                sortable: true,
                align: 'center'
            },
            {
                field: 'Commission_jihua',
                title: '计划佣金',
                sortable: true,
                align: 'center'
            },
            {
                field: 'Commission_queqiao',
                title: '高佣',
                sortable: true,
                align: 'center'
            },
            {
                field: 'Quan_surplus',
                title: '券数量',
                sortable: true,
                align: 'center'
            },
            {
                field: 'utime',
                title: '更新时间',
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

    if(row.item_url) {
        html += '<a class="detail" target="_blank" href="' + row.item_url + '">详情</a>';
    } else {
        html += '<span>详情</span>';
    }
    html += '&nbsp;';

    return html;
}

window.operateEvents = {
    'click .edit': function (e, value, row, index) {
    }
}
