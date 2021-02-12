<?php
if (isset($_GET['charts'])) {
    $charts = true;
} else {
    $charts = false;
}
$args = array(
    'post_type' => 'easysend_clicks',
    'posts_per_page' => '12'
);
$posts = get_posts($args);
$posts = array_reverse($posts);
$i = 0;
$home = 0;
$post_click = 0;
$btn = 0;
$sidebar = 0;
$draw_year = '';
$draw_month = '';
$draw_week = '';
$events = '';
foreach ($posts as $post) {
    setup_postdata($post);
    $i++;
    $easysend_clicks_date = get_field('easysend_clicks_date', $post->ID);
    $easysend_clicks_meta = get_field('easysend_clicks_meta', $post->ID);

    foreach ($easysend_clicks_meta as $meta) {
        if ($meta['local'] == 'home') {
            $home++;
        }
        if ($meta['local'] == 'post') {
            $post_click++;
        }
        if ($meta['local'] == 'btn') {
            $btn++;
        }
        if ($meta['local'] == 'sidebar') {
            $sidebar++;
        }
        $events .= '{"title": "' . $meta['name'] . ' ' . $meta['local'] . '",
                    "start": "' . $meta['date'] . '",
                    "url": "' . $meta['url'] . '"
                },';
    }
    $draw_year .= '["' . $easysend_clicks_date . '",' . $home . ',' . $post_click . ',' . $btn . ',' . $sidebar . '],';
    if ($i == count($posts)) {
        $month = [];
        foreach ($easysend_clicks_meta as $meta) {
            $newDate = date("d.m.Y", strtotime($meta['date']));
            if (array_key_exists($newDate, $month)) {
                $h = $month[$newDate]['home'];
                $p = $month[$newDate]['post'];
                $b = $month[$newDate]['btn'];
                $s = $month[$newDate]['sidebar'];
                if ($meta['local'] == 'home') {
                    $month[$newDate]['home'] = $h + 1;
                }
                if ($meta['local'] == 'post') {
                    $month[$newDate]['post'] = $p + 1;
                }
                if ($meta['local'] == 'btn') {
                    $month[$newDate]['btn'] = $b + 1;
                }
                if ($meta['local'] == 'sidebar') {
                    $month[$newDate]['sidebar'] = $s + 1;
                }
            } else {
                $month[$newDate]['home'] = 0;
                $month[$newDate]['post'] = 0;
                $month[$newDate]['btn'] = 0;
                $month[$newDate]['sidebar'] = 0;
                if ($meta['local'] == 'home') {
                    $month[$newDate]['home'] = 1;
                }
                if ($meta['local'] == 'post') {
                    $month[$newDate]['post'] = 1;
                }
                if ($meta['local'] == 'btn') {
                    $month[$newDate]['btn'] = 1;
                }
                if ($meta['local'] == 'sidebar') {
                    $month[$newDate]['sidebar'] = 1;
                }
            }
        }
        foreach ($month as $k => $v) {
            $draw_month .= '["' . $k . '",' . $v['home'] . ',' . $v['post'] . ',' . $v['btn'] . ',' . $v['sidebar'] . '],';
        }
        $week = array_slice($month, -7);
        foreach ($week as $k => $v) {
            $draw_week .= '["' . $k . '",' . $v['home'] . ',' . $v['post'] . ',' . $v['btn'] . ',' . $v['sidebar'] . '],';
        }
    }
}

