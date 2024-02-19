<?php
include '../koneksi.php';

// Pagination
$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Check if the request is a POST request and if the keyword is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["keyword"])) {
    // Sanitize the keyword to prevent SQL injection
    $keyword = mysqli_real_escape_string($koneksi, $_POST["keyword"]);

    // Query to search books by title or author
    $query = "SELECT * FROM buku WHERE judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%' OR tahun_terbit LIKE '%$keyword%' LIMIT $limit OFFSET $offset";
    $result = mysqli_query($koneksi, $query);
?>
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Cover</th>
            <th scope="col">Judul</th>
            <th scope="col">Pengarang</th>
            <th scope="col">Tahun Terbit</th>
            <!-- Tambahkan kolom sesuai dengan struktur tabel buku -->
            <th style="text-align: center;">Aksi</th>
        </tr>
    </thead>
    <?php

    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        // Display the results in a table format
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td><img src="' . $row['cover'] . '" alt="Cover" style="max-width: 100px; max-height: 100px;"></td>';
            echo '<td>' . $row['judul'] . '</td>';
            echo '<td>' . $row['penulis'] . '</td>';
            echo '<td>' . $row['tahun_terbit'] . '</td>';
            echo '<td class="text-center">';
            echo '<a class="badge badge-danger mr-2" onclick="return confirm(\'Yakin Mau Hapus buku?\')" href="delete.php?id=' . $row['id'] . '">Delete</a>';
            echo '<a class="badge badge-success" href="edit.php?id=' . $row['id'] . '">Edit</a>';
            echo '</td>';
            echo '</tr>';
        }
        // Display Pagination if the number of search results is more than limit
        $total_books_query = "SELECT COUNT(*) as total FROM buku WHERE judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%'";
        $total_books_result = mysqli_query($koneksi, $total_books_query);
        $total_books_row = mysqli_fetch_assoc($total_books_result);
        $total_books = $total_books_row['total'];
        $total_pages = ceil($total_books / $limit);
        if ($total_pages > 1) {
    ?>
            <nav aria-label="Page navigation example">
                <ul class="justify-content-center pagination">
                    <!-- Previous Page Button -->
                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?= ($page <= 1) ? 1 : ($page - 1); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <!-- Page Buttons -->
                    <?php
                    $start_page = max(1, $page - 2);
                    $end_page = min($total_pages, $page + 2);

                    for ($i = $start_page; $i <= $end_page; $i++) :
                    ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next Page Button -->
                    <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?= ($page >= $total_pages) ? $total_pages : ($page + 1); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
<?php
        }
    } else {
        // If no results found, display a message
        echo '<tr><td colspan="7" class="text-center">Tidak ada buku yang ditemukan.</td></tr>';
    }
} else {
    // If the request method is not POST or keyword is not set, display an error message
    echo '<tr><td colspan="7" class="text-center">Permintaan tidak valid.</td></tr>';
}
?>