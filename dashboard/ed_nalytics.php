<!DOCTYPE html>
<meta charset="utf-8">
<!--
ANALYTICS:
Charts | Aggregate | Generate Chart
Aggregate > Schedule / Rules[Common]
Generate Chart > create view, store view, display as chart > regularly update view
Charts 
 > Define which chart is first
 > Delete Charts
 > Hide charts
 > Group charts for display
 > Group charts for sending
 > Have a table to control all charts

Generate Chart
 > Set which table to use
 > Set max value for table(Y)
 > Set which aggregation/data to use
 > Set labels per a data chosen
 > Set max number for each chart
 > Create view for chart
 > Generate view on a schedule, depending on chart type, if not time sensetive daily once
 > Delete chart, delete view

Aggregate
 > Choose data
 > Choose method of aggregation
 > Choose frequency, this is predefined if not stated, longest possible.

 -->
<!-- Load Analytics abit 

 NOTES: 
 1) Chart doesn't display twice in analytics/analytics.php
 2) Solution https://getbootstrap.com/docs/4.0/components/navs/
    - Pills
    - Tab plugins, vertical pills
-->
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    body {
    font-family: "Lato", sans-serif;
    }

    .sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
    }

    .sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
    }

    .sidenav a:hover {
    color: #f1f1f1;
    }

    .sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
    }

    @media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
    }
</style>
</head>
<body>
    <div class="container" onmouseenter="closeNav()">
    <div class="row">
        <div class="col-sm-3"><span style="font-size:30px;cursor:pointer" onmouseover="openNav()"  >&#9776; open</span></div>
        <div class="col-sm-9"><h1></h1></div>
    </div>
    <div class="row">
        <div class="col"></div>
        <div class="col"></div>
    </div>
<!-- <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#dashboard">Dashboard</a></li>
        <li><a data-toggle="tab" href="#analytics">Analytics</a></li>
        <li><a data-toggle="tab" href="#SEO">SEO</a></li>
        <li><a data-toggle="tab" href="#options">Options</a></li>
    </ul>
    <br>
    -->
        <div id="mySidenav" class="sidenav">
            <ul class="nav">
                <a href="javascript:void(0)" class="closebtn" onmouseenter="closeNav()">&times;</a>
                <li><a data-toggle="tab" href="#dash">Dashboard</a></li>
                <li><a data-toggle="tab" href="#charts">Chart Manager</a></li>
                <li><a data-toggle="tab" href="#aggregate">Aggregate</a></li>
                <li><a data-toggle="tab" href="#visualize">Visualize</a></li>
            </ul>
        </div>
        
        
        <!-- DISPLAY DATA FROM HERE -->

        <div class="tab-content">
            <div id="dash" class= "tab-pane fade in active"><?php include "analytics/analytics_dashboard.php"; ?></div>
            <div id="charts"class= "tab-pane fade"><?php include "$path_to/test.php";#include "analytics/chart_manager.php"; ?></div>
            <div id="aggregate" class= "tab-pane fade"><?php include "analytics/aggregate.php"; ?></div>
            <div id="visualize" class= "tab-pane fade"><?php include "analytics/visualize.php"; ?></div>
            
        </div>
            

        

    <script>
        
        function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        }
    </script>
    </div>
</body>
</html> 

