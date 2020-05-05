//=========================================================================================
var count = 2;
var all_data = [];
var log = "";
function path_finder(){
  path = window.location.pathname;
  // count slashes
  slashes = path.split("/").length - 1;
  file = "ed_nalytics";
 
  var path_to = "";
  // LOOP and concatenate path_back
    var i;
    for (i = 0; i < slashes; i++) {
      path_to = path_to + "../";
      // alert(i);
    }
    path_to = path_to + file;
  
  return path_to

}
path_to = path_finder();
//===================================================================================
csv_graph = "";
function generateTable(table_name){
  // prep for visualizing table
  file_name = path_to +"/aggregate/"+table_name+".csv";
            //file_name = "aggregate/browser_month.csv";
            d3.text(file_name, function(data) {
                var container = d3.select("table").remove();
                var parsedCSV = d3.csv.parseRows(data);

                var container = d3.select("#viz")
                    .append("table")
                    .attr("class", "table")

                    .selectAll("tr")
                        .data(parsedCSV).enter()
                        .append("tr")
                        

                    .selectAll("td")
                        .data(function(d) { return d; }).enter()
                        .append("td")
                        .attr("class", "td")
                        .on("mouseover", getIndex)
                        .text(function(d) { return d; });
            });
        csv_graph = file_name;
        return csv_graph;
}

//----------------------------------------------------------------------------------
//                     GETTERS
//----------------------------------------------------------------------------------
function getIndex(){
    origin = this;
    count = 0;
    previous = origin.previousSibling;
    while(previous){
        previous = previous.previousSibling;
        count++;
    }
    // gives index;
    // alert(count);
}
chart = "";
function getChart(){
  var c = document.getElementById("visualization");
  chart = c.options[c.selectedIndex].value;
  chart = chart;
  return chart;
}
colour = "";
function getColour(){
  var gc = document.getElementById("result");
  colour = gc.innerHTML;
  return colour;
}

function getDesc(){
  var gD = document.getElementById("desc").value;
  return gD;
}

  function setColour(){
    colour = getColour();
    col_button = document.getElementById("colour-button");
    col_button.setAttribute("style", "background-color:"+colour);
    col_name = document.getElementById("colour-name");
    col_name.innerHTML = String(colour);

  }



function getData(target){
  var v = document.getElementById(target);
  getData1 = v.options[v.selectedIndex].value;
  return getData1;
}

function getName(){
  // Selecting the input element and get its value 
  var inputVal = document.getElementById("name").value;
  return inputVal;
}
 
//----------------------------------------------------------------------------------------
//                VISUALIZE   BAR
//----------------------------------------------------------------------------------------
function double_up(target){
  show_data(target);
  bar_chart(target);
}
// DATA COLLECTORS FOR BAR
function nudaTable(){
   //GENERATES another table
   //detect parent
   var submit = document.getElementById("submit");
   var new_label = document.createElement("label");
       label_text = document.createTextNode("Table list: ");
       new_label.setAttribute("for","sel1");
       new_label.appendChild(label_text);

  console.log(files);
   var new_table = document.createElement('select');
       //DESIGN
       new_table.setAttribute("class","form-control");
       //FIRST SELECT
       new_text = document.createTextNode("select");
         var opt = document.createElement("option");
         opt.text = "select";
         opt.value = "";
         new_table.options.add(opt);

    par = submit.parentNode;
    par.insertBefore(new_label, submit);
    par.insertBefore(new_table, submit);
    
    //insert options
       for(i=0; i<files.length; i++){
          var opt = document.createElement("option");
          opt.text = files[i];
          opt.value = files[i];
          new_table.options.add(opt);
       }

    //insert functions again
    data_count = "data"+count;
    new_table.setAttribute("id",data_count);
    new_table.setAttribute("onchange","double_up(getData('"+data_count+"')); ");
    
  //LOCK
    tar = document.getElementById(data_count).previousSibling.previousSibling;
    tar.setAttribute("disabled", "");
  
  count++;
}


