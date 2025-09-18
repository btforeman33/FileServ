<?ph
if(!file_exists("./settings.php")){
    //die(include("setup.php"));
}
?>
<html>
    <head>
        <link rel="stylesheet" href="includes/style.css">
        <style>
        </style>
        <script>
            function ajaxNavigation(page){
                var formData = {'page' : page};

                $.ajax({
                    url: "includes/control.php",
                    type: "POST",
                    data: formData,
                    success: function(result){$("#DynamicContent").html(result);},
                    error: function(result){$("#DynamicContent").html("Error!");}
                });
                return false;
            };
        </script>
        
        
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="./includes/content.js"></script>
        <?php
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
            if(!isset($_SESSION['username']))
                $_SESSION['username'] = 'guest';
        }
        require_once('includes/NavMenu.php');
        echo '<br><div class="dynamicContent" id="DynamicContent">';
        include 'includes/control.php';
        
        ?>
        <br>
    </body>    
</html

