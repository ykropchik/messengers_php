<?php
    class Message {
        private $id;
        private $author;
        private $timeCreate;
        private $text;

        public function __construct($author, $timeCreate, $text) {
            $this->author = $author;
            $this->timeCreate = $timeCreate;
            $this->text = $text;
        }

        public function getAuthor() {
            return $this->author;
        }

        public function getTimeCreate() {
            return $this->timeCreate;
        }

        public function getText() {
            return $this->text;
        }
    }

    class MessageMapper {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function saveMessage(Message $message) {
            $sqlReq = $this->db->prepare("INSERT INTO `messages` (`create_time`, `author`, `message`) VALUES (:time, :author, :message)");
            $sqlReq->execute(["time" => $message->getTimeCreate(), "author" => $message->getAuthor(), "message" => $message->getText()]);
        }

        public function removeMessage(Message $message) {
            $sqlReq = $this->db->prepare("DELETE * FROM `messages` WHERE `create_time` = :time AND `author` = :author AND `message` = :message");
            $sqlReq->execute(["time" => $message->getTimeCreate(), "author" => $message->getAuthor(), "message" => $message->getText()]);
        }

        public function getMessageById($id): Message {
            $sqlReq = $this->db->prepare("SELECT * FROM messages WHERE id= ?");
            $sqlReq->execute([$id]);
            $rows = $sqlReq->fetchAll();

            return new Message($rows["author"], $rows["create_time"]. $rows["message"]);
        }

        public function getAllMessages(): array {
            $sqlReq = $this->db->prepare("SELECT * FROM messages");
            $sqlReq->execute();
            $rows = $sqlReq->fetchAll();

            return $rows;
        }

        public function getMessageByField($field): array {
            
        }
    }
?>