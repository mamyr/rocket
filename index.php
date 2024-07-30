<?php

$name = "";
$title = "";
$text = "";

?>
<?php include("header.php"); ?>

        <form class="container" method="POST" action="/list.php?langID=<?=$lang?>">
            <h3><?=$langArray["addBook"];?></h3>
            <fieldset>
                <div class="mb-3">
                    <label for="name"><?=$langArray["name"];?></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?=$name;?>" autocomplete="name" placeholder="<?=$langArray["enterName"];?>">
                </div>
                <div class="mb-3">
                    <label for="title"><?=$langArray["title"];?></label>
                    <input type="text" class="form-control" id="title" name="title" value="<?=$title;?>" autocomplete="title" placeholder="<?=$langArray["enterTitle"];?>">
                </div>
                <div class="mb-3">
                    <label for="text"><?=$langArray["text"];?></label>
                    <textarea rows="7" class="form-control" id="text" name="text" value="<?=$text;?>" autocomplete="text" placeholder="<?=$langArray["enterText"];?>"></textarea>
                </div>
            </fieldset>
            <button class="btn btn-primary" name="createBook" id="createBook" onclick="showDiv()"><?=$langArray["createBook"];?></button>
            <div id="loadingGif" style="display:none"><img src="https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif"></div>
            <div id="showme" style="display:none;"><?=$langArray["waitMessage"];?></div>
        </form>
        <br>
<?php include("footer.php"); ?>
