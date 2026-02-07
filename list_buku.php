<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .search-bar {
            transition: width 0.3s ease-in-out;
            width: 160px;
        }
        .search-bar:focus {
            width: 300px;
        }
        .modal-backdrop {
            z-index: -1;
        }
        .disabled-link {
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center m-4">
        <div class="position-relative">
            <input type="text" id="searchInput" class="form-control rounded-pill search-bar pe-5" placeholder="Search by Title...">
            <button class="btn position-absolute top-50 end-0 translate-middle-y" type="button">🔍</button>
        </div>

        <!-- Dropdown Pencarian Kategori -->
        <div>
            <select id="categoryFilter" class="form-select">
                <option value="">Pilih Kategori</option>
                <?php
                $kategori_query = mysqli_query($conn, "SELECT * FROM kategori");
                while ($kategori = mysqli_fetch_array($kategori_query)) {
                    echo "<option value='{$kategori['kategori']}'>{$kategori['kategori']}</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row" id="book-list">
        <?php
        $query = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku DESC");
        while ($data = mysqli_fetch_array($query)) {
            $gambar = !empty($data['gambar']) ? $data['gambar'] : "noImage.jpg";

            $kategori_query = mysqli_query($conn, "SELECT k.kategori FROM kategori k
                                                   JOIN buku_kategori bk ON bk.id_kategori = k.id_kategori
                                                   WHERE bk.id_buku = " . $data['id_buku']);
            $kategori_list = [];
            while ($kategori = mysqli_fetch_array($kategori_query)) {
                $kategori_list[] = $kategori['kategori'];
            }
            $kategori_str = implode(", ", $kategori_list);
        ?>
            <div class="col-md-4 mb-4 book-item" data-title="<?php echo strtolower($data['judul']); ?>" data-category="<?php echo strtolower($kategori_str); ?>">
                <div class="card shadow-lg m-4" data-aos="zoom-in-up" style="height: 100%; cursor: pointer;" onclick="openModal('<?php echo $data['judul']; ?>', '<?php echo $data['deskripsi']; ?>', '<?php echo $data['penulis']; ?>', '<?php echo $data['tahun_terbit']; ?>', '<?php echo $data['penerbit']; ?>', '<?php echo $data['stok']; ?>', './assets/upload/<?php echo $gambar; ?>', '<?php echo $data['id_buku']; ?>', '<?php echo $kategori_str; ?>')">
                    <img class="card-img-top" src="./assets/upload/<?php echo $gambar; ?>" alt="Gambar Buku" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column flex-grow-1">
                        <h5 class="card-title text-center fw-bold book-title"> <?php echo $data['judul']; ?> </h5>
                        <p class="card-text" style="flex-grow: 1;"> <?php echo substr($data['deskripsi'], 0, 100); ?>...</p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="bookImage" class="img-fluid mb-3" style="width: 100%; height: 200px; object-fit: cover;">
                <p id="bookDescription"></p>
                <ul class="list-group">
                    <li class="list-group-item">Penulis: <span id="bookAuthor"></span></li>
                    <li class="list-group-item">Tahun Terbit: <span id="bookYear"></span></li>
                    <li class="list-group-item">Penerbit: <span id="bookPublisher"></span></li>
                    <li class="list-group-item">Stok: <span id="bookStock"></span></li>
                    <li class="list-group-item">Kategori: <span id="bookCategory"></span></li>
                </ul>
            </div>
            <div class="modal-footer">
                <a id="borrowLink" class="btn btn-info">Pinjam</a>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(title, description, author, year, publisher, stock, image, bookId, categories) {
        document.getElementById('bookTitle').innerText = title;
        document.getElementById('bookDescription').innerText = description;
        document.getElementById('bookAuthor').innerText = author;
        document.getElementById('bookYear').innerText = year;
        document.getElementById('bookPublisher').innerText = publisher;
        document.getElementById('bookStock').innerText = stock;
        document.getElementById('bookCategory').innerText = categories;
        document.getElementById('bookImage').src = image;

        let borrowLink = document.getElementById('borrowLink');
        if (parseInt(stock) > 0) {
            borrowLink.href = `?page=peminjaman_tambah&id_buku=${bookId}`;
            borrowLink.classList.remove('disabled-link');
        } else {
            borrowLink.href = "#";
            borrowLink.classList.add('disabled-link');
        }

        let modal = new bootstrap.Modal(document.getElementById('bookModal'));
        modal.show();
    }

    function filterBooks() {
        let searchText = document.getElementById('searchInput').value.toLowerCase();
        let selectedCategory = document.getElementById('categoryFilter').value.toLowerCase();
        let books = document.querySelectorAll('.book-item');

        books.forEach(book => {
            let title = book.getAttribute('data-title');
            let categories = book.getAttribute('data-category');

            let matchTitle = searchText === "" || title.includes(searchText);
            let matchCategory = selectedCategory === "" || categories.includes(selectedCategory);

            book.style.display = matchTitle && matchCategory ? '' : 'none';
        });
    }

    document.getElementById('searchInput').addEventListener('input', filterBooks);
    document.getElementById('categoryFilter').addEventListener('change', filterBooks);
</script>
</body>
</html>
