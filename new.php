<?php 
  require_once "db.php";

  $sql = "SELECT * FROM categories";
  $result = $db->query($sql);
  $categories = $result->fetchAll();

  if (isset($_POST['book_title'])) {
    $sql = "INSERT INTO books (book_title, book_title_sort, book_year, book_description, book_pages, category_id) VALUES (:book_title, :book_title_sort, :book_year, :book_description, :book_pages, :category_id)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
      ":book_title" => $_POST['book_title'],
      ":book_title_sort" => $_POST['book_title_sort'],
      ":book_year" => $_POST['book_year'],
      ":book_description" => $_POST['book_description'],
      ":book_pages" => $_POST['book_pages'],
      ":category_id" => $_POST['category_id']
    ]);

    if ($stmt->rowCount()) {
      header("Location: book.php?id={$db->lastInsertId()}");
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Book</title>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap" rel="stylesheet">
</head>
<body>
  <main class="main">
    <?php include 'header.php'; ?>
    <h1 class="title">New Book</h2>
    <form class="form edit-form" method="post">
      <input type="text" class="form-control" name="book_title" placeholder="Book Title" required>
      <input type="text" class="form-control" name="book_title_sort" placeholder="Sort Title">
      <input type="number" class="form-control" name="book_year" placeholder="Published Year" required>
      <input type="text" class="form-control" name="book_description" placeholder="Book Description" required>
      <input type="number" class="form-control" name="book_pages" placeholder="Number of Pages">
      <select class="form-control" name="category_id">
        <?php foreach ($categories as $category) : ?>
          <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="button">Add Book</button>
    </form> 
  </main>
</body>
</html>