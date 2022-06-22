<?php
  declare(strict_types = 1);

  class Review {
    public int $id;
    public int $restaurantId;
    public int $score;
    public string $comment;
    public string $userName;
    public string $answer;


    public function __construct(int $id, int $restaurantId, int $score, string $comment, string $userName, string $answer)
    { 
      $this->id = $id;
      $this->restaurantId = $restaurantId;
      $this->score = $score;
      $this->comment = $comment;
      $this->userName = $userName;
      $this->answer = $answer;
    }


    static function getReview(PDO $db, int $RestaurantId) : array {
  
      $stmt = $db->prepare('Select ReviewId, Name,Comment,Score From Review, User Where Review.UserId = User.UserId AND Review.RestaurantId = ?');
      $stmt->execute(array($RestaurantId));
    
  
      $reviews = array();
        while ($review = $stmt->fetch()) {
          $stmt1 = $db->prepare('Select Answer From Answers Where Answers.ReviewId = ? AND Answers.RestaurantId = ?');
          $stmt1->execute(array(intval($review['ReviewId']), $RestaurantId));  
          
          if($answerQuery = $stmt1->fetch()){
            $answer = strval($answerQuery['Answer']);
          }else {
            $answer = "";
          }

          $reviews[] = new Review(
            intval($review['ReviewId']),
            $RestaurantId,
            intval($review['Score']),
            htmlentities($review['Comment']),
            htmlentities($review['Name']),
            htmlentities($answer),
          );
        }
      return $reviews;  
    }
  }
?>