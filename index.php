<?php
    $error = '';
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
    }
    session_abort();
?>
<?php include("header.php"); ?>
    <form class="container" method="POST" action="/add.php?langID=<?=$lang?>&check=<?=$error=='auth'?"signup":"signin";?>">
        <h3><?=$langArray["auth"];?></h3>
        <fieldset>
            <div class="mb-3" <?=$error=='auth'?'':'style="display:none"'?> ><?=$langArray["errorAuth"];?></div>
            <div class="mb-3">
                <label for="login"><?=$langArray["login"];?></label>
                <input type="text" class="form-control" id="login" name="login" value="" autocomplete="login" placeholder="<?=$langArray["enterLogin"];?>">
            </div>
            <div class="mb-3">
                <label for="password"><?=$langArray["password"];?></label>
                <input type="password" class="form-control" id="password" name="password" value="" autocomplete="password" placeholder="<?=$langArray["enterPassword"];?>">
            </div>
        </fieldset>
        <button class="btn btn-primary" name="signin" id="createBook" onclick="showDiv()"><?=$error=='auth'?$langArray["signup"]:$langArray["signin"];?></button>
        <div id="loadingGif" style="display:none"><img src="https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif"></div>
        <div id="showme" style="display:none;"><?=$langArray["waitMessage"];?></div>
    </form>
    <br>
<?php include("footer.php"); ?>
