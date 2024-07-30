<?php
require_once ('vendor/autoload.php');
use \Dejurin\GoogleTranslateForFree;

$DB = mysqli_connect("localhost", "root", "", "rocket");
mysqli_set_charset($DB, "utf8mb4");

$name = "";
$title = "";
$order = "";
$sort = "";

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

$books = mysqli_fetch_all($books, MYSQLI_ASSOC);

if(isset($_POST['name']) && isset($_POST['title']) && isset($_POST['text'])){
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

    mysqli_query($DB, "INSERT INTO `book`(`name`, `title`, `name_eng`, `title_eng`, `text`) VALUES ('$newName', '$newTitle', '$name', '$title', '$newText')"); 

    $books = mysqli_query($DB, "SELECT * FROM `book`");
    $books = mysqli_fetch_all($books, MYSQLI_ASSOC);

}

if(isset($_POST['bookname'])){
    $bookname = trim($_POST['bookname']);
    if($bookname=="")
        $books = mysqli_query($DB, "SELECT * FROM `book`");
    else
        $books = mysqli_query($DB, "SELECT * FROM `book` WHERE `name` LIKE '%$bookname%'");
    $books = mysqli_fetch_all($books, MYSQLI_ASSOC);
}
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
                    <td><button popovertarget="book" class="btn btn-primary" name="readBook" id="readBook" onclick='showRead("<?=$book["name"];?>", "<?=$book["title"];?>", "<?=$book["text"];?>")'><?=$langArray["readBook"];?></button></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div popover id="book" class="book">
            <form class="container">
                <h3><?=$langArray["readBook"];?></h3>
                <fieldset>
                    <div class="mb-3">
                        <label for="name"><?=$langArray["name"];?></label>
                        <input disabled type="text" class="form-control" id="name" name="name" value="" autocomplete="name" placeholder="<?=$langArray["enterName"];?>">
                    </div>
                    <div class="mb-3">
                        <label for="title"><?=$langArray["title"];?></label>
                        <input disabled type="text" class="form-control" id="title" name="title" value="" autocomplete="title" placeholder="<?=$langArray["enterTitle"];?>">
                    </div>
                    <div class="mb-3">
                        <label for="text"><?=$langArray["text"];?></label>
                        <textarea rows="13" disabled class="form-control" id="text" name="text" value="" autocomplete="text" placeholder="<?=$langArray["enterText"];?>">
                    </div>
                </fieldset>
            </form>
        </div>

<?php include("footer.php"); ?>
