<?php
$user = ['login'=>''];
session_start();

if(isset($_POST['login']) && isset($_POST['password'])){

    $DB = mysqli_connect("localhost", "root", "", "rocket");
    mysqli_set_charset($DB, "utf8mb4");

    $login = $_POST['login'];
    $myPasswordHash = md5('dfui34fn!2Df'.$_POST['password']);

    $user = mysqli_query($DB, "SELECT * FROM `user` WHERE `login`= '$login' AND `password`= '$myPasswordHash'");
    $user = mysqli_fetch_array($user);    
    
    if(isset($_GET['check']) && $_GET['check']=='signup'){

        if(empty($user['login'])){
            mysqli_query($DB, "INSERT INTO `user`(`login`, `password`) VALUES ('$login', '$myPasswordHash')"); 

            $user = mysqli_query($DB, "SELECT * FROM `user` WHERE `login`= '$login' AND `password`= '$myPasswordHash'");
            $user = mysqli_fetch_array($user);        
        }
    }
}
$_SESSION["user"] = $user;
?>
<?php if($user['login']==$_SESSION["user"]['login']): ?>
    <?php include("header.php"); ?>
        <form class="container" method="POST" action="/list.php?langID=<?=$lang?>">
            <h3><?=$langArray["addBook"];?></h3>
            <fieldset>
                <div class="mb-3">
                    <label for="name"><?=$langArray["name"];?></label>
                    <input type="text" class="form-control" id="name" name="name" value="" autocomplete="name" placeholder="<?=$langArray["enterName"];?>">
                </div>
                <div class="mb-3">
                    <label for="title"><?=$langArray["title"];?></label>
                    <input type="text" class="form-control" id="title" name="title" value="" autocomplete="title" placeholder="<?=$langArray["enterTitle"];?>">
                </div>
                <div class="mb-3">
                    <label for="text"><?=$langArray["text"];?></label>
                    <textarea rows="7" class="form-control" id="text" name="text" value="" autocomplete="text" placeholder="<?=$langArray["enterText"];?>"></textarea>
                </div>
                <div class="mb-3">
                    <label for="avatar"><?=$langArray["imageBook"];?></label>
                    <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg, image/jpg" onchange="showImg()"/>
                    <textarea style="display:none;" class="form-control" id="fileblob" name="fileblob" value="" autocomplete="fileblob" placeholder=""></textarea>
                </div>
                <div class="mb-3">
                    <img id="imageBook" src=""/>
                </div>
            </fieldset>
            <button class="btn btn-primary" name="createBook" id="createBook" onclick="showDiv()"><?=$langArray["createBook"];?></button>
            <div id="loadingGif" style="display:none"><img src="https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif"></div>
            <div id="showme" style="display:none;"><?=$langArray["waitMessage"];?></div>
        </form>
        <br>
    <?php include("footer.php"); ?>
<?php else: ?>
    <?php      
        header("Location: /?error=auth");
        exit;
    ?>
<?php endif; ?>
