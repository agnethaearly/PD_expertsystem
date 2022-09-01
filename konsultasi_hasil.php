<?php 
session_start();
session_commit();
include('functions.php');
include('header.php');



?>



<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

<br>
<div class="col d-flex justify-content-center" data-aos="fade-up" data-aos-delay="150">  
    <div class="card border-primary" style="width: 65rem">
      <h5 class="card-header border-primary bg-transparent">Data Diri</h5>

    <div class="card-body">
      

   <?php
                  if (isset($_POST['proses'])) {


                    $nama = $_POST["nama"];
                    $umur = $_POST["umur"];
                    $jk = $_POST["jk"];
                    $alamat = $_POST["alamat"];

                    



                    $kondisi = $_POST['kondisi'];
                    $kondisistring = implode(",", $kondisi);
                    $idkriteria = $_POST['id_k'];
                    //var_dump($kondisi);
                    //var_dump($kriteria);
                    $i=0;
                    foreach ( $kondisi as $k ) {
                      $query = "UPDATE pengetahuan SET cf_input = $k WHERE id_kriteria = $idkriteria[$i]";
                      mysqli_query($conn, $query);
                      // mysqli_affected_rows($conn);
                      // echo "ini k: "; var_dump($k);
                      // echo "ini i: "; var_dump($i);
                      // echo "ini idk[i]: "; var_dump($idkriteria[$i]);
                    $i++;
                                        }


                    $jlh_gangguan = query("SELECT p.id_gangguan, g.nama_gangguan FROM pengetahuan p INNER JOIN gangguan g ON p.id_gangguan = g.id_gangguan GROUP BY p.id_gangguan");
                    
                    foreach ( $jlh_gangguan as $j) { 
                      $gangguan[] = $j['id_gangguan'];
                      $namaGangguan[] = $j['nama_gangguan'];
                      }

                    


                    
                    for( $i=0; $i < count($gangguan); $i++) {
                      
                      $cf = [];
                      $id_cari = $i+1; // karena id_gangguan pd tabel dimulai dari 1 maka dibuat i+1 agar mulai dari 0+1 yaitu = 1
                      
                      //var_dump($id_cari);

                      $sql = query("SELECT nilai_cf * cf_input AS hasil FROM pengetahuan WHERE id_gangguan = '$id_cari'");

                      
                      
                      foreach ( $sql as $s ){

                     $cf[] = ["nilai" => $s['hasil']];

                      
                      } 

                    // echo "Gangguan $namaGangguan[$i]: ";
                    // echo cf($cf); 

                     $arrHasil[] = ['akhir' => cf($cf)];
                     
                      //$arrHasil[] = cf($cf);
                     

                    }  


                   $highest = 0;
                   $i = 0; 
                   foreach (  $arrHasil as $key => $value ) {

                            
                              $initial = $value['akhir'];

                              if ( $initial > $highest ) {

                              $highest = $initial;
                              $index = $key;

                              
                              
                              }
                              
                             $i++; 

                            }

                            $nama_final =  $namaGangguan[$index];
                            //echo "$namaGangguan[$index]"; echo ":";
                            //echo "index ke- $index"; echo ":";
                              //echo " $highest"; 
                              $query = "INSERT INTO riwayat 
                              VALUES ('','$nama','$jk', '$umur', '$alamat', '$nama_final')"; 
                    mysqli_query($conn, $query);         

            }     


            $keterangan = query("SELECT deskripsi FROM gangguan WHERE nama_gangguan = '$nama_final'");

            foreach ( $keterangan as $k) { $deskripsi = $k['deskripsi']; } 

           
                    ?>

  <ul class="list-group list-group-flush">
    <li class="list-group-item"><h6>Nama : <?= $nama ?></h6></li>
    <li class="list-group-item"><h6>Umur : <?= $umur ?></h6></li>
    <li class="list-group-item"><h6>Jenis Kelamin : <?= $jk ?></h6></li>
  </ul>
 </div>
</div>
</div>
</div>
  <br>

 <div class="col d-flex justify-content-center" data-aos="fade-up" data-aos-delay="150">  
    <div class="card border-primary" style="width: 65rem">
      <h5 class="card-header border-primary bg-transparent">Hasil Konsultasi</h5>
      <div class="card-body">
      

  <ul class="list-group list-group-flush">
    <li class="list-group-item"><h2><?php echo"Gangguan Kepribadian"; echo "&nbsp"; echo "$nama_final"; echo "&nbsp"; echo "$highest"; echo "%";?></h2></li>
    <li class="list-group-item"><p> <?php echo $deskripsi; ?></p> </li>

   <a class="nav-link" href="konsultasi.php">Konsultasi Lagi</a>
  
   
             
   </div>
</div>
</div>
                       
  





    



   


</body>
</html>