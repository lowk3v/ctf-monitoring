<body>
<div class="wrapper">
    <div class="fresh-table full-screen-table toolbar-color-orange">
        <div class="toolbar">
            <button id="alertBtn" class="btn btn-default">Refresh</button>
        </div>
        <table id="fresh-table" class="table">
            <thead >
                <th data-field="id" class="col-sm-1">ID</th>
                <th data-field="time" class="col-sm-1" data-sortable="true">Time</th>
                <th data-field="status" class="col-sm-1" data-sortable="true">Status</th>
                <th data-field="method" class="col-sm-1" data-sortable="true">Method</th>
                <th data-field="rich data" class="col-sm-4">Rich Data</th>
                <th data-field="raw data" class="col-sm-2">Raw Data</th>
                <th data-field="response" class="col-sm-2">Response</th>
            </thead>
            <tbody id="renderphp">
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal left fade" id="moredetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modaltitle"></h4>
            </div>
            <div class="modal-body">
                <textarea readonly id="modalcontent"></textarea>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
</div>
</body>
