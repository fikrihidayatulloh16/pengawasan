<!-- Tambah Modal Sub-->
<div class="modal fade" id="subTambah<?= $data['id_m_pekerjaan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Master Sub Pekerjaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="subPekerjaanForm<?= $data['id_m_pekerjaan'] ?>" action="../../script/insert.php" method="POST">
                <input type="hidden" name="id_m_pekerjaan" value="<?= $_SESSION['id_m_pekerjaan'] ?>">
                <?php $id_m_pekerjaan = $data['id_m_pekerjaan'] ?>
                <div class="modal-body">
                    <!-- Static ID and hidden input field -->
                    <div class="form-group mb-3">
                        <label for="id_m_sub_pekerjaan" class="form-label">ID Pekerjaan (Tidak Bisa Diubah)</label>
                        <h5 class="form-label"><?= $data['id_m_pekerjaan'] ?></h5>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nama_sub_pekerjaan" class="form-label">Nama Sub Pekerjaan</label>
                        <button type="button" class="btn btn-success" onclick="addForm()"><i class='bx bx-plus-medical' name="btambah"></i>Tambah Form</button>
                    </div>
                    <div id="formContainer">
                        <!-- Initial form group -->
                        <div class="input-group mb-3 add-form">
                            <input type="text" class="form-control" name="nama_sub_pekerjaan[]" placeholder="ID Sub : SP<?= str_pad($num, 6, '0', STR_PAD_LEFT) ?>" aria-describedby="button-addon2" required>
                            <button type="button" class="btn btn-danger btn-outline-secondary text-light" onclick="removeForm(this)">Hapus</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="sub_simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Mendapatkan nomor ID terakhir dari server
    var lastId = <?= json_encode($last_id) ?>;
    var num = lastId ? parseInt(lastId.substr(2)) + 1 : 1;

    function addForm() {
        // Mendapatkan elemen form container
        var formContainer = document.getElementById('formContainer');
        if (!formContainer) {
            console.error('Form container tidak ditemukan');
            return;
        }
        
        // Membuat form group baru
        var formGroup = document.createElement('div');
        formGroup.className = 'input-group mb-3 add-form';
        
        // Menghasilkan ID baru
        var newId = 'SP' + num.toString().padStart(6, '0');
        num++;

        // Menambahkan elemen form ke form group
        formGroup.innerHTML = `
            <input type="text" class="form-control" name="nama_sub_pekerjaan[]" placeholder="ID Sub : ${newId}" aria-describedby="button-addon2" required>
            <button type="button" class="btn btn-danger btn-outline-secondary text-light" onclick="removeForm(this)">Hapus</button>
        `;
        
        // Menambahkan form group baru ke dalam form container
        formContainer.appendChild(formGroup);
    }

    function removeForm(button) {
        // Mendapatkan elemen form group yang mengandung tombol hapus
        var formGroup = button.parentNode;
        // Menghapus form group
        formGroup.remove();
        
    }
</script>
