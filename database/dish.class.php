<?php
  declare(strict_types = 1);

  class Dish {
    public int $id;
    public string $name;
    public float $price;
    public int $restaurantId;

    public function __construct(int $id, string $name, float $price, int $restaurantId)
    { 
      $this->id = $id;
      $this->name = $name;
      $this->price = $price;
      $this->restaurantId = $restaurantId;
    }

    static function getDishes(PDO $db, int $id) : array {
      $stmt = $db->prepare('SELECT * FROM Dishes WHERE Dishes.RestaurantId = ?');
      $stmt->execute(array($id));
      
      $dishes = array();

      while($dish = $stmt->fetch()){
        $dishes[] = new Dish(
          intval($dish['DishId']),
          htmlentities($dish['Name']),
          floatval(htmlentities(strval($dish['Price']))),
          intval($dish['RestaurantId'])
        );
      }

      return $dishes;
    }
    
    static function removeDish(PDO $db, int $dishId){
      $stmt = $db->prepare('Delete From Dishes WHERE Dishes.DishId = ?');
      $stmt->execute(array($dishId));
    }

    static function favoriteDish(PDO $db, int $dishId, int $userId){
      $stmt = $db->prepare('Insert into FavoriteDish (DishId, UserId) Values(?,?)');
      try{
        $stmt->execute(array($dishId,$userId));
      }catch(PDOException $e) {
        //Tentar dar favorito a um restaurant que já deu
      }
    }

    static function removeFavoriteDish(PDO $db, int $dishId, int $userId){
      $stmt = $db->prepare('Delete From FavoriteDish Where DishId = ? AND UserId = ?');
      $stmt->execute(array($dishId,$userId));
    }

    static function searchDishes(PDO $db, int $userId){
      $stmt = $db->prepare('SELECT * FROM Dishes,FavoriteDish WHERE Dishes.DishId = FavoriteDish.DishId AND 
      FavoriteDish.UserId = ?');
      $stmt->execute(array($userId));
      
      $dishes = array();

      while($dish = $stmt->fetch()){
        $dishes[] = new Dish(
          intval($dish['DishId']),
          htmlentities($dish['Name']),
          floatval(htmlentities(strval($dish['Price']))),
          intval($dish['RestaurantId'])
        );
      }

      return $dishes;
    }

    static function getDishesArrayIds(PDO $db, array $dishesId){
      $dishes = array();
      foreach($dishesId as $dishId){

        $stmt = $db->prepare('SELECT * FROM Dishes WHERE Dishes.DishId = ?');
        $stmt->execute(array($dishId));
      
        $dish = $stmt->fetch();

        if($dish != null){
          array_push($dishes,  new Dish(
            intval($dish['DishId']),
            htmlentities($dish['Name']),
            floatval(htmlentities(strval($dish['Price']))),
            intval($dish['RestaurantId'])
            )
          );
        }
      }
      return $dishes;
    }
  }   
?>