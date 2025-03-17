<?php
include('db.php');

if (!isset($_GET['id'])) {
    die("Không tìm thấy ID");
}

$MaSV = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Xử lý cập nhật hình ảnh (nếu có)
    if (!empty($_FILES["Hinh"]["name"])) {
        $targetDir = "app/images/";
        $fileName = time() . "_" . basename($_FILES["Hinh"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], __DIR__ . "/../../" . $targetFilePath)) {
            $sql = "UPDATE sinhvien SET HoTen=?, GioiTinh=?, NgaySinh=?, Hinh=?, MaNganh=? WHERE MaSV=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$HoTen, $GioiTinh, $NgaySinh, $targetFilePath, $MaNganh, $MaSV]);
        }
    } else {
        $sql = "UPDATE sinhvien SET HoTen=?, GioiTinh=?, NgaySinh=?, MaNganh=? WHERE MaSV=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$HoTen, $GioiTinh, $NgaySinh, $MaNganh, $MaSV]);
    }

    header("Location: index.php");
    exit();
}

// Lấy dữ liệu sinh viên để hiển thị
$sql = "SELECT * FROM sinhvien WHERE MaSV = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$MaSV]);
$sinhvien = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Sinh Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 40%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin: 50px auto;
        }
        h1 {
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .image-preview {
            margin-top: 10px;
        }
        .image-preview img {
            border-radius: 5px;
            max-width: 150px;
            height: auto;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .back-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chỉnh Sửa Sinh Viên</h1>
        <form method="POST" enctype="multipart/form-data">
            <label>Họ Tên:</label>
            <input type="text" name="HoTen" value="<?= htmlspecialchars($sinhvien['HoTen']) ?>" required>

            <label>Giới Tính:</label>
            <select name="GioiTinh">
                <option value="Nam" <?= $sinhvien['GioiTinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= $sinhvien['GioiTinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
            </select>

            <label>Ngày Sinh:</label>
            <input type="date" name="NgaySinh" value="<?= htmlspecialchars($sinhvien['NgaySinh']) ?>" required>

            <label>Hình Ảnh:</label>
            <input type="file" name="Hinh">
            <div class="image-preview">
                <?php if (!empty($sinhvien['Hinh'])): ?>
                    <img src="/<?= htmlspecialchars($sinhvien['Hinh']) ?>">
                <?php else: ?>
                    <p>Không có ảnh</p>
                <?php endif; ?>
            </div>

            <label>Mã Ngành:</label>
            <input type="text" name="MaNganh" value="<?= htmlspecialchars($sinhvien['MaNganh']) ?>" required>

            <button type="submit">Cập Nhật</button>
        </form>
        <a class="back-btn" href="index.php">Quay lại</a>
    </div>
</body>
</html>
