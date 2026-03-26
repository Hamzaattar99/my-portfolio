<?php
require_once "../includes/db.php";

// تحديد نوع العملية
$action = $_GET['action'] ?? '';

if($action === 'search') {
    // بحث لحظي
    $query = $_GET['query'] ?? '';

    if(!empty($query)){
        $stmt = $conn->prepare("SELECT * FROM skills WHERE skill_name_en LIKE ? OR skill_name_ar LIKE ? ORDER BY created_at DESC");
        $like = "%$query%";
        $stmt->bind_param("ss", $like, $like);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT * FROM skills ORDER BY created_at DESC");
    }

    // إعادة HTML للمهارات
    while($row = $result->fetch_assoc()):
?>
<div class="skill-item">
    <div>
        <strong><?php echo $row['skill_name_en']; ?></strong> |
        <?php echo $row['skill_name_ar']; ?>
        <span class="level <?php echo strtolower($row['skill_level']); ?>">
            <?php echo $row['skill_level']; ?>
        </span>
    </div>
    <div>
        <button class="btn btn-warning btn-sm"
        onclick="editSkill(
        <?php echo $row['skill_id']; ?>,
        '<?php echo $row['skill_name_en']; ?>',
        '<?php echo $row['skill_name_ar']; ?>',
        '<?php echo $row['skill_level']; ?>'
        )">Edit</button>

        <button class="btn btn-danger btn-sm"
        onclick="deleteSkill(<?php echo $row['skill_id']; ?>)">Delete</button>
    </div>
</div>
<?php endwhile;

} else {
    // إضافة / تعديل المهارة
    $id = $_POST['id'] ?? '';
    $en = $_POST['en'] ?? '';
    $ar = $_POST['ar'] ?? '';
    $level = $_POST['level'] ?? 'Beginner';

    if(empty($id)){
        // Insert
        $stmt = $conn->prepare("INSERT INTO skills (skill_name_en, skill_name_ar, skill_level) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $en, $ar, $level);
        $stmt->execute();
    } else {
        // Update
        $stmt = $conn->prepare("UPDATE skills SET skill_name_en=?, skill_name_ar=?, skill_level=? WHERE skill_id=?");
        $stmt->bind_param("sssi", $en, $ar, $level, $id);
        $stmt->execute();
    }
}