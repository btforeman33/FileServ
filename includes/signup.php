<script>
function signupcheck(){
	var formData = {
            'user' : $('input[id=user]').val(),
            'pass' : $('input[id=pass]').val(),
            'passcheck' : $('input[id=passcheck]').val(),
            'submit' : true
        };
        /*
        formData.append('user',$('input[name=user]').val());
        formData.append('pass',$('input[name=pass]').val());
        formData.append('passcheck',$('input[name=passcheck]').val());
        formData.append('submit',true);
        */
    $.ajax({
        url: "includes/signupCheck.php",
        type: "POST",
        data: formData,
        success: function(result){$("#passcheckOutput").html(result);},
        error: function(result){$("#passcheckOutput").html("Error!");}
    });
}
</script>

<?php
$username = $_POST['user'] ?? null;
?>

Username:<input type="text" id="user" value=""><br>
Password:<input type="password" id="pass" value=""><br>
Enter your password again:<input type="password" id="passcheck" value=""><br>
<button onclick="return signupcheck();">Submit</button>
<button onclick='return ajaxNavigation("login");'>Back to login</button>
<div id="passcheckOutput"></div>






