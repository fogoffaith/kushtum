<?php

include 'inc/header.php';
require 'inc/function.php'
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kamus Kucqit - Indonesia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <h1 class="text-center mb-4">Kamus Kucqit ⇄ Indonesia</h1>

        <form method="GET" action="">
          <div class="mb-3">
            <label for="direction" class="form-label">Arah Pencarian</label>
            <select class="form-select bg-dark text-white border-secondary" id="direction" name="direction">
              <option value="indo" <?php echo (isset($_GET['direction']) && $_GET['direction'] == 'indo') ? 'selected' : ''; ?>>Bahasa Indonesia → Kucqit</option>
              <option value="kucqit" <?php echo (isset($_GET['direction']) && $_GET['direction'] == 'kucqit') ? 'selected' : ''; ?>>Bahasa Kucqit → Indonesia</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="search-input" class="form-label">Masukkan kata</label>
            <input type="text" class="form-control bg-dark text-white border-secondary" id="search-input" name="keyword" required value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Cari Arti</button>
          </div>
        </form>

        <?php
            $keyword = trim($_GET['keyword']);
            $direction = $_GET['direction'];

            hasilSearching($keyword, $direction);
        ?>

      </div>
    </div>
  </div>

  <footer>
    <?php include 'inc/footer.php'; ?>
  </footer>

</body>
</html>