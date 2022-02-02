<?php
  require_once "db.php";
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM books WHERE book_title LIKE :search ORDER BY book_title_sort ASC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':search', "%{$_GET['search']}%");
    $stmt->execute();
    $books = $stmt->fetchAll();
  } else {
    $sql = "SELECT * FROM books";
    $result = $db->query($sql);
    $books = $result->fetchAll();
    sort($books);
  }  
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seussology</title>
  <link rel="stylesheet" href="./style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap" rel="stylesheet">
</head>
<body>
  <main class="main">
    <?php include 'header.php'; ?>
    <h1 class="title">Books</h1>
    <form class="form">
      <input type="search" class="form-control" name="search" placeholder="Search">
    </form>
    <section class="books">
      <?php foreach ($books as $book) : ?>
        <a class="book" href="book.php?id=<?php echo $book['book_id']; ?>">
        
          <?php if ($book['book_image'] === $book['book_id']) : ?>
          <image class="book-about-covers"  src="/book-covers/<?php echo $book['book_image']?>"></image>
            sort($books);
            <?php else : ?>
            <?php echo $book['book_title']; ?>
            <?php endif; ?>
          </a>
          
      <?php endforeach; ?>
    </section>
  </main>
</body>
</html>