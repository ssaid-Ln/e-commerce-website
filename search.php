<?php
include 'dbcon.php';


$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';  
$search_results = [];

if ($search_query !== '') {
    $stmt = $con->prepare("SELECT name, price,url FROM products WHERE name LIKE ?");
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("s", $search_param);
    
   
    $stmt->execute();
    $result = $stmt->get_result();

   
    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
    }

    $stmt->close();
}


$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Said Ecommerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
  
  <!-- Include the navigation bar -->
  <?php include 'nav.php'; ?>

  <!-- Search Results -->
  <div class="container mt-4">
    <?php if ($search_query !== ''): ?>
      <h2 class="text-center">Search Results for: "<?php echo htmlspecialchars($search_query); ?>"</h2>

      <!-- If there are no results -->
      <?php if (empty($search_results)): ?>
        <p class="text-center">No products found matching your search.</p>
      <?php else: ?>
        <div class="row">
          <?php foreach ($search_results as $product): ?>
            <div class="col-md-4 mb-4">
              <div class="card">
                <img class="card-img-top" src="<?php echo htmlspecialchars($product['url']); ?>" alt="Product image">
                <div class="card-body">
                  <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                  <p class="card-text" style="color: red;"><b><?php echo htmlspecialchars($product['price']); ?>€</b></p>
                  <a href="#" class="btn btn-dark">Add To Cart</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <!-- Include the footer -->
  <?php include 'footer.php'; ?>

</body>
</html>
