<?php

function searchKamus($keyword, $direction) {
    global $conn;

    if ($direction === 'indo') {
        $sql = "
            SELECT kata, arti, kategori, konteks 
            FROM kamus_bahasa 
            WHERE arti = ?
        ";
    } else {
        $sql = "
            SELECT kata, arti, kategori, konteks 
            FROM kamus_bahasa 
            WHERE kata = ?
        ";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $keyword);
    $stmt->execute();
    $result = $stmt->get_result();

    $results = [];
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    $stmt->close();
    return $results;
}

function hasilSearching($keyword, $direction) {
    global $conn;

    if (empty($keyword)) {
        echo '<div class="mt-5">';
        echo '<h2 class="h4">Hasil Pencarian</h2>';
        echo '<div class="bg-secondary p-4 rounded">';
        echo '<p class="mb-0">Masukkan kata di atas dan klik "Cari Arti" untuk melihat hasil.</p>';
        echo '</div>';
        echo '</div>';
        return;
    }

    $results = searchKamus($keyword, $direction);

    if (!empty($results)) {
        echo '<div class="mt-5">';
        echo '<h2 class="h4">Hasil Pencarian</h2>';

        foreach ($results as $row) {
            echo '<div class="bg-secondary p-4 rounded mb-3">';
            echo '<h3 class="h5 mb-2">' . htmlspecialchars($row['kata']) . '</h3>';
            echo '<p class="mb-1"><strong>Bahasa Indonesia:</strong> ' . htmlspecialchars($row['arti']) . '</p>';
            echo '<p class="mb-1"><strong>Kategori:</strong> ' . htmlspecialchars($row['kategori']) . '</p>';
            if (!empty($row['konteks'])) {
                echo '<p class="mb-0"><strong>Konteks:</strong> ' . htmlspecialchars($row['konteks']) . '</p>';
            }
            echo '</div>';
        }

        echo '</div>';
    } else {
        echo '<div class="mt-5 bg-secondary p-4 mb-3">Tidak ditemukan hasil untuk "<strong>' . htmlspecialchars($keyword) . '</strong>"</div>';
    }
}



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
            WHERE kata = ?
               OR arti = ?
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
