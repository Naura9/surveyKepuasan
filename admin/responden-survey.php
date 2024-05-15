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

// Query to fetch user information from m_user table based on username
$query_user = "SELECT nama, role FROM m_user WHERE username = '$username'";

// Execute the query
$result_user = mysqli_query($kon, $query_user);

// Check if the query executed successfully
if ($result_user) {
    // Fetch the user's information
    $user_info = mysqli_fetch_assoc($result_user);

    // Store the user's name and role in variables
    $nama = $user_info['nama'];
    $role = $user_info['role'];
} else {
    // Handle the case where the query fails
    $nama = "Nama Pengguna";
    $role = "Role";
}


// Query untuk mengambil data responden mahasiswa
$query_all_respondents = "
(
    SELECT DISTINCT m.nama, m.username, m.role, r.responden_mahasiswa_id AS responden_id, r.responden_tanggal
    FROM t_jawaban_mahasiswa j
    INNER JOIN t_responden_mahasiswa r ON j.responden_mahasiswa_id = r.responden_mahasiswa_id
    INNER JOIN m_survey s ON s.survey_id = r.survey_id
    INNER JOIN m_user m ON s.user_id = m.user_id
    )
    UNION
    (
    SELECT DISTINCT m.nama, m.username, m.role, r.responden_alumni_id AS responden_id, r.responden_tanggal
    FROM t_jawaban_alumni j
    INNER JOIN t_responden_alumni r ON j.responden_alumni_id = r.responden_alumni_id
    INNER JOIN m_survey s ON s.survey_id = r.survey_id
    INNER JOIN m_user m ON s.user_id = m.user_id
    )
    UNION
    (
    SELECT DISTINCT m.nama, m.username, m.role, r.responden_ortu_id AS responden_id, r.responden_tanggal
    FROM t_jawaban_ortu j
    INNER JOIN t_responden_ortu r ON j.responden_ortu_id = r.responden_ortu_id
    INNER JOIN m_survey s ON s.survey_id = r.survey_id
    INNER JOIN m_user m ON s.user_id = m.user_id
    )
    UNION
    (
    SELECT DISTINCT m.nama, m.username, m.role, r.responden_tendik_id AS responden_id, r.responden_tanggal
    FROM t_jawaban_tendik j
    INNER JOIN t_responden_tendik r ON j.responden_tendik_id = r.responden_tendik_id
    INNER JOIN m_survey s ON s.survey_id = r.survey_id
    INNER JOIN m_user m ON s.user_id = m.user_id
    )
    UNION
    (
    SELECT DISTINCT m.nama, m.username, m.role, r.responden_dosen_id AS responden_id, r.responden_tanggal
    FROM t_jawaban_dosen j
    INNER JOIN t_responden_dosen r ON j.responden_dosen_id = r.responden_dosen_id
    INNER JOIN m_survey s ON s.survey_id = r.survey_id
    INNER JOIN m_user m ON s.user_id = m.user_id
    )
    UNION
    (
    SELECT DISTINCT m.nama, m.username, m.role, r.responden_industri_id AS responden_id, r.responden_tanggal
    FROM t_jawaban_industri j
    INNER JOIN t_responden_industri r ON j.responden_industri_id = r.responden_industri_id
    INNER JOIN m_survey s ON s.survey_id = r.survey_id
    INNER JOIN m_user m ON s.user_id = m.user_id
    )
";

// Execute the query
$result_all_respondents = mysqli_query($kon, $query_all_respondents);


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
        .table {
            width: 1020px;
            border-radius: 10px; /* Menambahkan radius */
            overflow: hidden;
            margin-bottom: 0;
        }

        .table th {
        padding-top: 15px; /* Menambahkan jarak di bagian atas */
        padding-bottom: 15px; /* Menambahkan jarak di bagian bawah */
    }

    .kosong {
        background-color: #ececed; /* Memberi warna latar belakang */
        height: 273px;
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
        <h2>Responden Survey</h2>
            <!-- Tabel responden survey -->
            <table class="table">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                <?php
                    // Loop untuk menampilkan data responden mahasiswa
                    while($row = mysqli_fetch_assoc($result_all_respondents)) {                
                    ?>
                    <tr>
                        <td><?php echo date('d-m-Y', strtotime($row['responden_tanggal'])); ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <?php 
                                // Mengecek role responden dan mengatur responden_id
                                if ($row['role'] == 'mahasiswa') {
                                    $responden_id = $row['responden_id'];
                                } elseif ($row['role'] == 'alumni') {
                                    $responden_id = $row['responden_id'];
                                } elseif ($row['role'] == 'dosen') {
                                    $responden_id = $row['responden_id'];
                                } elseif ($row['role'] == 'industri') {
                                    $responden_id = $row['responden_id'];
                                } elseif ($row['role'] == 'ortu') {
                                    $responden_id = $row['responden_id'];
                                } elseif ($row['role'] == 'tendik') {
                                    $responden_id = $row['responden_id'];
                                } else {
                                    // Jika tidak ada kunci yang cocok, atur nilai responden_id ke sesuatu yang sesuai
                                    $responden_id = ''; // Atau sesuaikan dengan kebutuhan Anda
                                }
                                // Membuat tautan detail dengan parameter yang sesuai
                                echo "<a href=\"detail-responden.php?responden_id=$responden_id&role={$row['role']}&username={$row['username']}\" class=\"btn btn-light btn-outline-dark button-edit\">Detail</a>";
                            ?>
                        </td>

                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="kosong"></div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
        $('nav ul li').click(function(){
             $(this).addClass("active").siblings().removeClass("active");
        });    

        
        
    </script>
</body>
</html>