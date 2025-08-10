<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';
include 'header.php';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = trim($_POST['category']);
    $item_name = trim($_POST['item_name']);
    $contact_info = trim($_POST['contact_info']);
    $description = trim($_POST['description']);
    $status = trim($_POST['status']);

    if (empty($category) || empty($item_name) || empty($contact_info) || empty($description) || empty($status)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        $stmt = $conn->prepare("SELECT id FROM items WHERE category = ? AND item_name = ? AND status = ? AND contact_info = ?");
        $stmt->bind_param("ssss", $category, $item_name, $status, $contact_info);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('This item has already been posted!');</script>";
        } else {
            $image = 'default.png';
            if (!empty($_FILES['image']['name'])) {
                $target_dir = "uploads/";
                $image = time() . "_" . basename($_FILES['image']['name']);
                $target_file = $target_dir . $image;

                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    echo "<script>alert('Image upload failed. Check file size and permissions.');</script>";
                }
            }

            $stmt = $conn->prepare("INSERT INTO items (category, item_name, status, image, contact_info, description, date_reported) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssssss", $category, $item_name, $status, $image, $contact_info, $description);

            if ($stmt->execute()) {
                echo "<script>alert('Item posted successfully!'); window.location='dashboard.php';</script>";
            } else {
                echo "<script>alert('Error posting item. Please try again.');</script>";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Post an Item - FinderKeeper</title>
    <style>
        body {
            padding-top: 70px;
            background: #f4f6f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .main-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 40px;
            flex-wrap: wrap;
        }
        .form-container, .preview-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 450px;
            max-width: 90vw;
        }
        .form-container h2, .preview-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2575fc;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group input[type="file"] {
            border: none;
        }
        .btn-submit {
            background: linear-gradient(90deg, #2575fc 0%, #6a11cb 100%);
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-submit:hover {
            background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
        }
        /* Preview Card */
        .preview-card {
            background: #f9fafb;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .preview-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .preview-card h3 {
            margin: 0;
            font-size: 1.4rem;
            color: #333;
        }
        .preview-card p {
            margin: 8px 0;
            font-size: 1rem;
            color: #555;
        }
    </style>
</head>

<body>

<div class="main-container">

    <!-- Form Section -->
    <div class="form-container">
        <h2>Post an Item</h2>
        <form method="POST" enctype="multipart/form-data" id="itemForm">
            <div class="form-group">
                <label>Category</label>
                <select name="category" required onchange="updatePreview('category', this.value)">
                    <option value="">Select Category</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Documents">Documents</option>
                    <option value="Clothing">Clothing</option>
                    <option value="Accessories">Accessories</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            <div class="form-group">
                <label>Item Name</label>
                <input type="text" name="item_name" required oninput="updatePreview('name', this.value)">
            </div>

            <div class="form-group">
                <label>Contact Information</label>
                <input type="text" name="contact_info" required oninput="updatePreview('contact', this.value)">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" required onchange="updatePreview('status', this.value)">
                    <option value="Lost">Lost</option>
                    <option value="Found">Found</option>
                </select>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4" required oninput="updatePreview('description', this.value)"></textarea>
            </div>

            <div class="form-group">
                <label>Upload Image</label>
                <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
            </div>

            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>

    <!-- Live Preview Section -->
    <div class="preview-container">
        <h2>Live Preview</h2>
        <div class="preview-card">
            <img id="previewImage" src="uploads/default.png" alt="Preview Image">
            <h3 id="previewName">Item Name</h3>
            <p id="previewCategory">Category</p>
            <p id="previewStatus" style="font-weight: bold;">Status</p>
            <p id="previewContact">Contact Info</p>
            <p id="previewDescription">Description</p>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>

<script>
function updatePreview(type, value) {
    if (type === 'name') document.getElementById('previewName').innerText = value || "Item Name";
    if (type === 'category') document.getElementById('previewCategory').innerText = "Category: " + value;
    if (type === 'status') document.getElementById('previewStatus').innerText = value;
    if (type === 'contact') document.getElementById('previewContact').innerText = "Contact: " + value;
    if (type === 'description') document.getElementById('previewDescription').innerText = value;
}

function previewImage(event) {
    let reader = new FileReader();
    reader.onload = function(){
        document.getElementById('previewImage').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</body>
</html>