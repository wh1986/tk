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

    html += '<a class="modify"  href="javascript:void(0)">详情</a>';
    html += '&nbsp;';
    html += '<a class="delete"  href="javascript:void(0)">删除</a>';
    html += '&nbsp;';

    return html;
}

window.operateEvents = {
    'click .edit': function (e, value, row, index) {
    }
}
