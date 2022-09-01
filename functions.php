<?php 

$conn = mysqli_connect("localhost","root","","expertsystem");

function query($query) {

	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}

# MENU GANGGUAN

function cari_gangguan($keyword) {
	$query = "SELECT * FROM gangguan 
				WHERE
				kode_gangguan LIKE '%$keyword%' OR 
				nama_gangguan LIKE '%$keyword%'
	";

	return query($query);

}

function tambah_gangguan($data) {
	global $conn;
//ambil data tiap elemen dalam form
	$kode = $data["kode"];
	$nama = $data["nama"];
	$deskripsi = $data["deskripsi"];

//cek duplikasi data
	$result_kombo = mysqli_query($conn, "SELECT * FROM gangguan WHERE nama_gangguan = '$nama' && kode_gangguan = '$kode'");
	$result_kode = mysqli_query($conn, "SELECT * FROM gangguan WHERE kode_gangguan = '$kode' "); 
	$result_nama = mysqli_query($conn, "SELECT * FROM gangguan WHERE nama_gangguan = '$nama' ");

	if ( mysqli_fetch_assoc($result_kombo) ){
		echo "<script> alert('Kombinasi kode dan nama sudah terdaftar')</script>";
		return false;

	}

	if ( mysqli_fetch_assoc($result_kode) ) {
		echo " <script> alert('Kode sudah terdaftar!')</script>";
		return false;

	}

		if ( mysqli_fetch_assoc($result_nama) ) {

			echo "<script> alert ('Nama sudah terdaftar!') </script>";
			return false;
		}


//query insert data 
	$query = "INSERT INTO gangguan 
				VALUES 
				('','$kode','$nama','$deskripsi')"; 
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil merupakan pengujian affected rows apakah lebih dari 0


}

function hapus_gangguan($id) {

	global $conn;
	mysqli_query($conn, "DELETE FROM gangguan WHERE id_gangguan = $id");
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil adalah pengujian affected rows apakah lebih dari 0


}


function ubah_gangguan($data) {
	global $conn;
//ambil data tiap elemen dalam form
	$id = $data["id"];
	$kode = $data["kode"];
	$nama = $data["nama"];

// cek jika ada nama duplicate
	$result_nama = mysqli_query($conn, "SELECT * FROM gangguan WHERE nama_gangguan = '$nama' ");

	if ( mysqli_fetch_assoc($result_nama) ){
		echo "<script> alert('Nama sudah terdaftar!')</script>";
		return false;
	}

//query insert data
	$query = "UPDATE gangguan 
				SET 
				kode_gangguan = '$kode',
				nama_gangguan = '$nama'
				
				WHERE id_gangguan = $id " ; 

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil merupakan pengujian affected rows apakah lebih dari 0


}




# MENU KRITERIA

function cari_kriteria($keyword) {
	$query = "SELECT * FROM kriteria 
				WHERE
				kode_kriteria LIKE '%$keyword%' OR 
				nama_kriteria LIKE '%$keyword%'
	";

	return query($query);

}

function tambah_kriteria($data) {
	global $conn;
//ambil data tiap elemen dalam form
	$kode = $data['kode'];
	$nama = $data["nama"];

//cek duplikasi data
	$result_kombo = mysqli_query($conn, "SELECT * FROM kriteria WHERE nama_kriteria = '$nama' && kode_kriteria = '$kode'");
	$result_kode = mysqli_query($conn, "SELECT * FROM kriteria WHERE kode_kriteria = '$kode' "); 
	$result_nama = mysqli_query($conn, "SELECT * FROM kriteria WHERE nama_kriteria = '$nama' ");

		if ( mysqli_fetch_assoc($result_kombo)  ){
		echo "<script> alert('Kode atau nama sudah terdaftar!')</script>";
		return false;

		}

		if ( mysqli_fetch_assoc($result_kode) ) {
		echo " <script> alert('Kode sudah terdaftar!')</script>";
		return false;

		}

		if ( mysqli_fetch_assoc($result_nama) ) {

		echo "<script> alert ('Nama sudah terdaftar!') </script>";
			return false;
		}
	


//query insert data
	$query = "INSERT INTO kriteria 
				VALUES 
				('','$kode','$nama')"; 
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil merupakan pengujian affected rows apakah lebih dari 0


}

