<?php self::unpjax('container', array('title'=>'Dahboard', 'preload'=>'')); ?>

<h1 class="page-header">Dashboard</h1>

<!-- page and operation -->
<div>
    <form class="form-inline" action="" method="GET" role="form">
        <!--- filter -->
        <div class="btn-group" style="margin:20px 0px; margin-right:10px;">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                Operate <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:;" class="btn-refresh">Update</a></li>
            </ul>
        </div>
        <!-- end filter -->

        <!-- search -->
        <div class="form-group">
            <input type="text" name="start" class="form-control ui-datepicker" value="<?php echo $start; ?>" placeholder="Start" />
        </div>
        <div class="form-group">
            <input type="text" name="end" class="form-control ui-datepicker" value="<?php echo $end; ?>" placeholder="End" />
        </div>
        <button class="btn btn-default btn-flat" type="submit"><span class="glyphicon glyphicon-search"></span></button>
        <!-- end search -->
    </form>

</div>
<!--  page and operation  -->



<!-- modal -->
<div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Update Data</h4>
            </div>
            <form class="modal-body form-horizontal">

                <blockquote>
                    <p>API limitation: query to get data by only one day every time.</p>
                </blockquote>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Date</label>
                    <div class="col-sm-6">
                        <input type="text" name="date" class="form-control ui-datepicker" value=""  />
                    </div>
                </div>

            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-submit">Update</button>
            </div>
        </div>
    </div>
</div>


<div id="chartdiv" style="height:500px;">

</div>



<script src="<?php echo RESOURCES_URL; ?>js/jquery.zdatepicker.js"></script>
<link href="<?php echo RESOURCES_URL; ?>css/zdatepicker.css" rel="stylesheet" />
<script src="<?php echo RESOURCES_URL; ?>js/amcharts/amcharts.js"></script>
<script src="<?php echo RESOURCES_URL; ?>js/amcharts/serial.js"></script>

<script>
$(function(){

    $(".ui-datepicker").zdatepicker({ viewmonths:1 });

    var modal = $("#modal");

    $(".btn-refresh").click(function(){
        var btn = $(this);
        modal.find("form")[0].reset();
        modal.modal("show");
    });

    modal.find(".btn-submit").click(function(){
        var btn = $(this), form = modal.find("form"), post = form.serialize();
        btn.prop('disabled', true).text("Uploading");
        $.post("?module=overview&operate=refresh", post, function(data){
            btn.prop('disabled', false).text("Upload");
            if (data.s == 0){
                alert('Successful update of data.', 'success', function(){}, modal.find(".modal-body"));
            } else {
                alert(data.err, 'error', null, modal.find(".modal-body"));
            }
        }, "json");
    });

    AmCharts.makeChart("chartdiv",
    {
        "path": "<?php echo RESOURCES_URL ?>js/amcharts",
        "type": "serial",
        "categoryField": "date",
        "dataDateFormat": "YYYY-MM-DD",
        "handDrawn": true,
        "handDrawScatter": 0,
        "handDrawThickness": 0,
        "theme": "default",
        "categoryAxis": {
            "parseDates": true
        },
        "chartCursor": {
            "enabled": true
        },
        "chartScrollbar": {
            "enabled": true
        },
        "trendLines": [],
        "graphs": [
            {
                "bullet": "round",
                "id": "ag-1",
                "title": "Users",
                "valueField": "user"
            },
            {
                "bullet": "square",
                "id": "ag-2",
                "title": "PV",
                "valueField": "pv"
            },
            {
                "bullet": "square",
                "id": "ag-3",
                "title": "UV",
                "valueField": "uv"
            }
        ],
        "guides": [],
        "valueAxes": [],
        "allLabels": [],
        "balloon": {},
        "legend": {
            "enabled": true,
            "useGraphSettings": true
        },
        "dataProvider": <?php echo json_encode($data); ?>
    }
);

});
</script>