
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<script>
function logout(){
window.location = "http://localhost/logout.php";

};
</script>
<head>
<title>User Dashboard</title>
</head>
<body>
<div id="welcome">Welcome : <i><?php echo $_SESSION["user_token"]; ?></i> <br>

<button type="button" onclick="logout()">Change Content</button>

</div>
</body>
</html>