function hapus_kriteria($id) {

	global $conn;
	mysqli_query($conn, "DELETE FROM kriteria WHERE id_kriteria = $id");
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil adalah pengujian affected rows apakah lebih dari 0


}


function ubah_kriteria($data) {
	global $conn;
//ambil data tiap elemen dalam form
	$id = $data["id"];
	$kode = $data["kode"];
	$nama = $data["nama"];

// cek jika ada nama duplicate
	$result_nama = mysqli_query($conn, "SELECT * FROM kriteria WHERE nama_kriteria = '$nama' ");

	if ( mysqli_fetch_assoc($result_nama) ){
		echo "<script> alert('Nama sudah terdaftar!')</script>";
		return false;
	}

//query insert data
	$query = "UPDATE kriteria 
				SET 
				kode_kriteria = '$kode',
				nama_kriteria = '$nama'
				
				WHERE id_kriteria = $id " ; 

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil merupakan pengujian affected rows apakah lebih dari 0


}

# MENU PENGETAHUAN

function cari_pengetahuan($keyword) {
	$query = "SELECT k.nama_kriteria, k.kode_kriteria, g.nama_gangguan, g.kode_gangguan, p.nilai_cf

		FROM pengetahuan p INNER JOIN 
			 gangguan g ON g.id_gangguan=p.id_gangguan INNER JOIN 
			 kriteria k ON k.id_kriteria=p.id_kriteria 
			 

		WHERE k.nama_kriteria LIKE '%$keyword%'
        OR k.kode_kriteria LIKE '%$keyword%'
        OR g.nama_gangguan LIKE '%$keyword%'
        OR g.kode_gangguan LIKE '%$keyword%'
        OR p.nilai_cf LIKE '%$keyword%'

        ORDER BY p.id_gangguan, p.id_kriteria
	";

	return query($query);

}

function hapus_pengetahuan($id) {

	global $conn;
	mysqli_query($conn, "DELETE FROM pengetahuan WHERE id_pengetahuan = $id");
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil adalah pengujian affected rows apakah lebih dari 0


}

function tambah_pengetahuan($data) {
	global $conn;
//ambil data tiap elemen dalam form
	$id_k = $data["kode_k"];
	$id_g = $data["kode_g"];
	$id_cf = $data["nilai"];

//fetch result

$result_kombinasi = mysqli_query($conn, "SELECT * FROM pengetahuan WHERE id_kriteria = '$id_k' && id_gangguan = '$id_g' "); 
$result_gangguan = mysqli_query($conn, "SELECT * FROM pengetahuan WHERE id_gangguan = '$id_g' ");

//cek duplikasi data

	if ( mysqli_fetch_assoc($result_kombinasi) ){
		echo "<script> alert('Kombinasi kriteria dan gangguan sudah terdaftar!')</script>";
		return false;
	} 

//query insert data
	$query = "INSERT INTO pengetahuan
				VALUES 
				('','$id_k','$id_g','$id_cf','')"; 
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil merupakan pengujian affected rows apakah lebih dari 0

}


function ubah_pengetahuan($data) {
	global $conn;
//ambil data tiap elemen dalam form
	$id_p = $data["id_p"];
	$nilai = $data["nilai"];

//query insert data
	$query = "UPDATE pengetahuan 
				SET 
				
				nilai_cf = '$nilai'
				
				WHERE id_pengetahuan = $id_p " ; 

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil merupakan pengujian affected rows apakah lebih dari 0


}

