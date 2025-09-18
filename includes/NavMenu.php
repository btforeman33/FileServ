<html>
    <head>
    </head>
    <body>
        <div id="NavMenu" class="NavMenu">
            <a class="NavMenu" href="" onclick="return ajaxNavigation('files');">Files</a>
            <!--<a class="NavMenu" href="" onclick="return ajaxNavigation('homework');">Homework</a>
            <a class="NavMenu" href="" onclick="return ajaxNavigation('servers');">Servers</a>-->
            <?php
            if($_SESSION['username'] != 'guest'){
                echo '<a class="NavMenu" href="" onclick="return ajaxNavigation(\'vault\');">Vault</a>';
                echo '<a class="NavMenu" href="" onclick="return ajaxNavigation(\'shares\');">Shares</a>';
            }
            
            if(isset($_SESSION['username']) && $_SESSION['username'] != "guest"){
                echo '<a class="NavMenu" href="" style="float:right;" onclick="return ajaxNavigation(\'logout\');">Logout</a>';
            }
            else{
                echo '<a class="NavMenu" href="" style="float:right;" onclick="return ajaxNavigation(\'login\');">Login</a>';
                echo '<a class="NavMenu" href="" style="float:right;" onclick="return ajaxNavigation(\'signup\');">Signup</a>';
            }

            ?>
            

            <!--<a class="NavMenu" href="" onclick="return ajaxNavigation('gallery');">Gallery</a>-->
        </div>
    </body>
</html>