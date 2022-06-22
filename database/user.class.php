<?php
  declare(strict_types = 1);

  class User {
    public int $id;
    public string $address;
    public string $phoneNumber;
    public string $email;
    public string $name;

    public function __construct(int $id, string $address, string $phoneNumber, string $email, string $name)
    { 
      $this->id = $id;
      $this->address = $address;
      $this->phoneNumber = $phoneNumber;
      $this->email = $email;
      $this->name = $name;
    }

    static function getUsers(PDO $db) : array {
      $stmt = $db->prepare('SELECT * FROM User');
      $stmt->execute();
  
      $users = array();
      while ($user = $stmt->fetch()) {
        $users[] = new User(
          intval($user['UserId']),
          htmlentities($user['Address']),
          htmlentities($user['PhoneNumber']),
          htmlentities($user['Email']),
          htmlentities($user['Name'])
        );
      }
  
      return $users;
    }

    static function getUserEmailPassword(PDO $db, string $email, string $password ){
      $stmt = $db->prepare('SELECT * FROM User WHERE lower(email) = ? ');
      $stmt->execute(array(strtolower($email)));

      if($user = $stmt->fetch()){
        if(!password_verify($password, $user['Password'])){
          return null;
        }
        if($user['Address'] == null){
          $address = "Address not registed";
        }else{
          $address = $user['Address'];
        }
        if($user['PhoneNumber'] == null){
          $phoneNumber = "Phone Number not registed";
        }else{
          $phoneNumber = $user['PhoneNumber'];
        }
        return new User(
          intval($user['UserId']),
          htmlentities($address),
          htmlentities($phoneNumber),
          htmlentities($user['Email']),
          htmlentities($user['Name'])
        );
      }else return null;
    }
    
    static function getUserById(PDO $db, int $id){
      $stmt = $db->prepare('SELECT * FROM User WHERE UserId = ?');
      $stmt->execute(array($id));
      

      if($user = $stmt->fetch()){
        if($user['Address'] == null){
          $address = "Address not registed";
        }else{
          $address = $user['Address'];
        }
        if($user['PhoneNumber'] == null){
          $phoneNumber = "Phone Number not registed";
        }else{
          $phoneNumber = $user['PhoneNumber'];
        }

        return new User(
          intval($user['UserId']),
          htmlentities($address),
          htmlentities($phoneNumber),
          htmlentities($user['Email']),
          htmlentities($user['Name'])
        );
      }else return null;
    }
  }
?>