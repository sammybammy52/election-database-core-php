<?php include '../header.php'; ?>
<?php include 'nav.php'; ?>



<div class="bg-dark text-white">
    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">Polling Unit ID</th>
                <th scope="col">Polling Unit Name</th>
                <th scope="col">Total Votes</th>

            </tr>
        </thead>
        <tbody>
            <?php
            require '../connection.php';

            $sql = "SELECT DISTINCT announced_pu_results.polling_unit_uniqueid, polling_unit.polling_unit_name, SUM(announced_pu_results.party_score) as sum_party_score FROM `announced_pu_results` INNER JOIN polling_unit on announced_pu_results.polling_unit_uniqueid = polling_unit.uniqueid GROUP BY announced_pu_results.polling_unit_uniqueid DESC";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo ' <tr>
                    <td>' . $row['polling_unit_uniqueid'] . '</td>
                    <td>' . $row['polling_unit_name'] . '</td>
                    <td>' . $row['sum_party_score'] . '</td>
                        </tr>';
                }
            } else {
                echo 'nothing dey here boss!';
            }


            ?>

        </tbody>
    </table>
    <center><a href="../pages/q2.php"><button class="btn btn-primary btn-lg m-4">Go to Question 2</button></a></center>


</div>

<?php require '../footer.php'; ?>
