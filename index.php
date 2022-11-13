<?php 
  
 date_default_timezone_set("Asia/Tokyo");

  $comment_array = array();
  $pdo = null;
  $stmt = null;
  $error_messages = array();

  try {
    $pdo = new PDO('mysql:host=localhost;dbname=bbs', "root", "");
  }catch(PDOException $e){
    echo $e->getMessage();
  }

  if(empty($_POST["username"])){
    // echo"名前を入力してください";
    $error_messages ["username"]= "名前を入力してください";
    }

  if(empty($_POST["comment"])){
    // echo"コメントを入力してください";
    $error_messages ["comment"]= "コメントを入力してください";
  }


     if(!empty($_POST["submitButton"])){
    
    if(empty($error_messages)){
      $postDate = date("y-m-d H:i:s");

      try{
        $stmt = $pdo->prepare("INSERT INTO `bbs-table` (`username` , `comment` , `postDate`) Value(:username , :comment , :postDate)");
        $stmt->bindParam(':username', $_POST["username"], PDO::PARAM_STR);
        $stmt->bindParam(':comment', $_POST["comment"],PDO::PARAM_STR);
        $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);
       
        $stmt->execute();
       } catch (PDOException $e){
          echo $e->getMessage();
       }
    }
   
     }
 
  
  
  $sql="SELECT `id`, `username`, `comment`, `postDate` FROM `bbs-table`;";
  $comment_array = $pdo->query($sql);

  $pdo = null;


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掲示板</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1 class="title">掲示板</h1>
  <hr>
  <div class="boardWrapper">
    <section>
      <?php foreach($comment_array as $comment): ?>
      <article>
        <div class="Wrapper">
          <div class="nameArea">
            <span>名前：</span>
            <p class="username"><?php echo $comment["username"]; ?></p>
            <time>:<?php echo $comment["postDate"]; ?></time>
          </div>
          <p class="comment"><?php echo $comment["comment"]; ?></p>
        </div>
      </article>
      <?php endforeach;?>
    </section>
    <form class="formWrapper" method="POST">
       <div>
            <input type="submit" value="入力" name="submitButton">
            <label for="">名前：</label>
            <input type="text" name="username">
       </div>
       <div>
        <textarea class="commentTextArea" name="comment"></textarea>
       </div>

    </form>

</body>
</html>
