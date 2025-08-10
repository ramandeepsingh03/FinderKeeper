<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include __DIR__ . '/config.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - FinderKeeper</title>
    <style>
    /* Basic Page Setup */
    body {
        margin: 0;
        padding-top: 80px;
        font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg,rgb(250, 250, 250), #ffffff);
        min-height: 100vh;
    }

    /* Search Section */
    .search-container {
        margin: 20px auto;
        width: 90%;
        max-width: 1100px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 12px;
    }
    .search-container input, 
    .search-container select {
        padding: 14px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 15px;
        flex: 1 1 220px;
        background: white;
        transition: 0.3s;
    }
    .search-container input:focus, 
    .search-container select:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 8px rgba(59, 130, 246, 0.4);
        outline: none;
    }
    .search-container button {
        padding: 14px 24px;
        background: linear-gradient(90deg, #3B82F6, #6366F1);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.4s, transform 0.2s;
    }
    .search-container button:hover {
        background: linear-gradient(90deg, #6366F1, #3B82F6);
        transform: scale(1.05);
    }

    /* Card Section */
    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 30px 20px;
    }
    .item-card {
        width: 260px;
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        cursor: pointer;
    }
    .item-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 30px rgba(59, 130, 246, 0.2);
    }
    .item-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .card-body {
        padding: 20px;
        text-align: center;
    }
    .item-title {
        font-size: 20px;
        font-weight: 600;
        color: #1e293b;
    }
    .item-category {
        font-size: 14px;
        color: #64748b;
        margin-top: 6px;
    }
    .item-status {
        margin-top: 10px;
        font-weight: bold;
        color: #3B82F6;
    }
    .item-status.lost {
        color: #EF4444;
    }
    .item-status.found {
        color: #10B981;
    }
    .item-contact {
        margin-top: 8px;
        font-size: 14px;
        color: #0EA5E9;
    }

    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow-y: auto;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(8px);
        padding-top: 60px;
    }
    .modal-content {
        background: rgba(255, 255, 255, 0.95);
        margin: auto;
        padding: 35px;
        border-radius: 20px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        animation: fadeInZoom 0.3s ease;
        position: relative;
    }
    @keyframes fadeInZoom {
        from { transform: scale(0.85); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .modal-content img {
        width: 100%;
        height: auto;
        border-radius: 14px;
        margin-bottom: 20px;
    }
    .modal-content h2 {
        color: #3B82F6;
        margin-bottom: 15px;
    }
    .modal-content p {
        font-size: 16px;
        color: #1e293b;
        margin: 8px 0;
    }
    .close-btn {
        position: absolute;
        top: 18px;
        right: 25px;
        font-size: 30px;
        font-weight: bold;
        color: #555;
        cursor: pointer;
    }
    .close-btn:hover {
        color: #000;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .search-container {
            flex-direction: column;
            align-items: center;
        }
        .item-card {
            width: 90%;
        }
    }
</style>
</head>

<body>

<!-- Search Bar -->
<div class="search-container">
    <input type="text" id="search-name" placeholder="Search by Name">
    <select id="search-category">
        <option value="">Select Category</option>
        <option value="Electronics">Electronics</option>
        <option value="Documents">Documents</option>
        <option value="Clothing">Clothing</option>
        <option value="Accessories">Accessories</option>
        <option value="Others">Others</option>
    </select>
    <select id="search-status">
        <option value="">Select Status</option>
        <option value="Lost">Lost</option>
        <option value="Found">Found</option>
    </select>
    <button onclick="filterItems()">Search</button>
</div>

<!-- Items Grid -->
<div class="card-container" id="items-container">
    <?php
    $items = $conn->query("SELECT * FROM `items` ORDER BY id DESC");
    while ($row = $items->fetch_assoc()):
        $image = (!empty($row['image']) && $row['image'] !== 'NULL') ? 'uploads/' . $row['image'] : 'uploads/default.png';
    ?>
        <div class="item-card" 
            onclick="openModal('<?= htmlspecialchars($row['item_name']) ?>', '<?= htmlspecialchars($row['category']) ?>', '<?= htmlspecialchars($row['status']) ?>', '<?= htmlspecialchars($row['contact_info']) ?>', '<?= htmlspecialchars($row['description']) ?>', '<?= $image ?>')"
            data-name="<?= strtolower($row['item_name']) ?>"
            data-category="<?= strtolower($row['category']) ?>"
            data-status="<?= strtolower($row['status']) ?>">
            <img src="<?= $image ?>" alt="<?= $row['item_name'] ?>">
            <div class="card-body">
                <div class="item-title"><?= $row['item_name'] ?></div>
                <div class="item-category">Category: <?= $row['category'] ?></div>
                <div class="item-status" style="color: <?= $row['status'] == 'Lost' ? 'red' : 'green' ?>;">
                    <?= strtoupper($row['status']) ?>
                </div>
                <div class="item-contact">Contact: <?= $row['contact_info'] ?></div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<!-- Modal for Enlarged View -->
<div id="itemModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <img id="modalImage" src="" alt="Item Image">
        <h2 id="modalItemName"></h2>
        <p><strong>Category:</strong> <span id="modalCategory"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
        <p><strong>Contact:</strong> <span id="modalContact"></span></p>
        <p id="modalDescription"></p>
    </div>
</div>

<!-- JavaScript for Search and Modal -->
<script>
function filterItems() {
    let name = document.getElementById("search-name").value.toLowerCase();
    let category = document.getElementById("search-category").value.toLowerCase();
    let status = document.getElementById("search-status").value.toLowerCase();
    
    document.querySelectorAll(".item-card").forEach(card => {
        let itemName = card.getAttribute("data-name");
        let itemCategory = card.getAttribute("data-category");
        let itemStatus = card.getAttribute("data-status");

        if ((name === "" || itemName.includes(name)) &&
            (category === "" || itemCategory === category) &&
            (status === "" || itemStatus === status)) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}

function openModal(name, category, status, contact, description, imageUrl) {
    document.getElementById('modalItemName').innerText = name;
    document.getElementById('modalCategory').innerText = category;
    document.getElementById('modalStatus').innerText = status;
    document.getElementById('modalContact').innerText = contact;
    document.getElementById('modalDescription').innerText = description;
    document.getElementById('modalImage').src = imageUrl;

    document.getElementById('itemModal').style.display = "block";
}

function closeModal() {
    document.getElementById('itemModal').style.display = "none";
}
</script>

<?php include 'footer.php'; ?>
</body>
</html>