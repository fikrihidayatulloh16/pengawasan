<?php
include "../koneksi.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //operasi untuk laporan harian
    // Aksi tambah laporan harian
    if (isset($_POST['lh_simpan'])) {
        //generate id baru
        $sql_get_last_id = "SELECT MAX(	id_laporan_harian) AS last_id FROM laporan_harian";
        $result = $conn->query($sql_get_last_id);
        $row = $result->fetch_assoc();
        $last_id = $row['last_id'];

        // Menghasilkan id_laporan baru dengan format PJM001, PJM002, ...
        if ($last_id) {
            $num = intval(substr($last_id, 3)) + 1;
        } else {
            $num = 1;
        }
        $new_id = 'L' . str_pad($num, 6, '0', STR_PAD_LEFT); //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001

        // Ambil data dari form
        $id_projek = $_POST['id_projek'];
        $tanggal = $_POST['tanggal'];

        $laporan_harian = "INSERT INTO 
                                laporan_harian (id_laporan_harian,id_projek, tanggal, progress_harian) 
                            VALUES ('$new_id','$id_projek', '$tanggal', NULL)";

        $laporan_insert = mysqli_query($conn, $laporan_harian);

        
        
        // Proses checkbox yang dipilih
        if (isset($_POST['box_sp'])) {
            $checkbox_values = $_POST['box_sp'];
            foreach ($checkbox_values as $id_m_sub_pekerjaan) {
                $pekerjaan_harian = "INSERT INTO
                                                pekerjaan_harian(id_laporan_harian, id_m_sub_pekerjaan	)
                                                VALUE ('$new_id','$id_m_sub_pekerjaan')";
                
                $pekerjaan_harian_insert = mysqli_query($conn, $pekerjaan_harian);
            }
        }

        if ($laporan_insert){
            // Prepare and execute query to insert cuaca data
            $cuaca_data = [
                ['00:00', '01:00', 'cerah'],
                ['01:00', '02:00', 'cerah'],
                ['02:00', '03:00', 'cerah'],
                ['03:00', '04:00', 'cerah'],
                ['04:00', '05:00', 'cerah'],
                ['05:00', '06:00', 'cerah'],
                ['06:00', '07:00', 'cerah'],
                ['07:00', '08:00', 'cerah'],
                ['08:00', '09:00', 'cerah'],
                ['09:00', '10:00', 'cerah'],
                ['10:00', '11:00', 'cerah'],
                ['11:00', '12:00', 'cerah'],
                ['12:00', '13:00', 'cerah'],
                ['13:00', '14:00', 'cerah'],
                ['14:00', '15:00', 'cerah'],
                ['15:00', '16:00', 'cerah'],
                ['16:00', '17:00', 'cerah'],
                ['17:00', '18:00', 'cerah'],
                ['18:00', '19:00', 'cerah'],
                ['19:00', '20:00', 'cerah'],
                ['20:00', '21:00', 'cerah'],
                ['21:00', '22:00', 'cerah'],
                ['22:00', '23:00', 'cerah'],
                ['23:00', '00:00', 'cerah']
            ];

            $sql_cuaca = $conn->prepare("INSERT INTO cuaca (id_laporan_harian, jam_mulai, jam_selesai, kondisi) VALUES (?, ?, ?, ?)");
            for ($i = 0; $i < count($cuaca_data); $i++) {
                $jam_mulai = $cuaca_data[$i][0];
                $jam_selesai = $cuaca_data[$i][1];
                $kondisi = $cuaca_data[$i][2];
                $sql_cuaca->bind_param('ssss', $new_id, $jam_mulai, $jam_selesai, $kondisi);
                $sql_cuaca->execute();
            }
        }

        if ($laporan_insert && $pekerjaan_harian_insert) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/laporanharian.php';
                </script>";
        } else {
            echo "<script>
                    alert('Simpan Data Laporan Harian Gagal!');
                    document.location='../page/operator/laporanharian.php';
                </script>";
        }
    }

    //aksi ubah laporan

    //aksi hapus laporan
    if (isset($_POST['lh-hapus'])){
        // Mengambil Data

        $hapus = mysqli_query($conn, "DELETE FROM laporan_harian WHERE id_laporan_harian = '$_POST[id_laporan_harian]'" );

        if ($hapus) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/laporanharian.php';
                </script>";
        } else {
            echo "<script>
                    alert('Hapus Data Gagal!');
                    document.location='../page/operator/laporanharian.php';
                </script>";
        }
    }

    //Operasi Untuk Pekerja
    // Aksi tambah pekerja
    if (isset($_POST['ph-pekerja-simpan'])) {
        //generate id baru
        $sql_get_last_id = "SELECT MAX(	id_pekerja) AS last_id FROM pekerja";
        $result = $conn->query($sql_get_last_id);
        $row = $result->fetch_assoc();
        $last_id = $row['last_id'];

        // Menghasilkan id_laporan baru dengan format PJM001, PJM002, ...
        if ($last_id) {
            $num = intval(substr($last_id, 3)) + 1;
        } else {
            $num = 1;
        }
        $new_id = 'PKJ' . str_pad($num, 6, '0', STR_PAD_LEFT); //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001

        // Ambil data dari form
        $id_laporan_harian = $_POST['id_laporan_harian'];
        $id_m_pekerja = $_POST['id_m_pekerja'];
        $id_sub_pekerjaan = $_POST['id_sub_pekerjaan'];

        $jumlah_pekerja = $_POST['jumlah_pekerja'];

        //menyimpan ke database
        $pekerja = "INSERT INTO 
                                pekerja (id_pekerja ,id_laporan_harian, id_m_sub_pekerjaan , id_m_pekerja , jumlah_pekerja) 
                            VALUES ('$new_id','$id_laporan_harian', '$id_sub_pekerjaan', '$id_m_pekerja','$jumlah_pekerja')";

        $pekerja_insert = mysqli_query($conn, $pekerja);
        
        if ($pekerja_insert) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    window.location.href = '../page/operator/operator.pekerjaan.php?message=Data Berhasil Disimpan';
                  </script>";
        } else {
            echo "<script>
                    alert('Simpan Data Pekerja Gagal!');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        }
    }

    //aksi ubah pekerja
    if (isset($_POST['ph-pekerja-ubah'])){
        // Mengambil Data

        $ubah = mysqli_query($conn, "UPDATE pekerja SET id_m_pekerja = '$_POST[id_m_pekerja]', jumlah_pekerja = '$_POST[jumlah_pekerja]' WHERE id_pekerja = '$_POST[id_pekerja]'" );

        if ($ubah) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Ubah Data Gagal!');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        }
    }

    //aksi hapus pekerja
    if (isset($_POST['ph-pekerja-hapus'])){
        // Mengambil Data

        $hapus = mysqli_query($conn, "DELETE FROM pekerja WHERE id_pekerja = '$_POST[id_pekerja]'" );

        if ($hapus) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Hapus Data Gagal!');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        }
    }

    //Operasi untuk Peralatan
    // Aksi tambah peralatan
    if (isset($_POST['ph-peralatan-simpan'])) {
        //generate id baru
        $sql_get_last_id = "SELECT MAX(	id_peralatan) AS last_id FROM peralatan";
        $result = $conn->query($sql_get_last_id);
        $row = $result->fetch_assoc();
        $last_id = $row['last_id'];

        // Menghasilkan id_laporan baru dengan format PJM001, PJM002, ...
        if ($last_id) {
            $num = intval(substr($last_id, 5)) + 1;
        } else {
            $num = 1;
        }
        $new_id = 'PRLTN' . str_pad($num, 6, '0', STR_PAD_LEFT); //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001

        // Ambil data dari form
        $id_laporan_harian = $_POST['id_laporan_harian'];
        $id_m_peralatan = $_POST['id_m_peralatan'];
        $id_sub_pekerjaan = $_POST['id_sub_pekerjaan'];

        $jumlah_peralatan = $_POST['jumlah_peralatan'];

        //menyimpan ke database
        $peralatan = "INSERT INTO 
                                peralatan (id_peralatan ,id_laporan_harian, id_m_sub_pekerjaan , id_m_peralatan , jumlah_peralatan) 
                            VALUES ('$new_id','$id_laporan_harian', '$id_sub_pekerjaan', '$id_m_peralatan','$jumlah_peralatan')";

        $peralatan_insert = mysqli_query($conn, $peralatan);
        
        if ($peralatan_insert) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Simpan Data Peralatan Gagal!');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        }
    }

    //aksi ubah peralatan
    if (isset($_POST['ph-peralatan-ubah'])){
        // Mengambil Data

        $ubah = mysqli_query($conn, "UPDATE peralatan SET id_m_peralatan = '$_POST[id_m_peralatan]', jumlah_peralatan = '$_POST[jumlah_peralatan]' WHERE id_peralatan = '$_POST[id_peralatan]'" );

        if ($ubah) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Ubah Data Gagal!');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        }
    }

    //aksi hapus peralatan
    if (isset($_POST['ph-peralatan-hapus'])){
        // Mengambil Data

        $hapus = mysqli_query($conn, "DELETE FROM peralatan WHERE id_peralatan = '$_POST[id_peralatan]'" );

        if ($hapus) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Hapus Data Gagal!');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        }
    }

    //Operasi untuk Bahan
    // Aksi tambah bahan
    if (isset($_POST['ph-bahan-simpan'])) {
        //generate id baru
        $sql_get_last_id = "SELECT MAX(	id_bahan) AS last_id FROM bahan";
        $result = $conn->query($sql_get_last_id);
        $row = $result->fetch_assoc();
        $last_id = $row['last_id'];

        // Menghasilkan id_laporan baru dengan format PJM001, PJM002, ...
        if ($last_id) {
            $num = intval(substr($last_id, 3)) + 1;
        } else {
            $num = 1;
        }
        $new_id = 'BHN' . str_pad($num, 6, '0', STR_PAD_LEFT); //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001

        // Ambil data dari form
        $id_laporan_harian = $_POST['id_laporan_harian'];
        $id_m_bahan = $_POST['id_m_bahan'];
        $id_sub_pekerjaan = $_POST['id_sub_pekerjaan'];

        $jumlah_bahan = $_POST['jumlah_bahan'];

        //menyimpan ke database
        $bahan = "INSERT INTO 
                                bahan (id_bahan ,id_laporan_harian, id_m_sub_pekerjaan , id_m_bahan , jumlah_bahan) 
                            VALUES ('$new_id','$id_laporan_harian', '$id_sub_pekerjaan', '$id_m_bahan','$jumlah_bahan')";

        $bahan_insert = mysqli_query($conn, $bahan);
        
        if ($bahan_insert) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Simpan Data Bahan Gagal!');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        }
    }

    //aksi ubah bahan
    if (isset($_POST['ph-bahan-ubah'])){
        // Mengambil Data

        $ubah = mysqli_query($conn, "UPDATE bahan SET id_m_bahan = '$_POST[id_m_bahan]', jumlah_bahan = '$_POST[jumlah_bahan]' WHERE id_bahan = '$_POST[id_bahan]'" );

        if ($ubah) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Ubah Data Gagal!');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        }
    }

    //aksi hapus bahan
    if (isset($_POST['ph-bahan-hapus'])){
        // Mengambil Data

        $hapus = mysqli_query($conn, "DELETE FROM bahan WHERE id_bahan = '$_POST[id_bahan]'" );

        if ($hapus) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Hapus Data Gagal!');
                    document.location='../page/operator/operator.pekerjaan.php';
                </script>";
        }
    }

    //Operasi untuk Permasalahan
    // Aksi tambah permasalahan
    if (isset($_POST['masalah_simpan'])) {
        //generate id baru
        $sql_get_last_id = "SELECT MAX(id_permasalahan) AS last_id FROM permasalahan";
        $result = $conn->query($sql_get_last_id);
        $row = $result->fetch_assoc();
        $last_id = $row['last_id'];

        // Menghasilkan id_laporan baru dengan format PJM001, PJM002, ...
        if ($last_id) {
            $num = intval(substr($last_id, 3)) + 1;
        } else {
            $num = 1;
        }
        $new_id = 'MSL' . str_pad($num, 6, '0', STR_PAD_LEFT); //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001

        // Ambil data dari form
        $id_laporan_harian = $_POST['id_laporan_harian'];
        $permasalahan = $_POST['permasalahan'];
        $saran = $_POST['saran'];

        //menyimpan ke database
        $permasalahan = "INSERT INTO 
                                permasalahan (id_permasalahan ,id_laporan_harian, permasalahan , saran) 
                            VALUES ('$new_id','$id_laporan_harian', '$permasalahan', '$saran')";

        $permasalahan_insert = mysqli_query($conn, $permasalahan);
        
        if ($permasalahan_insert) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/operator.permasalahan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Simpan Data Bahan Gagal!');
                    document.location='../page/operator/operator.permasalahan.php';
                </script>";
        }        
    }

    //ubah data permasalahan
    if (isset($_POST['masalah_ubah'])){
        // Mengambil Data

        $ubah = mysqli_query($conn, "UPDATE permasalahan SET permasalahan = '$_POST[permasalahan]', saran = '$_POST[saran]' WHERE id_permasalahan = '$_POST[id_permasalahan]'" );

        if ($ubah) {
            echo "<script>
                    sessionStorage.setItem('navigated', 'true');
                    document.location='../page/operator/operator.permasalahan.php';
                </script>";
        } else {
            echo "<script>
                    alert('Ubah Data Gagal!');
                    document.location='../page/operator/operator.permasalahan.php';
                </script>";
        }
    }

    //Hapus data permasalahan
        if (isset($_POST['masalah_hapus'])){
            // Mengambil Data

            $hapus = mysqli_query($conn, "DELETE FROM permasalahan WHERE id_permasalahan = '$_POST[id_permasalahan]'" );

            if ($hapus) {
                echo "<script>
                        sessionStorage.setItem('navigated', 'true');
                        document.location='../page/operator/operator.permasalahan.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Hapus Data Gagal!');
                        document.location='../page/operator/operator.permasalahan.php';
                    </script>";
            }
        }

    // Handle form submission untuk perubahan data cuaca
        if (isset($_POST['cuaca_ubah'])) {
            $id_cuaca_value = $_POST['id_cuaca'];
            $kondisi_value = $_POST['kondisi'];
        
            // Loop through each pair of id_cuaca and kondisi
            for ($i = 0; $i < count($id_cuaca_value); $i++) {
                $id_cuaca = $id_cuaca_value[$i];
                $kondisi = $kondisi_value[$i];
        
                // Update data cuaca in the database
                $cuaca_ubah = "UPDATE cuaca SET kondisi = '$kondisi' WHERE id_cuaca = '$id_cuaca'";
                $cuaca_ubah_insert = mysqli_query($conn, $cuaca_ubah);
        
                // Check if update was successful
                if ($cuaca_ubah_insert) {
                    echo "<script>
                            sessionStorage.setItem('navigated', 'true');
                            document.location='../page/operator/cuaca.php';
                        </script>";
                } else {
                    echo "<script>
                            alert('Gagal mengubah data Cuaca!');
                            document.location='../page/operator/cuaca.php';
                        </script>";
                }
            }
        }

        //Operasi untuk Tim Pengawas
        //Tambah Data Tim Pengawas
        if (isset($_POST['pengawas_simpan'])) {
            //generate id baru
            $sql_get_last_id = "SELECT MAX(id_tim_pengawas ) AS last_id FROM tim_pengawas";
            $result = $conn->query($sql_get_last_id);
            $row = $result->fetch_assoc();
            $last_id = $row['last_id'];
    
            // Menghasilkan id_laporan baru dengan format PJM001, PJM002, ...
            if ($last_id) {
                $num = intval(substr($last_id, 3)) + 1;
            } else {
                $num = 1;
            }
            $new_id = 'TPG' . str_pad($num, 6, '0', STR_PAD_LEFT); //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
    
            // Ambil data dari form
            $id_projek = $_POST['id_projek'];
            $timpengawas = $_POST['timpengawas'];
            $timleader = $_POST['timleader'];
    
            //menyimpan ke database
            $pengawas = "INSERT INTO 
                                    tim_pengawas (id_tim_pengawas ,id_projek, tim_pengawas , tim_leader) 
                                VALUES ('$new_id','$id_projek', '$timpengawas', '$timleader')";
    
            $pengawas_insert = mysqli_query($conn, $pengawas);

            if ($pengawas_insert) {
                echo "<script>
                        sessionStorage.setItem('navigated', 'true');
                        document.location='../page/operator/operator.timpengawas.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Simpan Data Pengawas Gagal!');
                        document.location='../page/operator/operator.timpengawas.php';
                    </script>";
            }        
        }
    
        //ubah data permasalahan
        if (isset($_POST['timpengawas-ubah'])){
            // Mengambil Data
    
            $ubah = mysqli_query($conn, "UPDATE tim_pengawas SET tim_pengawas = '$_POST[tim_pengawas]', tim_leader = '$_POST[tim_leader]' WHERE id_tim_pengawas = '$_POST[id_tim_pengawas]'" );
    
            if ($ubah) {
                echo "<script>
                        sessionStorage.setItem('navigated', 'true');
                        document.location='../page/operator/operator.timPengawas.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Ubah Data Gagal!');
                        document.location='../page/operator/operator.permasalahan.php';
                    </script>";
            }
        }
    
        //Hapus data permasalahan
            if (isset($_POST['timpengawas-hapus'])){
                // Mengambil Data
    
                $hapus = mysqli_query($conn, "DELETE FROM tim_pengawas WHERE id_tim_pengawas = '$_POST[id_tim_pengawas]'" );
    
                if ($hapus) {
                    echo "<script>
                            sessionStorage.setItem('navigated', 'true');
                            document.location='../page/operator/operator.timPengawas.php';
                        </script>";
                } else {
                    echo "<script>
                            alert('Hapus Data Gagal!');
                            document.location='../page/operator/operator.permasalahan.php';
                        </script>";
                }
            }
        //Akhir Operasi Tim Pengawas


        // Operasi untuk Foto Kegiatan
        // Aksi tambah Foto Kegiatan
        if (isset($_POST['foto_simpan'])) {
            // Generate id baru
            $sql_get_last_id = "SELECT MAX(id_foto_kegiatan) AS last_id FROM foto_kegiatan";
            $result = $conn->query($sql_get_last_id);
            $row = $result->fetch_assoc();
            $last_id = $row['last_id'];
        
            // Menghasilkan id_laporan baru dengan format FTO000001, FTO000002, ...
            if ($last_id) {
                $num = intval(substr($last_id, 3)) + 1;
            } else {
                $num = 1;
            }
            $new_id = 'FTO' . str_pad($num, 6, '0', STR_PAD_LEFT);
        
            // Menyimpan post ke variabel
            $id_laporan_harian = $_POST['id_laporan_harian'];
            $keterangan = $_POST['keterangan'];
        
              // Handling file upload
            $foto_temp = $_FILES['foto']['tmp_name'];
            $foto_error = $_FILES['foto']['error'];
            
            // Mendapatkan ekstensi file asli
            $foto_ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            
            // Menentukan nama file baru dengan id yang dihasilkan
            $foto_name = $new_id . '.' . $foto_ext;
            $foto_path = '../public/asset/img/uploads/foto_kegiatan/' . $foto_name;
        
            // Periksa apakah tidak ada error saat upload
            if ($foto_error === UPLOAD_ERR_OK) {
                // Pindahkan file dari temporary location ke lokasi yang ditentukan
                if (move_uploaded_file($foto_temp, $foto_path)) {
                    // Menyimpan ke database
                    $sql_foto = "INSERT INTO foto_kegiatan (id_foto_kegiatan, id_laporan_harian, foto, keterangan) 
                                VALUES ('$new_id', '$id_laporan_harian', '$foto_name', '$keterangan')";
        
                    $foto_insert = mysqli_query($conn, $sql_foto);
        
                    if ($foto_insert) {
                        echo "<script>
                                sessionStorage.setItem('navigated', 'true');
                                document.location='../page/operator/fotokegiatan.php';
                            </script>";
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error: File tidak dapat dipindahkan.";
                    // Error tambahan untuk membantu troubleshooting
                    if (!file_exists('D:/xampp/htdocs/pengawasan_me/page/operator/uploads/')) {
                        echo "Error: Direktori tujuan tidak ditemukan.";
                    } else if (!is_writable('D:/xampp/htdocs/pengawasan/page/operator/uploads/')) {
                        echo "Error: Direktori tujuan tidak memiliki izin tulis.";
                    }
                }
            } else {
                // Menangani berbagai kesalahan upload file
                switch ($foto_error) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        echo "Error: Ukuran file terlalu besar.";
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        echo "Error: File hanya ter-upload sebagian.";
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        echo "Error: Tidak ada file yang di-upload.";
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        echo "Error: Folder temporary tidak ditemukan.";
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        echo "Error: Gagal menulis file ke disk.";
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        echo "Error: Upload file dihentikan oleh ekstensi PHP.";
                        break;
                    default:
                        echo "Error: Terjadi kesalahan yang tidak diketahui.";
                        break;
                }
            }
        }

        //operasi ubah foto
        if (isset($_POST['foto-ubah'])) {
            $id_foto_kegiatan = $_POST['id_foto_kegiatan'];
            $keterangan = $_POST['keterangan'];
            
            // Mengambil nama file lama dari database
            $sql_get_foto = "SELECT foto FROM foto_kegiatan WHERE id_foto_kegiatan = '$id_foto_kegiatan'";
            $result = mysqli_query($conn, $sql_get_foto);
        
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $old_foto_name = $row['foto'];
                $old_foto_path = '../public/asset/img/uploads/foto_kegiatan/' . $old_foto_name;
                
                // Periksa apakah ada file baru yang diupload
                if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $foto_error = $_FILES['foto']['error'];
                    $foto_name = $_FILES['foto']['name'];
                    $foto_temp = $_FILES['foto']['tmp_name'];
        
                    if ($foto_error === UPLOAD_ERR_OK) {
                        // Menghapus file lama dari server
                        if (file_exists($old_foto_path)) {
                            unlink($old_foto_path);
                        }
        
                        // Menentukan nama file baru
                        $foto_ext = pathinfo($foto_name, PATHINFO_EXTENSION);
                        $foto_new_name = $id_foto_kegiatan . '_foto.' . $foto_ext;
                        $foto_path = '../public/asset/img/uploads/foto_kegiatan/' . $foto_new_name;
        
                        // Pindahkan file dari temporary location ke lokasi yang ditentukan
                        if (move_uploaded_file($foto_temp, $foto_path)) {
                            // Update database dengan nama file baru
                            $sql_update_foto = "UPDATE foto_kegiatan SET foto = '$foto_new_name', keterangan = '$keterangan' WHERE id_foto_kegiatan = '$id_foto_kegiatan'";
                            $update_result = mysqli_query($conn, $sql_update_foto);
        
                            if ($update_result) {
                                echo "<script>
                                        sessionStorage.setItem('navigated', 'true');
                                        document.location='../page/operator/fotokegiatan.php';
                                    </script>";
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                        } else {
                            echo "Error: File tidak dapat dipindahkan.";
                            // Error tambahan untuk membantu troubleshooting
                            if (!file_exists('../public/asset/img/uploads/foto_kegiatan/')) {
                                echo "Error: Direktori tujuan tidak ditemukan.";
                            } else if (!is_writable('../public/asset/img/uploads/foto_kegiatan/')) {
                                echo "Error: Direktori tujuan tidak memiliki izin tulis.";
                            }
                        }
                    } else {
                        // Menangani berbagai kesalahan upload file
                        switch ($foto_error) {
                            case UPLOAD_ERR_INI_SIZE:
                            case UPLOAD_ERR_FORM_SIZE:
                                echo "Error: Ukuran file terlalu besar.";
                                break;
                            case UPLOAD_ERR_PARTIAL:
                                echo "Error: File hanya ter-upload sebagian.";
                                break;
                            case UPLOAD_ERR_NO_FILE:
                                echo "Error: Tidak ada file yang di-upload.";
                                break;
                            case UPLOAD_ERR_NO_TMP_DIR:
                                echo "Error: Folder temporary tidak ditemukan.";
                                break;
                            case UPLOAD_ERR_CANT_WRITE:
                                echo "Error: Gagal menulis file ke disk.";
                                break;
                            case UPLOAD_ERR_EXTENSION:
                                echo "Error: Upload file dihentikan oleh ekstensi PHP.";
                                break;
                            default:
                                echo "Error: Terjadi kesalahan yang tidak diketahui.";
                                break;
                        }
                    }
                } else {
                    // Tidak ada file baru, hanya perbarui keterangan
                    $sql_update_foto = "UPDATE foto_kegiatan SET keterangan = '$keterangan' WHERE id_foto_kegiatan = '$id_foto_kegiatan'";
                    $update_result = mysqli_query($conn, $sql_update_foto);
        
                    if ($update_result) {
                        echo "<script>
                                sessionStorage.setItem('navigated', 'true');
                                document.location='../page/operator/fotokegiatan.php';
                            </script>";
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                }
            } else {
                echo "Error: Foto tidak ditemukan.";
            }
        }
        

        // Operasi hapus foto kegiatan
        if (isset($_POST['foto-hapus'])) {
            $id_foto_kegiatan = $_POST['id_foto_kegiatan'];

            // Mengambil nama file dari database
            $sql_get_foto = "SELECT foto FROM foto_kegiatan WHERE id_foto_kegiatan = '$id_foto_kegiatan'";
            $result = mysqli_query($conn, $sql_get_foto);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $foto_name = $row['foto'];
                $foto_path = '../public/asset/img/uploads/foto_kegiatan/' . $foto_name;

                // Menghapus file dari server
                if (file_exists($foto_path)) {
                    unlink($foto_path);
                }

                // Menghapus entri dari database
                $sql_delete_foto = "DELETE FROM foto_kegiatan WHERE id_foto_kegiatan = '$id_foto_kegiatan'";
                $delete_result = mysqli_query($conn, $sql_delete_foto);

                if ($delete_result) {
                    echo "<script>
                            sessionStorage.setItem('navigated', 'true');
                            document.location='../page/operator/fotokegiatan.php';
                        </script>";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Error: Foto tidak ditemukan.";
            }
        }

        

}
?>