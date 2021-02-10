<?php
	include_once '../connect/db-connect.php';
	include_once 'functions.php';
	
	$sport_filter = $_GET['sport'];
	$type_filter = $_GET['type'];
	
	$query = "SELECT a.match_id, a.title, b.sport_name, a.category, a.start_date, a.start_time, (SELECT COUNT(*) FROM joined_matches WHERE match_id = a.match_id AND user_id = ?) FROM matches a, sports b WHERE a.sport_id = b.sport_id AND a.deadline > CURRENT_TIMESTAMP";
	
	if (isset($sport_filter) && $sport_filter != '') {
		$query .= " AND b.sport_name = '$sport_filter'";	
	}
	
	if (isset($type_filter) && $type_filter != '') {
		$query .= " AND a.category = '$type_filter'";	
	}
	
	$query .= " ORDER BY a.deadline";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $_COOKIE['user_id']);
	$stmt->execute();
	$stmt->bind_result($match_id, $title, $sport, $category, $date, $time, $joined);
		
	while($stmt->fetch()) {
		$match['match_id'] = "$match_id";
		$match['title'] = "$title";
		$match['sport'] = "$sport";
		$match['category'] = "$category";
		$match['date'] = "$date";
		$match['time'] = "$time";
		$match['joined'] = "$joined";
	
		$matches[] = $match;
	}
	$stmt->close();
	
	function checkStripe($order) {
		if ($order == 0) {
			return "odd";
		} else {
			return "even";
		}
	}
?>

<div id="match-list_wrapper" class="dataTables_wrapper no-footer">
<table id="match-list" class="display dataTable no-footer" cellspacing="0" width="100%" role="grid" style="width:100%;">
    <thead>
        <tr role="row">
            <th class="sorting_disabled" rowspan="1" colspan="1">Name</th>
            <th class="sorting_disabled" rowspan="1" colspan="1">Sport</th>
            <th class="sorting_disabled" rowspan="1" colspan="1">Type</th>
            <th class="sorting_disabled" rowspan="1" colspan="1">Start Date</th>
            <th class="sorting_disabled" rowspan="1" colspan="1">Start Time (EST)</th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($matches) == 0) { echo "<tr><td colspan='5' class='dataTables_empty' style='text-align:center'>No current matches available.</td></tr>"; } 
	
	for($i = 0; $i < count($matches); $i++): $stripe = checkStripe($i); ?>
    <tr role="row" class="<?php echo $stripe; ?>">
        <td style="font-weight:700;"><a href="match?matchId=<?php echo $matches[$i]['match_id']; ?>" data-category="pp_matches" data-action="match_list" data-label="title"><?php echo $matches[$i]['title']; ?></a></td>
        <td><?php echo $matches[$i]['sport']; ?></td>
        <td><?php echo $matches[$i]['category']; ?></td>
        <td><?php echo $matches[$i]['date']; ?></td>
        <td>
            <span class="match-time"><?php echo $matches[$i]['time']; ?></span>
            <?php if ($matches[$i]['joined']) : ?>
            <a onClick="quitMatch(<?php echo $matches[$i]['match_id']; ?>)"><div class="view-match quit-match right">Quit</div></a>
            <?php else : ?>
            <a onClick="joinMatch(<?php echo $matches[$i]['match_id']; ?>)"><div class="view-match right">View</div></a>
            <?php endif; ?>
        </td>
    </tr>
	<?php endfor; ?>
    </tbody>
</table>
<?php if (count($matches) == 0) : ?>
<div class="match-list-mobile left" style="display:none; width: 100%;">
    <p>No current matches available.</p>
</div>
<?php endif; ?>
<?php for($i = 0; $i < count($matches); $i++): ?>
<div class="match-list-mobile left" style="display:none;">
    <a href="match?matchId=<?php echo $matches[$i]['match_id']; ?>" data-category="pp_matches" data-action="match_list" data-label="title"><p class="match-title"><?php echo $matches[$i]['title']; ?></p></a>
    <p class="match-type"><?php echo $matches[$i]['sport']; ?> - <?php echo $matches[$i]['category']; ?></p>
    <p class="match-date"><?php echo $matches[$i]['date']; ?> - <?php echo $matches[$i]['time']; ?></p>
</div>
<div class="match-view-mobile right" style="display:none;">
    <?php if ($matches[$i]['joined']) : ?>
    <a onClick="quitMatch(<?php echo $matches[$i]['match_id']; ?>)"><div class="view-match quit-match right">Quit</div></a>
    <?php else : ?>
    <a onClick="joinMatch(<?php echo $matches[$i]['match_id']; ?>)"><div class="view-match right">Join</div></a>
    <?php endif; ?>
</div>
<?php endfor; ?>
