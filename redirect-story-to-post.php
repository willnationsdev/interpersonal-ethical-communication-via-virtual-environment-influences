<?php

session_start();

//establish connection to database
$conn = new mysqli($_SESSION['servername'], 
                   $_SESSION['username'], 
                   $_SESSION['password'], 
                   $_SESSION['db']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$participantID = $_SESSION['pID'];

if ($_SESSION['storyID'] == "A") {
    
    $q1 = $_POST['q1'];
    $q2 = $_POST['q2'];
    $q3 = $_POST['q3'];
    $q12 = $_POST['q12'];
    $q22 = $_POST['q22'];
    $q32 = $_POST['q32'];

    $_SESSION['sql'] = "UPDATE participants SET q1='$q1', q2='$q2', q3='$q3', q12='$q12', q22='$q22', q32='$q32', completed='true' WHERE id='$participantID'";
    $result = $conn->query($_SESSION['sql']);
    if ($result === FALSE) {
        $_SESSION['error'] = "10";
        header("Location:error.php");
    }
}
else if ($_SESSION['storyID'] == "B") {

    $_SESSION['sql'] = "UPDATE participants SET completed='true' WHERE id='$participantID'";
    $result = $conn->query($_SESSION['sql']);
    if ($result === FALSE) {
        $_SESSION['error'] = "11";
        header("Location:error.php");
    }
}

header("Location:".$_SESSION['survey']);

?>
