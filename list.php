<?php
include 'inc/header.php';
require 'inc/function.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Kosakata Bahasa Kucqit</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

 <div class="container py-4">
   <h1 class="text-center mb-4">Kosakata Bahasa Kucqit</h1>

   <div class="mb-5 text-center">
     <form action="" method="get" class="d-inline-flex gap-2">
       <input type="text" name="keyword" class="form-control bg-dark text-white border-secondary" style="max-width: 240px;" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
       <button type="submit" class="btn btn-primary">Cari</button>
     </form>
   </div>

   <?php displayKosakataList(); ?>

 </div>

</body>
</html>