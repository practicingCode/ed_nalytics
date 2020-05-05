<!--
    OPTIONS:
     - TELEGRAM REPORTING
       > FREQUENCY
       > Password Generation
       > Messages

     - Data Collection
       > Type of data
       > Checkboxes
       > Grey out boxes dependent on other boxes [optional]

     - Privacy Policy 
        > JS, Footer
     - Feedback Bubble
        > Modal
        > Disable

     - Themes
-->



<!DOCTYPE html>
<meta charset="utf-8">
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
    <h1> Options </h1>
    <div class="container" onmouseenter="closeOptions()">
        <div id="optionsSidenav" class="sidenav">
            <ul class="nav">
                <a href="javascript:void(0)" class="closebtn" onmouseenter="closeNav()">&times;</a>
                <li><a data-toggle="tab" href="#control_center">Control Center</a></li>
                <li><a data-toggle="tab" href="#telegram">Telegram</a></li>
                <li><a data-toggle="tab" href="#">Data Collcetion</a></li>
                <li><a data-toggle="tab" href="#privacy">Privacy Policy</a></li>
            </ul>
        </div>
        <span style="font-size:30px;cursor:pointer" onmouseover="openOptions()"  >&#9776; open</span>
        
        <!-- DISPLAY DATA FROM HERE -->

        <div class="tab-content">
      
            <div id="control_center" class= "tab-pane fade in active"><?php include "options/control_center.php"; ?></div>
            <div id="telegram"class= "tab-pane fade"><?php include "options/telegram.php"; ?></div>
            <div id="data" class= "tab-pane fade"><?php include "options/data.php"; ?></div>
            <div id="privacy" class= "tab-pane fade"><?php include "options/privacy.php"; ?></div>
            
        </div>
            

        

    <script>
        
        function openOptions() {
        document.getElementById("optionsSidenav").style.width = "250px";
        }

        function closeOptions() {
        document.getElementById("optionsSidenav").style.width = "0";
        }
    </script>
    </div>
</body>
</html> 

