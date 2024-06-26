<?php
    session_start();

    include '../Koneksi.php';
    $db = new Koneksi();
    $kon = $db->getConnection();

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login/login.php");
        exit(); 
    }

    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    $nama = $_SESSION['nama'];
    
    $query = "SELECT * FROM t_responden_alumni 
            JOIN m_survey ON m_survey.survey_id = t_responden_alumni.survey_id
            JOIN m_user ON m_user.user_id = m_survey.user_id
            WHERE m_user.user_id = '$user_id'";

    $res = mysqli_query($kon, $query); 

    if(mysqli_num_rows($res) > 0) {
        $alumni = mysqli_fetch_assoc($res);

        if(isset($_FILES["fileImg"]["name"])){ 
            $id = $_POST["responden_alumni_id"];

            $src = $_FILES["fileImg"]["tmp_name"];
            $imageName = uniqid() . $_FILES["fileImg"]["name"]; 

            $target = "img/" . $imageName;

            move_uploaded_file($src, $target);

            $query = "UPDATE t_responden_alumni SET image = '$imageName' WHERE responden_alumni_id = $id"; 
            mysqli_query($kon, $query);

            header("Location: profil.php");
        }

        $query_get_profil_image = "SELECT image FROM t_responden_alumni     
        JOIN m_survey ON m_survey.survey_id = t_responden_alumni.survey_id
        JOIN m_user ON m_user.user_id = m_survey.user_id
        WHERE m_user.user_id = '$user_id'";
        $result_get_profil_image = mysqli_query($kon, $query_get_profil_image);
        $row_get_profil_image = mysqli_fetch_assoc($result_get_profil_image);
        $profil_image = $row_get_profil_image['image'];
?>    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/96cfbc074b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../header.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style>
        h2 {
            font-weight: bold;
        }

        .form-profile {
            margin-top: 20px;
            margin-bottom: 20px;
            margin-right: 100px;
            background-color: white; 
            padding: 10px;
            width : 1050px;
            border-radius: 10px;
        }

        .card-body {
            background-color: #ececed;
        }

        .bg-custom {
            background-color: #ececed;
            width:700px;
        }

        .button-container {
            display: flex;
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            border: black;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .button-kembali {
            background-color: white;
            outline: black;
        }

        .button-simpan {
            margin-left: 890px; 
            background-color: #2d1b6b;
            color: white;
        }

        .username img {
            margin-left: 795px;
        }

        .upload {
            width: 140px;
            margin-bottom: 20px;
        }

        .upload img {
            border: 2px solid #DCDCDC;
            width: 150px;
            height: 150px;
        }

        .upload .rightRound {
            background: #00B4FF;
            width: 32px;
            height: 32px;
            line-height: 32px;
            text-align: center;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
        }

        .upload .leftRound {
            bottom: 0;
            left: 0;
            background: red;
            width: 32px;
            height: 32px;
            line-height: 33px;
            text-align: center;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
        }

        .upload .fa {
            color: white;
        }

        .upload input {
            position: absolute;
            transform: scale(2);
            opacity: 0;
        }

        .upload input::-webkit-file-upload-button, .upload input[type=submit] {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <?php include '../header.php'; ?>
    <section>
    <div class="content">
        <h2>Edit Profil</h2>
            <div class="form-profile">
                <table class="table">
                    <div class="form-group text-left font-weight-bold">
                        <div class="profile-label">Foto Profil</div>
                            <form class="form" id="form" action="" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="responden_alumni_id" value="<?php echo $alumni['responden_alumni_id']; ?>">
                            <div class="upload">
                            <div class="rightRound" id="upload">
                                    <input type="file" name="fileImg" id="fileImg" accept=".jpg, .jpeg, .png">
                                    <i class="fa fa-camera"></i>
                                </div>
                                <img src="img/<?php echo $alumni['image']; ?>" id="image">

                                <div class="leftRound" id="cancel" style="display: none;">
                                    <i class="fa fa-times"></i>
                                </div>
                                <div class="rightRound" id="confirm" style="display: none;">
                                    <input type="submit">
                                    <i class="fa fa-check"></i>
                                </div>
                            </div>     
                            </form>                        
                        <form action="proses-edit.php" method="POST">

                        </div>					
                        <div class="form-group text-left font-weight-bold">
                            <label for="responden_nip">NIP</label>
                            <input type="text" class="form-control bg-custom" name="responden_nip" id="responden_nip" value="<?php echo $alumni['responden_nip']; ?>">
                        </div>					
                        <div class="form-group text-left font-weight-bold">
						    <label for="responden_nama">Nama Lengkap</label>
							<input type="text" class="form-control bg-custom" name="responden_nama" id="responden_nama" value="<?php echo $alumni['responden_nama']; ?>">
						</div>						
                        <div class="form-group text-left font-weight-bold">
                            <label for="username">Username</label>
							<input type="text" class="form-control bg-custom" name="username" id="username" value="<?php echo $alumni['username']; ?>">
						</div>						
                        <div class="form-group text-left font-weight-bold">
                            <label for="password">Password</label>
                            <input type="password" class="form-control bg-custom" name="password" id="password" value="">
						</div>						
                        <div class="form-group text-left font-weight-bold">
                            <label for="responden_prodi">Program Studi</label>
							<input type="text" class="form-control bg-custom" name="responden_prodi" id="responden_prodi" value="<?php echo $alumni['responden_prodi']; ?>">
						</div>						
                        <div class="form-group text-left font-weight-bold">
                            <label for="responden_email">Email</label>
							<input type="text" class="form-control bg-custom" name="responden_email" id="responden_email" value="<?php echo $alumni['responden_email']; ?>">
						</div>						
                        <div class="form-group text-left font-weight-bold">
							<label for="responden_hp">No. Hp</label>
							<input type="text" class="form-control bg-custom" name="responden_hp" id="responden_hp" value="<?php echo $alumni['responden_hp']; ?>">
						</div>						
                        <div class="form-group text-left font-weight-bold">
							<label for="tahun_lulus">Tahun Lulus</label>
							<input type="text" class="form-control bg-custom" name="tahun_lulus" id="tahun_lulus" value="<?php echo $alumni['tahun_lulus']; ?>">
						</div>	                    
                        
                    </div>					
                </table>
            </div>
            <div class="button-container">
                <a href="profil.php" class="btn btn-light btn-outline-dark button-kembali">Kembali</a>
                <input type="submit" class="btn btn-outline-light button-simpan" name="simpan" value="Simpan">
            </div>    
        </form>

    </div>
</section>

<script type="text/javascript">
      document.getElementById("fileImg").onchange = function(){
        document.getElementById("image").src = URL.createObjectURL(fileImg.files[0]); 

        document.getElementById("cancel").style.display = "block";
        document.getElementById("confirm").style.display = "block";

        document.getElementById("upload").style.display = "none";
      }

      var userImage = document.getElementById('image').src;
      document.getElementById("cancel").onclick = function(){
        document.getElementById("image").src = userImage; 

        document.getElementById("cancel").style.display = "none";
        document.getElementById("confirm").style.display = "none";

        document.getElementById("upload").style.display = "block";
      }
    </script>
</body>
</html>
<?php
} else {
    echo "Data profil tidak ditemukan.";
}

mysqli_close($kon);
?>
