<?php
    // Check for errors
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Get info from URL
    $wave = $_POST['wave'];
    $name = $_POST['name'];

    $list = $_POST['list'];
    $fullList = '';

    foreach ($list as $pick) {
        $fullList .= $pick . ' ';
    }

    // temp
    $proposalId = '300';

    // Connect db
    require './db-connect.php';

    // Run query to pull questions
    $sql = "SELECT proposal_id FROM voting_questions WHERE wave_id = ?";
    $stmt = $connection->prepare($sql);
    mysqli_stmt_bind_param($stmt, 's', $wave);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $idArray = mysqli_fetch_all($result);
    $stmt->close();

    /*foreach ($idArray as $id) {
        $proposalId = $id[0];
        $proposalChoice = $_GET[$id[0]];

        $sql1 = "INSERT INTO voting_results (proposal_id, proposal_voter, voter_selection) VALUES (?, ?, ?);";
        $stmt1 = $connection->prepare($sql1);
        $stmt1->bind_param("sss", $proposalId, $name, $proposalChoice);
        $stmt1->execute();
    }*/

    $sql1 = "INSERT INTO voting_results (proposal_id, proposal_voter, voter_selection) VALUES (?, ?, ?);";
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("sss", $proposalId, $name, $fullList);
    $stmt1->execute();

    $stmt1->close();
    mysqli_close($connection);
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
            <h3>Thanks for voting!</h3>
        </div>
    </body>
</html>