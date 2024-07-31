<?php
require_once ('vendor/autoload.php');
use \Dejurin\GoogleTranslateForFree;

$DB = mysqli_connect("localhost", "root", "", "rocket");
mysqli_set_charset($DB, "utf8mb4");

$name = "";
$title = "";
$order = "";
$sort = "";

if(isset($_GET['bookID'])){
    if(isset($_POST['name']) && isset($_POST['title']) && isset($_POST['text']) && isset($_POST['id'])){
        $newName = $_POST['name'];
        $newTitle = $_POST['title'];
        $newText = $_POST['text'];
        $id = $_POST['id'];

        mysqli_query($DB, "UPDATE `book` SET `name`='$newName', `title`='$newTitle', `text`='$newText' WHERE `id`=$id");     
    }
} else {
    if(isset($_POST['name']) && isset($_POST['title']) && isset($_POST['text']) && isset($_POST['fileblob'])){
        $tr = new GoogleTranslateForFree();
        
        $source = 'ru';
        $target = 'en';
        $attempts = 5;
        $arr = explode(" ", $_POST['name']);
        $resultName = $tr->translate($source, $target, $arr, $attempts);
        foreach ($resultName as $value) {
            $name = $name.' '.$value;
        }
        
        $arr = explode(" ", $_POST['title']);
        $resultTitle = $tr->translate($source, $target, $arr, $attempts);
        foreach ($resultTitle as $value) {
            $title = $title.' '.$value;
        }
    
        $newName = $_POST['name'];
        $newTitle = $_POST['title'];
        $newText = $_POST['text'];
        $fileblob = $_POST['fileblob'];
        
        mysqli_query($DB, "INSERT INTO `book`(`name`, `title`, `name_eng`, `title_eng`, `text`, `image`) VALUES ('$newName', '$newTitle', '$name', '$title', '$newText', '$fileblob')"); 
    }    
}

$books = mysqli_query($DB, "SELECT * FROM `book`");

if(isset($_GET['sort'])){
    $sort = $_GET['sort'];
    $order = $_GET['order'];
    if($sort == "name"){
        if($order == "asc")
            $books = mysqli_query($DB, "SELECT * FROM `book` ORDER BY `name` ASC");
        else
            $books = mysqli_query($DB, "SELECT * FROM `book` ORDER BY `name` DESC");
    } else if($sort == "date"){
        if($order == "asc")
            $books = mysqli_query($DB, "SELECT * FROM `book` ORDER BY `create_date` ASC");
        else
            $books = mysqli_query($DB, "SELECT * FROM `book` ORDER BY `create_date` DESC");
    }
}

if(isset($_POST['bookname'])){
    $bookname = trim($_POST['bookname']);
    if($bookname=="")
        $books = mysqli_query($DB, "SELECT * FROM `book`");
    else
        $books = mysqli_query($DB, "SELECT * FROM `book` WHERE `name` LIKE '%$bookname%'");
}

$books = mysqli_fetch_all($books, MYSQLI_ASSOC);
?>
<?php include("header.php"); ?>
        <form class="container" method="POST" action="/list.php?langID=<?=$lang?>">
            <h3><?=$langArray["searchBookTitle"];?></h3>
            <h6><?=$langArray["searchBookTitleAll"];?></h6>
            <fieldset>
                <div class="mb-3">
                    <label for="bookname"><?=$langArray["name"];?></label>
                    <input type="text" class="form-control" id="bookname" name="bookname" value="" autocomplete="bookname" placeholder="<?=$langArray["enterName"];?>">
                </div>
            </fieldset>
            <button class="btn btn-primary" name="createBook" id="createBook" onclick="showDiv()"><?=$langArray["searchBook"];?></button>
            <div id="loadingGif" style="display:none"><img src="https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif"></div>
            <div id="showme" style="display:none;"><?=$langArray["waitMessage"];?></div>
        </form>
        <br>

        <table class="table">
            <tr>
                <th scope="col"><?=$langArray["id"];?></th>
                <th scope="col"><?=$langArray["name"];?><button class="arrowButton" onclick="listSortName('arr11')"><div class="mobile-arrow <?=$order=="asc"&&$sort=="name"?"up":"down"?>" id="arr11"></div></button></th>
                <th scope="col"><?=$langArray["title"];?></th>
                <th scope="col"><?=$langArray["nameEng"];?></th>
                <th scope="col"><?=$langArray["titleEng"];?></th>
                <th scope="col"><?=$langArray["createDate"];?><button class="arrowButton" onclick="listSortDate('arr21')"><div class="mobile-arrow <?=$order=='asc'&&$sort=='date'?'up':'down'?>" id="arr21"></div></button></th>
                <th></th>
            </tr>
            <?php foreach($books as $book): ?>
                <tr>
                    <th scope="row"><?=$book["id"];?></th>
                    <td><?=$book["name"];?></td>
                    <td><?=$book["title"];?></td>
                    <td><?=$book["name_eng"];?></td>
                    <td><?=$book["title_eng"];?></td>
                    <td><?=date("d.m.Y - H:i",strtotime($book["create_date"]))?></td>
                    <td><button popovertarget="book" class="btn btn-primary" name="readBook" id="readBook" onclick='showRead(<?=$book["id"];?>,"<?=$book["name"];?>", "<?=$book["title"];?>", "<?=$book["text"];?>", "<?=$book["image"];?>")'><?=$langArray["readBook"];?></button></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div popover id="book" class="book">
            <form class="container" method="POST" action="/list.php?langID=<?=$lang?>&bookID=update">
                <h3><?=$langArray["readBook"];?></h3>
                <fieldset>
                    <div class="mb-3">
                        <label for="name"><?=$langArray["name"];?></label>
                        <input type="text" class="form-control" id="name" name="name" value="" autocomplete="name" placeholder="<?=$langArray["enterName"];?>">
                        <input type="hidden" class="form-control" id="id" name="id" value="" autocomplete="name" placeholder="<?=$langArray["enterName"];?>">
                    </div>
                    <div class="mb-3">
                        <label for="title"><?=$langArray["title"];?></label>
                        <input type="text" class="form-control" id="title" name="title" value="" autocomplete="title" placeholder="<?=$langArray["enterTitle"];?>">
                    </div>
                    <div class="mb-3">
                        <label for="text"><?=$langArray["text"];?></label>
                        <textarea rows="13" class="form-control" id="text" name="text" value="" autocomplete="text" placeholder="<?=$langArray["enterText"];?>"></textarea>
                    </div>
                    <div class="mb-3">
                        <img src="" id="image"/>
                    </div>
                </fieldset>
                <button class="btn btn-primary" name="editBook" id="editBook"><?=$langArray["editBook"];?></button>
            </form>
        </div>

<?php include("footer.php"); ?>
