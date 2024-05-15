<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    // Jika belum, redirect pengguna ke halaman login
    header("Location: ../login/login.php");
    exit(); // Pastikan untuk keluar dari skrip setelah redirect
}

// Ambil nilai username dan role dari sesi
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$nama = $_SESSION['nama'];

// Query untuk mengambil rata-rata jawaban dari setiap kategori
$query_kategori_1 = "SELECT jawaban, COUNT(*) AS total
                    FROM (
                        SELECT j.jawaban 
                        FROM t_jawaban_mahasiswa j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 1
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_dosen j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 1
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_tendik j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 1
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_ortu j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 1
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_industri j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 1
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_alumni j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 1
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                    ) AS combined_tables
                    GROUP BY jawaban
                    ORDER BY total DESC
                    LIMIT 1;
                    ";

$query_kategori_2 = "SELECT jawaban, COUNT(*) AS total
                    FROM (
                        SELECT j.jawaban 
                        FROM t_jawaban_mahasiswa j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 2
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_dosen j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 2
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_tendik j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 2
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_ortu j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 2
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_industri j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 2
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_alumni j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 2
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                    ) AS combined_tables
                    GROUP BY jawaban
                    ORDER BY total DESC
                    LIMIT 1;
                    ";

$query_kategori_3 = "SELECT jawaban, COUNT(*) AS total
                    FROM (
                        SELECT j.jawaban 
                        FROM t_jawaban_mahasiswa j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 3
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_dosen j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 3
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_alumni j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 3
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_tendik j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 3
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_industri j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 3
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_ortu j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 3
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                    ) AS combined_tables
                    GROUP BY jawaban
                    ORDER BY total DESC
                    LIMIT 1;
                    ";

$query_kategori_4 = "SELECT jawaban, COUNT(*) AS total
                    FROM (
                        
                        SELECT j.jawaban 
                        FROM t_jawaban_mahasiswa j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 4
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_dosen j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 4
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_tendik j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 4
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_ortu j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 4
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_industri j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 4
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                        UNION ALL
                        SELECT j.jawaban 
                        FROM t_jawaban_alumni j
                        JOIN m_survey_soal s ON j.soal_id = s.soal_id
                        WHERE s.kategori_id = 4
                        AND j.jawaban IN ('kurang', 'cukup', 'baik', 'sangat_baik')
                    ) AS combined_tables
                    GROUP BY jawaban
                    ORDER BY total DESC
                    LIMIT 1;
                    ";


$result_kategori_1 = mysqli_query($kon, $query_kategori_1);
$result_kategori_2 = mysqli_query($kon, $query_kategori_2);
$result_kategori_3 = mysqli_query($kon, $query_kategori_3);
$result_kategori_4 = mysqli_query($kon, $query_kategori_4);

