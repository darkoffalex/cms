<main>
    <div class="title-bar">
        <h1><?php echo __a('Statistics'); ?></h1>
    </div><!--/title-bar-->
    <div class="content">
        <div class="module-block">
            <div class="module-head iconed world">
                <span class="title"><?php echo __a('World Map'); ?></span>
            </div><!--/module-head-->
            <div class="module-content" id="regions_div"></div><!--/module-content-->
        </div><!--/module-block-->

        <div class="module-block">
            <div class="module-head iconed places">
                <span class="title"><?php echo __a('IP Address'); ?></span>
            </div><!--/module-head-->
            <div class="module-content">
                <div class="unique-counter">
                    <span class="title">Total<br/>unique users</span>
                    <span class="counter">10 627 091</span>
                </div><!--/unique-counter-->

                <div class="item ip">
                    <a href="">10.14.154.14</a> from USA
                    <span class="time">16/03/2015 04:53:06</span>
                </div><!--/item-->
                <div class="item ip">
                    <a href="">10.14.154.14</a> from USA
                    <span class="time">16/03/2015 04:53:06</span>
                </div><!--/item-->
                <div class="item ip">
                    <a href="">10.14.154.14</a> from USA
                    <span class="time">16/03/2015 04:53:06</span>
                </div><!--/item-->
                <div class="item ip">
                    <a href="">10.14.154.14</a> from USA
                    <span class="time">16/03/2015 04:53:06</span>
                </div><!--/item-->
                <div class="item ip">
                    <a href="">10.14.154.14</a> from USA
                    <span class="time">16/03/2015 04:53:06</span>
                </div><!--/item-->
            </div><!--/module-content-->
        </div><!--/module-block-->

        <div class="module-block">
            <div class="module-head iconed activity">
                <span class="title"><?php echo __a('Recent Activity'); ?></span>
            </div><!--/module-head-->
            <div class="module-content">
                <div class="item activity">
                    <a href="">Mohamed Ali</a> fatouh registered a new account.<br/>
                    <span class="time">16/03/2015 04:53:06</span>
                </div><!--/item-->
                <div class="item activity">
                    <a href="">Mohamed Ali</a> fatouh registered a new account.<br/>
                    <span class="time">16/03/2015 04:53:06</span>
                </div><!--/item-->
                <div class="item activity">
                    <a href="">Mohamed Ali</a> fatouh registered a new account.<br/>
                    <span class="time">16/03/2015 04:53:06</span>
                </div><!--/item-->
                <div class="item activity">
                    <a href="">Mohamed Ali</a> fatouh registered a new account.<br/>
                    <span class="time">16/03/2015 04:53:06</span>
                </div><!--/item-->
                <div class="item activity">
                    <a href="">Mohamed Ali</a> fatouh registered a new account.<br/>
                    <span class="time">16/03/2015 04:53:06</span>
                </div><!--/item-->
            </div><!--/module-content-->
        </div><!--/module-block-->
    </div><!--/content-->
</main>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["geochart"]});
    google.setOnLoadCallback(drawRegionsMap);
    function drawRegionsMap() {

        var data = google.visualization.arrayToDataTable([
            ['Country', 'Visits', 'Unique'],
            ['Germany', 200, 85],
            ['United States', 300, 54],
            ['Lithuania', 400, 85],
        ]);

        var options = {colorAxis: {colors: ['#fce9b8', '#c69209']}, legend: 'none'};
        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        chart.draw(data, options);
    }
</script>