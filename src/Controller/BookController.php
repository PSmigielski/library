<?php
namespace App\Controller;
use App\Model\Book;
use DateTime;
use Exception;

class BookController{
    public function createBook(string $title, 
        DateTime $publication_date, 
        string $publisher, 
        int $pages,
        string $isbn, 
        string $genre,
        string $authorId, 
        string|null $language = null){
        $data = [
            "title" => $title,
            "publication_date" => $publication_date,
            "publisher" => $publisher,
            "pages" => $pages,
            "isbn" => $isbn,
            "genre" => $genre,
            "authorId" => $authorId,
        ];
        if($language !== null){
            $data["language"] = $language;
        }
        try{
            Book::validate($data);
            $book = new Book($data);
            $res = $book->create();
            return $res;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function getBook(string $bookId){
        try{
            $bookObj  = new Book();
            $book = $bookObj->getBook($bookId);
            return $book;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
