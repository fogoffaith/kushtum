<?php 

include 'inc/header.php'; 
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
            <input type="text" class="form-control bg-dark text-white border-secondary" id="search-input" name="keyword" required value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Cari Arti</button>
          </div>
        </form>

        <?php
        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keyword = trim($_GET['keyword']);
            $direction = $_GET['direction'] ?? 'indo';

            $searchTerm = '%' . strtolower($keyword) . '%';

            if ($direction === 'indo') {
                $sql = "
                    SELECT kata, arti, kategori, konteks 
                    FROM kamus_bahasa 
                    WHERE LOWER(arti) LIKE ? 
                    OR LOWER(kata) LIKE ?
                    LIMIT 10
                ";
            } else {
                $sql = "
                    SELECT kata, arti, kategori, konteks 
                    FROM kamus_bahasa 
                    WHERE LOWER(kata) LIKE ? 
                    OR LOWER(arti) LIKE ?
                    LIMIT 10
                ";
            }

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $searchTerm, $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<div class="mt-5">';
                echo '<h2 class="h4">Hasil Pencarian</h2>';

                while ($row = $result->fetch_assoc()) {
                    echo '<div class="bg-secondary p-4 rounded mb-3">';
                    echo '<h3 class="h5 mb-2">' . ($row['kata']) . '</h3>';
                    echo '<p class="mb-1"><strong>Bahasa Indonesia:</strong> ' . ($row['arti']) . '</p>';
                    echo '<p class="mb-1"><strong>Kategori:</strong> ' . ($row['kategori']) . '</p>';
                    if (!empty($row['konteks'])) {
                        echo '<p class="mb-0"><strong>Konteks:</strong> ' . ($row['konteks']) . '</p>';
                    }
                    echo '</div>';
                }

                echo '</div>';
            } else {
                echo '<div class="mt-5 alert alert-warning">Tidak ditemukan hasil untuk "<strong>' . $keyword . '</strong>"</div>';
            }

            $stmt->close();
            $conn->close();

        } else {
            echo '<div class="mt-5">';
            echo '<h2 class="h4">Hasil Pencarian</h2>';
            echo '<div class="bg-secondary p-4 rounded">';
            echo '<p class="mb-0">Masukkan kata di atas dan klik "Cari Arti" untuk melihat hasil.</p>';
            echo '</div>';
            echo '</div>';
        }
        ?>

      </div>
    </div>
  </div>

  <footer>
    <?php include 'inc/footer.php'; ?>
  </footer>

</body>
</html>


<?php

include 'inc/header.php';

$SusunanAbjad = [
    'A', 'B', 'Ş', 'G', 'D', 'V', 'C', 'Ḫ', 'Z', 'H', 'R', 'J', 'Q', 'K', 'L', 'N', 'F', 'M', 'T', 'W', 'Ñ', 'P', 'S', 'Y', 'Ŝ', 'G̈', 'X'
];

$sql = "SELECT kata, arti FROM kamus_bahasa ORDER BY kata ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$hurufhuruf = $result->fetch_all(MYSQLI_ASSOC);

$SusunanHuruf = [];
foreach ($SusunanAbjad as $letter) {
    $SusunanHuruf[$letter] = [];
}

foreach ($hurufhuruf as $huruf) {
    $HurufPertama = mb_substr($huruf['kata'], 0, 1);
    foreach ($SusunanAbjad as $letter) {
        if ($HurufPertama === $letter) {
            $SusunanHuruf[$letter][] = $huruf;
            break;
        }
    }
}

