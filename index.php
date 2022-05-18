<?php
require __DIR__ . "/Config/bootstrap.php";
require __DIR__ . "/Model/Book.php";

use App\Model\Book;

try {
    $data = [
        "title" => "asdasdfasdfasdfasdf",
        "publication_date" => new DateTime("now"),
        "publisher" => "afffasfasdf",
        "pages" => 123,
        "isbn" => "1231231231233",
        "authorId" => "6402c05f-d6ae-11ec-8825-0242ac140002"
    ];
    $validationRes = Book::validate($data);
    $book = new Book($data);
    print($book->edit("f73c5638-d6b7-11ec-8825-0242ac140002"));
    $book = new Book();
    $books = $book->fetchAll(1);
    $book1 = $book->show("f73c5638-d6b7-11ec-8825-0242ac140002");
} catch (Exception $e) {
    print($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <pre><?php print_r($books); ?></pre>
    <pre><?php print_r($book1); ?></pre>
    <pre><?php print_r($book->remove("756b7858-d6cb-11ec-8825-0242ac140001")); ?></pre>
</body>

</html>