function registrasi($data) {
	
	global $conn;

	$nama = $data["nama"];
	$email = $data["email"];
	$nomor = $data["no"];
	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);


	// cek username apakah sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

	if ( mysqli_fetch_assoc($result) ) {
		echo "<script> alert('Username sudah terdaftar!')

		</script>";
		return false;
	}
	
	// cek konfirmasi pass

	if ( $password !== $password2 ) {

		echo "
		<script> 
		alert('Konfirmasi password tidak sesuai.')</script>";
		return false;
	}

	// enkripsi password

	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan user baru ke database
	mysqli_query($conn, "INSERT INTO pendaftar VALUES('', '$nama', '$email', '$nomor','$username', '$password','Pending')");
	return mysqli_affected_rows($conn);


}

function cf($data) {
                          
                          $cf_old = 0;


                          foreach (  $data as $key => $value ) {

                            if (  $key==0) {

                              $cf_old = $value['nilai'];
                               
                              

                            } else {
                              $cf_old = $cf_old + ($value['nilai'] * ( 1 - $cf_old));
                              

                            }
                          }
                              
                            $presentase = $cf_old * 100;
                            return $presentase;                            
                            
                      }

function cari_riwayat($keyword) {
	$query = "SELECT * FROM riwayat 
				WHERE

				nama LIKE '%$keyword%' OR 
				hasil LIKE '%$keyword%' OR
				umur LIKE '%$keyword' OR
				hasil LIKE '%$keyword%' OR
				alamat LIKE '%$keyword%' OR
				jenis_kelamin LIKE '%$keyword%'
	";

	return query($query);

}

function hapus_riwayat($id) {

	global $conn;
	mysqli_query($conn, "DELETE FROM riwayat WHERE id_riwayat = $id");
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil adalah pengujian affected rows apakah lebih dari 0


}

function ubah_riwayat($data) {
	global $conn;
//ambil data tiap elemen dalam form
	$id = $data["id"];
	$umur = $data["umur"];
	$nama = $data["nama"];
	$alamat = $data["alamat"];
	$jk = $data["jk"];
	$hasil = $data["hasil"];




//query insert data
	$query = "UPDATE riwayat 
				SET 
				nama = '$nama',
				umur = '$umur',
				jenis_kelamin = '$jk',
				alamat = '$alamat',
				hasil = '$hasil'

				
				WHERE id_riwayat = $id " ; 

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil merupakan pengujian affected rows apakah lebih dari 0


}

function tolak_pendaftar($id) {

	global $conn;
	mysqli_query($conn, "DELETE FROM pendaftar WHERE id_pendaftar = $id");
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil adalah pengujian affected rows apakah lebih dari 0


}

function terima_pendaftar($data) {

	global $conn;

	//ambil data tiap elemen dalam form
	$nama = $data["nama"];
	$nomor = $data["no"];
	$email = $data["email"];
	$id = $data["id"];
	$username = $data["username"];
	$password = $data["password"];
	$level = $data["level"];

	mysqli_query($conn, "INSERT INTO users VALUES('', '$id','$username', '$password','$level')");
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil adalah pengujian affected rows apakah lebih dari 0

}

function update_pendaftar($data) {

	global $conn;
	$nama = $data["nama"];
	$nomor = $data["no"];
	$email = $data["email"];
	$id = $data["id"];
	$username = $data["username"];
	$password = $data["password"];
	$level = $data["level"];
	
	mysqli_query($conn, "UPDATE pendaftar SET 

		nama_lengkap = '$nama',
		email = '$email',
		no_telp = '$nomor',
		username = '$username',
		password = '$password',
		status = 'Diterima'

		WHERE id_pendaftar = '$id'");
	return mysqli_affected_rows($conn);

}

function ubah_akun($data) {

	global $conn;
	$id_pendaftar = $data["id_pendaftar"];
	$id = $data["id_user"];
	$username = $data["username"];
	$password = $data["password"];
	$level = $data["level"];
	
	mysqli_query($conn, "UPDATE users SET 

		level = '$level'

		WHERE id_user = '$id'");
	return mysqli_affected_rows($conn);


}

function hapus_akun($id) {

	global $conn;
	mysqli_query($conn, "DELETE FROM users WHERE id_user = $id");
	return mysqli_affected_rows($conn); // return affected rows karena line yang dipanggil adalah pengujian affected rows apakah lebih dari 0


}
 ?>