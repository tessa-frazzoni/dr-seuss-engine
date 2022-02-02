<?php 
  require_once "db.php";

  if (isset($_POST['book_title'])) {
    $sql = "UPDATE books SET 
            book_title = :book_title,
            book_title_sort = :book_title_sort,
            book_year = :book_year,
            book_description = :book_description,
            book_pages = :book_pages,
            category_id = :category_id
            WHERE book_id = :book_id";

    $stmt = $db->prepare($sql);
    $stmt->execute([
      ":book_title" => $_POST['book_title'],
      ":book_title_sort" => $_POST['book_title_sort'],
      ":book_year" => $_POST['book_year'],
      ":book_description" => $_POST['book_description'],
      ":book_pages" => $_POST['book_pages'],
      ":category_id" => $_POST['category_id'],
      ":book_id" => $_POST['book_id']
    ]);

    if($stmt->rowCount()) {
      header("Location: book.php?id={$_POST['book_id']}");
    }
  }


  $sql = "SELECT * FROM categories";
  $result = $db->query($sql);
  $categories = $result->fetchAll();

  if (isset($_GET['id'])) {
    $sql = "SELECT * FROM books WHERE book_id = :book_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':book_id', $_GET['id']);
    $stmt->execute();
    $book = $stmt->fetch();

  } else {
    header("Location: index.php");
  }
 ?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Book</title>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap" rel="stylesheet">
</head>
<body>
  <main class="main">
    <?php include 'header.php'; ?>
    <h1 class="title">Edit Book</h2>
    <form class="form edit-form" method="post">
        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
        <input type="text" class="form-control" name="book_title" placeholder="Book Title" required value="<?php echo $book['book_title']; ?>">
        <input type="text" class="form-control" name="book_title_sort" placeholder="Sort Title" value="<?php echo $book['book_title_sort']; ?>">
        <input type="number" class="form-control" name="book_year" placeholder="Published Year" required value="<?php echo $book['book_year']; ?>">
        <input type="text" class="form-control" name="book_description" placeholder="Book Description" required value="<?php echo $book['book_description']; ?>">
        <input type="number" class="form-control" name="book_pages" placeholder="Number of Pages" value="<?php echo $book['book_pages']; ?>">
        <select class="form-control" name="category_id">
          <?php foreach ($categories as $category) : ?>
            <?php if ($category['category_id'] === $book['category_id']) : ?>
              <option value="<?php echo $category['category_id']; ?>" selected><?php echo $category['category_name']; ?></option>
            <?php else : ?>
              <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="button">Update Book</button>
    </form>
    <form class="form delete-form" method="post" action="delete.php">
      <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
      <button type="submit" class="button danger">Delete Book</button>
    </form>
  </main>
</body>
</html>