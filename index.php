 <?php
        //koneksi database
         $koneksi = mysqli_connect("localhost","root","", "utscrud");

         if(mysqli_connect_error()){
	echo "koneksi database gagal :". mysqli_connect_error();
}


// tombol simpan
if (isset($_POST['simpan']))
{
 //ngecek diedit atau disimpan
	if($_GET['hal'] == "edit")
	{
		//data akan diedit
		$edit = mysqli_query($koneksi, " UPDATE crud set
			                              nim = '$_POST[nim]',
			                              nama = '$_POST[nama]',
			                              alamat = '$_POST[alamat]',
			                              prodi = '$_POST[prodi]'
			                              WHERE id_mhs = '$_GET[id]'
                                       ");
//edit berhasil
if($edit)
{
	echo "<script>
            alert('Selamat data anda telah diubah');
            document.location='index.php';
	     </script>";
}
else
{
	echo "<script>
            alert('Mohon periksa kembali');
            document.location='index.php';
	     </script>";
}
	}else
	{
		//data arep disimpan anyar
		$simpan = mysqli_query($koneksi, "INSERT INTO crud (nim, nama, alamat, prodi)
									  VALUES('$_POST[nim]',
								             '$_POST[nama]',
								             '$_POST[alamat]',
								             '$_POST[prodi]')    
                                  ");
	//seumpomo simpan berhasil	
if($simpan) 
{
	echo "<script>
            alert('Selamat data anda telah tersimpan');
            document.location='index.php';
	     </script>";
}
else
{
	echo "<script>
            alert('Mohon Periksa kembali');
            document.location='index.php';
	     </script>";
}
	}


	
	}


//seumpomo tombol edit / hapus di klik
	if(isset($_GET['hal']))
	{
		//edit data
		if($_GET['hal']=="edit")
		{
        //data seng arep diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM crud where id_mhs= '$_GET[id]'");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				
				$vnim = $data['nim'];
				$vnama = $data['nama'];
				$valamat = $data['alamat'];
				$vprodi = $data['prodi'];
			}
		}

		else if ($_GET['hal']=="hapus")
		{
        // hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM crud WHERE id_mhs = '$_GET[id]'");
			if($hapus){
			    echo "<script>
            alert('hapus data sukses');
            document.location='index.php';
	     </script>";	
	       }
		}
	}

     ?>
	

<!DOCTYPE html>
<html>
<head>
	<title>CRUD</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

<h2 class="text-center"> DATA MAHASISWA  </h2>


<!--awal--->
<div class="card mt-5">
  <div class="card-header bg-primary text-white">
    Form Input Data Mahasiswa
  </div>
  <div class="card-body">
    <form method="post" action="" > 
    	<div class="form-group">
    		<label>NIM</label>
    		<input type="text" name="nim" value="<?=@$vnim?>" class="form-control" placeholder="Masukkan Nim" required="">
    	</div>
    	<div class="form-group">
    		<label>Nama</label>
    		<input type="text" name="nama" value="<?=@$vnama?>" class="form-control" placeholder="Masukkan nama" required="">
    	</div>
    	<div class="form-group">
    		<label>ALAMAT</label>
    		<textarea class="form-control" name="alamat"  placeholder="Masukkan alamat"><?=@$valamat?></textarea>
    	</div>
    	<div class="form-group">
    		<label>Program Studi</label>
    		<select class="form-control" name="prodi">
    		<option value = "<?=@$vprodi?>"><?=@$vprodi?></option>
    		<option value="S1-Akuntansi">S1-Akuntansi</option>
    		<option value="S1-Manajemen">S1-Manajemen</option>
    		<option value="S1-Sistem informasi">S1-Sistem Informasi</option>
    		<option value="S1-Teknik Mesin">S1-Teknik Mesin</option>
    	</select>
    	</div>
    	<button type="submit" class="btn btn-success" name="simpan">Simpan</button>
    	<button type="reset" class="btn btn-danger" name="reset">Hapus</button>
    </form>
  </div>
</div>
<!--akhir--->

<!--awal tabel--->
<div class="card mt-5">
  <div class="card-header bg-success text-white">
  Daftar Mahasiswa
  </div>
  <div class="card-body">

  	<table class="table table-border table-striped">
  		<tr>
  			<th>NO.</th>
  			<th>NIM</th>
  			<th>NAMA</th>
  			<th>ALAMAT</th>
  			<th>PROGRAM STUDI</th>
  			<th>TINDAKAN</th>
  		</tr>
  		<?php
  		$no = 1;
  		    $tampil = mysqli_query($koneksi, "select * from crud");
  		    while ($data = mysqli_fetch_array($tampil)){
  		?>
  		<tr>
  		 <td><?php echo $no++; ?></td>
         <td><?php echo $data['nim']; ?></td>
         <td><?php echo $data['nama']; ?></td>
         <td><?php echo $data['alamat']; ?></td>
         <td><?php echo $data['prodi']; ?></td>
         <td>
         	<a href="index.php? hal=edit&id=<?=$data['id_mhs']?>"  class="btn btn-success"> EDIT </a>  ||
         	<a href="index.php? hal=hapus&id=<?=$data['id_mhs']?>" onclick= "return confirm('Apakah yakin ingin mengahpus data ini?')" class= "btn btn-danger">HAPUS</a>
         </td>
  		</td>
     </tr>
     <?php
         }
         ?>
     </table>
 </body>
 </html>
<!--akhir tabel--->


</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>