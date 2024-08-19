<?php
include "../koneksi.php";

// Fungsi untuk menghasilkan ID berikutnya untuk m_projek
function generateNextIdProjek($conn) {
    // Ambil nilai terakhir id_m_pekerja dari database
    $sql_get_last_id = "SELECT MAX(id_projek) AS last_id FROM m_projek";
    $result = $conn->query($sql_get_last_id);
    $row = $result->fetch_assoc();
    $last_id = $row['last_id'];

    // Menghasilkan id_m_pekerja baru dengan format PJM001, PJM002, ...
    if ($last_id) {
        $num = intval(substr($last_id, 3)) + 1;
    } else {
        $num = 1;
    }
    $new_id = 'PRJ' . str_pad($num, 3, '0', STR_PAD_LEFT); //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
    
    return $new_id;
}



// Fungsi untuk menghasilkan ID berikutnya untuk m_bahan
function generateNextIdBahan($conn) {
    // Ambil nilai terakhir id_m_pekerja dari database
    $sql_get_last_id = "SELECT MAX(id_m_bahan) AS last_id FROM m_bahan";
    $result = $conn->query($sql_get_last_id);
    $row = $result->fetch_assoc();
    $last_id = $row['last_id'];

    // Menghasilkan id_m_pekerja baru dengan format PJM001, PJM002, ...
    if ($last_id) {
        $num = intval(substr($last_id, 4)) + 1;
    } else {
        $num = 1;
    }
    $new_id= 'MBHN' . str_pad($num, 3, '0', STR_PAD_LEFT); //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
    
    return $new_id;
}

// Fungsi untuk menghasilkan ID berikutnya untuk m_jam
function generateNextIdJam($conn) {
    $sql = "SELECT MAX(RIGHT(id_m_jam, 2)) AS max_id FROM m_jam";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $max_id = $row['max_id'];
        $next_id = intval($max_id) + 1;
        return sprintf("MJ%02d", $next_id); // Format ID dengan prefix "mj" dan leading zeros
    } else {
        return "MJ01"; // Jika tabel kosong, mulai dari mj01
    }
}

// Fungsi untuk menghasilkan ID berikutnya untuk m_peralatan
function generateNextIdPeralatan($conn) {
    // Ambil nilai terakhir id_m_pekerja dari database
    $sql_get_last_id = "SELECT MAX(id_m_peralatan) AS last_id FROM m_peralatan";
    $result = $conn->query($sql_get_last_id);
    $row = $result->fetch_assoc();
    $last_id = $row['last_id'];

    // Menghasilkan id_m_pekerja baru dengan format PJM001, PJM002, ...
    if ($last_id) {
        $num = intval(substr($last_id, 6)) + 1;
    } else {
        $num = 1;
    }
    $new_id = 'MPRLTN' . str_pad($num, 3, '0', STR_PAD_LEFT); //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
    
    return $new_id;
}

// fungsi untuk memproses logo
function convertToWebP($source, $destination, $quality = 80) {
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);
    } else {
        return false;
    }

    imagewebp($image, $destination, $quality);
    imagedestroy($image);
    return true;
}

function imageToBase64($imagePath) {
    $imageData = file_get_contents($imagePath);
    return base64_encode($imageData);
}


