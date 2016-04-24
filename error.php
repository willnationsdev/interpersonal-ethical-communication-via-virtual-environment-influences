<!DOCTYPE html>
<html>
  <title>Error!</title>
  <body>
    <p>A problem occurred during communication with the server. Please
       notify Will Nations. Your current session in the study will be 
       invalidated.</p>
    <p>
    <?php session_start(); echo $_SESSION['sql'] ?>
    </p>
    <p>
    <?php echo $_SESSION['error'] ?>
    </p>
  </body>
</html>
