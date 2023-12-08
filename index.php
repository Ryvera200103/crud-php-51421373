<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "akademik";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
  die("Tidak bisa terkoneksi ke database");
}
$nama = "";
$npm = "";
$alamat = "";
$fakultas = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = '';
}
if($op == 'delete') {
  $id = $_GET['id'];
  $sql1 = "delete from ujian_51421373 where id = '$id'";
  $q1 = mysqli_query($koneksi, $sql1);
  if ($q1) {
    $sukses = "Berhasil menghapus data";
  }else {
    $error = "Gagal menghapus data";
  }
}
if ($op == 'edit') {
  $id = $_GET['id'];
  $sql1 = "select * from ujian_51421373 where id = '$id'";
  $q1 = mysqli_query($koneksi, $sql1);
  $r1 = mysqli_fetch_array($q1);
  $nama = $r1['nama'];
  $npm = $r1['npm'];
  $alamat = $r1['alamat'];
  $fakultas = $r1['fakultas'];

  if ($npm == '') {
    $error = "Data tidak ditemukan";
  }
}

if (isset($_POST['simpan'])) { //untuk create
  $nama = $_POST['nama'];
  $npm = $_POST['npm'];
  $alamat = $_POST['alamat'];
  $fakultas = $_POST['fakultas'];

  if ($nama && $npm && $alamat && $fakultas) {
    if ($op == 'edit') { //untuk update
      $sql1 = "update ujian_51421373 set nama='$nama',npm='$npm',alamat='$alamat',fakultas='$fakultas' where id = '$id'";
      $q1 = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Data berhasil diupdate";
      } else {
        $error = "Data gagal diupdate";
      }
    } else { //untuk insert
      $sql1 = "insert into ujian_51421373(nama,npm,alamat,fakultas) values('$nama', '$npm', '$alamat', '$fakultas')";
      $q1 = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Berhasil memasukkan data baru";
      } else {
        $error = "Gagal memasukkan data";
      }
    }

  } else {
    $error = "Silakkan masukkan semua data";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel = "stylesheet "href="style.css">
</head>

<body>
  <div class="mx-auto">
    <!-- Untuk memasukkan data-->
    <div class="card">
      <div class="card-header">
        Create / Edit Data
      </div>
      <div class="card-body">
        <?php
        if ($error) {
          ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
          <?php
          header("refresh:5;url=index.php");//5 : detik
        }
        ?>
        <?php
        if ($sukses) {
          ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
          <?php
          header("refresh:5;url=index.php");
        }
        ?>
          <form action="" method="POST">
          <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-from-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="npm" class="col-sm-2 col-from-label">NPM</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="npm" name="npm" value="<?php echo $npm ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="alamat" class="col-sm-2 col-from-label">Alamat</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="fakultas" class="col-sm-2 col-from-label">Fakultas</label>
            <div class="col-sm-10">
              <select class="form-control" name="fakultas" id="fakultas">
                <option value="">- Pilih Fakultas -</option>
                <option value="Informatika" <?php if ($fakultas == "Informatika")
                  echo "selected" ?>>Informatika</option>
                  <option value="Psikologi" <?php if ($fakultas == "Psikologi")
                  echo "selected" ?>>Psikologi</option>
              </div>
            </div>
            <div class="col-12">
              <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
            </div>
          </form>
        </div>
      </div>

      <!-- Untuk mengeluarkan data-->
      <div class="card">
        <div class="card-header">
          Data Mahasiswa
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">NPM</th>
                <th scope="col">Alamat</th>
                <th scope="col">Fakultas</th>
                <th scope="col">Aksi</th>
              </tr>
            <tbody>
              <?php
                $sql2 = "select * from ujian_51421373 order by id desc";
                $q2 = mysqli_query($koneksi, $sql2);
                $urut = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                  $id = $r2['id'];
                  $nama = $r2['nama'];
                  $npm = $r2['npm'];
                  $alamat = $r2['alamat'];
                  $fakultas = $r2['fakultas'];

                  ?>
              <tr>
                <th scope="row">
                  <?php echo $urut++ ?>
                </th>
                <td scope="row">
                  <?php echo $nama ?>
                </td>
                <td scope="row">
                  <?php echo $npm ?>
                </td>
                <td scope="row">
                  <?php echo $alamat ?>
                </td>
                <td scope="row">
                  <?php echo $fakultas ?>
                </td>
                <td scope="row">
                  <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                  <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Apakah anda yakin ingin mendelete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                </td>
              </tr>
              <?php
                }
                ?>
          </tbody>
          </thead>
        </table>
      </div>
    </div>
  </div>
</body>

</html>