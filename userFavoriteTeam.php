<?php
session_start();
$UserName = $_SESSION['user_token'];
//$_SESSION['Pos'] = "$UserName" . " asdf";
//$Pos= $_SESSION['Pos'];
//array_push($_SESSION['Fav'], "$UserName", 'asdf');
//echo "<br><center> ".var_dump($_SESSION['Fav'])." </center>";
//$Pos[0] = $UserName;
//$Pos[1]='asdf';
echo " <script> var UserName = '$UserName'; 
		var Pos = '$Pos';
		console.log(Pos);</script>";
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
function GetFavGames(){
		console.log('hello');
        console.log(UserName);
//      numCols = document.getElementById("Matches").name;
//      console.log(numCols);
        url= "submit_req.php?rows="+UserName+"&junk="+Math.random();
//      url = "hel.php?rows="+numRows+"&cols="+numCols+"&junk="+Math.random();        
        http.open('get', url);
        http.onreadystatechange = handleAjaxResponse;
        http.send(null);
}
	
	function GetPos(){
	
        console.log(Pos);
//      numCols = document.getElementById("Matches").name;
//      console.log(numCols);
        url= "submit_req.php?rows="+Pos+"&junk="+Math.random();
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
<center><h2><?php echo "Welcome: " . $UserName; ?>
</h2></center>

	<button id="userFavs" name="userFavs" onclick=GetFavGames() value='Team Fixtures'> Team Fixtures</button>
	
	<br><br><br><br><br><br>

           
<div id=home>
<a href="index.html">
<center><img alt="home" src="logo.jpg" width="450" height="250"></center><br>
</a>
</div>
	
	<br><center>
	<div id="subresult"></div></center>
</body>
	
</html>