wp_reset_postdata();
?>
<a class="btn with-icon btn-default <?php echo ($charts) ? '' : 'active'; ?>" href="https://dev.nashapolsha.pl/easysend-statistics/"><i class="icon-calendar"></i> Calendar</a>
<a class="btn with-icon btn-default <?php echo ($charts) ? 'active' : ''; ?>" href="https://dev.nashapolsha.pl/easysend-statistics/?charts"><i class="icon-chart-bar"></i> Charts</a>
<?php if ($charts) { ?>
    <div class="pull-right charts-selector">
        <button class="btn btn-default button_y active">Year</button>
        <button class="btn btn-default button_m">Month</button>
        <button class="btn btn-default button_w">Week</button>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.10.1/chartist.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plottable.js/2.2.0/plottable.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.2/plugins/export/export.css"><style>
        @-webkit-keyframes rotate-forever {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-moz-keyframes rotate-forever {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes  rotate-forever {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        .loading-spinner {
            -webkit-animation-duration: 0.75s;
            -moz-animation-duration: 0.75s;
            animation-duration: 0.75s;
            -webkit-animation-iteration-count: infinite;
            -moz-animation-iteration-count: infinite;
            animation-iteration-count: infinite;
            -webkit-animation-name: rotate-forever;
            -moz-animation-name: rotate-forever;
            animation-name: rotate-forever;
            -webkit-animation-timing-function: linear;
            -moz-animation-timing-function: linear;
            animation-timing-function: linear;
            height: 60px;
            width: 60px;
            border-radius: 50%;
            display: inline-block;
        }
    </style>
    <div class="app">
        <h1>Charts</h1>
        <center>
            <div class="charts" style="background: inherit;">
                <div data-duration="500" class="charts-loader enabled" style="display: none; position: relative; top: 170px; height: 0;">
                    <center>
                        <div class="loading-spinner" style="border: 3px solid #000000; border-right-color: transparent;"></div>
                    </center>
                </div>
                <div class="charts-chart">
                    <div id="charts_clicks" style="height: 400px;"></div>
                </div>
            </div>
        </center>
    </div>
    <script type="text/javascript" src="https://cdn.rawgit.com/Mikhus/canvas-gauges/gh-pages/download/2.1.2/all/gauge.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.10.1/chartist.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script type="text/javascript" src="https://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://static.fusioncharts.com/code/latest/themes/fusioncharts.theme.fint.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">google.charts.load('current', {'packages': ['corechart', 'gauge', 'geochart', 'bar', 'line']})</script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.7/highcharts.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.7/js/modules/offline-exporting.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highmaps/5.0.7/js/modules/map.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highmaps/5.0.7/js/modules/data.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/mapdata/custom/world.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.6/raphael.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.2/justgage.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.6/raphael.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/plottable.js/2.8.0/plottable.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.0.1/progressbar.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/echarts/3.6.2/echarts.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.2/amcharts.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.2/serial.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.2/plugins/export/export.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.2/themes/light.js"></script>
    <script>
        (function ($) {
            "use strict";
            $('.charts').each(function () {
                var chart = $(this).find('.charts-chart');
                var loader = $(this).find('.charts-loader');
                var time = loader.data('duration');

                if (loader.hasClass('enabled')) {
                    chart.css({visibility: 'hidden'});
                    loader.fadeIn(350);

                    setTimeout(function () {
                        loader.fadeOut(350, function () {
                            chart.css({opacity: 0, visibility: 'visible'}).animate({opacity: 1}, 350);
                        });
                    }, time)
                }
            });
        })(jQuery);
    </script>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            $(".button_y").click(function () {
                $('.charts-selector .btn').removeClass('active');
                $(this).addClass('active');
                google.charts.setOnLoadCallback(draw_year);
            });
            $(".button_m").click(function () {
                $('.charts-selector .btn').removeClass('active');
                $(this).addClass('active');
                google.charts.setOnLoadCallback(draw_month);
                console.log(<?php echo $draw_month; ?>);
            });
            $(".button_w").click(function () {
                $('.charts-selector .btn').removeClass('active');
                $(this).addClass('active');
                google.charts.setOnLoadCallback(draw_week);
            });
            google.charts.load('current', {'packages': ['bar']})
            var charts_clicks;
            google.charts.setOnLoadCallback(draw_year)

            function draw_year() {
                var data = google.visualization.arrayToDataTable([
                    [
                        '',
                        "Main",
                        "Record",
                        "Button",
                        "Sitebar",
                    ],<?php echo $draw_year; ?>])

                var options = {
                    chart: {
                    },
                    colors: [
                        "#4990e2",
                        "#58cb5d",
                        "#d15959",
                        "#FFC107",
                        "#9a3970",
                    ],
                };

                charts_clicks = new google.charts.Bar(document.getElementById("charts_clicks"))

                charts_clicks.draw(data, options)
            }
            function draw_month() {
                var data = google.visualization.arrayToDataTable([
                    [
                        '',
                        "Main",
                        "Record",
                        "Button",
                        "Sitebar",
                    ],<?php echo $draw_month; ?>])

                var options = {
                    chart: {
                    },
                    colors: [
                        "#4990e2",
                        "#58cb5d",
                        "#d15959",
                        "#FFC107",
                        "#9a3970",
                    ],
                };

                charts_clicks = new google.charts.Bar(document.getElementById("charts_clicks"))

                charts_clicks.draw(data, options)
            }
            function draw_week() {
                var data = google.visualization.arrayToDataTable([
                    [
                        '',
                        "Main",
                        "Record",
                        "Button",
                        "Sitebar",
                    ],<?php echo $draw_week; ?>])

                var options = {
                    chart: {
                    },
                    colors: [
                        "#4990e2",
                        "#58cb5d",
                        "#d15959",
                        "#FFC107",
                        "#9a3970",
                    ],
                };

                charts_clicks = new google.charts.Bar(document.getElementById("charts_clicks"));

                charts_clicks.draw(data, options)
            }
        })(jQuery);
    </script>
<?php } else { ?>
    <style>
        .locale-selector .select2-container {
            min-width: 90px;
            text-align: center;
        }
        /*        .fc-time, .fc-title {
                    color: #fff;
                }
                #calendar a:hover * {
                    color: #fd3300;
                } */
    </style>
    <div class="pull-right locale-selector">
        <label for="locale-selector">Languages:</label>
        <div class="clearfix"></div>
        <select name="locale-selector" id="locale-selector" class="skin-select"></select>
    </div>
    <h1>Calendar</h1>
    <div id='calendar'></div>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.0/fullcalendar.min.css'/>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.0/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.0/locale-all.js'></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                var initialLocaleCode = 'uk';
                events = [<?php echo $events; ?>];
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prevYear prev today next nextYear',
                        center: 'title',
                        right: 'year,month,agendaWeek,agendaDay listYear,listMonth,listWeek,listDay'
                    },
                    views: {
                        listDay: {buttonText: 'in a day'},
                        listWeek: {buttonText: 'in a week'},
                        listMonth: {buttonText: 'in a month'},
                        listYear: {buttonText: 'in a year'},
                    },
                    locale: initialLocaleCode,
                    weekNumbers: true,
                    navLinks: true,
                    editable: true,
                    eventLimit: true,
                    events: events,
                    eventClick: function (event) {
                        if (event.url) {
                            window.open(event.url, "_blank");
                            return false;
                        }
                    }
                });
                $.each($.fullCalendar.locales, function (localeCode) {
                    $('#locale-selector').append(
                            $('<option/>')
                            .attr('value', localeCode)
                            .prop('selected', localeCode == initialLocaleCode)
                            .text(localeCode)
                            );
                });
                $('#locale-selector').on('change', function () {
                    if (this.value) {
                        $('#calendar').fullCalendar('option', 'locale', this.value);
                    }
                });
            });
        })(jQuery);
    </script>
    <?php
}?>