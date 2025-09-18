<script>
   function check(){
	var formData = {
            'user' : $('input[id=user]').val(),
            'pass' : $('input[id=pass]').val(),
            'submit' : true
        };
    $.ajax({
        url : 'includes/loginCheck.php',
        type : 'POST',
        data : formData,
        success: function(result){ 
            //result is preceeded by space for some reason? thats the reason for [2]
            if(result[2] == '1'){
                alert("Logged in successfully");
                location.reload();
            }
            else
                $("#check").html(result);
            console.log(result[2])
        },
        error: function(result){ $("#check").html("Connection failed!");},

	});
    }
</script>
<div id="login">
    Username:<input type="text" id='user' value=""><br>
    Password:<input type="password" id='pass' value="" ><br>
    <button onclick="return check();">Submit</button>
    <button onclick='return ajaxNavigation("signup");'>Need to sign up?</button>
</div>
<div id="check"></div>
