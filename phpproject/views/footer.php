<script type="text/javascript" src="public/assets/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="public/assets/js/bootstrap.js"></script>
<script type="text/javascript" src="public/assets/js/bootstrap-table.js"></script>
<script type="text/javascript">
    var $table = $('#fresh-table'),
        $alertBtn = $('#alertBtn'),
        full_screen = false,
        window_height;
    $().ready(function(){
        getdata = function(){
            // update data
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'index.php?controller=webchallenge&action=parselog',
                data: {'id': 0},
                success: function(data){
                    data.sort(function(a, b){
                        keyA = Number(a['id'])
                        keyB = Number(b['id'])
                        if (keyA > keyB) return -1;
                        if (keyA < keyB) return 1;
                        return 0;
                    })
                    html = ''
                    data.forEach(function(row){
                        html += "<tr>"
                        for (var k in row)
                        {
                            if (k == 'raw_data')
                            {
                                html += `<td><a href='' data-toggle="modal" data-target="#moredetail" onclick="openmodal('Raw Data', '${btoa(row['raw_data'])}')">See More</a></td>`
                            }else if (k == 'response')
                            {
                                html += `<td><a href='' data-toggle="modal" data-target="#moredetail" onclick="openmodal('Response', '${btoa(row['response'])}')">See More</a></td>`
                            }
                            else if (k == 'rich_data')
                            {
                                html+= `<td><textarea readonly>${row[k]}</textarea></td>`
                            }else
                            {
                                html+= `<td><p>${row[k]}</p></td>`
                            }
                        }
                        html += "</tr>"
                    })
                    $('#renderphp').html(html);
                },
                error: function(err){
                    console.log(err);
                }
            });
        }();
        window_height = $(window).height();
        table_height = window_height - 20;
        $table.bootstrapTable({
            toolbar: ".toolbar",
            showRefresh: true,
            search: false,
            showToggle: false,
            showColumns: false,
            pagination: true,
            striped: true,
            sortable: false,
            height: table_height,
            pageSize: 25,
            pageList: [25,50,100],
            formatShowingRows: function(pageFrom, pageTo, totalRows){
                //do nothing here, we don't want to show the text "showing x of y from..."
            },
            formatRecordsPerPage: function(pageNumber){
                return pageNumber + " rows visible";
            },
            icons: {
                refresh: 'fa fa-refresh',
                toggle: 'fa fa-th-list',
                columns: 'fa fa-columns',
                detailOpen: 'fa fa-plus-circle',
                detailClose: 'fa fa-minus-circle'
            }
        });
        $(window).resize(function () {
            $table.bootstrapTable('resetView');
        });
        function update_data()
        {
            setTimeout(function()
            {
                try
                {
                    id = $('td p')[0].innerHTML;
                }catch (e) {
                    id = '-1'
                    update_data()
                }
                console.log(id);
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'index.php?controller=webchallenge&action=parselog',
                    data: {'id': id}, // max current id
                    success: function(data){
                        data.sort(function(a, b){
                            keyA = Number(a['id'])
                            keyB = Number(b['id'])
                            if (keyA > keyB) return -1;
                            if (keyA < keyB) return 1;
                            return 0;
                        })
                        data.forEach(function(row)
                        {
                            html = "<tr>"
                            for (var k in row)
                                if (k == 'raw_data')
                                {
                                    html += `<td><a href='' data-toggle="modal" data-target="#moredetail" onclick="openmodal('Raw Data', '${btoa(row['raw_data'])}')">See More</a></td>`
                                }else if (k == 'response')
                                {
                                    html += `<td><a href='' data-toggle="modal" data-target="#moredetail" onclick="openmodal('Response', '${btoa(row['response'])}')">See More</a></td>`
                                }
                                else if (k == 'rich_data')
                                {
                                    html += `<td><textarea readonly>${row[k]}</textarea></td>`
                                }else
                                {
                                    html += `<td><p>${row[k]}</p></td>`
                                }
                            html += "</tr>"
                            $(html).insertBefore('table > tbody > tr:first');
                        })
                    },
                    error: function(err){
                        console.log(err);
                    }
                });
            }, 1000);
        };
//        update_data();
    });

    function openmodal(title, content){
        $('#modaltitle').html(title);
        $('#modalcontent').html(atob(content));
    }
</script>