if ($result_kategori_1 && $result_kategori_2 && $result_kategori_3 && $result_kategori_4) {
    // Ambil nilai-nilai dari hasil query
    $row_kategori_1 = mysqli_fetch_assoc($result_kategori_1);
    $rata_rata_kategori_1 = $row_kategori_1 ? $row_kategori_1['jawaban'] : "";

    $row_kategori_2 = mysqli_fetch_assoc($result_kategori_2);
    $rata_rata_kategori_2 = $row_kategori_2 ? $row_kategori_2['jawaban'] : "";

    $row_kategori_3 = mysqli_fetch_assoc($result_kategori_3);
    $rata_rata_kategori_3 = $row_kategori_3 ? $row_kategori_3['jawaban'] : "";

    $row_kategori_4 = mysqli_fetch_assoc($result_kategori_4);
    $rata_rata_kategori_4 = $row_kategori_4 ? $row_kategori_4['jawaban'] : "";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/96cfbc074b.js" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="../header.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <style>
        /* CSS untuk kotak berwarna putih */
.survey-box {
    background-color: #ffffff;
    border-radius: 8px;
    padding: 30px;
    display: flex;
    align-items: center;
    width: 10px;
    height: 150px;
    margin-left: 100px;
    margin-top: 40px;
    margin-right: 5px;
}


/* CSS untuk jumlah survey ditanggapi */
.survey-count {
    font-size: 28px;
    font-weight: bold;
    margin-left: 50px;
    margin-right: 16px; /* Jarak antara jumlah dan ikon */
}

/* CSS untuk ikon di bagian kanan */
.icon {
    margin-left: 50px; /* Mendorong ikon ke kanan */
    font-size: 60px;
}

/* CSS untuk tulisan "Survey telah ditanggapi" */
.survey-text {
    margin-top: 5px;
    font-size: 20px;
}

.ratarata {
    font-size: 16px;
    background-color: #2d1b6b;
    border-radius: 15px;
    color: white;
    text-align: center;
    

}
.content {
    display: flex;
    flex-wrap: wrap; /* Memungkinkan wrapping jika layar terlalu kecil */
}
.survey-box.left {
    width: 470px;
    margin-top: 20px; /* Memberi jarak atas untuk kotak di sebelah kiri */
    margin-left: 30px; /* Memberi jarak kanan untuk kotak di sebelah kiri */
}

.survey-box.right {
    width: 470px;

    margin-top: 20px; /* Memberi jarak atas untuk kotak di sebelah kanan */
    margin-left: 30px; /* Memberi jarak kiri untuk kotak di sebelah kanan */
}

.kosong {
    background: #ececed;
    height: 205px;
}
.message {
            width: 5px;
            margin-left: 885px
        }

    </style>
</head>
<body>
<div class="container">
        <nav class="navbar">
            <div class="logo">
                <img src="img/logo-nama.png" alt="Logo" width="100">
            </div>
            <div class="username">
                <span><?php echo $nama; ?> | Admin </span>
                <a href="permintaan-user.php" class="message">
                    <i class="fa-regular fa-envelope"></i>
                </a>
                <a href="../login/logout.php" class="logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </a>
            </div>
        </nav>
    </div>

    <nav class="sidebar">
        <ul class="sidebar-nav">
            <li class="">
                <a href="dashboard-admin.php" class="">
                    <i class="fa-solid fa-house"></i>
                    Dashboard
                </a>
            </li>
            <li class="">
                <a href="#" class="" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                <i class="fa-solid fa-list-ol"></i> Survey
                    <span class="lni lni-chevron-down"></span>
                </a>
                <ul id="auth" class="" data-bs-parent="#sidebar">
                    <li><a href="soal-pendidikan.php"><i class="fa-solid fa-medal"></i> Kualitas Pendidikan</a></li>
                    <li><a href="soal-fasilitas.php"><i class="fa-solid fa-layer-group"></i>     Fasilitas</a></li>                    
                    <li><a href="soal-pelayanan.php"><i class="fa-solid fa-handshake"></i>  Pelayanan</a></li>
                    <li><a href="soal-lulusan.php"><i class="fa-solid fa-graduation-cap"></i>  Lulusan</a></li>
                </ul>
            </li>
            <li class="">
                <a href="responden-survey.php" class="">
                    <i class="fa-solid fa-user-group"></i>
                    Responden
                </a>
            </li>
            <li class="">
                <a href="laporan-survey.php" class="">
                    <i class="fa-solid fa-book-open"></i>
                    Laporan
                </a>
            </li>
        </ul>
    </nav>
    <section>
    <div class="content">
            <!-- Kotak berwarna putih di sebelah kiri -->
            <div class="survey-box left">
                <div class="icon">
                <i class="fa-solid fa-layer-group"></i>
                </div>
                <div class="survey-count">
                    <div class="survey-text">Fasilitas Polinema</div>
                    <div class="ratarata">Rata-rata <?php echo $rata_rata_kategori_2; ?></div>
                </div>
            </div>

            <div class="survey-box left">
                <div class="icon">
                <i class="fa-solid fa-medal"></i>
            </div>
                <div class="survey-count">
                    <div class="survey-text">Kualitas Pendidikan Polinema</div>
                    <div class="ratarata">Rata-rata <?php echo $rata_rata_kategori_1; ?></div>
                </div>
            </div>

            <!-- Kotak berwarna putih di sebelah kanan -->
            <div class="survey-box right"> 
                <div class="icon">
                <i class="fa-solid fa-handshake"></i>
                </div>
                <div class="survey-count">
                    <div class="survey-text">Pelayanan Polinema</div>
                    <div class="ratarata">Rata-rata <?php echo$rata_rata_kategori_3; ?></div>
                </div>
            </div>

            <div class="survey-box right">
                <div class="icon">
                <i class="fa-solid fa-graduation-cap"></i>                </div>
                <div class="survey-count">
                    <div class="survey-text">Lulusan Polinema</div>
                    <div class="ratarata">Rata-rata <?php echo $rata_rata_kategori_4; ?></div>
                </div>
            </div>
        </div>
    <div class="kosong">
        </div>
</section>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
        $('nav ul li').click(function(){
             $(this).addClass("active").siblings().removeClass("active");
        });    

        
        
    </script>
</body>
</html>
<?php
} else {
    echo "Gagal mengambil data dari database";
}