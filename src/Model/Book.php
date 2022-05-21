<?php

namespace App\Model;

use App\Enum\Genre;
use App\Model\Dbh;
use DateTime;
use Exception;
use ValueError;

class Book extends Dbh
{
    private string $title;
    private DateTime $publication_date;
    private string $publisher;
    private string|NULL $language;
    private int $pages;
    private string $isbn;
    private string $genre;
    private string $authorId;
    public function __construct(array $data = null)
    {
        if (!is_null($data)) {
            try{
                $this->validate($data);
            } catch (Exception $e){
                throw new Exception($e->getMessage());
            }
            $this->title = $data["title"];
            $this->publication_date = $data["publication_date"];
            $this->publisher = $data["publisher"];
            $this->language = $data["language"];
            $this->pages = $data["pages"];
            $this->isbn = $data["isbn"];
            $this->genre = $data["genre"];
            $this->authorId = $data["authorId"];
        }
    }
    protected function create(): string
    {
        $sql = "INSERT INTO book(bo_title,bo_publication_date,bo_publisher,bo_language,bo_pages,bo_isbn,bo_author_id,bo_genre) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $res = $stmt->execute([$this->title, $this->publication_date->format("Y-m-d"), $this->publisher, $this->language, $this->pages, $this->isbn, $this->authorId, $this->genre]);
        if ($res === TRUE) {
            return "the book has been added";
        } else {
            return "the book hasn't been added";
        }
    }
    protected function edit(string $bookId): string
    {
        $book = $this->getBook($bookId);

        $sql = "UPDATE `book` SET `bo_title`=? , `bo_publication_date`=?, `bo_publisher`=?, `bo_language`=?, `bo_pages`=?, `bo_isbn`=?, `bo_author_id`=?, `bo_genre`=? WHERE `bo_id`=?";
        $stmt = $this->connect()->prepare($sql);
        $res = $stmt->execute([$this->title, $this->publication_date->format("Y-m-d"), $this->publisher, $this->language, $this->pages, $this->isbn, $this->authorId, $this->genre,$bookId]);
        if ($res === TRUE) {
            return "the book has been added";
        } else {
            return "the book hasn't been added";
        }
    }
    private static function validate(array $data): bool
    {
        $requiredKeys = ["title", "publication_date", "publisher", "pages", "isbn", "authorId", "genre"];
        $optionalKeys = ["language"];
        foreach ($data as $key => $value) {
            if(array_search($key, $requiredKeys) === false && array_search($key, $optionalKeys) === false){
                throw new Exception("additional data not allowed");
            }
            switch($key){
                case "title":
                    if (strlen($value) > 150) {
                        throw new Exception("title is too long");
                    }
                    break;
                case "publication_date":
                    if (!($value instanceof DateTime)) {
                        throw new Exception("invalid publication_date");
                    }
                    break;
                case "publisher":
                    if (strlen($value) > 70) {
                        throw new Exception("publisher is too long");
                    }
                    break;
                case "pages":
                    if ($value > 20000) {
                        throw new Exception("invalid page number");
                    }
                    break;
                case "isbn":
                    if (strlen($value) !== 13) {
                        throw new Exception("invalid isbn");
                    }
                    break;
                case "authorId":
                    if (strlen($value) !== 36) {
                        throw new Exception("invalid authorId format");
                    }
                    break;
                case "genre":
                    try{
                        Genre::from($value);
                    }catch(ValueError $e){
                        throw new Exception("invalid genre name");
                    }
                    break;
                case "language":
                    if (!is_null($value)) {
                        if (strlen($value) > 20) {
                            throw new Exception("invalid language length");
                        }
                    }
                    break;
            }
            $index = array_search($key, $requiredKeys);
            if($index !== false){
                unset($requiredKeys[$index]);
            }
        }
        if(count($requiredKeys)!=0){
            $requiredData = "";
            foreach($requiredKeys as $value){
                $requiredData = $requiredData.$value." ";
            }
            throw new Exception("required data has not been passed: $requiredData");
        }
        return true;
    }
    private function count(): int
    {
        $sql = "SELECT COUNT(`bo_id`) as `count` FROM `book`";
        $res = $this->connect()->query($sql);
        return $res->fetch()["count"];
    }
    protected function getBooks(int $page = 1, int $limit = 30)
    {
        $count = $this->count();
        $totalPages = ceil($count / $limit);
        if ($page > $totalPages) {
            throw new Exception("page overflow");
        }
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM `book` INNER JOIN `author` ON `book`.`bo_author_id`=`author`.`au_id` LIMIT $limit OFFSET $offset";
        $res = $this->connect()->query($sql);
        return [
            "books" => $res->fetchAll(),
            "page" => $page,
            "totalPages" => $totalPages,
            "count" => $count
        ];
    }
    protected function getBook(string $bookId)
    {
        $sql = "SELECT * FROM `book` INNER JOIN `author` ON `book`.`bo_author_id`=`author`.`au_id` WHERE `bo_id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$bookId]);
        $book = $stmt->fetch();
        if ($book === FALSE) {
            throw new Exception("book with this id does not exist");
        }
        return $book;
    }
    protected function remove(string $bookId)
    {
        $sql = "DELETE FROM `book` WHERE `bo_id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $res = $stmt->execute([$bookId]);
        return $res;
    }
}
