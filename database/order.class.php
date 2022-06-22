<?php
  declare(strict_types = 1);
  require_once( __DIR__ . '/../database/dish.class.php');

  class Order {
    public int $id;
    public int $restaurantId;
    public string $restaurantName;
    public array $dishes;
    public string $state;
    public int $userId;


    public function __construct(int $id, int $restaurantId, array $dishes, string $state, int $userId, string $restaurantName)
    { 
      $this->id = $id;
      $this->restaurantId = $restaurantId;
      $this->dishes = $dishes;
      $this->state = $state;
      $this->userId = $userId;
      $this->restaurantName = $restaurantName;
    }

    static function getOrdersRestaurant(PDO $db, int $restaurantId){
      $stmt = $db->prepare('SELECT OrderId, RestaurantId, State, Orders.UserId, Name FROM Orders left join Restaurant using (RestaurantId)  where RestaurantId = ?');
      $stmt->execute(array($restaurantId));
  
      $orders = array();
      while ($order = $stmt->fetch()) {
        $stmt1 = $db->prepare('Select DishId From OrderDish Where OrderId = ?');
        $stmt1->execute(array(intval($order['OrderId'])));

        $dishIds = array();

        while($dishId = $stmt1->fetch()) {
          array_push($dishIds, intval($dishId['DishId']));
        }


        $orders[] = new Order(
          intval($order['OrderId']),
          intval($order['RestaurantId']),
          Dish::getDishesArrayIds($db,$dishIds),
          htmlentities($order['State']),      
          intval($order['UserId']),
          htmlentities($order['Name'])
        );
      }
  
      return $orders;
    }

    static function getOrdersUser(PDO $db, int $userId){
      $stmt = $db->prepare('SELECT OrderId, RestaurantId, State, Orders.UserId, Name FROM Orders left join Restaurant using (RestaurantId) where Orders.userId = ?');
      $stmt->execute(array($userId));
  
      $orders = array();
      while ($order = $stmt->fetch()) {
        $stmt1 = $db->prepare('Select DishId From OrderDish Where OrderId = ?');
        $stmt1->execute(array(intval($order['OrderId'])));

        $dishIds = array();

        while($dishId = $stmt1->fetch()) {
          array_push($dishIds, intval($dishId['DishId']));
        }


        $orders[] = new Order(
          intval($order['OrderId']),
          intval($order['RestaurantId']),
          Dish::getDishesArrayIds($db,$dishIds),
          htmlentities($order['State']),
          intval($order['UserId']),
          htmlentities($order['Name'])
        );
      }
  
      return $orders;
    }
    
    static function addOrder(PDO $db, int $RestaurantId, int $userId, string $state){
      $stmt = $db->prepare('INSERT INTO Orders (RestaurantId,State,UserId)Values(?,?,?)');
      try{
        $stmt->execute(array($RestaurantId,$state,$userId));
      }catch(PDOException $e){
        die('Location: index.php');
      }

      $stmt1 = $db->prepare('Select max(OrderId) From Orders Where RestaurantId = ?');
      $stmt1->execute(array($RestaurantId));

      $orderId = $stmt1->fetch();

      return $orderId;

    }

    static function addDishToOrder(PDO $db,int $orderId, int $dishId){
      $stmt = $db->prepare('INSERT INTO OrderDish (OrderId, DishId) VALUES(?,?)');
      $stmt->execute(array($orderId,$dishId));
    }

    static function getRestaurantName(int $RestaurantId):string {
      $stmt = $db->prepare('SELECT Name FROM Restaurant WHERE RestaurantId = ?');
      $stmt->execute(array($RestaurantId));
      $restaurant = $stmt->fetch;
      return $restaurant['Name'];
    }
  }
?>