// Ambil data dari form dan lakukan operasi yang sesuai
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Operasi untuk m_projek
    if (isset($_POST['projek_simpan'])) {
        $nama_projek = $_POST['nama_projek'];
        $tanggal_mulai = $_POST['tanggal_mulai_tambah'];
        $tanggal_selesai = $_POST['tanggal_selesai_tambah'];
        $pemilik_pekerjaan = $_POST['pemilik_pekerjaan'];
        $pengawas = $_POST['pengawas'];
        $kontraktor = $_POST['kontraktor'];
        $tambahan_waktu = !empty($_POST['tambahan_waktu_tambah']) ? $_POST['tambahan_waktu_tambah'] : NULL;

        // Generate ID baru untuk m_projek
        $id_projek = generateNextIdProjek($conn);

         // Handling file upload
        $logo1_name = $_FILES['logo1']['name'];
        $logo2_name = $_FILES['logo2']['name'];
        $logo3_name = $_FILES['logo3']['name'];

        $logo1_new_name = NULL;
        $logo2_new_name = NULL;
        $logo3_new_name = NULL;

        // Kondisi untuk logo1
        if (!empty($logo1_name)) {
            $logo1_ext = pathinfo($logo1_name, PATHINFO_EXTENSION);
            $logo1_new_name = $id_projek . '_logo1.' . $logo1_ext;
            $logo1_temp = $_FILES['logo1']['tmp_name'];
            $logo1_path = '../public/asset/img/uploads/logo/' . $logo1_new_name;
            move_uploaded_file($logo1_temp, $logo1_path);
        }

        // Kondisi untuk logo2
        if (!empty($logo2_name)) {
            $logo2_ext = pathinfo($logo2_name, PATHINFO_EXTENSION);
            $logo2_new_name = $id_projek . '_logo2.' . $logo2_ext;
            $logo2_temp = $_FILES['logo2']['tmp_name'];
            $logo2_path = '../public/asset/img/uploads/logo/' . $logo2_new_name;
            move_uploaded_file($logo2_temp, $logo2_path);
        }

        // Kondisi untuk logo3
        if (!empty($logo3_name)) {
            $logo3_ext = pathinfo($logo3_name, PATHINFO_EXTENSION);
            $logo3_new_name = $id_projek . '_logo3.' . $logo3_ext;
            $logo3_temp = $_FILES['logo3']['tmp_name'];
            $logo3_path = '../public/asset/img/uploads/logo/' . $logo3_new_name;
            move_uploaded_file($logo3_temp, $logo3_path);
        }


        // Prevent SQL injection
        $nama_projek = $conn->real_escape_string($nama_projek);
        $tanggal_mulai = $conn->real_escape_string($tanggal_mulai);
        $tanggal_selesai = $conn->real_escape_string($tanggal_selesai);
        $pemilik_pekerjaan = $conn->real_escape_string($pemilik_pekerjaan);
        $pengawas = $conn->real_escape_string($pengawas);
        $kontraktor = $conn->real_escape_string($kontraktor);

        // Tambahkan nilai NULL atau tanggal jika ada
        if ($tambahan_waktu !== NULL) {
            $sql_m_projek .= "'$tambahan_waktu')";
        } else {
            $sql_m_projek .= "NULL)";
        }

        // SQL untuk memasukkan data ke dalam tabel m_projek
    $sql_m_projek = "INSERT INTO m_projek (id_projek, nama_projek, tanggal_mulai, tanggal_selesai, pemilik_pekerjaan, pengawas, kontraktor, logo_pemilik, logo_pengawas, logo_kontraktor, tambahan_waktu)
                    VALUES ('$id_projek', '$nama_projek', '$tanggal_mulai', '$tanggal_selesai', '$pemilik_pekerjaan', '$pengawas', '$kontraktor', '$logo1_new_name', '$logo2_new_name', '$logo3_new_name', ";

        // Tambahkan nilai NULL atau tanggal jika ada
    if ($tambahan_waktu !== NULL) {
        $sql_m_projek .= "'$tambahan_waktu')";
    } else {
        $sql_m_projek .= "NULL)";
    }

        $projek_insert = mysqli_query($conn, $sql_m_projek);

        // Eksekusi query untuk m_projek
        if ($projek_insert) {
            echo "<script>
                alert('Simpan Data Berhasil!');
                document.location='../page/admin/m_projek.php';
                </script>";
        } else {
            echo "Error: " . $sql_m_projek . "<br>" . $conn->error;
        }
    }


    // Operasi untuk mengubah data projek
if (isset($_POST['projek_ubah'])) {
    $id_projek = $_POST['id_projek']; // Ambil ID projek dari form
    $nama_projek = $_POST['nama_projek'];
    $tanggal_mulai = $_POST['tanggal_mulai_ubah'];
    $tanggal_selesai = $_POST['tanggal_selesai_ubah'];
    $pemilik_pekerjaan = $_POST['pemilik_pekerjaan'];
    $pengawas = $_POST['pengawas'];
    $kontraktor = $_POST['kontraktor'];
    $tambahan_waktu = !empty($_POST['tambahan_waktu_ubah']) ? $_POST['tambahan_waktu_ubah'] : NULL;

    // Handling file upload
    $logo1_name = $_FILES['logo1']['name'];
    $logo2_name = $_FILES['logo2']['name'];
    $logo3_name = $_FILES['logo3']['name'];

    $logo1_new_name = NULL;
    $logo2_new_name = NULL;
    $logo3_new_name = NULL;

    // Kondisi untuk logo1
    if (!empty($logo1_name)) {
        $logo1_ext = pathinfo($logo1_name, PATHINFO_EXTENSION);
        $logo1_new_name = $id_projek . '_logo1.' . $logo1_ext;
        $logo1_temp = $_FILES['logo1']['tmp_name'];
        $logo1_path = '../public/asset/img/uploads/logo/' . $logo1_new_name;
        move_uploaded_file($logo1_temp, $logo1_path);
    }

    // Kondisi untuk logo2
    if (!empty($logo2_name)) {
        $logo2_ext = pathinfo($logo2_name, PATHINFO_EXTENSION);
        $logo2_new_name = $id_projek . '_logo2.' . $logo2_ext;
        $logo2_temp = $_FILES['logo2']['tmp_name'];
        $logo2_path = '../public/asset/img/uploads/logo/' . $logo2_new_name;
        move_uploaded_file($logo2_temp, $logo2_path);
    }

    // Kondisi untuk logo3
    if (!empty($logo3_name)) {
        $logo3_ext = pathinfo($logo3_name, PATHINFO_EXTENSION);
        $logo3_new_name = $id_projek . '_logo3.' . $logo3_ext;
        $logo3_temp = $_FILES['logo3']['tmp_name'];
        $logo3_path = '../public/asset/img/uploads/logo/' . $logo3_new_name;
        move_uploaded_file($logo3_temp, $logo3_path);
    }

    // Prevent SQL injection
    $nama_projek = $conn->real_escape_string($nama_projek);
    $tanggal_mulai = $conn->real_escape_string($tanggal_mulai);
    $tanggal_selesai = $conn->real_escape_string($tanggal_selesai);
    $pemilik_pekerjaan = $conn->real_escape_string($pemilik_pekerjaan);
    $pengawas = $conn->real_escape_string($pengawas);
    $kontraktor = $conn->real_escape_string($kontraktor);

    // SQL untuk memperbarui data di tabel m_projek
    $sql_m_projek = "UPDATE m_projek SET 
                        nama_projek='$nama_projek',
                        tanggal_mulai='$tanggal_mulai',
                        tanggal_selesai='$tanggal_selesai',
                        pemilik_pekerjaan='$pemilik_pekerjaan',
                        pengawas='$pengawas',
                        kontraktor='$kontraktor'";

    // Update logo jika ada
    if (!empty($logo1_new_name)) {
        $sql_m_projek .= ", logo_pemilik='$logo1_new_name'";
    }
    if (!empty($logo2_new_name)) {
        $sql_m_projek .= ", logo_pengawas='$logo2_new_name'";
    }
    if (!empty($logo3_new_name)) {
        $sql_m_projek .= ", logo_kontraktor='$logo3_new_name'";
    }

    // Tambahkan nilai tambahan_waktu jika ada
    if ($tambahan_waktu !== NULL) {
        $sql_m_projek .= ", tambahan_waktu='$tambahan_waktu'";
    } else {
        $sql_m_projek .= ", tambahan_waktu=NULL";
    }

    $sql_m_projek .= " WHERE id_projek='$id_projek'";

    $projek_update = mysqli_query($conn, $sql_m_projek);

    // Eksekusi query untuk m_projek
    if ($projek_update) {
        echo "<script>
            alert('Update Data Berhasil!');
            document.location='../page/admin/m_projek.php';
            </script>";
    } else {
        echo "Error: " . $sql_m_projek . "<br>" . $conn->error;
    }
}

    

    
    

    //Hapus data projek
        if (isset($_POST['projek_hapus'])){
            // Mengambil Data

            $hapus = mysqli_query($conn, "DELETE FROM m_projek WHERE id_projek = '$_POST[id_projek]'" );

            if ($hapus) {
                echo "<script>
                        alert('Hapus Data Sukses!');
                        document.location='../page/admin/m_projek.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Hapus Data Gagal!');
                        document.location='../page/admin/m_projek.php';
                    </script>";
            }
        }


    // Operasi Insert untuk m_bahan
    if (isset($_POST['bahan_simpan'])) {
        $id_projek = $_POST['id_projek'];
        $nama_bahan = $_POST['nama_bahan'];
        $satuan = $_POST['satuan'];
        
        // Generate ID baru untuk m_bahan
        $id_m_bahan = generateNextIdBahan($conn);

        // SQL untuk memasukkan data ke dalam tabel m_bahan
        $sql_m_bahan = "INSERT INTO m_bahan (id_m_bahan, id_projek, nama_bahan, satuan) VALUES ('$id_m_bahan','$id_projek', '$nama_bahan', '$satuan')";

        // Eksekusi query untuk m_bahan
        if ($conn->query($sql_m_bahan) === TRUE) {
            echo "<script>
                alert('Simpan Data Berhasil!');
                document.location='../page/admin/m_bahan.php';
                </script>";
        } else {
            echo "Error: " . $sql_m_bahan . "<br>" . $conn->error;
        }
    }

    //ubah data m_bahan
    if (isset($_POST['bahan_ubah'])){
        // Mengambil Data

        $ubah = mysqli_query($conn, "UPDATE m_bahan SET nama_bahan = '$_POST[nama_bahan]', satuan = '$_POST[satuan]' WHERE id_m_bahan = '$_POST[id_m_bahan]'" );

        if ($ubah) {
            echo "<script>
                    alert('Ubah Data Sukses!');
                    document.location='../page/admin/m_bahan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Ubah Data Gagal!');
                    document.location='../page/admin/m_bahan.php';
                </script>";
        }
    }

    //Hapus data bahan
        if (isset($_POST['bahan_hapus'])){
            // Mengambil Data

            $hapus = mysqli_query($conn, "DELETE FROM m_bahan WHERE id_m_bahan = '$_POST[id_m_bahan]'" );

            if ($hapus) {
                echo "<script>
                        alert('Hapus Data Sukses!');
                        document.location='../page/admin/m_bahan.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Hapus Data Gagal!');
                        document.location='../page/admin/m_bahan.php';
                    </script>";
            }
        }

    

    

    // Operasi untuk m_jam
    if (isset($_POST['bsimpan_jam'])) {
        $jam_mulai = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];
        
        // Generate ID baru untuk m_jam
        $id_m_jam = generateNextIdJam($conn);

        // SQL untuk memasukkan data ke dalam tabel m_jam
        $sql_m_jam = "INSERT INTO m_jam (id_m_jam, jam_mulai, jam_selesai) VALUES ('$id_m_jam', '$jam_mulai', '$jam_selesai')";

        // Eksekusi query untuk m_jam
        if ($conn->query($sql_m_jam) === TRUE) {
            echo "<script>
                alert('Simpan Data Berhasil!');
                document.location='../page/admin/m_jam.php';
                </script>";
        } else {
            echo "Error: " . $sql_m_jam . "<br>" . $conn->error;
        }
    }

    //ubah data jam
    if (isset($_POST['jam_ubah'])){
        // Mengambil Data

        $ubah = mysqli_query($conn, "UPDATE m_jam SET jam_mulai = '$_POST[jam_mulai]', jam_selesai = '$_POST[jam_selesai]' WHERE id_m_jam = '$_POST[id_m_jam]'" );

        if ($ubah) {
            echo "<script>
                    alert('Ubah Data Sukses!');
                    document.location='../page/admin/m_jam.php';
                </script>";
        } else {
            echo "<script>
                    alert('Ubah Data Gagal!');
                    document.location='../page/admin/m_jam.php';
                </script>";
        }
    }

    //Hapus data jam
        if (isset($_POST['jam_hapus'])){
            // Mengambil Data

            $hapus = mysqli_query($conn, "DELETE FROM m_jam WHERE id_m_jam = '$_POST[id_m_jam]'" );

            if ($hapus) {
                echo "<script>
                        alert('Hapus Data Sukses!');
                        document.location='../page/admin/m_jam.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Hapus Data Gagal!');
                        document.location='../page/admin/m_jam.php';
                    </script>";
            }
        }

    // Operasi untuk m_peralatan
    if (isset($_POST['alat_simpan'])) {
        $projek = $_POST['id_projek'];
        $nama_alat = $_POST['nama_alat'];
        $satuan = $_POST['satuan'];
        
        // Generate ID baru untuk m_peralatan
        $id_m_peralatan = generateNextIdPeralatan($conn);

        // SQL untuk memasukkan data ke dalam tabel m_peralatan
        $sql_m_peralatan = "INSERT INTO m_peralatan (id_m_peralatan, id_projek, nama_alat, satuan) VALUES ('$id_m_peralatan', '$projek', '$nama_alat', '$satuan')";

        // Eksekusi query untuk m_peralatan
        if ($conn->query($sql_m_peralatan) === TRUE) {
            echo "<script>
                alert('Simpan Data Berhasil!');
                document.location='../page/admin/m_peralatan.php';
                </script>";
        } else {
            echo "Error: " . $sql_m_peralatan . "<br>" . $conn->error;
        }
    }

    //ubah data peralatan
    if (isset($_POST['alat_ubah'])){
        // Mengambil Data

        $ubah = mysqli_query($conn, "UPDATE m_peralatan SET nama_alat = '$_POST[nama_alat]', satuan = '$_POST[satuan]' WHERE id_m_peralatan = '$_POST[id_m_peralatan]'" );

        if ($ubah) {
            echo "<script>
                    alert('Ubah Data Sukses!');
                    document.location='../page/admin/m_peralatan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Ubah Data Gagal!');
                    document.location='../page/admin/m_peralatan.php';
                </script>";
        }
    }

    //Hapus data peralatan
        if (isset($_POST['alat_hapus'])){
            // Mengambil Data

            $hapus = mysqli_query($conn, "DELETE FROM m_peralatan WHERE id_m_peralatan = '$_POST[id_m_peralatan]'" );

            if ($hapus) {
                echo "<script>
                        alert('Hapus Data Sukses!');
                        document.location='../page/admin/m_peralatan.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Hapus Data Gagal!');
                        document.location='../page/admin/m_peralatan.php';
                    </script>";
            }
        }



    // Operasi untuk m_pekerjaan
    if (isset($_POST['pekerjaan_simpan'])) {
        // Ambil nilai terakhir id_m_pekerjaan dari database
        $sql_get_last_id = "SELECT MAX(id_m_pekerjaan) AS last_id FROM m_pekerjaan";
        $result = $conn->query($sql_get_last_id);
        $row = $result->fetch_assoc();
        $last_id = $row['last_id'];
    
        // Menghasilkan id_m_pekerjaan baru dengan format PJM001, PJM002, ...
        if ($last_id) {
            $num = intval(substr($last_id, 3)) + 1;
        } else {
            $num = 1;
        }
        $new_id_m_pekerjaan = 'P' . str_pad($num, 4, '0', STR_PAD_LEFT); //$new_id_m_pekerjaan = 'PJM' . str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
    
        // Menyimpan data baru
        $id_projek = $_POST['id_projek'];
        $nama_pekerjaan = $_POST['nama_pekerjaan'];
        $simpan = mysqli_query($conn, "INSERT INTO m_pekerjaan(id_m_pekerjaan, id_projek, nama_pekerjaan) VALUES ('$new_id_m_pekerjaan', '$id_projek', '$nama_pekerjaan')");
        
        if ($simpan) {
            echo "<script>
                    alert('Simpan Data Sukses!');
                    document.location='../page/admin/m_pekerjaan.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Simpan Data Gagal!');
                    document.location='../page/admin/m_pekerjaan.php';
                  </script>";
        }
    }
    

    //ubah data m_pekerjaan
    if (isset($_POST['pekerjaan_ubah'])){
        // Mengambil Data

        $ubah = mysqli_query($conn, "UPDATE m_pekerjaan SET nama_pekerjaan = '$_POST[nama_pekerjaan]' WHERE id_m_pekerjaan = '$_POST[id_m_pekerjaan]'" );

        if ($ubah) {
            echo "<script>
                    alert('Ubah Data Sukses!');
                    document.location='../page/admin/m_pekerjaan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Ubah Data Gagal!');
                    document.location='../page/admin/m_pekerjaan.php';
                </script>";
        }
    }

    //Hapus data m_pekerjaan
        if (isset($_POST['pekerjaan_hapus'])){
            // Mengambil Data

            $hapus = mysqli_query($conn, "DELETE FROM m_pekerjaan WHERE id_m_pekerjaan = '$_POST[id_m_pekerjaan]'" );

            if ($hapus) {
                echo "<script>
                        alert('Hapus Data Sukses!');
                        document.location='../page/admin/m_pekerjaan.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Hapus Data Gagal!');
                        document.location='../page/admin/m_pekerjaan.php';
                    </script>";
            }
        }

        //operasi untuk pekerja
        if (isset($_POST['bsimpan'])) {
            // Ambil nilai terakhir id_m_pekerja dari database
            $sql_get_last_id = "SELECT MAX(id_m_pekerja) AS last_id FROM m_pekerja";
            $result = $conn->query($sql_get_last_id);
            $row = $result->fetch_assoc();
            $last_id = $row['last_id'];
        
            // Menghasilkan id_m_pekerja baru dengan format PJM001, PJM002, ...
            if ($last_id) {
                $num = intval(substr($last_id, 3)) + 1;
            } else {
                $num = 1;
            }
            $new_id_m_pekerja = 'PJM' . $num; //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
        
            // Menyimpan data baru
            $jenis_pekerja = $_POST['jenis_pekerja'];
            $projek = $_POST['id_projek'];
            $simpan = mysqli_query($conn, "INSERT INTO m_pekerja(id_m_pekerja, id_projek, jenis_pekerja) VALUES ('$new_id_m_pekerja', '$projek', '$jenis_pekerja')");
            
            if ($simpan) {
                echo "<script>
                        alert('Simpan Data Sukses!');
                        document.location='../page/admin/m_pekerja.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Simpan Data Gagal!');
                        document.location='../page/admin/m_pekerja.php';
                      </script>";
            }
        }
        
        //ubah data
        if (isset($_POST['bubah'])){
            // Mengambil Data
        
            $ubah = mysqli_query($conn, "UPDATE m_pekerja SET jenis_pekerja = '$_POST[jenis_pekerja]' WHERE id_m_pekerja = '$_POST[id_m_pekerja]'" );
        
            if ($ubah) {
                echo "<script>
                        alert('Ubah Data Sukses!');
                        document.location='../page/admin/m_pekerja.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Ubah Data Gagal!');
                        document.location='../page/admin/m_pekerja.php';
                      </script>";
            }
        }
        
        //Hapus data
        if (isset($_POST['bhapus'])){
            // Mengambil Data
        
            $hapus = mysqli_query($conn, "DELETE FROM m_pekerja WHERE id_m_pekerja = '$_POST[id_m_pekerja]'" );
        
            if ($hapus) {
                echo "<script>
                        alert('Hapus Data Sukses!');
                        document.location='../page/admin/m_pekerja.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Hapus Data Gagal!');
                        document.location='../page/admin/m_pekerja.php';
                      </script>";
            }
        }

        //operasi untuk sub_m_pekerjaan
        if (isset($_POST['sub_simpan'])) {
            // Ambil nilai terakhir id_m_pekerja dari database
            $sql_get_last_id = "SELECT MAX(id_m_sub_pekerjaan) AS last_id FROM m_sub_pekerjaan";
            $result = $conn->query($sql_get_last_id);
            $row = $result->fetch_assoc();
            $last_id = $row['last_id'];
        
            // Menghasilkan id_m_pekerja baru dengan format PJM001, PJM002, ...
            if ($last_id) {
                $num = intval(substr($last_id, 3)) + 1;
            } else {
                $num = 1;
            }
            $new_id_m_sub_pekerjaan = 'SP' . str_pad($num, 6, '0', STR_PAD_LEFT); //$new_id_m_pekerjaan = 'PJM' . str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
        
            // Menyimpan data baru
            $nama_sub_pekerjaan = $_POST['nama_sub_pekerjaan'];
            $id_m_pekerjaan = $_POST['id_m_pekerjaan'];
            
            $simpan = mysqli_query($conn, "INSERT INTO m_sub_pekerjaan(id_m_sub_pekerjaan, id_m_pekerjaan, nama_sub_pekerjaan) VALUES ('$new_id_m_sub_pekerjaan', '$id_m_pekerjaan', '$nama_sub_pekerjaan')");
            
            if ($simpan) {
                echo "<script>
                        alert('Simpan Data Sukses!');
                        document.location='../page/admin/m_sub_pekerjaan.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Simpan Data Gagal!');
                        document.location='../page/admin/m_sub_pekerjaan.php';
                      </script>";
            }
        }
        
        //ubah data sub
        if (isset($_POST['sub_ubah'])){
            // Mengambil Data
        
            $ubah = mysqli_query($conn, "UPDATE m_sub_pekerjaan SET nama_sub_pekerjaan = '$_POST[nama_sub_pekerjaan]' WHERE id_m_sub_pekerjaan = '$_POST[id_m_sub_pekerjaan]'" );
        
            if ($ubah) {
                echo "<script>
                        alert('Ubah Data Sukses!');
                        document.location='../page/admin/m_sub_pekerjaan.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Ubah Data Gagal!');
                        document.location='../page/admin/m_sub_pekerjaan.php';
                      </script>";
            }
        }
        
        //Hapus data sub
        if (isset($_POST['sub_hapus'])){
            // Mengambil Data
        
            $hapus = mysqli_query($conn, "DELETE FROM m_sub_pekerjaan WHERE id_m_sub_pekerjaan = '$_POST[id_m_sub_pekerjaan]'" );
        
            if ($hapus) {
                echo "<script>
                        alert('Hapus Data Sukses!');
                        document.location='../page/admin/m_sub_pekerjaan.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Hapus Data Gagal!');
                        document.location='../page/admin/m_sub_pekerjaan.php';
                      </script>";
            }
        }
}

// Tutup koneksi
$conn->close();
?>
