<?php
	include_once '../connect/db-connect.php';
	include_once 'functions.php';
	
	$userId = $_COOKIE['user_id'];
	$time_frame = $_GET['time'];
	
	$allMatchPoints = getRanking($connection, $time_frame);

	for ($i = 0; $i < count($allMatchPoints['id']); $i++) : ?>
    <tr <?php if($userId == $allMatchPoints['id'][$i]) { echo "style='color: #fff; background-color: #fc4349'"; } ?>>
        <td><?php echo $i + 1; ?></td>
        <td><a href="/profile?id=<?php echo $allMatchPoints['id'][$i]; ?>" data-category="pp_leaderboard" data-action="standings" data-label="player_name"><?php echo $allMatchPoints['first_name'][$i] . ' ' . $allMatchPoints['last_name'][$i]; ?></a></td>
        <td><?php echo floor($allMatchPoints['points'][$i]); ?></td>
        <td><?php echo number_format(fmod($allMatchPoints['points'][$i], 1), 3); ?></td>
    </tr>
    <?php endfor; ?>
	<?php if (count($allMatchPoints['id']) == 0) : ?>
    <tr>
        <td colspan="4">No current matches completed.</td>
    </tr>
	<?php endif; 
?>
