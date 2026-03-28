<?php
require_once "../includes/db.php";

$action = $_GET['action'] ?? '';

if($_SERVER['REQUEST_METHOD']=="POST"){

    $id = $_POST['id'] ?? '';

    if(empty($id)){
        $stmt = $conn->prepare("INSERT INTO experience 
        (exp_title_en,exp_title_ar,exp_company,exp_description_en,exp_description_ar,start_date,end_date)
        VALUES (?,?,?,?,?,?,?)");

        $stmt->bind_param("sssssss",
            $_POST['title_en'],
            $_POST['title_ar'],
            $_POST['company'],
            $_POST['desc_en'],
            $_POST['desc_ar'],
            $_POST['start_date'],
            $_POST['end_date']
        );
    } else {
        $stmt = $conn->prepare("UPDATE experience SET 
        exp_title_en=?,exp_title_ar=?,exp_company=?,exp_description_en=?,exp_description_ar=?,start_date=?,end_date=? 
        WHERE exp_id=?");

        $stmt->bind_param("sssssssi",
            $_POST['title_en'],
            $_POST['title_ar'],
            $_POST['company'],
            $_POST['desc_en'],
            $_POST['desc_ar'],
            $_POST['start_date'],
            $_POST['end_date'],
            $id
        );
    }

    $stmt->execute();
}

elseif($action=="search"){
    $q="%".$_GET['q']."%";
    $stmt=$conn->prepare("SELECT * FROM experience 
        WHERE exp_title_en LIKE ? 
        OR exp_title_ar LIKE ? 
        OR exp_company LIKE ?");

    $stmt->bind_param("sss",$q,$q,$q);
    $stmt->execute();
    $res=$stmt->get_result();


    while($row=$res->fetch_assoc()){
    echo '
    <div class="exp-item d-flex justify-content-between align-items-start flex-wrap gap-2">

        <div class="exp-info">
            <h5>'.$row['exp_title_en'].'</h5>
            <h6 class="text-secondary">'.$row['exp_title_ar'].'</h6>
            <p class="mb-1"><strong>'.$row['exp_company'].'</strong></p>

            <p class="small text-muted mb-1">
                '.$row['exp_description_en'].'
            </p>

            <p class="small text-muted">
                '.$row['exp_description_ar'].'
            </p>

            <span class="badge bg-info">
                '.$row['start_date'].' → '.($row['end_date'] ? $row['end_date'] : 'Present').'
            </span>
        </div>

        <div class="exp-actions d-flex gap-2">
            <button onclick="editExp(
                '.$row['exp_id'].',
                \''.addslashes($row['exp_title_en']).'\',
                \''.addslashes($row['exp_title_ar']).'\',
                \''.addslashes($row['exp_company']).'\',
                \''.addslashes($row['exp_description_en']).'\',
                \''.addslashes($row['exp_description_ar']).'\',
                \''.$row['start_date'].'\',
                \''.$row['end_date'].'\'
            )" class="btn btn-warning btn-sm">Edit</button>

            <button onclick="deleteExp('.$row['exp_id'].')" class="btn btn-danger btn-sm">Delete</button>
        </div>

    </div>
    ';
        }
}