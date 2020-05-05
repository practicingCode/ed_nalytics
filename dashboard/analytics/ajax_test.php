<html>
<head>
    <title>AJAX - Fetching Data On Mouse Hover</title>
    <style type="text/css">
        .img {
            height: 40%;
        }
    </style>
  	<script>
  
       var XMLHttpRequestObject = false; 
         if (window.XMLHttpRequest) { 
          XMLHttpRequestObject = new XMLHttpRequest();
         }
         else if (window.ActiveXObject) { 
          XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
          }
      
         function getData(dataSource, divID) {
          if(XMLHttpRequestObject) {
           var obj = document.getElementById(divID); 
           XMLHttpRequestObject.open("GET", dataSource); 

           XMLHttpRequestObject.onreadystatechange = function(){
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200){ 
             obj.innerHTML = XMLHttpRequestObject.responseText; 
            }
           } 
           XMLHttpRequestObject.send(null); 
          }
         }
    
    </script>
</head>
<body>

    <h1 style="text-align:center;">Fetching data with Ajax</h1>

    <form>
        <img class="img" src="https://www.bbcgoodfood.com/sites/default/files/recipe-collections/collection-image/2013/05/recipe-image-legacy-id-1074500_11.jpg" onmouseover="getData('data/soup.txt', 'targetDiv')">
        <img class="img" src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.washingtonpost.com%2Fnews%2Fvoraciously%2Fwp%2F2019%2F04%2F23%2Fpineapple-on-pizza-is-easy-to-hate-at-least-in-theory%2F&psig=AOvVaw3zgLzWZ2-IqvWpilYivnJV&ust=1584885551874000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCICOpfXcq-gCFQAAAAAdAAAAABAD" onmouseover="getData('data/pizza.txt', 'targetDiv')">
        <img class="img" src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.bbcgoodfood.com%2Frecipes%2Fcollection%2Fsandwich&psig=AOvVaw0mOaPlCLbFB1KE2gjTIGWy&ust=1584885574235000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCMj2hv_cq-gCFQAAAAAdAAAAABAI" onmouseover="getData('data/sandwiches.txt','targetDiv')">
    </form>

    <h1 style="text-align:center;">
    	<div id="targetDiv">
     		<h1>The fetched data will go here.</h1>
    </div>
    <h1>   
</body>
</html>