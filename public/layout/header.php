<?//php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--  jQuery dan DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Font From Google -->
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&family=Inter:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="../../css/general.css" rel="stylesheet">
</head>

<style>
    .navbar-toggler {
    position: relative; /* Pastikan posisi relatif jika diperlukan */
    z-index: 1050; /* Atur z-index jika ikon tertutup oleh elemen lain */
}

.nav-head {
    position: relative;
    font-size: 16px; /* Sesuaikan ukuran font jika perlu */
    text-decoration: none;
    color: #000; /* Sesuaikan warna teks jika perlu */
}

.nav-head::before,
.nav-head::after {
    content: '';
    position: absolute;
    left: 0;
    width: 100%;
    height: 2px; /* Tinggi garis */
    background-color: #000; /* Warna garis */
    transition: transform 0.3s ease;
}

.nav-head::before {
    top: 0;
    transform: scaleX(0);
}

.nav-head::after {
    bottom: 0;
    transform: scaleX(0);
}

.nav-head:hover::before,
.nav-head:hover::after {
    transform: scaleX(1);
}

/* Jika Anda menggunakan Font Awesome atau pustaka ikon lainnya */
.navbar-toggler-icon {
    color: #000; /* Pastikan warna ikon terlihat */
    font-size: 24px; /* Sesuaikan ukuran ikon jika perlu */
}

</style>
<body>
    <nav class="container navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <?php echo $navBrands; ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center offset-lg-3" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">

                <!-- Nav items will be included dynamically -->
                <?php echo $navItems; ?>

                <li class="nav-item dropdown ms-lg-5">
                    <a class="nav-link nav-head dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bxs-user-circle" style="font-size: 24px;"></i>
                        <i class='bx bx-caret-down'></i>
                    </a>
                    <ul class="dropdown-menu"> 
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../admin/m_projek_utkop.php"><i class="bx bx-log-out" style="margin-right: 5px;"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>