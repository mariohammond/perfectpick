<?php
    // Check for errors
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Get info from URL
    $wave = $_GET['wave'];
    $name = $_GET['name'];
    
    // Initialize variables
    $waveOptions = [];
    $counter = 1;

    // Connect db
    require './db-connect.php';

    // Run query to pull questions
    $query = "SELECT proposal_id, proposal_question, proposal_type FROM voting_questions WHERE wave_id = ?";
    $stmt = $connection->prepare($query);
    mysqli_stmt_bind_param($stmt, 's', $wave);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $questionArray = mysqli_fetch_all($result);
    $type = $questionArray[0][2];
    $stmt->close();

    // Run query to pull options
    function getOptions($id) {
        global $connection;
        global $type;
        
        $query = "SELECT proposal_option, proposal_value FROM voting_options WHERE proposal_id = ?";
        $stmt = $connection->prepare($query);
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $optionsArray = mysqli_fetch_all($result);
        $stmt->close();

        if ($type == 'single') {
            foreach ($optionsArray as $index=>$option) {
                echo
                "<div class='form-check'>
                    <input class='form-check-input' type='radio' id='id$id$option[1]' name='$id' value='$option[1]' required>
                    <label class='form-check-label' for='id$id$option[1]'>
                        $option[0]
                    </label>
                </div>";
            }
        } else if ($type == 'multiple') {
            foreach ($optionsArray as $index=>$option) {
                echo
                "<div class='form-check'>
                    <label><input class='form-check-input' type='checkbox' name='list[]' value='$option[1]'>$option[0]</label>
                </div>";
            }
        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- bootstrap css -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- bootstrap js support -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <style>
            body {
                background: lightblue;
            }

            hr {
                border: 1px solid;
            }
        </style>
    </head>
    <body>
        <div class="mt-2 px-2">
            <h3>League Voting System</h3>
            <h6>Voting Member: <?php echo ucfirst($name); ?></h6>
            <hr>
        </div>
        <form action="results.php" method="post">
            <input class="form-control" type="text" name="wave" value="<?php echo $wave; ?>" hidden>
            <input class="form-control" type="text" name="name" value="<?php echo $name; ?>" hidden>
            <?php foreach ($questionArray as $question): ?>
            <fieldset class="form-group px-2">
                <div class="row mb-4">
                    <div class="col-12">
                        <?php echo "<h5>$question[1]</h5>"; ?>
                        <?php getOptions($question[0]); ?>
                    </div>
                </div>
            </fieldset>
            <?php endforeach; ?>
            <div class="form-group row px-2">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </div>
        </form>
    </body>
</html>