$stmt->close();
$conn->close();
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
       <input type="text" name="keyword" class="form-control bg-dark text-white border-secondary" style="max-width: 240px;" value="">
       <button type="submit" class="btn btn-primary">Cari</button>
     </form>
   </div>

   <?php foreach ($SusunanAbjad as $letter): ?>
     <?php if (!empty($SusunanHuruf[$letter])): ?>
       <div class="mb-4" id="section-<?php echo $letter; ?>">
         <h2 class="h3 bg-secondary p-2 rounded"><?php echo htmlspecialchars($letter); ?></h2>
         <div class="d-flex flex-column gap-2 mt-2">
           <?php foreach ($SusunanHuruf[$letter] as $huruf): ?>
             <div class="d-flex justify-content-between border-bottom pb-2 border-secondary">
               <span><?php echo htmlspecialchars($huruf['kata']); ?></span>
               <span><?php echo htmlspecialchars($huruf['arti']); ?></span>
             </div>
           <?php endforeach; ?>
         </div>
       </div>
     <?php endif; ?>
   <?php endforeach; ?>

 </div>

</body>
</html>

<?php

function getKosakataByLetter() {
    global $conn;

    $SusunanAbjad = [
        'A', 'B', 'Ş', 'G', 'D', 'V', 'C', 'Ḫ', 'Z', 'H', 'R', 'J', 'Q', 'K', 'L', 'N', 'F', 'M', 'T', 'W', 'Ñ', 'P', 'S', 'Y', 'Ŝ', 'G̈', 'X'
    ];

    $sql = "SELECT kata, arti FROM kamus_bahasa ORDER BY kata ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $listKata = $result->fetch_all(MYSQLI_ASSOC);

    $SusunanHuruf = [];
    foreach ($SusunanAbjad as $letter) {
        $SusunanHuruf[$letter] = [];
    }

    foreach ($listKata as $kata) {
        $HurufPertama = mb_substr($kata['kata'], 0, 1);
        foreach ($SusunanAbjad as $letter) {
            if ($HurufPertama === $letter) {
                $SusunanHuruf[$letter][] = $kata;
                break;
            }
        }
    }

    $stmt->close();
    return $SusunanHuruf;
}

function displayKosakataList() {
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

    if (!empty($keyword)) {
        $sql = "
            SELECT kata, arti 
            FROM kamus_bahasa 
            WHERE LOWER(kata) = LOWER(?)
               OR LOWER(arti) = LOWER(?)
            LIMIT 10
        ";

        global $conn;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();

        $results = [];
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        $stmt->close();

        if (!empty($results)) {
            echo '<div class="mt-4">';
            echo '<h2 class="h4">Hasil Pencarian untuk "<strong>' . htmlspecialchars($keyword) . '</strong>"</h2>';
            echo '<div class="d-flex flex-column gap-2 mt-2">';

            foreach ($results as $row) {
                echo '<div class="d-flex justify-content-between border-bottom pb-2 border-secondary">';
                echo '<span>' . ucfirst(htmlspecialchars($row['kata'])) . '</span>';
                echo '<span>' . ucfirst(htmlspecialchars($row['arti'])) . '</span>';
                echo '</div>';
            }

            echo '</div>';
            echo '</div>';

        } else {
            echo '<div class="mt-4 alert alert-warning">Tidak ditemukan hasil untuk "<strong>' . htmlspecialchars($keyword) . '</strong>"</div>';
        }

    } else {
        $SusunanHuruf = getKosakataByLetter();

        foreach ($SusunanHuruf as $letter => $kataList) {
            if (!empty($kataList)) {
                echo '<div class="mb-4" id="section-' . htmlspecialchars($letter) . '">';
                echo '<h2 class="h3 bg-secondary p-2 rounded">' . htmlspecialchars($letter) . '</h2>';
                echo '<div class="d-flex flex-column gap-2 mt-2">';

                foreach ($kataList as $kata) {
                    echo '<div class="d-flex justify-content-between border-bottom pb-2 border-secondary">';
                    echo '<span>' . ucfirst(htmlspecialchars($kata['kata'])) . '</span>';
                    echo '<span>' . ucfirst(htmlspecialchars($kata['arti'])) . '</span>';
                    echo '</div>';
                }

                echo '</div>';
                echo '</div>';
            }
        }
    }
}
?>