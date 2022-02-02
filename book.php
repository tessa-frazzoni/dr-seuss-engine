<?php 
  require_once "db.php";

  if (isset($_GET['id'])) {
    $sql = "SELECT * FROM books WHERE book_id = :book_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':book_id', $_GET['id']);
    $stmt->execute();
    $book = $stmt->fetch();

    $sql = "SELECT quote FROM quotes WHERE book_id = {$book['book_id']}";
    $stmt = $db->prepare($sql);
    $result = $db->query($sql);
    $quote = $result->fetch();

    $sql = "SELECT category_name FROM categories WHERE category_id = {$book['category_id']}";
    $result = $db->query($sql);
    $category = $result->fetch();
  } else {
    header("Location: index.php");
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $book['book_title']?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="main">
    <?php include 'header.php'; ?>
    <h1 class="title"><?php echo $book['book_title']?></h1>
    <a class="book-edit" href="edit.php?id=<?php echo $book['book_id']; ?>">Edit</a>
    <section class="book-details">
      <div class="images">
        <img class="book-details-image" src="/book-covers/<?php echo $book['book_image']?>"></img>
      </div>  
      <div class="book-details-content">
      
        <h2 class="book-details-title">About the Book</h2> 
        <p><?php echo $book['book_description']?></p>
        <div class="book-details-stats"> 
          <span>Published: <?php echo $book['book_year']?></span>
          <span>Pages: <?php echo $book['book_pages']?></span>
          <span><?php echo $category['category_name']?></span>
        </div> 
        <h3 class="book-details-title">Book Quotes</h3>
        <div class="book-details-quotes">
          <blockquote class="book-details-quote"><?php echo $quote['quote']?></blockquote>
        </div>     
      </div>
      
    </section>
  </main>
</body>
</html>