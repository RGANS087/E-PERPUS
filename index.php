<?php
include('koneksi.php');

if(!isset($_SESSION['user'])) {
    header('Location: login.php');
}

if ($_SESSION['user']['level'] == 'admin') {
    $profilePhoto = "./assets/img/admin.jpg";
}

if ($_SESSION['user']['level'] == 'peminjam') {
    $profilePhoto = "./assets/img/peminjam.jpg";
}

if ($_SESSION['user']['level'] == 'petugas') {
    $profilePhoto = "./assets/img/petugas.jpg";
}

$id = $_SESSION['user']['id_user'];
$query = mysqli_query($conn, "SELECT status FROM user WHERE id_user='$id'");
$data = mysqli_fetch_assoc($query);

if ($data['status'] != 'aktif') {
    session_unset();
    session_destroy();
    echo "<script>alert('Akun Anda telah dibanned. Silakan hubungi admin.'); window.location.href='login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Akek E-Library</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark sb-sidenav-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-1 pe-3" href="?">Dashboard <?php echo $_SESSION['user']['level'] ?></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <div class="d-flex justify-content-between w-100">
            <h5 class="m-3 fw-bold">Selamat datang <?php echo $_SESSION['user']['nama']; ?></h5>
            <div class="d-flex align-items-center">
                <i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;
                <span id="time" class="fw-light"></span>
            </div>
            </div>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav mb-4" style="overflow: hidden;">
                            <div class="text-center m-2">
                                <img src="<?php echo $profilePhoto; ?>" alt="admin" class="rounded-circle border border-2 border-light w-50 mb-2">
                                <p class="mt-2 fw-bold text-light"><?php echo $_SESSION['user']['nama']; ?></p>
                                <p class="mt-2 fw-bold text-light">Created at:<br><?php echo $_SESSION['user']['created_at'] ?></p>
                            </div>
                            <script>
                                    function Time() {
                                        var options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                                        var now = new Date();
                                        document.getElementById("time").innerHTML = now.toLocaleDateString('id-ID', options);
                                        setTimeout(Time, 1000);
                                    }
                                    Time();
                                </script>
                            <div class="sb-sidenav-menu-heading">Main</div>
                            <a class="nav-link" href="?">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Navigasi</div>
                            <?php
                            if ($_SESSION['user']['level'] != 'peminjam') {
                            ?>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="?page=kategori">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Kategori
                            </a>
                            <a class="nav-link" href="?page=buku">
                                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                Buku
                            </a>
                            <?php
                            } else {
                            ?>
                            <a class="nav-link" href="?page=list_buku">
                                <div class="sb-nav-link-icon"><i class="fas fa-swatchbook"></i></div>
                                Daftar Buku
                            </a>
                            <a class="nav-link" href="?page=peminjaman">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Peminjaman
                            </a>
                        <?php } ?>
                            <a class="nav-link" href="?page=ulasan">
                                <div class="sb-nav-link-icon"><i class="fas fa-comment"></i></div>
                                Ulasan
                            </a>
                            <?php if($_SESSION['user']['level'] != 'peminjam') { ?>
                            <a class="nav-link" href="?page=peminjaman_admin">
                                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                Laporan Peminjaman
                            </a>
                            <?php if ($_SESSION['user']['level'] == 'admin') {?>
                            <a class="nav-link" href="?page=laporan">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Cetak Laporan
                            </a>
                        <?php } ?>
                        <?php } ?>
                            <a class="nav-link" href="?page=anggota">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Anggota
                            </a>
                            <a class="nav-link" href="?page=statistik">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-simple"></i></div>
                                Statistik
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-power-off"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $_SESSION['user']['level']; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                        if (file_exists($page . '.php')) {
                            include $page . '.php';
                        } else {
                            include '404.php';
                        }
                        ?> 
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; E-Library 2025</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>
