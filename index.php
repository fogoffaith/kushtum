<?php 
include 'inc/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kucqit Yush-ya Maltum</title>
</head>

<body class="bg-dark text-white">
    <div class="px-4 pt-5 my-5 text-center border-bottom">
        <h1 class="display-4 fw-bold">Kucqit Yush-Ya Maltum</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Tempat Tercepat Untuk Melihat List kosakata, Kamus, dan belajar bahasa Kucqit serta
                terhubung dengan komunitas Kucqit</p>
            <br>
            <p>
                Cuma mau nyari kosakata? coba quick search dulu
            </p>
            <div class="gap-2 d-flex justify-content-sm-center mb-5">
                <div class="container py-5">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            <h1 class="text-center mb-4">Quick Search</h1>

                            <form method="GET" action="list.php">

                                <div class="mb-3">
                                    <label for="search-input" class="form-label">Masukkan kata</label>
                                    <input type="text" class="form-control bg-dark text-white border-secondary"
                                        id="search-input" name="keyword" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Cari Arti</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</body>

</html>

<?php 
include 'inc/footer.php';
?>