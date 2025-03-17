<?php
include('db.php');

if (!isset($_GET['id'])) {
    die("Không tìm thấy ID");
}

$MaSV = $_GET['id'];

$sql = "SELECT * FROM sinhvien WHERE MaSV = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$MaSV]);
$sinhvien = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sinhvien) {
    die("Không tìm thấy sinh viên");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Sinh Viên</title>
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
        p {
            font-size: 18px;
            color: #555;
        }
        img {
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
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
        <h1>Chi Tiết Sinh Viên</h1>
        <p><strong>Mã SV:</strong> <?= htmlspecialchars($sinhvien['MaSV']) ?></p>
        <p><strong>Họ Tên:</strong> <?= htmlspecialchars($sinhvien['HoTen']) ?></p>
        <p><strong>Giới Tính:</strong> <?= htmlspecialchars($sinhvien['GioiTinh']) ?></p>
        <p><strong>Ngày Sinh:</strong> <?= htmlspecialchars($sinhvien['NgaySinh']) ?></p>
        <p><strong>Mã Ngành:</strong> <?= htmlspecialchars($sinhvien['MaNganh']) ?></p>
        <p>
            <strong>Hình:</strong><br>
            <?php if (!empty($sinhvien['Hinh'])): ?>
                <img src="/php/kiemtra/app/images/<?= htmlspecialchars($sinhvien['Hinh']) ?>" width="150">
            <?php else: ?>
                <p>Không có ảnh</p>
            <?php endif; ?>
        </p>
        <a class="back-btn" href="index.php">Quay lại</a>
    </div>
</body>
</html>
