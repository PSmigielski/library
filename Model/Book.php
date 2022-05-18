<?php

namespace App\Model;

require PROJECT_ROOT_PATH . "/Model/Dbh.php";

use App\Model\Dbh;
use DateTime;
use Exception;

class Book extends Dbh
{
    private string $title;
    private DateTime $publication_date;
    private string $publisher;
    private string|NULL $language;
    private int $pages;
    private string $isbn;
    private string $authorId;
    public function __construct(array $data = null)
    {
        if (!is_null($data)) {
            $this->title = $data["title"];
            $this->publication_date = $data["publication_date"];
            $this->publisher = $data["publisher"];
            $this->language = $data["language"];
            $this->pages = $data["pages"];
            $this->isbn = $data["isbn"];
            $this->authorId = $data["authorId"];
        }
    }
    public function create(): string
    {
        $sql = "INSERT INTO book(bo_title,bo_publication_date,bo_publisher,bo_language,bo_pages,bo_isbn,bo_author_id) VALUES (?,?,?,?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $res = $stmt->execute([$this->title, $this->publication_date->format("Y-m-d"), $this->publisher, $this->language, $this->pages, $this->isbn, $this->authorId]);
        if ($res === TRUE) {
            return "the book has been added";
        } else {
            return "the book hasn't been added";
        }
    }
    public function edit(string $bookId): string
    {
        $book = $this->show($bookId);
        $sql = "UPDATE `book` SET `bo_title`=? , `bo_publication_date`=?, `bo_publisher`=?, `bo_language`=?, `bo_pages`=?, `bo_isbn`=?, `bo_author_id`=? WHERE `bo_id`=?";
        $stmt = $this->connect()->prepare($sql);
        $res = $stmt->execute([$this->title, $this->publication_date->format("Y-m-d"), $this->publisher, $this->language, $this->pages, $this->isbn, $this->authorId, $bookId]);
        if ($res === TRUE) {
            return "the book has been added";
        } else {
            return "the book hasn't been added";
        }
    }
    public static function validate(array $data): bool
    {
        if (strlen($data["title"]) > 150) {
            throw new Exception("invalid title");
        }
        if (strlen($data["publisher"]) > 70) {
            throw new Exception("invalid publisher");
        }
        if ($data["pages"] > 20000) {
            throw new Exception("invalid page number");
        }
        if (!($data["publication_date"] instanceof DateTime)) {
            throw new Exception("invalid publication_date");
        }
        if (strlen($data["isbn"]) !== 13) {
            throw new Exception("invalid isbn");
        }
        if (strlen($data["authorId"]) !== 36) {
            throw new Exception("invalid authorId format");
        }
        if (!is_null($data["language"])) {
            if (strlen($data["language"]) > 20) {
                throw new Exception("invalid language length");
            }
        }
        return true;
    }
    private function count(): int
    {
        $sql = "SELECT COUNT(`bo_id`) as `count` FROM `book`";
        $res = $this->connect()->query($sql);
        return $res->fetch()["count"];
    }
    public function fetchAll(int $page = 1, int $limit = 30)
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
    public function show(string $bookId)
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
    public function remove(string $bookId)
    {
        $sql = "DELETE FROM `book` WHERE `bo_id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $res = $stmt->execute([$bookId]);
        return $res;
    }
}
