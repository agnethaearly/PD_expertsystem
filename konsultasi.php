<?php 

session_start();
session_commit();

include('functions.php');
include('header.php');

$kriteria = query("SELECT * FROM pengetahuan p INNER JOIN kriteria k ON p.id_kriteria = k.id_kriteria GROUP BY k.id_kriteria");

?>



<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

<br>
<br>
    <div class="col d-flex justify-content-center" data-aos="fade-up" data-aos-delay="150">  
    <div class="card border-primary" style="width: 65rem">
      <h5 class="card-header border-primary bg-transparent">Form</h5>

    <div class="card-body">

      <form action="konsultasi_hasil.php" method="post" >

        <input type="hidden" name="">
    <div class="container-sm">
      <div class="col-md-6 me-auto col-md-offset-3">
        <label for="nama" class="form-label">Nama : </label>
        <input type="text" class="form-control" name="nama" id="nama" required="">
      </div>

      <div class="col-md-6 me-auto col-md-offset-3">
        <label for="jk" class="form-label">Jenis Kelamin : </label>
        <select class="form-select col-md-6 me-auto col-md-offset-3" aria-label="Default select example" id="jk" name="jk">

  
  <option selected value='Laki-laki'>Laki-laki</option>
  <option value='Perempuan'>Perempuan</option>

</select>
      </div>

     <div class="col-md-6 me-auto col-md-offset-3">
        <label for="umur" class="form-label">Umur : </label>
        <input type="text" class="form-control" name="umur" id="umur" required="">
     </div>

     <div class="col-md-6 me-auto col-md-offset-3">
        <label for="alamat" class="form-label">Alamat : </label>
        <input type="text" class="form-control" name="alamat" id="alamat" required="">
     </div>
     <br>


    </div>
  </div>
</div>
</div>

  


<br>

<div class="col d-flex justify-content-center" data-aos="fade-up" data-aos-delay="150">  
    <div class="card border-primary" style="width: 65rem">
      <h5 class="card-header border-primary bg-transparent">Gangguan Kepribadian</h5>


    <div class="card-body">
      







        
    <br>
  <h6>Pilih kriteria berdasarkan tingkat keyakinan!</h6>
  <br>

      
  <table class="table table-hover">

<tr>
    <th>No.</th>
    <th>Kriteria</th>
   
    <th style="width: 10rem">Tingkat Keyakinan</th>
</tr>
 
  <?php $i = 1; ?>
  <?php foreach ( $kriteria as $row ) : ?>

<tr>
    <td><?= $i ?></td>
    <td><?= $row["nama_kriteria"]; ?></td>

    <input type="hidden" name="id_k[]" value="<?= $row['id_kriteria']?>">
    

    <td>
      <select name="kondisi[<?= $row['id_kriteria']?>]">
                    
        <option  value="1.0" >Sangat Yakin</option>
        <option  value="0.8" >Yakin</option>
        <option  value="0.6">Cukup Yakin</option>
        <option  value="0.4">Kurang Yakin</option>
        <option  value="0.2" selected>Tidak Yakin</option>
                                                                   
    </select>
  </td>

  </tr>
    <?php $i++; ?>
    <?php endforeach; ?>  
</table>
<br>
     <!-- <input type="submit" name="button" value="proses"> -->
     <button type="submit" name="proses" class="btn btn-primary">Proses</button>
</form>

</div>
</div>
</div>

    <br>
 </div>
</div>
</div>
</div>


</body>
</html>