<?php 
	include_once 'connect/db-connect.php';
	include_once 'util/functions.php';
	
	session_start();
	
	$joined = checkMatchJoin($connection, $_GET['matchId'], $_COOKIE['user_id']);
	
	if(!isset($_GET['matchId']) || !($joined)) {
		header("Location: matches");	
	}
	
	$user_info = getUserInfo($connection, $_COOKIE['user_id']);
	$match = getMatchInfo($connection, $_GET['matchId']);
	$questions = getQuestionCount($connection, $_GET['matchId']);
	$points = getAvailablePoints($connection, $_GET['matchId']);
	$seconds = getMatchDeadline($connection, $_GET['matchId']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Match Picks | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
    
    <!-- Countdown Timer: Start -->
	<script>
	var seconds = <?php echo $seconds; ?>;
	function secondPassed() {
		if (seconds > 0) {
			var remainingDays = Math.floor(seconds / 86400);
			var remainingHours = Math.floor((seconds % 86400) / 3600);
			var remainingMinutes = Math.floor(((seconds % 86400) % 3600) / 60);
			var remainingSeconds = Math.floor(((seconds % 86400) % 3600) % 60);
			
			var dayTitle  = 'd ';
			var hourTitle = 'h ';
			var minuteTitle = 'm ';
			var secondTitle = 's';
			
			if(remainingDays == 0) { remainingDays = ''; dayTitle = ''; }
			if(remainingHours == 0) { remainingHours = ''; hourTitle = ''; }
			if(remainingMinutes == 0) { remainingMinutes = ''; minuteTitle = ''; }
			if(remainingSeconds == 0) { remainingSeconds = ''; secondTitle = ''; }
			
			document.getElementById('countdown').style.backgroundColor = "#2c3e50";
			document.getElementById('countdown').style.color = "#fff";
			document.getElementById('countdown').style.padding = "5px";
			document.getElementById('countdown').style.textAlign = "center";
			document.getElementById('countdown').innerHTML = "&nbsp;Deadline: " +
				remainingDays + dayTitle + remainingHours + hourTitle + remainingMinutes + minuteTitle + remainingSeconds + secondTitle;
			
			seconds--;
			
			if (seconds == 0) {
				clearInterval(countdownTimer);
				window.location.replace('<?php echo $_SERVER['REQUEST_URI']; ?>');
			}
		} else {
			document.getElementById('countdown').style.display = "none";
		}
	}
	var countdownTimer = setInterval('secondPassed()', 1000);
	</script>
	<!-- Countdown Timer: End -->
</head>
<body>
	<div class="MatchPicksWrapper">
		<?php include 'menu.php'; ?>
        <?php include 'header.php'; ?>
        <div class="MatchContainer Main">
            <div class="cover-container"></div>
            <?php if ($seconds <= 0) : ?>
            <div class="view-only-container"></div>
            <?php endif; ?>
            <div class="QuestionContainer">
                <div class="MatchTitle">
                    <h1 style="display: none;"><?php echo $match['title']; ?></h1>
                    <h2 style="display: none;"><?php echo $user_info['first_name'] . ' ' . $user_info['last_name']; ?></h2>
                </div>
                <?php if ($seconds > 0) : ?>
                <div class="MatchQuestions flex left">
                <?php else: ?>
                <div class="MatchQuestions view-only">
                <?php endif; ?>
                	<div id="q0" class="QuestionContent">
                    	<h1 class="start-title"><?php echo $match['title']; ?></h1><br/>
                        <h1 class="start-info"><strong>Start Date:</strong> <?php echo $match['date']; ?></h1>
                        <h1 class="start-info"><strong>Start Time:</strong> <?php echo $match['time']; ?></h1>
                        <h1 class="start-info"><strong>Total Questions:</strong> <?php echo $questions; ?></h1>
                        <h1 class="start-info"><strong>Available Points:</strong> <?php echo $points; ?></h1><br/>
                        <h1 id="countdown" class="start-info">Loading deadline...</h1>
                        <div class='nav-buttons'>
                        	<a data-category="pp-match-picks" data-action="match-questions" data-label="start"><div class='start-button'><p>Start Match</p></div></a>
                      	</div>
                    </div>
                	<?php $questionsCount = getQuestions($connection, $_GET['matchId']); ?>
                    <script>
					function submitTiebreaker() {
						$tbAnswer = $('.tiebreaker-answer').val();
						$('[name=tiebreaker]').val($tbAnswer);
					}
					</script>
                </div>
                <div class="QuestionFooter left">
                	<?php for ($i = 0; $i <= $questionsCount; $i++) : ?>
                    <a id="slide<?php echo $i+1; ?>" data-category="pp-match-picks" data-action="match-questions" data-label="nav-dots"><p class="nav-dots">&#9679;</p></a>
                    <?php endfor; ?>
                    <form action="util/save-picks?matchId=<?php echo $_GET['matchId']; ?>" method="post">
                        <input name="q1" value="" hidden="true"/>
                        <input name="q2" value="" hidden="true"/>
                        <input name="q3" value="" hidden="true"/>
                        <input name="q4" value="" hidden="true"/>
                        <input name="q5" value="" hidden="true"/>
                        <input name="q6" value="" hidden="true"/>
                        <input name="q7" value="" hidden="true"/>
                        <input name="q8" value="" hidden="true"/>
                        <input name="q9" value="" hidden="true"/>
                        <input name="q10" value="" hidden="true"/>
                        <input name="q11" value="" hidden="true"/>
                        <input name="q12" value="" hidden="true"/>
                        <input name="q13" value="" hidden="true"/>
                        <input name="q14" value="" hidden="true"/>
                        <input name="q15" value="" hidden="true"/>
                        <input name="q16" value="" hidden="true"/>
                        <input name="q17" value="" hidden="true"/>
                        <input name="q18" value="" hidden="true"/>
                        <input name="q19" value="" hidden="true"/>
                        <input name="q20" value="" hidden="true"/>
                        <input name="tiebreaker" value="" hidden="true"/>
                        <?php if ($seconds > 0) : ?>
                        <a data-category="pp-match-picks" data-action="match-questions" data-label="save-picks"><input type="button" value="SAVE PICKS" onClick="form.submit();" /></a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
		</div>
        <?php include 'footer.php'; ?>
    </div>
    <script>
	$(document).ready(function(e) {
		$allSlides = <?php echo ($questionsCount + 2) * 320; ?>;
		$slidesMinus1 = <?php echo ($questionsCount + 1) * 320; ?>;
		$slidesMinus2 = <?php echo $questionsCount * 320; ?>;
		
		<?php for($i = 0; $i < $questionsCount; $i++) : ?>
		if ($("#answer<?php echo $i + 1; ?>").css("background-color") == "rgb(0, 165, 80)") {
			$("#slide<?php echo $i + 1; ?> p").css("color", "#00a550");	
			$("#slide<?php echo $i + 1; ?> p").addClass("answered");
		}
		<?php endfor; ?>
		
		if ($(".tiebreaker-answer").val() != 0) {
			$("#slide<?php echo $questionsCount + 1; ?> p").css("color", "#00a550");
			$("#slide<?php echo $questionsCount + 1; ?> p").addClass("answered");
		}
		
		// Set width based on number of questions
        $(".MatchQuestions").css("width", $allSlides);
		
		if ($(".MatchQuestions").css("left") == "-320px") {
			$(".back-button").css("background-color", "#ccc");
		}
		
		if ($(".MatchQuestions").css("left") == -$allSlides) {
			$(".next-button").css("background-color", "#ccc");
		}
		
		// Back Button functions
		$(".back-button").click(function(e) {
			// Move match slider
			$leftPos = parseInt($(".MatchQuestions").css("left"));
			if ($leftPos == -640) {
				$(".back-button").css("background-color", "#ccc");
			}
			if ($leftPos != -320) {
				$(".MatchQuestions").css("left", $leftPos + 320);
				$(".next-button").css("background-color", "#fc4349");
				
				// Adjust height of Match Questions container
				$parentId = $(this).closest(".QuestionContent").attr("id"); 
				$idNumber = parseInt($parentId.substring(1)) - 1;
				$nextId = "q" + $idNumber;
				
				$currentDiv = document.getElementById($nextId);
				$children = $currentDiv.childNodes; 
				
				$questionHeight = 0;
				$optionHeight = 0;
				
				for (i = 0; i < $children.length; i++) {
					if ($children[i].className == "question") {
						$questionHeight += $children[i].clientHeight + 20;
					}
					
					if ($children[i].className == "answer-choice" || $children[i].className == "answer-choice selected") {
						$optionHeight += $children[i].clientHeight + 20;
					}
				}
				
				$(".MatchQuestions").css("height", $optionHeight + $questionHeight + 98);
			}
			
			// Decrement current slide number and set nav dot
			$(".nav-dots").css("color", "#fc4349");
			$(".answered").css("color", "#00a550");
			$("#slide" + $idNumber + " p").css("color", "#2c3e50");
		});
		
		// Next button functions
		$(".next-button").click(function(e) {
			// Move match slider
			$leftPos = parseInt($(".MatchQuestions").css("left"));
			if ($leftPos > -$slidesMinus1) {
				$(".MatchQuestions").css("left", $leftPos - 320);
				$(".back-button").css("background-color", "#fc4349");
				
				// Adjust height of Match Questions container
				$parentId = $(this).closest(".QuestionContent").attr("id"); 
				$idNumber = parseInt($parentId.substring(1)) + 1;
				$nextId = "q" + $idNumber;
				
				$currentDiv = document.getElementById($nextId);
				$children = $currentDiv.childNodes; 
				
				$questionHeight = 0;
				$optionHeight = 0;
				
				for (i = 0; i < $children.length; i++) {
					if ($children[i].className == "question") {
						$questionHeight += $children[i].clientHeight + 20;
					}
					
					if ($children[i].className == "answer-choice" || $children[i].className == "answer-choice selected") {
						$optionHeight += $children[i].clientHeight + 20;
					}
					
					if ($children[i].className == "tiebreaker-answer") {
						$optionHeight += $children[i].clientHeight + 20;
					}
				}
				
				$(".MatchQuestions").css("height", $optionHeight + $questionHeight + 98);
			}
			
			if ($leftPos == -$slidesMinus2) {
				$(".next-button").css("background-color", "#ccc");
			}
			
			// Increment current slide number and set nav dot
			$(".nav-dots").css("color", "#fc4349");
			$(".answered").css("color", "#00a550");
			$("#slide" + $idNumber + " p").css("color", "#2c3e50");
		});
		
		// Navigation buttons functions
		$(".QuestionFooter a").click(function(e) {
			$sliderId = $(this).attr("id");
			$idNumber = parseInt($sliderId.substr(5));
			
			$sliderPosition = $idNumber * 320;
			$(".MatchQuestions").css("left", -$sliderPosition);
			
			$(".nav-dots").css("color", "#fc4349");
			$(".answered").css("color", "#00a550");
			$("#slide" + $idNumber + " p").css("color", "#2c3e50");
			
			// Adjust height of Match Questions container
			$nextId = "q" + $idNumber;
			
			$currentDiv = document.getElementById($nextId);
			$children = $currentDiv.childNodes;
			
			$questionHeight = 0;
			$optionHeight = 0;
			
			for (i = 0; i < $children.length; i++) {
				if ($children[i].className == "question") {
					$questionHeight += $children[i].clientHeight + 20;
				}
				
				if ($children[i].className == "answer-choice" || $children[i].className == "answer-choice selected") {
					$optionHeight += $children[i].clientHeight + 20;
				}
				
				if ($children[i].className == "tiebreaker-answer") {
					$optionHeight += $children[i].clientHeight + 20;
				}
			}
			
			$(".MatchQuestions").css("height", $optionHeight + $questionHeight + 98);
			
			// Back button color
			if (-$sliderPosition == -320) {
				$(".back-button").css("background-color", "#ccc");
			} else {
				$(".back-button").css("background-color", "#fc4349");
			}
			
			// Next button color
			if (-$sliderPosition == -$slidesMinus1) {
				$(".next-button").css("background-color", "#ccc");
			} else {
				$(".next-button").css("background-color", "#fc4349");
			}
		});
    });
	</script>
    <span class="wideCheck"></span><span class="desktopCheck"></span><span class="tabletCheck"></span><span class="mobileCheck"></span>
</body>
</html>
