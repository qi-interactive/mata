<h1>Dashboard</h1>

<script src="/js/lib/chart.js"></script>

<canvas id="myChart" width="800" height="400"></canvas>

<br/><br/><br/><br/><br/><br/><br/><br/>



<script>

    var data = {
        labels: ["1", "2", "3", "4", "5", "6", "7"],
        datasets: [
            {
                fillColor: "rgba(153,153,153,0.2)",
                strokeColor: "#999",
                pointColor: "#fff",
                pointStrokeColor: "#999",
                data: [28, 48, 40, 19, 96, 27, 1]
            }
        ]
    }

    var ctx = document.getElementById("myChart").getContext("2d");
    var myNewChart = new Chart(ctx).Line(data);
</script>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => Yii::app()->eventLog->getModel()->search(),
    "template" => "<div class='list-view standard-list'>{items}</div>",
    'itemView' => '_systemEventLogView',
));
?>