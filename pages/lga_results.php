<?php
require '../connection.php';

$lga_id = $_GET['lga_id'];


$sql = "SELECT DISTINCT announced_pu_results.polling_unit_uniqueid, polling_unit.lga_id, SUM(announced_pu_results.party_score) as sum_party_score FROM `announced_pu_results` INNER JOIN `polling_unit` ON announced_pu_results.polling_unit_uniqueid = polling_unit.uniqueid WHERE polling_unit.lga_id= $lga_id GROUP BY polling_unit_uniqueid";
$result = mysqli_query($conn, $sql);
$response = [];
if ($result) {

    while ($row = mysqli_fetch_assoc($result)) {

        $arr = [
            "polling_unit_uniqueid" => $row["polling_unit_uniqueid"],
            "lga_id" => $row["lga_id"],
            "sum_party_score" => $row["sum_party_score"],
        ];
        array_push($response, $arr);
    }
    echo json_encode($response);
} else {
    echo '<option>nothing</option>';
}
