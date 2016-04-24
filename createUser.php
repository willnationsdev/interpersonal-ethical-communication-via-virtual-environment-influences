<?php

session_start();

//Initialize variables for database access
$_SESSION['servername'] = "localhost";
$_SESSION['username'] = "nations";
$_SESSION['password']  = "yr9fwW@B";
$_SESSION['db']  = "nations";
$_SESSION['table']  = "participants";
$_SESSION['storyID'] = "-";
$_SESSION['destination'] = "";
$_SESSION['error'] = "";
$_SESSION['sql'] = "";
//Also bringing over $_SESSION['pID'] from consent-form.php!!!

//establish connection to database
$conn = new mysqli($_SESSION['servername'], 
                   $_SESSION['username'], 
                   $_SESSION['password'], 
                   $_SESSION['db']);
$participantID = $_SESSION['pID'];
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the total number of A and B stories
$a_num = "";
$b_num = "";
$_SESSION['sql'] = "SELECT story, COUNT(story) as count, completed FROM participants GROUP BY story, completed ORDER BY completed, story ASC;";
$result = $conn->query($_SESSION['sql']);
if ($result === FALSE) {
    $_SESSION['error'] = "2";
    $_SESSION['storyID'] = "--";
    header("Location:error.php");
}
if ($result->num_rows <= 3) {
    $a_num = "0";
    $b_num = "1";
}
else {
    $row = $result->fetch_assoc();
    $row = $result->fetch_assoc();
    $row = $result->fetch_assoc();
    $a_num = $row['count'];
    $row = $result->fetch_assoc();
    $b_num = $row['count'];
}
// If there are more Bs, then make a new A story
if (intval($b_num) >= intval($a_num)) {
    // Create a new entry for the new player
    $_SESSION['sql'] = "INSERT INTO participants (id, story, q1, q2, q3, q12, q22, q32, completed, used) VALUES ('$participantID', 'A', '0', '0', '0', '0', '0', '0', 'false', 'false');";
    $result = $conn->query($_SESSION['sql']);
    if ($result === FALSE) {
        $_SESSION['error'] = "3";
        $_SESSION['storyID'] = "---";
        header("Location:error.php");
    }
    $_SESSION['storyID'] = "A";
    $_SESSION['destination'] = "Thesis_Story_Part_1_Snowman.html";
    $_SESSION['survey'] = "https://baylor.qualtrics.com/SE/?SID=SV_bmfLTFDmodY5BIN&participantID=$participantID";
}
// Otherwise, get all the complete, but unused As.
else {
    $_SESSION['sql'] = "SELECT * FROM participants WHERE story = 'A' AND completed = 'true' AND used = 'false';";
    $result = $conn->query($_SESSION['sql']);
    if ($result === FALSE) {
        $_SESSION['error'] = "4";
        $_SESSION['storyID'] = "----";
        header("Location:error.php");
    }
    else if ($result->num_rows > 0) {
        // Select a random one
        $offset = rand(0, $result->num_rows - 1);
        if(!$result->data_seek($offset)) {
            header("Location:error.php");
        }
        $row = $result->fetch_assoc();
        $random_player_id = $row['id'];
        $rq1 = $row['q1'];
        $rq2 = $row['q2'];
        $rq3 = $row['q3'];
        $rq12 = $row['q12'];
        $rq22 = $row['q22'];
        $rq32 = $row['q32'];
        // Update the data to "used" status
        $_SESSION['sql'] = "UPDATE participants SET used='true' WHERE id='$random_player_id';";
        $result = $conn->query($_SESSION['sql']);
        if ($result === FALSE) {
            $_SESSION['error'] = "5";
            $_SESSION['storyID'] = "-----";
            header("Location:error.php");
        }
        // Create a new entry for the new player
        $_SESSION['sql'] ="INSERT INTO participants (id, story, source, q1, q2, q3, q12, q22, q32, completed, used) VALUES ('$participantID', 'B', '$random_player_id', '$rq1', '$rq2', '$rq3', '$rq12', '$rq22', '$rq32', 'false', 'true')";
        $result = $conn->query($_SESSION['sql']);
        if ($result === FALSE) {
            $_SESSION['error'] = "6";
            $_SESSION['storyID'] = "------";
            header("Location:error.php");
        }
        $_SESSION['storyID'] = "B";
        $_SESSION['destination'] = "./next/Thesis_Story_Part_2_Snowman.html";
        $_SESSION['survey'] = "https://baylor.qualtrics.com/SE/?SID=SV_bl5tNxCBLCHlPNP&participantID=$participantID";
        // feed the q-Values to localStorage
        $randomly_selected_row = $row;
    }
    else {
        // There are no unused A's (somehow?). Create a new entry for the new player
        $_SESSION['sql'] = "INSERT INTO participants (id, story, q1, q2, q3, q12, q22, q32, completed, used) VALUES ('$participantID', 'A', '0', '0', '0', '0', '0', '0', 'false', 'false');";
        $result = $conn->query($_SESSION['sql']);
        if ($result === FALSE) {
            $_SESSION['error'] = "3";
            $_SESSION['storyID'] = "---";
            header("Location:error.php");
        }
        $_SESSION['storyID'] = "A";
        $_SESSION['destination'] = "Thesis_Story_Part_1_Snowman.html";
        $_SESSION['survey'] = "https://baylor.qualtrics.com/SE/?SID=SV_bmfLTFDmodY5BIN&participantID=$participantID";
    }
}
?>

