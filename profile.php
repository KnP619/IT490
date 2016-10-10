
<?php
include('login_session.php');


?>
<!DOCTYPE html>
<html>
<script>
function logout(){
window.location = "http://localhost/login/logout.php";

};
</script>
<head>
<title>User Dashboard</title>
</head>
<body>
<div id="welcome">Welcome : <i><?php echo $user_check; ?></i> <br>

<button type="button" onclick="logout()">Change Content</button>

</div>
</body>
</html>
