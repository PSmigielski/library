<?php

namespace App\View;

use App\Model\Book;

class BookView
{
    public function showBook(Book $book){
        $title = $book->getTitle();
        $author = $book->getAuthorId();
        $publisher = $book->getPublisher();
        $publicationDate = $book->getPublicationDate()->format("Y-m-d");
        $genre = $book->getGenre();
        $isbn = $book->getIsbn();
        $pages = $book->getPages();
        return "
        <div class=\"book\">
            <h3>$title</h3>
            <p>$genre</p>
            <p>$author</p>
            <p>$publisher</p>
            <p>$publicationDate</p>
            <p>$isbn</p>
            <p>$pages</p>
        </div>";
    }   
}
