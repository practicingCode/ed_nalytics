//===============================================================================================================
console.log("detected");
function viz(elem){
    
    row_id = elem.parentNode.parentNode.id;
    row = document.getElementById(row_id);
    name_point = row.firstChild;
    name = name_point.innerHTML;
    table_point = name_point.nextSibling;
    table = table_point.innerHTML;

    //PATH NAME
    path_name = "/view/"+table+"_"+name+".csv";
    
    display_me = path_to+path_name;
    
    //Modal body
    body = document.getElementById('modal-body');
    // body.innerHTML += display_me;
    // 1) Visualize Chart
        //CLEAR SCREEN
        var svg = d3.select("#vizz_bar");
        svg.selectAll("*").remove();
        
        //DRAW NEW
        draw_me = display_me;
        target_table = display_me;
        if(display_me.search("Bar") != -1){
            draw_bar(display_me, date , "hsl(186, 100%, 50%)");
            console.log("Bar Drawn");
        }
        
    
  }
  
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
  var path_to = path_finder();

  function removeRow(elem){
    //GET ALL IN ROW
    row_id = elem.parentNode.parentNode.id;
    row = document.getElementById(row_id);
    name_point = row.firstChild;
    name = name_point.innerHTML;
    table_point = name_point.nextSibling;
    table = table_point.innerHTML;
    
    //PATH NAME
      path_name = "/view/"+table+"_"+name+".csv";
      delete_me = path_to+path_name;
    //REMOVE RULES  
    if(window.confirm("are you sure you want to delete this?")){
      var search = "path=" + path_name;
          if (typeof search != 'undefined') {
              const destroy = new XMLHttpRequest();
              destroy.onload = function(){
                     console.log(this.responseText);
                  };
                    destroy.open("POST", path_to+"/handler/delete_rule.php"); 
                    // destroy.open("POST", path_to+"/test.php");
                    destroy.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); //header, important if not data wont actually be sent.
                    destroy.send(search);
                }
    //REMOVE VIEW --> in PHP
    //REMOVE FROM UI
    row.remove();

    }else{
      console.log("I won't");
    }
    
  }

//DATA
date = "d79/y2020";
draw_me = path_to+"/view/Bar_Chart_abc.csv";
// draw_me = "view/Bar_Chart_annoying_chicken.csv";
// draw_me = "view/Bar_Chart_abc.csv";
var colour_list = ["#69b3a2", "#58508d", "#bc5090", "#ff6361", "#ffa600", "#488f31", "#ffa600", "#004c6d", "#de425b", "#d1c27f", "#5C1A1B","#63264A","#845EC2", "#5EC27F", "#FFAC1E", "#1ED3FF" ];
draw_me = draw_me;

function setDate(){
var v = document.getElementById("find_me");
getData1 = v.options[v.selectedIndex].value;
date = getData1;

var svg = d3.select("#vizz_bar");
//Clear before visualizing again
svg.selectAll("*").remove();
rand = Math.floor(Math.random() * colour_list.length-1);
colour = colour_list[rand];
//=========================
//DELETE LATER
// colour = "hsl(300, 100%, 50%)";
//=========================

draw_bar(draw_me, date, colour);
}
// console.log(count);
//Shows data options from selected table
//===========================================SELECT DATE===========================================================
function draw_date(draw_me){ 
//detect parent
// console.log("-------------");
// console.log(draw_me); 
var vizz_bar = document.getElementById("vizz_bar");
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
    id = "find_me"
    new_drop.setAttribute("id",id);
    new_drop.setAttribute("onchange","setDate();");

//Append to parent after sibling
par = vizz_bar.parentNode;
par.insertBefore(new_drop, vizz_bar); // here we take the reference get parent and add it beside reference after


//get keys
d3.csv(draw_me,function(data){
  Keys = Object.keys(d3.values(data));
  key_len = Keys.length -1; //(remember header)
  v = d3.values(data[2])
  

  //generate dropdown
  //add options
  for(i=0;i<key_len;i++){
    v = d3.values(data[i])
    
    var opt = document.createElement("option");
        opt.text = v[2];
        opt.value = v[2];
        new_drop.options.add(opt);
  }
})
}
//==========================================================================================================

    // BAR

//---------------------------------------------------------------------------------

draw_bar(draw_me, date, "#69b3a2");
function draw_bar(draw_me, date, colour){
    // set the dimensions and margins of the graph
      var margin = {top: 10, right: 30, bottom: 90, left: 40},
          width = 460 - margin.left - margin.right,
          height = 450 - margin.top - margin.bottom;

      // append the svg object to the body of the page
      var svg = d3.select("#vizz_bar")
        .append("svg")
          .attr("width", width + margin.left + margin.right)
          .attr("height", height + margin.top + margin.bottom)
        .append("g")
          .attr("transform",
                "translate(" + margin.left + "," + margin.top + ")");

      // Parse the Data
      d3.csv(draw_me, function(data) {
      max = 0;
      console.log(data);
      length = data.length;
      let new_data = [];
      for(i=0;i<length;i++){
          key = data[i]["Country"];
          val = data[i]["Value"];
          cur_date = data[i]["Frequency"];

          if (max<val){ max=val;}
          if(cur_date == date){
              var argh = {Country: key, Value: val, Frequency: cur_date};
              new_data.push(argh);
          }
      }
      console.log(new_data);
      max = parseInt(max*1.1);

      // X axis
      var x = d3.scaleBand()
        .range([ 0, width ])
        .domain(new_data.map(function(d) { return d.Country; }))
        .padding(0.2);
      svg.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x))
        .selectAll("text")
          .attr("transform", "translate(-10,0)rotate(-45)")
          .style("text-anchor", "end");

      // Add Y axis
      var y = d3.scaleLinear()
        .domain([0, max])
        .range([ height, 0]);
      svg.append("g")
        .call(d3.axisLeft(y));

      // Bars
      svg.selectAll("mybar")
        .data(new_data)
        .enter()
        .append("rect")
          .attr("x", function(d) { 
              // if(d.Date == date){
                  return x(d.Country); 
              // }
              
          })
          .attr("width", x.bandwidth())
          .attr("fill", colour)
          // no bar at the beginning thus:
          .attr("height", function(d) { return height - y(0); }) // always equal to 0
          .attr("y", function(d) { return y(0); })

      // Animation
      svg.selectAll("rect")
        .transition()
        .duration(800)
        .attr("y", function(d) { return y(d.Value); })
        .attr("height", function(d) { return height - y(d.Value); })
        .delay(function(d,i){console.log(i) ; return(i*100)})

      })
      find_me =  document.getElementById("find_me");
      if(find_me == null){
        draw_date(draw_me);
      }
        
      
      
}



