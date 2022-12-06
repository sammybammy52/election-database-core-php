<?php require '../header.php'; ?>
<?php include 'nav.php'; ?>

<div class="bg-dark vh-100 d-flex justify-content-center">

  <div class="mb-3 col-6">
    <label for="LGA" class="form-label text-warning mt-4">Only delta State has LGAs, state_id of 25 </label>
    <label for="LGA" class="form-label text-warning mb-4">Not all LGAs have pu results, please check multiple LGAs e.g Ukwuani, Ughelli North, Ethiope West </label>
    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="lga">
      <option selected>Select Delta LGAs</option>
      <?php
      require '../connection.php';

      $sql = "SELECT lga_id, lga_name FROM `lga`";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<option value="' . $row['lga_id'] . '">' . $row['lga_name'] . '</option>';
        }
      } else {
        echo '<option>nothing</option>';
      }


      ?>


    </select>

    <div id="total">

    </div>
    <div></div>
    <center><a href="../pages/q3.php"><button class="btn btn-primary btn-lg mt-4 mb-2">Go to Question 3</button></a></center>
    <center><a href="../pages/q1.php"><button class="btn btn-secondary btn-lg">Back to Question 1</button></a></center>
  </div>

  <script>
    $(document).ready(function() {
      $('#lga').on('change', function() {
        var lga_id = this.value;
        $.get("lga_results.php", {
            lga_id: lga_id
          })
          .done(function(data) {
            console.log(JSON.parse(data));
            var result = JSON.parse(data);

            if (result.length < 1) {
              $("#total").html(`<h3 class="text-danger"> No Results Found 🧐</h3>`);
            } else {
              let total = 0;

              for (let index = 0; index < result.length; index++) {
                const element = result[index];
                let intval = parseInt(element.sum_party_score);

                total = total + intval;
              }

              $("#total").html(`<h3 class="text-success">Total: ${total} 🤓 </h3>`);

            }

          });

      });



    });
  </script>


</div>

<?php require '../footer.php'; ?>