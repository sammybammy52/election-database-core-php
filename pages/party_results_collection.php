<?php
require '../connection.php';

$party = $_POST['party'];
$party_score = $_POST['party_score'];
$entered_by = $_POST['entered_by'];


$ip = '127.0.0.1';

$check = "SELECT * FROM `announced_pu_results` WHERE polling_unit_uniqueid = 999 AND party_abbreviation = '$party'";
$check_result = mysqli_query($conn, $check);
$checkrows = mysqli_num_rows($check_result);
if ($checkrows > 0) {
    $response = [
        'message' => 'Error: result already exists for this party',
        'status' => 'fail'
    ];
    echo json_encode($response);
}
else {
    $sql = "INSERT into `announced_pu_results` (polling_unit_uniqueid, party_abbreviation, party_score, entered_by_user, date_entered, user_ip_address) VALUES (999, '$party', $party_score, '$entered_by', NOW(), '$ip')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $response = [
            'message' => 'Successful insertion',
            'status' => 'success'
        ];

        echo json_encode($response);
    }


}

