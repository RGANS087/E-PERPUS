<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">📊 Statistik Peminjaman</h2>

    <div class="row">
        <!-- Statistik User Paling Sering Meminjam -->
        <div class="col-md-6">
            <h4 class="text-center">👤 User Paling Sering Meminjam</h4>
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Rank</th>
                        <th>Nama User</th>
                        <th>Jumlah Peminjaman</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $queryUser = mysqli_query($conn, 
                        "SELECT u.nama, COUNT(p.id_peminjaman) AS total_peminjaman
                        FROM peminjaman p
                        JOIN user u ON p.id_user = u.id_user
                        GROUP BY p.id_user
                        ORDER BY total_peminjaman DESC
                        LIMIT 5");

                    $rank = 1;
                    while ($user = mysqli_fetch_array($queryUser)) {
                        echo "<tr>
                                <td>{$rank}</td>
                                <td>{$user['nama']}</td>
                                <td>{$user['total_peminjaman']}</td>
                              </tr>";
                        $rank++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Statistik Buku Paling Sering Dipinjam -->
        <div class="col-md-6">
            <h4 class="text-center">📚 Buku Paling Sering Dipinjam</h4>
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Rank</th>
                        <th>Judul Buku</th>
                        <th>Jumlah Dipinjam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $queryBuku = mysqli_query($conn, 
                        "SELECT b.judul, COUNT(p.id_peminjaman) AS total_dipinjam
                        FROM peminjaman p
                        JOIN buku b ON p.id_buku = b.id_buku
                        GROUP BY p.id_buku
                        ORDER BY total_dipinjam DESC
                        LIMIT 5");

                    $rank = 1;
                    while ($buku = mysqli_fetch_array($queryBuku)) {
                        echo "<tr>
                                <td>{$rank}</td>
                                <td>{$buku['judul']}</td>
                                <td>{$buku['total_dipinjam']}</td>
                              </tr>";
                        $rank++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
