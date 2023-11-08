<?php
include("C:/xampp/htdocs/poliklinik-topwan/inc/koneksi.php");

// Mengambil data dokter dan pasien untuk dropdown
$dokters = mysqli_query($mysqli, "SELECT * FROM dokter");
$pasiens = mysqli_query($mysqli, "SELECT * FROM pasien");

if (!$dokters || !$pasiens) {
  die("Error fetching data: " . $mysqli->error);
}
?>

<div class="modal fade" id="periksaModal" tabindex="-1" aria-labelledby="periksaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="periksaModalLabel">Form Periksa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="index.php?page=periksa/aksi_periksa">
          <div class="mb-3">
            <label for="id_dokter" class="form-label">Dokter</label>
            <select class="form-control" id="id_dokter" name="id_dokter">
              <?php
              while ($dokter = mysqli_fetch_assoc($dokters)) {
                echo "<option value='" . $dokter['id'] . "'>" . $dokter['nama'] . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="id_pasien" class="form-label">Pasien</label>
            <select class="form-control" id="id_pasien" name="id_pasien">
              <?php
              while ($pasien = mysqli_fetch_assoc($pasiens)) {
                echo "<option value='" . $pasien['id'] . "'>" . $pasien['nama'] . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="tanggal_periksa" class="form-label">Tanggal Periksa</label>
            <input type="date" class="form-control" id="tanggal_periksa" name="tanggal_periksa">
          </div>

          <div class="mb-3">
            <label for="waktu" class="form-label">Waktu Periksa</label>
            <input type="time" class="form-control" id="waktu" name="waktu">
          </div>

          <div class="mb-3">
            <label for="obat" class="form-label">Obat</label>
            <textarea class="form-control" id="obat" name="obat" rows="1"></textarea>
          </div>

          <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="container mt-5">
  <h3 class="mb-3 text-center">DAFTAR PERIKSA</h3>
  <table class="table table-bordered table-striped" id="daftar-periksa">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Pasien</th>
        <th>Nama Dokter</th>
        <th>Tanggal Periksa</th>
        <th>Waktu</th>
        <th>Obat</th>
        <th>Catatan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = "SELECT pr.id, p.nama AS nama_pasien, d.nama AS nama_dokter, pr.tanggal_periksa, pr.waktu, pr.obat, pr.catatan
                          FROM periksa pr 
                          JOIN pasien p ON pr.id_pasien = p.id 
                          JOIN dokter d ON pr.id_dokter = d.id 
                          ORDER BY pr.tanggal_periksa ASC";

      $result = mysqli_query($mysqli, $query);
      if (!$result) {
        die("Error fetching examination data: " . $mysqli->error);
      }

      $no = 1;
      while ($data = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $data['nama_pasien'] . "</td>";
        echo "<td>" . $data['nama_dokter'] . "</td>";
        $tanggal_periksa = date('d M Y', strtotime($data['tanggal_periksa']));
        echo "<td>" . $tanggal_periksa . "</td>";
        echo "<td>" . $data['waktu'] . "</td>";
        echo "<td>" . $data['obat'] . "</td>";
        echo "<td>" . $data['catatan'] . "</td>";
        echo "<td>";
        echo "<a href='index.php?page=periksa/periksa_edit&id=" . $data['id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
        echo "<a href='index.php?page=periksa/aksi_periksa&action=delete&id=" . $data['id'] . "' class='btn btn-danger btn-sm'>Hapus</a>";
        echo "</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#periksaModal">Tambah</button>
</div>

</div>