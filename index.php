<?php
include('db.php'); // Kết nối CSDL

$sql = "SELECT * FROM sinhvien";
$stmt = $pdo->query($sql);
$sinhviens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sinh Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        a {
            text-decoration: none;
            color: #fff;
            padding: 8px 12px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 10px;
        }
        .btn-add {
            background-color: #28a745;
        }
        .btn-add:hover {
            background-color: #218838;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .btn-edit {
            background-color: #ffc107;
        }
        .btn-detail {
            background-color: #17a2b8;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-edit:hover { background-color: #e0a800; }
        .btn-detail:hover { background-color: #138496; }
        .btn-delete:hover { background-color: #c82333; }
        img {
            border-radius: 5px;
            width: 80px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>QUẢN LÝ SINH VIÊN</h1>
    <a href="create.php" class="btn-add">Thêm Sinh Viên</a>
    <table>
        <tr>
            <th>MaSV</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Hình</th>
            <th>Ngành</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($sinhviens as $sv): ?>
            <tr>
                <td><?= isset($sv['MaSV']) ? htmlspecialchars($sv['MaSV']) : 'N/A' ?></td>
                <td><?= isset($sv['HoTen']) ? htmlspecialchars($sv['HoTen']) : 'N/A' ?></td>
                <td><?= isset($sv['GioiTinh']) ? htmlspecialchars($sv['GioiTinh']) : 'N/A' ?></td>
                <td><?= isset($sv['NgaySinh']) ? htmlspecialchars($sv['NgaySinh']) : 'N/A' ?></td>
                <td>
                    <?php if (!empty($sv['Hinh'])): ?>
                        <img src="/php/kiemtra/app/images/<?= basename($sv['Hinh']) ?>">
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td><?= isset($sv['MaNganh']) ? htmlspecialchars($sv['MaNganh']) : 'N/A' ?></td>
                <td>
                    <a href="edit.php?id=<?= $sv['MaSV'] ?>" class="btn-edit">Edit</a>
                    <a href="detail.php?id=<?= $sv['MaSV'] ?>" class="btn-detail">Details</a>
                    <a href="delete.php?id=<?= $sv['MaSV'] ?>" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
