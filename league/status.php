<?php
    // Check for errors
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Get info from URL
    //$wave = $_GET['wave'];
    //$name = $_GET['name'];
    
    // Initialize variables
    //$waveOptions = [];
    //$counter = 1;

    // Connect db
    require './db-connect.php';

    // Run query to pull questions
    $query = "SELECT * FROM voting_results WHERE proposal_id = 001";
    $stmt = $connection->prepare($query);
    //mysqli_stmt_bind_param($stmt, 's', $wave);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $voteArray1 = mysqli_fetch_all($result);
    $stmt->close();

    $query = "SELECT * FROM voting_results WHERE proposal_id = 002";
    $stmt = $connection->prepare($query);
    //mysqli_stmt_bind_param($stmt, 's', $wave);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $voteArray2 = mysqli_fetch_all($result);
    $stmt->close();

    //var_dump($voteArray1);
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
            <h3>Current Voting Status</h3>
            <hr>
        </div>
        <h5 class="px-2">Points awarded for Defensive "Three and Out"</h5>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Vote</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voteArray1 as $vote): ?>
                <tr>
                    <th scope="row"><?php echo ucfirst($vote[2]); ?></th>
                    <td><?php echo $vote[3]; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <hr>
        <h5 class="px-2">Points awarded for Defensive "Tackle for Loss"</h5>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Vote</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voteArray2 as $vote): ?>
                <tr>
                    <th scope="row"><?php echo ucfirst($vote[2]); ?></th>
                    <td><?php echo $vote[3]; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>