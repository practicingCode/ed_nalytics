<html>
<head>
  <script src="https://d3js.org/d3.v4.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <!-- Load d3.js -->
<script src="https://d3js.org/d3.v4.js"></script>
  <style>
    .modal-backdrop {
    /* bug fix - no overlay */    
    display: none;    
}
  </style>
</head>
<h1> Chart Manager </h1>
<p> Here we will manage all the charts of that we have generated </p>

<script type="text/javascript"charset="utf-8" src="<?php echo $path_to; ?>/dashboard/analytics/chart_manager2.js"></script>
<table class="table table-hover">
    <thead>
      <tr><th class="text-center">Name</th><th class="text-center">Table type</th><th class="text-center">entries</th><th></th></tr>
    </thead>
    <tbody>
      <?php
        include $path_to."/handler/display_view.php";
      ?>

    </tbody>
  </table>
  <div class="container">
  <h2>Modal Example</h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myMod">Open Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myMod" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          Modal body..
          <!-- Create a div where the graph will take place -->
          <div id="viz_bar_chart"></div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
<script>
    //DATA
      date = "d79/y2020";
      draw_me = "<?php echo $path_to ?>/view/Bar_Chart_abc.csv";
      var colour_list = ["#69b3a2", "#58508d", "#bc5090", "#ff6361", "#ffa600", "#488f31", "#ffa600", "#004c6d", "#de425b", "#d1c27f", "#5C1A1B","#63264A","#845EC2", "#5EC27F", "#FFAC1E", "#1ED3FF" ];
      target_table = draw_me;
      db = document.getElementById('viz_bar_chart');
      db.innerHTML = "DB DETECTED";
      draw_bar(draw_me, date, "#ff6361");
    //=========================================================================================================
    function setDate(){
      var v = document.getElementById("find_me");
      getData1 = v.options[v.selectedIndex].value;
      date = getData1;
      
      var svg = d3.select("#viz_bar_chart");
      //Clear before visualizing again
      svg.selectAll("*").remove();
      rand = Math.floor(Math.random() * colour_list.length-1);
      colour = colour_list[rand];
    //=========================
      //DELETE LATER
      // colour = "hsl(300, 100%, 50%)";
    //=========================
      // alert(draw_me);
      draw_bar_again(draw_me, date, colour);
    }
    // console.log(count);
      //Shows data options from selected table
    //===========================================SELECT DATE===========================================================
    function draw_date(draw_me){
      //detect parent
      var submit = document.getElementById("viz_bar_chart");
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
      par = submit.parentNode;
      par.insertBefore(new_drop, submit); // here we take the reference get parent and add it beside reference after
      

      //get keys
      d3.csv(target_table,function(data){
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

    
    function draw_bar(draw_me, date, colour){
    // set the dimensions and margins of the graph
      var margin = {top: 10, right: 30, bottom: 90, left: 40},
          width = 460 - margin.left - margin.right,
          height = 450 - margin.top - margin.bottom;

      // append the svg object to the body of the page
      var svg = d3.select("#viz_bar_chart")
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

    function draw_bar_again(draw_me, date, colour){
          // set the dimensions and margins of the graph
            var margin = {top: 10, right: 30, bottom: 90, left: 40},
                width = 460 - margin.left - margin.right,
                height = 450 - margin.top - margin.bottom;

            // append the svg object to the body of the page
            var svg = d3.select("#viz_bar_chart")
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
            // if date selector drawn ignore
            find_me =  document.getElementById("find_me");
            
    }

</script>
<!--
    1) List rules here
    2) Delete button
    3) Search and Destroy
    4) Display rules
    5) Search and Update

    READ
    UPDATE
    DELETE
    -->