<!DOCTYPE html>
<html>
  <title>Server Preparation</title>
  <head>
    <script 
      src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js">
    </script>
    <script>

    console.log('starting server prep');
$(document).ready(function() {

    var t = window.ThesisServer = {

        preq1: <?php echo $rq1 ?>,
        preq2: <?php echo $rq2 ?>,
        preq3: <?php echo $rq3 ?>,
        preq12: <?php echo $rq12 ?>,
        preq22: <?php echo $rq22 ?>,
        preq32: <?php echo $rq32 ?>,

        q1as: [
         "A show of loyalty is never critical to my opinion of whether someone is good or bad. Other things are far more important.",
         "I do not usually care all that much about the loyalty of another person.",
         "It's pretty close, but I would probably side with it being a bad thing.",
         "Loyalty is important, I guess. I don't like to get too attached, but I would rather have it than nothing.",
         "I would say that loyalty is very significant in most cases.",
         "There is little, if anything at all, more important than loyalty."
              ],

        q2as: [
        "There should never be any kind of limitation on how you express yourself on a team. Appearances are not everything.",
        "That kinda stuff is not typically important. I say express away.",
        "Expressing yourself on a team is not that big of a deal, if it is just a little bit.",
        "Well, I would only say matching up with your team is slightly important.",
        "You can usually count on a team to have a universal appearance. It is relatively important.",
        "People should always uphold their duty to the team, even if it means giving up their self-expression."
              ],

        q3as: [
        "Heck no! Just because family is on the wrong side of the law does not mean I need to be too.",
        "I am not interested in going to prison, though I would feel for them.",
        "That is tough. I would feel bad, but I feel as though I would not get involved.",
        "I guess I would support them, but I would not feel entirely comfortable about it.",
        "I would definitely help my family, because I trust them.",
        "I will always put my family before anything else, no matter what they may have done."
              ],

        q12as: [
        "You can never assume anything about the loyalty of others. In fact, there is no reason to see it as a significant moral factor at all.",
        "I would not count on people being loyal. And I would not usually think anything about them either way because of it.",
        "It can be hard to say, but there's no real reason to expect people to be loyal. It doesn't even matter all that much.",
        "Loyalty matters a little bit. I would at least expect some loyalty out of those I know.",
        "The cases may vary, but you usually want people to be loyal. I know I always account for that.",
        "I always expect loyalty out of those I describe as good."
               ],
         
        q22as: [
        "And dissolve into the so-called other? No way. Individuality is crucial, way beyond the significance of anything loyalty could provide.",
        "I generally prefer not to make those kinds of sacrifices for others.",
        "Your sense of self is important, but it is still a difficult thing to say for sure, whether loyalty is equally or more important.",
        "I am sort of on the fence. I don't think I would risk my relationships with others just to maintain my individuality though.",
        "I would be perfectly willing to reduce the sense of self I have, within reason. Loyalty can sometimes be more important than staying as you were.",
        "Individuality is meaningless compared to the loss of my sense of loyalty. I am always concerned about honoring the trust of those around me."
               ],
         
        q32as: [
        "It is completely senseless to take any sort of risk just for the sake of preserving a sense of loyalty towards another.",
        "You can certainly take it too far, risking things for relationships.",
        "I do not think I would wanna take much of any risk, but I would still be vaguely concerned about the well-being of the person in question.",
        "I am not entirely sure. I certainly would prioritize my relationship with the other, but putting myself at risk...it depends on what it would be.",
        "Given the situation, there is a very good chance I would wager my well-being for the sake of being loyal.",
        "I would have no problem risking myself if it meant I could prove my loyalty to a loved one. If it were important, I would sacrifice anything."
                ],

	shuffle3: function(a) {

                     var rand = Math.random();
                     var A = a[0];
                     var B = a[1];
                     var C = a[2];
                     if (rand < 0.33) {
                         a[0] = A;
                         if (Math.random() < 0.5) {
                             a[1] = B;
                             a[2] = C;
                         }
                         else {
                             a[1] = C;
                             a[2] = B;
                         }
                     } else if(rand < 0.66) {
	                 a[0] = B;
                         if (Math.random() < 0.5) {
                             a[1] = A;
                             a[2] = C;
                         }
                         else {
                             a[1] = C;
                             a[2] = A;
                         }
                     } else {
                         a[0] = C;
                         if (Math.random() < 0.5) {
                             a[1] = B;
                             a[2] = A;
                         }
                         else {
                             a[1] = A;
                             a[2] = B;
                         }
                     }

                     return a;
                 },

        newPassages: ["Friend-Family-Question", "Betrayal-Question", "Expression-Question"],
        newPassagesOrdering: [0, 1, 2],
        nextNum: 0,
        getNext: function() {
                     if (this.nextNum < 3) {
                         return this.newPassages[this.newPassagesOrdering[this.nextNum++]];
                     }
                     else {
                         return "Finish";
                     }
                 },
        surveyAddress: "<?php echo $_SESSION['survey'] ?>"
    };

    console.log(t);
    console.log(t.q32as);
    console.log(t.newPassages);
    console.log(t.newPassagesOrdering);

    window.testT = t;
    console.log("T is now in the window");
    console.log(window.testT.newPassages);
    console.log(t.newPassagesOrdering);

    var ts = window.testT;

    ts.newPassagesOrdering = ts.shuffle3(ts.newPassagesOrdering);

    console.log("Passages shuffled");
    console.log(ts.newPassagesOrdering);
    console.log(ts.newPassages[ts.newPassagesOrdering[0]]);
    console.log(ts.newPassages[ts.newPassagesOrdering[1]]);
    console.log(ts.newPassages[ts.newPassagesOrdering[2]]);
    console.log(window.ThesisServer.getNext());
    console.log(window.ThesisServer.getNext());
    console.log(window.ThesisServer.getNext());
    console.log(window.ThesisServer.getNext());
    window.ThesisServer.nextNum = 0;

    localStorage.setItem("rq1", ts.q1as[<?php echo $rq1 ?>]);
    localStorage.setItem("rq2", ts.q2as[<?php echo $rq2 ?>]);
    localStorage.setItem("rq3", ts.q3as[<?php echo $rq3 ?>]);
    localStorage.setItem("rq12", ts.q12as[<?php echo $rq12 ?>]);
    localStorage.setItem("rq22", ts.q22as[<?php echo $rq22 ?>]);
    localStorage.setItem("rq32", ts.q32as[<?php echo $rq32 ?>]);
    console.log(localStorage.getItem("rq1"));
    console.log(localStorage.getItem("rq2"));
    console.log(localStorage.getItem("rq3"));
    console.log(localStorage.getItem("rq12"));
    console.log(localStorage.getItem("rq22"));
    console.log(localStorage.getItem("rq32"));

});
    
    </script>
  </head>
  <body>
    <div>
<?php echo "StoryID: ".$_SESSION['storyID']; ?>
    </div>
    <div>
      <p>System data now prepared for your study. Thank you for waiting.</p>
    </div>
    <div>
      <a href=<?php echo "https://baylor.qualtrics.com/SE/?SID=SV_9nMSsoBjKYhGNGR&participantID=$participantID"; ?>>Start Demographic Survey</a>
    </div>
  </body>
</html>

<?php $conn->close(); ?>
