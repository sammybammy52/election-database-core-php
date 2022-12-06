<?php require '../header.php'; ?>
<?php include 'nav.php'; ?>

<div class="bg-dark vh-100">
    <h3 class="text-white mb-4 pt-4 ms-4">Party Result input for Test polling unit, with id of 999</h3>
    <h4 class="text-warning mb-4 mb-4 ms-4 ">I have created a Test polling unit, with id of 999 so the results of the parties here will be linked to it</h4>

    <form id="form" action="javascript:alert( 'request sent!' );" class="m-5">
        <div class="mb-3">
            <label for="LGA" class="form-label text-white">Select Party</label>
            <select class="form-select mb-3" aria-label=".form-select-lg example" id="party" name="party" required>

                <?php
                require '../connection.php';

                $sql = "SELECT partyid FROM `party`";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['partyid'] . '">' . $row['partyid'] . '</option>';
                    }
                } else {
                    echo '<option>nothing</option>';
                }


                ?>

            </select>

        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label text-white">Party Score</label>
            <input type="number" class="form-control" placeholder="party score" id="partyScore" name="party_score" required>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label text-white">Entered by:</label>
            <input type="text" class="form-control" placeholder="your name" id="enteredBy" name="entered_by" required>
        </div>

        <div class="resultdiv" id="resultdiv">

        </div>


        <button class="btn btn-primary" id="submit">Insert Result</button>



    </form>

    <center><a href="../pages/q2.php"><button class="btn btn-secondary btn-lg">Back to Question 2</button></a></center>
    <center><a href="../pages/q1.php"><button class="btn btn-primary btn-lg mt-4 mb-2">Go to Question 1</button></a></center>


    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {


                var party = $('#party').val();
                var party_score = $('#partyScore').val();
                var entered_by = $('#enteredBy').val();

                console.log(party);
                console.log(party_score);
                console.log(entered_by);

                $.ajax({
                    url: "party_results_collection.php",
                    type: "POST",
                    data: {
                        party,
                        party_score,
                        entered_by,
                    },
                    success: function(result) {
                        var response = JSON.parse(result);
                        console.log(response);

                        if (response.status == 'fail') {
                            $('#resultdiv').html(`<h5 class="text-danger">${response.message}</h5>`)
                        } else if (response.status == 'success') {
                            $('#resultdiv').html(`<h5 class="text-success">${response.message}</h5>`)
                        } else {
                            $('#resultdiv').html(`<h5 class="text-danger">Unknown Error Occured</h5>`)
                        }
                    }
                });

            });



        });
    </script>


</div>

<?php require '../footer.php'; ?>