function show_data(target){
  // console.log(count);
  //Shows data options from selected table
  target_table = path_to+"/aggregate/"+target+".csv";

  //detect parent
  var submit = document.getElementById("submit");
  //Creating node to be made
    var new_drop = document.createElement('select');
      //DESIGN
      new_drop.setAttribute("class","form-control");
      //FIRST SELECT
      new_text = document.createTextNode("select");
        var opt = document.createElement("option");
        opt.text = "select";
        opt.value = "0";
        new_drop.options.add(opt);

      //ADDING FUNCTION ON CHANGE
      drop_count = "drop"+count;
      new_drop.setAttribute("id", drop_count);
      new_drop.setAttribute("onchange","nudaTable();");

  //Append to parent after sibling
  par = submit.parentNode;
  par.insertBefore(new_drop, submit); // here we take the reference get parent and add it beside reference after
  

  //get keys
  d3.csv(target_table,function(data){
    Keys = Object.keys(d3.values(data)[0]);
    // console.log(Keys.length + "this is the length");

    //generate dropdown
    //add options
    for(i=0;i<Keys.length;i++){
    var opt = document.createElement("option");
        opt.text = Keys[i];
        opt.value = Keys[i];
        new_drop.options.add(opt);
    }
  })
  // LOCK
  if(document.getElementById('data2') == null){
      //for first gen
      tar = document.getElementById('data1');
      tar.setAttribute("disabled", "");
    }
  //LOCK
  tar = document.getElementById(drop_count).previousSibling;
  tar.setAttribute("disabled", "");
}
//----------------------------------------------------------------------------------
//                    
//                        VIEW AND VISUALIZE
//----------------------------------------------------------------------------------

function button(){
  //get all path and pointers
  for(i=2; i<count; i++){
    counter = i-1;
    data_count = "data"+counter;
    drop_count = "drop"+i;
      data = getData(data_count);
      drop = getData(drop_count);
    path_name = data+".csv";
    pointer_name = drop;


    // store in array
    if (i == 2){
      c = i-2;
      d = c+1;
      // all_data[c] = path_name;
      log += "data1="+path_name;
      // all_data[d] = pointer_name;
      log += "&drop2="+pointer_name;
    }else{
      array_pointer = 2*(i-1);
      first = array_pointer - 1;
      // all_data[first] = path_name;
      log+= "&"+data_count+"="+path_name;
      // all_data[array_pointer] = pointer_name;
      log+= "&"+drop_count+"="+pointer_name;
    }

  }
      // adding chart name
        name = getName();
        name = name.replace(/\s/g, '_');
        log+= "&chart_name="+name; 
      // adding chart type
        chart_type = getChart();
        chart_type = chart_type.replace(/\s/g, '_');
        log+= "&chart_type="+chart_type;
        colour = getColour();
        log+= "&chart_colour="+colour;
        desc = getDesc();
        console.log(desc);
        log+= "&chart_desc="+desc;
        // console.log(colour);
        // console.log(log);
  
      
  // POST TO PHP
    if (typeof log != 'undefined') {
        const bcd = new XMLHttpRequest();
              bcd.onload = function(){
                console.log(String(this.responseText));
                
              };
        
              bcd.open("POST", path_to+"/handler/generate_view.php"); 
              bcd.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); //header, important if not data wont actually be sent.
              bcd.send(log);
              
          }
      console.log("done");
  //CLEAR SVG
    var svg = d3.select("#viz_bar");
    svg.selectAll("*").remove();
  //CLEAR DATE SELECTOR
    var elem = document.querySelector('#find_me');
    elem.parentNode.removeChild(elem);
  //SET PATH
    chart_type = getChart().replace(/\s/g, '_');
    draw_me = path_to+"/view/"+chart_type+"_"+getName()+".csv";
  //RE DRAW
    draw_date_selector(draw_me);
    bar_chart(draw_me, date, colour);

}
