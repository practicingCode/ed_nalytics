<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: relative;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  right:0;
}

.dropdown-content a {
  color: black;
  
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}
        </style>
    </head>
<h1>Aggregate</h1>
    <p> Here we will aggregate all the data of your site</p>
    <p>Which data set would you like to aggregate?</p>
<h1 id="x" onmouseover="getData(<?php echo $path_to;?>+'/handler/tables_list', 'Aggregate')">AXE</h1>
<!-- 
    Data | Aggregation | Frequency
               +          default 1 week


-->
<form method="POST">
<!-- selects -->
    <?php //include $path_to."/handler/drop_down.php"; ?>
    
    
</form>
<!-- <script>
    //AJAX 2:
    //Declaring Variable
var XMLHttpRequestObject = false;

if (window.XMLHttpRequest) {
    XMLHttpRequestObject = new XMLHttpRequest();
} else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}

// Gets The Data From The Html 'div' tag
// function getData(dataSource, divID) { 
//     if (XMLHttpRequestObject) {
//         var obj = document.getElementById(divID);

//         // Get Method Will Fatch The data From Given dataSource
//         XMLHttpRequestObject.open("GET", dataSource);

//         XMLHttpRequestObject.onreadystatechange = function() {

//             // defines the status : "200" Means 'OK'
//             if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
//                 obj.innerHTML = XMLHttpRequestObject.responseText;
//             }
//         }
//         XMLHttpRequestObject.send(null);
//     }
// }


    // LOAD ALL EXISTING AGGREGATES

    // ON OBJECT CREATE, generate list using AJAX
            // SORT EM by tables
//     var target = document.getElementsByClassName("table_selector");
//     window.onload.hello();
//     target.addEventListner("onmouseover", myFunction);

//     function myFunction() {
//         target.innerHTML = "Hello World!";
        
//     }

// </script> -->


<button onclick="tables_list()">Try it</button>



<?php 
echo $path_to."/handler/tables_list.php";
// Aggregate Data:
// FIND
// 1) AJAX, onclick.....list_tables [DONE]
// 2) write handler/list_tables
// 3) Display tables in drop down.

// Aggregation starts here
// Types of aggregation:
// 1) Sum
// 2) Avg
// 3) ratio
// 4) comparison to date (Day, Month, Year, Quarter)
?>
</html>


