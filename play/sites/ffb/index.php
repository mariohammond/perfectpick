<?php ?>
<html>
<head>
	<title>Game Film Breakdown</title>
	<?php include 'head-info.php'; ?>
</head>
<body>
	<div id="page-home">
        <div class="content">
        	<div class="play-info">
            	<label>Down: </label>
                <select id="playDown">
                  <option value="first">1st Down</option>
                  <option value="second">2nd Down</option>
                  <option value="third">3rd Down</option>
                  <option value="fourth">4th Down</option>
                  <option value="2pc">2-Pt Conversion</option>
                </select><br/>
                
                <label>Distance: </label>
                <input id="playDistance" type="number" name="distance"><br/>
                
                <label>Ball Location: </label>
                <select id="playLocation">
                  <option value="location-left">Left Hash</option>
                  <option value="location-middle" selected>Middle</option>
                  <option value="location-right">Right Hash</option>
                </select><br/>
                
                <label>Formation: </label>
                <select id="playFormation" onchange="addNewFormation()">
                  <option value="formation-i">I-Form</option>
                  <option value="formation-split">Split Back</option>
                  <option value="formation-4wide">4 WR</option>
                  <option value="formation-other">Add New...</option>
                </select>
                <input id="newFormation" class="hidden" type="text" name="new-form" placeholder="Enter new formation"><br/>
                
                <label>Strong Side: </label>
                <select id="playStrong">
                  <option value="strong-left">Left</option>
                  <option value="strong-right">Right</option>
                  <option value="strong-none" selected>None</option>
                </select><br/>
                
                <label>Play Type: </label>
                <select id="playType" onchange="getPlayType()">
                	<option>Select:</option>
                  	<option value="type-run">Run</option>
                  	<option value="type-pass">Pass</option>
                </select><br/>
                <div id="runInfo" class="hidden">
                	<label>Run Type: </label>
                    <select id="runType">
                      <option value="run-dive">Dive</option>
                      <option value="run-lead">Lead</option>
                      <option value="run-sweep">Sweep</option>
                      <option value="run-draw">Draw</option>
                      <option value="run-counter">Counter/Trap</option>
                      <option value="run-reverse">Reverse</option>
                      <option value="run-sneak">Sneak</option>
                    </select>
                    <label>Run Direction: </label>
                    <select id="runDirection">
                      <option value="run-left">Left</option>
                      <option value="run-middle" selected>Middle</option>
                      <option value="run-right">Right</option>
                    </select>
                </div>
                <div id="passInfo" class="hidden">
                	<label>Route Ran: </label>
                    <select id="passRoute">
                      <option value="pass-fly">Fly/Fade</option>
                      <option value="pass-out-route">Out Route</option>
                      <option value="pass-in-route">In Route</option>
                      <option value="pass-curl">Curl</option>
                      <option value="pass-slant">Slant</option>
                      <option value="pass-post">Post</option>
                      <option value="pass-corner">Post Corner</option>
                    </select>
                    <label>Pass Completed: </label>
                    <select id="passCompleted">
                      <option value="pass-complete">Yes</option>
                      <option value="pass-incomplete" selected>No</option>
                    </select>
                </div>
                
                <div id="playerInfo">
                	<div class="player">
                        <label>Player Involved (Jersey #): </label>
                        <input class="playerNumber" type="number" name="distance">
                        <a class="add-player" href="javascipt:;">Add another player</a>
                    </div>
              	</div>
            </div>
        </div>
    </div>
</body>
</html>
