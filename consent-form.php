<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <title>Consent Form</title>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script>

<?php
  // Generate an ID and store it locally
  $participantID = uniqid();
  $_SESSION['pID'] = $participantID;
  // Then store the ID on the client
?>

$(document).ready(function () {
  localStorage.setItem("participantID", <?php echo "\"".$participantID."\"" ?>);
});

    </script>
  </head>
  <body>
    <div>
      <h1>Baylor University</h1>
      <h2>Department of Computer Science</h2>
      <p>Consent Form for Research<p>
      <p>PROTOCOL TITLE: Interpersonal Ethical Communication via Virtual Environment Influences</p>
      <p>PRINCIPAL INVESTIGATOR: Will Nations</p>
      <p>SUPPORTED BY: Baylor University</p>
    </div>
    <div>
      <p><b>Purpose of the research:</b></p>
      <p>The purpose of this study is to evaluate the potential for interactive media to facilitate the communication of ethical ideas by the nature of virtually shared experiences. We are asking you to take part in this study because people are needed for ethical communication in the first place; therefore, one individual is needed to input an ethical concept and another to be able to extract it.</p>
    </div>
    <div>
      <p><b>Study activities:</b></p>
      <p>If you choose to be in the study, you will...</p>
      <ol>
        <li>be sorted into one of two groups, A or B</li>
        <li>be asked to read through an interactive fiction differentiated for each group. You will need to be able to answer questions in response to character queries.</li>
        <li>complete a few short questionnaires covering ethical considerations.</li>
      </ol>
    </div>
    <div>
      <p><b>Risks and Benefits:</b></p>
      <p>If for any reason you become uncomfortable during the study, you do not have to continue.</p>
      <p>If you are taking the study to receive extra credit, there will be an alternative assignment available to you. consult with your professor for details.</p>
    </div>
    <div>
      <p><b>Confidentiality:</b></p>
      <p>A risk of taking part in this study is the possibility of a loss of confidentiality. Loss of confidentiality includes having your personal information shared with someone who is not on the study team and was not supposed to see or know about your information. The researcher plans to protect your confidentiality.</p>
      <p>Confidentiality will be maintained to the degree permitted by the technology used. Your participation in this online survey involves risks similar to a person's everyday use of the Internet, which could include illegal interception of the data by another party. If you are concerned about your data security, you should not participate in this research.</p>
      <p>We will keep the records of this study confidential by not recording any personally identifying information regarding participants.  We will make every effort to keep your records confidential.  However, there are times when federal or state law requires the disclosure of your records.</p>
      <p>Authorized staff of Baylor University may review the study records for purposes such as quality control or safety.</p>
      <p>You will not be paid for taking part in this study.</p>
      <p>If your professor has offered extra credit, consult with them for the details of how much extra credit you will receive upon completing the study.</p>
    </div>
    <div>
      <p><b>Questions or concerns about this research study:</b></p>
      <p>You can call us with any concerns or questions about the research at any time. our contact information is listed below:</p>
      <p>Principal Investigator<br />Will Nations<br />Will_Nations@baylor.edu<br />817-296-5864<br /></p>
      <p>Research Advisor<br />Dr. Matthew Fendt<br />Matthew_Fendt@baylor.edu<br />(254)-710-1798<br /></p>
      <p>If you want to speak with someone not directly involved in this research study, you may contact the Baylor University IRB through the Office of the Vice Provost for Research at 254-710-1438. You can talk to them about:<p>
      <ul>
        <li>Your rights as a research subject</li>
        <li>Your concerns about the research</li>
        <li>A complaint about the research</li>
      </ul>
      <p>Taking part in this study is your choice.  You are free not to take part or to stop at any time for any reason.  No matter what you decide, there will be no penalty or loss of benefit to which you are entitled.  If you decide to withdraw from this study, the information that you have already provided will be kept confidential. Information already collected about you cannot be deleted.</p>
      <p>By continuing with the research and completing the study activities, you are providing consent.</p>
    </div>
    <br />
    <div>
      <form action='createUser.php' method='post'>
        <input type='submit' name='submit' value='I CONSENT'>
      </form>
    </div>
  </body>
</html>
