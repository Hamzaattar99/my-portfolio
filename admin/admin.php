<?php
session_start();
require_once "../includes/db.php";

$currentRole = $_SESSION['role'] ?? 'admin';

// جلب المستخدمين
$result = $conn->query("SELECT user_id, username, role, is_active FROM admin ORDER BY user_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admins</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/adminDahs.css">
<link rel="stylesheet" href="../assets/css/admin_users.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="admin-body">

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">Admin Management</span>
    <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</nav>

<div class="container py-4">

    <div class="d-flex justify-content-between mb-3">
        <h4>Admins</h4>

        <?php if($currentRole === 'superAdmin'): ?>
        <button class="btn btn-success" onclick="openForm()">+ Add Admin</button>
        <?php endif; ?>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <?php if($currentRole === 'superAdmin'): ?>
                    <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>

            <tbody id="adminsTable">

                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['username']; ?></td>

                    <td>
                        <span class="badge bg-info"><?php echo $row['role']; ?></span>
                    </td>

                    <td>
                        <?php if($row['is_active']): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inactive</span>
                        <?php endif; ?>
                    </td>

                    <?php if($currentRole === 'superAdmin'): ?>
                    <td>
                        <button class="btn btn-warning btn-sm"
                            onclick="editAdmin(
                                <?php echo $row['user_id']; ?>,
                                '<?php echo addslashes($row['username']); ?>',
                                '<?php echo $row['role']; ?>',
                                <?php echo $row['is_active']; ?>
                            )">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <button class="btn btn-danger btn-sm"
                            onclick="deleteAdmin(<?php echo $row['user_id']; ?>)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>

            </tbody>
        </table>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="adminModal">
<div class="modal-dialog">
<div class="modal-content bg-dark text-white">

<div class="modal-header">
<h5 id="formTitle">Add Admin</h5>
<button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="hidden" id="admin_id">

<input type="text" id="username" class="form-control mb-2" placeholder="Username">

<input type="password" id="password" class="form-control mb-2" placeholder="Password (only for new)">

<select id="role" class="form-control mb-2">
<option value="admin">Admin</option>
<option value="superAdmin">Super Admin</option>
</select>

<select id="status" class="form-control">
<option value="1">Active</option>
<option value="0">Inactive</option>
</select>

</div>

<div class="modal-footer">
<button class="btn btn-primary w-100" onclick="saveAdmin()">Save</button>
</div>

</div>
</div>
</div>

<script src="../assets/js/admin_users.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>