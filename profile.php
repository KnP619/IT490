<?php
session_start();
?>
<script>
function createRequestObject(){
        var ro;
        //Get name of browser
    var browser = navigator.appName;
        //Create browser-specific HTTP request object
    if(browser == "Microsoft Internet Explorer")
                ro = new ActiveXObject("Microsoft.XMLHTTP");  
    else
                ro = new XMLHttpRequest(); 
    return ro;
}

var http = createRequestObject();
//ajax requests
function sendAjaxReq(){

       teamList = document.getElementById("teamNames").value;
        console.log(teamList);
//      numCols = document.getElementById("Matches").name;
//      console.log(numCols);
        url= "fav_add.php?rows="+teamList+"&junk="+Math.random();
//      url = "hel.php?rows="+numRows+"&cols="+numCols+"&junk="+Math.random();        
        http.open('get', url);
        http.onreadystatechange = handleAjaxResponse;
        http.send(null);
}
//ajax response

function handleAjaxResponse(){
        if( http.readyState == 4 ){   
        var response=http.responseText;
        document.getElementById("subresult").innerHTML = response;
    }
}

</script>

<html>

<body>
<link rel="stylesheet" href="login.css"/>


  <div id=logoutbutton>
	  <a href="logout.php">Logout</a>
</div>

<br><br>
<br><br>
<br><br>
<br>
<center><h2><?php echo "Welcome: " . $_SESSION['user_token']; ?>
</h2></center>

		   
<div id=home>
<a href="index.html">
<center><img alt="home" src="logo.jpg" width="450" height="250"></center><br>
</a>
</div>
<br><br>
<br><br>
	<center>
		<label for="teamNames"> Team Names </label>
	<select name="teamNames" id="teamNames">
<?php 
include ("teams.php");
?>
										  </select>
		<input type=button id=favleagues name=favLeague value=subscribe onclick=sendAjaxReq()> <div id="subresult"></div></center>
	
	
	
<br><br>
<br><br>
<div id=ligue1>
<h1> Ligue 1</h1>
<a href="ligue.html">
<img alt="french" src="frenchligue.jpg" width="300" height="300">

</a>
</div>

<div id=premier>
<h1> Premier League</h1>
<a href="premier.html">
<img alt="england" src="premier.jpg" width="300" height="300">

</a>
</div>

<br><br>
<br><br>
<div id=spain>
<h1> La Liga</h1>
<a href="laliga.html">
<img alt="spain" src="spain.png" width="300" height="300">

</a>
</div>

<div id=germany>
<h1> BundesLiga</h1>
<a href="german.html">
<img alt="german" src="german.png" width="300" height="300">

</a>
</div>

<br><br>
<br><br>


<div id=italian>
<h1> Serie A</h1>
<a href="italian.html">
<img alt="italian" src="italian-league.jpg" width="300" height="300">

</a>
</div>
</p>


</body>
</html>

