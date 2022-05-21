<?php

use App\Controller\BookController;
use App\Model\Book;
use App\View\BookView;

require __DIR__ . "/src/Config/bootstrap.php";
require_once realpath("vendor/autoload.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./src/style/index.css" />
        <title>Document</title>
    </head>
    <body>
        <?php
            $bookController = new BookController();
            $bookView = new BookView();
            $bookData = $bookController->getBook("9ac40786-d91c-11ec-9cf3-0242ac140002");
            $bookData["publication_date"] = new DateTime($bookData["publication_date"]);
            $book = new Book($bookData);
            print($bookView->showBook($book));
        ?>
    </body>
</html>