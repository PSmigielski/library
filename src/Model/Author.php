<?php
namespace App\Model;

use DateTime;
use Exception;

class Author extends Dbh{
    private string $name;
    private string $surname;
    private DateTime|null $birthday = null;
    private string|null $bio = null;

    public function __construct(array $data=null)
    {
        if(!$data !== null){
            $this->name = $data["name"];
            $this->surname = $data["surname"];
            if(array_key_exists("bio", $data)){
                $this->bio = $data["bio"];
            }
            if (array_key_exists("birthday", $data)) {
                $this->birthday = $data["birthday"];
            }
        }
    }
    public static function validate(array $data): bool
    {
        $requiredKeys = ["surname", "name"];
        $optionalKeys = ["birthday", "bio"];
        foreach ($data as $key => $value) {
            if (array_search($key, $requiredKeys) === false && array_search($key, $optionalKeys) === false) {
                throw new Exception("additional data not allowed");
            }
            switch ($key) {
                case "name":
                case "surname":
                    if (strlen($value) > 60) {
                        throw new Exception("$key is too long");
                    }
                break;
                case "birthday":
                    if (!($value instanceof DateTime)) {
                        throw new Exception("invalid birthday");
                    }
                    break;
            }
            $index = array_search($key, $requiredKeys);
            if ($index !== false) {
                unset($requiredKeys[$index]);
            }
        }
        if (count($requiredKeys) != 0) {
            $requiredData = "";
            foreach ($requiredKeys as $value) {
                $requiredData = $requiredData . $value . " ";
            }
            throw new Exception("required data has not been passed: $requiredData");
        }
        return true;
    }
    public function create(): string
    {
        $sql = "INSERT INTO author(name,surname,birthday,bio) VALUES (?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $res = $stmt->execute([$this->name, $this->surname, $this->birthday->format("Y-m-d"), $this->bio]);
        if ($res === TRUE) {
            return "the author has been added";
        } else {
            return "the author hasn't been added";
        }
    }
    public function edit(string $authorId): string
    {
        try{
            $this->getAuthor($authorId);
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
        $sql = "UPDATE `author` SET `name`=? , `surname`=?, `birthday`=?, `bio`=? WHERE `id`=?";
        $stmt = $this->connect()->prepare($sql);
        $res = $stmt->execute([$this->name, $this->surname, $this->birthday->format("Y-m-d"), $this->bio, $authorId]);
        if ($res === TRUE) {
            return "the author has been edited";
        } else {
            return "the author hasn't been edited";
        }
    }
    public function getAuthor(string $authorId)
    {
        $sql = "SELECT * FROM `author` WHERE `id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$authorId]);
        $author = $stmt->fetch();
        if ($author === FALSE) {
            throw new Exception("author with this id does not exist");
        }
        return $author;
    }
    public function remove(string $authorId)
    {
        $sql = "DELETE FROM `author` WHERE `id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $res = $stmt->execute([$authorId]);
        return $res;
    }
    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getBio()
    {
        return $this->bio;
    }
}