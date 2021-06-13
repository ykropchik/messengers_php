<?php
    class User {
        private $login;
        private $password;

        public function __construct($login, $password) {
            $this->login = $login;
            $this->password = $password;
        }

        public function getLogin() {
            return $this->login;
        }

        public function getPassword() {
            return $this->password;
        }

        public function save($db) {
            $sqlReq = $db->prepare("INSERT INTO `users` (`login`, `password`) VALUES (:login, :password)");
            $sqlReq->execute(["login" => $this->login, "password" => $this->password]);
        } 

        public function remove($db) {
            $sqlReq = $db->prepare("DELETE FROM `users` WHERE `login` = :login AND `password` = :password)");
            $sqlReq->execute(["login" => $this->login, "password" => $this->password]);
        }

        public function getByLogin($login, $db) {
            $sqlReq = $db->prepare("SELECT * FROM users WHERE `login` = ?");
            $sqlReq->execute([$login]);
            $rows = $sqlReq->fetchAll();
            
            if (count($rows) != 0) {
                return new User($rows[0]["login"], $rows[0]["password"]);
            } else {
                return new User();
            }
        }

        public function all($db): array {
            $sqlReq = $db->prepare("SELECT * FROM users");
            $sqlReq->execute();
            $rows = $sqlReq->fetchAll();
            return $rows;
        }

        public function getByField($field, $db): array {
            $strField = (string)$field;
            $sqlReq = $db->prepare("SELECT $strField FROM users");
            $sqlReq->execute();
            $rows = $sqlReq->fetchAll();
            return $rows;
        }
    }

?>

