<?php
  //code to diplays post, comment, and insert comment for all that login user can see (donation_campaign)
  $connect_campaign=mysqli_connect("localhost","root","","bayanion_db");
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  //code to display donation posts
  $result_campaign = mysqli_query($connect_campaign,"SELECT * FROM donation_campaign INNER JOIN users ON donation_campaign.user_id=users.user_id WHERE donation_campaign.post_status='public' AND users.username='". $_SESSION["username"] ."'");

  while($rowcampaign = mysqli_fetch_assoc($result_campaign))
  {
    echo "<table style='width: 600px; height: 500px; background-color: #ffffff;'>";
    echo "<center>";
      echo "<tbody>";
        echo "<form action='home.php' method='post'>";
          echo "<tr>";
            echo "<td style='text-align: left; padding: 10px;'>";
                echo "<img class='img-circle' src='Uploads/",$rowcampaign['user_photo'],"' width='50px' height='50px' />";
                echo "</br>";
                echo "<center>";
              echo "<label name='username' id='username' value =" . $rowcampaign['username'] . ">". $rowcampaign['username'] ."</label>";
                echo "</center>";
                echo "</br>";
            echo "</td>";
            echo "<td style='text-align: left; padding: 10px;'>";
            if($rowcampaign['post_status']==='timeline')
            {
                echo "<img src='images/user.png' width='20px' height='20px' />";
                echo "<label >". '@' ."</label>";
              echo "<label type='text' name='tag_user' id='tag_user' value =" . $rowcampaign['tag_user'] . ">". $rowcampaign['tag_user'] ."</label>";
              echo "&nbsp;&nbsp;&nbsp;&nbsp;";
            }
              echo "<img src='images/public.png' width='20px' height='20px' />";
              echo "<label type='text' name='post_status' id='post_status' value =" . $rowcampaign['post_status'] . ">" . $rowcampaign['post_status'] ."</label>";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                echo "<img src='images/time.png' width='20px' height='20px' />";
              echo "<label type='text' name='create_date' id='post_status' value =" . $rowcampaign['create_date'] . ">" . $rowcampaign['create_date'] ."</label>";
                echo "</br>";
                echo "</br>";
              echo "<p>".$rowcampaign['campaign_description']."</p>";
                echo "</br>";
              echo "<img src='Uploads/",$rowcampaign['campaign_photo'],"' width='300px' height='250px' />";
                echo "</br>";
                echo "<label type='text' name='total_like' id='total_like' value =" . $rowcampaign['total_like'] . ">" . $rowcampaign['total_like'] ."</label>";
                echo "<form id='likefrm' name='likefrm' action='' method='post'>";
                  echo "<input type=hidden name='campaign_id' id='campaign_id' value =" . $rowcampaign['campaign_id'] . ">";
                  echo "<input type=hidden id='Text1' name='Text1'>";
                  echo "<input type=hidden id='Text1' name='Text1'>";
                  echo "<button type='submit' style='border:0;background:transparent' id='like' name='like'>";
                    echo "<img src='/images/star.png' width='30px' height='30px' alt='submit'>";
                  echo "</button>";
                echo "</form>";
                echo "<form action='' method='post' style='float:right;padding-right:25em';>";
                echo "<input type=hidden name='campaign_id' id='campaign_id' value =" . $rowcampaign['campaign_id'] . ">";
                echo "<button name='commentbtn' id='commentbtn' style='border:0;background:transparent'>";
                  echo "<img src='/images/comment.png' width='30px' height='30px' alt='submit'>";
                echo "</button>";
                echo "</form>";
              echo "<div>";
              //code to create comment
                  echo "<center>";
                    echo "<form id='create_comment' name='create_comment' action='' method='post' style='display:inline-block;'>";
                      echo "</br>";
                      echo "<fieldset>";
                          echo "<input type=hidden name='campaign_id' id='campaign_id' value =" . $rowcampaign['campaign_id'] . ">";
                          $resultcampuserid = mysqli_query($connect_campaign,"SELECT user_id FROM users WHERE username='". $_SESSION["username"] ."'");
                          while($rowcampuserid = mysqli_fetch_assoc($resultcampuserid))
                          {
                          echo "<input type='hidden' name='user_id' id='user_id' value ='". $rowcampuserid["user_id"] ."'>";
                          }
                        echo "<textarea name='comment_content' id='comment_content' rows='1' cols='50' style='text-align:left;width:300px;resize:none;' placeholder='Write A Comment........'>" . "</textarea>";
                        echo "<button type='submit' style='border:0;background:transparent;' id='commment_status' name='comment_status'>";
                          echo "<img src='/images/comment.png' width='30px' height='30px' alt='submit'>";
                        echo "</button>";
                      echo "</fieldset>";
                    echo "</form>";
                  echo "</center>";
                  //code to display comments
                  $result_comment_campaign = mysqli_query($connect_campaign,"SELECT comment_content, comment_date, username FROM post_comment INNER JOIN users ON post_comment.user_id=users.user_id WHERE campaign_id=". $rowcampaign['campaign_id']."");
                  while($rowcomcampaign = mysqli_fetch_assoc($result_comment_campaign))
                  {
                          echo $rowcomcampaign['username'] . "&nbsp;&nbsp;";
                          echo "(" . $rowcomcampaign['comment_date'] .  ")";
                          echo "</br>";
                          echo $rowcomcampaign['comment_content'];
                          echo "</br>";
                          echo "</br>";
                  }
              echo "</div>";
            echo "</td>";
          echo "</tr>";
        echo "</form>";
      echo "</tbody>";
      echo "</center>";
    echo "</table>";
    echo "</br>";
  }
  mysqli_close($connect_campaign);
?>

<?php include 'databaseconn.php' ?>
<?php
  //code to update like
if (isset($_POST['like'])) {
  $campaign_id = $_POST['campaign_id'];

  mysqli_query($connect, "UPDATE donation_campaign SET total_like=total_like + 1 WHERE campaign_id=$campaign_id");
  if(mysqli_affected_rows($connect) > 0){
    echo "Successfully Update!";
  }else {
    echo mysqli_error($connect);
  }
    echo "<meta http-equiv='refresh' content='0'>";
}
?>

<?php include 'databaseconn.php' ?>
<?php
//code to insert records in comment table
if(isset($_POST['comment_status']))
{
  $user_id = $_POST['user_id'];
  $campaign_id = $_POST['campaign_id'];
  $comment_content = $_POST['comment_content'];

  mysqli_query($connect, "INSERT INTO post_comment (user_id,campaign_id,comment_content,comment_date)
              VALUES('$user_id','$campaign_id','$comment_content', NOW())");
              if(mysqli_affected_rows($connect) > 0){
            }else {
              echo mysqli_error($connect);
              echo "Not Added!";
            }
  echo "<meta http-equiv='refresh' content='0'>";
}
?>






<?php
  //code to diplays post, comment, and insert comment for all that login user can see (donation_campaign)
  $connecttest=mysqli_connect("localhost","root","","bayanion_db");
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  //code to display donation posts
  $result_testimonies = mysqli_query($connecttest,"SELECT * FROM testimonies INNER JOIN users ON testimonies.user_id=users.user_id WHERE testimonies.post_status='public' AND users.username='". $_SESSION["username"] ."'");

  while($rowtestimony = mysqli_fetch_assoc($result_testimonies))
  {
    echo "<table style='width: 600px; height: 300px; background-color: #ffffff;'>";
    echo "<center>";
      echo "<tbody>";
        echo "<form action='home.php' method='post'>";
          echo "<tr>";
            echo "<td style='text-align: left; padding: 10px;'>";
                echo "<img class='img-circle' src='Uploads/",$rowtestimony['user_photo'],"' width='50px' height='50px' />";
                echo "</br>";
                echo "<center>";
              echo "<label name='username' id='username' value =" . $rowtestimony['username'] . ">". $rowtestimony['username'] ."</label>";
                echo "</center>";
                echo "</br>";
            echo "</td>";
            echo "<td style='text-align: left; padding: 10px;'>";

            if($rowtestimony['post_status']==='timeline')
            {
                echo "<img src='images/user.png' width='20px' height='20px' />";
                echo "<label >". '@' ."</label>";
              echo "<label type='text' name='tag_user' id='tag_user' value =" . $rowtestimony['tag_user'] . ">". $rowtestimony['tag_user'] ."</label>";
              echo "&nbsp;&nbsp;&nbsp;&nbsp;";
            }
              echo "<img src='images/public.png' width='20px' height='20px' />";
              echo "<label type='text' name='post_status' id='post_status' value =" . $rowtestimony['post_status'] . ">" . $rowtestimony['post_status'] ."</label>";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                echo "<img src='images/time.png' width='20px' height='20px' />";
              echo "<label type='text' name='create_date' id='post_status' value =" . $rowtestimony['create_date'] . ">" . $rowtestimony['create_date'] ."</label>";
                echo "</br>";
                echo "</br>";
              echo "<p>".$rowtestimony['testimony']."</p>";
                echo "</br>";
              //echo "<img src='Uploads/",$row['campaign_photo'],"' width='300px' height='250px' />";
                //echo "</br>";
                echo "<label type='text' name='total_like' id='total_like' value =" . $rowtestimony['total_like'] . ">" . $rowtestimony['total_like'] ."</label>";
                echo "<form id='likefrm' name='likefrm' action='' method='post'>";
                  echo "<input type=hidden name='testimony_id' id='testimony_id' value =" . $rowtestimony['testimony_id'] . ">";
                  echo "<input type=hidden id='Text1' name='Text1'>";
                  echo "<input type=hidden id='Text1' name='Text1'>";
                  echo "<button type='submit' style='border:0;background:transparent' id='like' name='like'>";
                    echo "<img src='/images/star.png' width='30px' height='30px' alt='submit'>";
                  echo "</button>";
                echo "</form>";
                echo "<form action='' method='post' style='float:right;padding-right:25em';>";
                echo "<input type=hidden name='testimony_id' id='testimony_id' value =" . $rowtestimony['testimony_id'] . ">";
                echo "<button name='commentbtn' id='commentbtn' style='border:0;background:transparent'>";
                  echo "<img src='/images/comment.png' width='30px' height='30px' alt='submit'>";
                echo "</button>";
                echo "</form>";
              echo "<div>";
              //code to create comment
                  echo "<center>";
                    echo "<form id='create_comment' name='create_comment' action='' method='post' style='display:inline-block;'>";
                      echo "</br>";
                      echo "<fieldset>";
                          echo "<input type=hidden name='testimony_id' id='testimony_id' value =" . $rowtestimony['testimony_id'] . ">";
                          $resultuserid = mysqli_query($connecttest,"SELECT user_id FROM users WHERE username='". $_SESSION["username"] ."'");
                          while($rowuserid = mysqli_fetch_assoc($resultuserid))
                          {
                          echo "<input type='hidden' name='user_id' id='user_id' value ='". $rowuserid["user_id"] ."'>";
                          }
                        echo "<textarea name='comment_content' id='comment_content' rows='1' cols='50' style='text-align:left;width:300px;resize:none;' placeholder='Write A Comment........'>" . "</textarea>";
                        echo "<button type='submit' style='border:0;background:transparent;' id='commment_status' name='comment_status'>";
                          echo "<img src='/images/comment.png' width='30px' height='30px' alt='submit'>";
                        echo "</button>";
                      echo "</fieldset>";
                    echo "</form>";
                  echo "</center>";
                  //code to display comments
                  $result_comment_test = mysqli_query($connecttest,"SELECT comment_content, comment_date, username FROM post_comment INNER JOIN users ON post_comment.user_id=users.user_id WHERE testimony_id=". $rowtestimony['testimony_id']."");
                  while($rowtest = mysqli_fetch_assoc($result_comment_test))
                  {
                          echo $rowtest['username'] . "&nbsp;&nbsp;";
                          echo "(" . $rowtest['comment_date'] .  ")";
                          echo "</br>";
                          echo $rowtest['comment_content'];
                          echo "</br>";
                          echo "</br>";
                  }
              echo "</div>";
            echo "</td>";
          echo "</tr>";
        echo "</form>";
      echo "</tbody>";
      echo "</center>";
    echo "</table>";
    echo "</br>";
  }
  mysqli_close($connecttest);
?>

<?php include 'databaseconn.php' ?>
<?php
  //code to update like
if (isset($_POST['like'])) {
  $testimony_id = $_POST['testimony_id'];

  mysqli_query($connect, "UPDATE testimonies SET total_like=total_like + 1 WHERE testimony_id=$testimony_id");
  if(mysqli_affected_rows($connect) > 0){
    echo "Successfully Update!";
  }else {
    echo mysqli_error($connect);
  }
    echo "<meta http-equiv='refresh' content='0'>";
}
?>

<?php include 'databaseconn.php' ?>
<?php
  //code to insert records in comment table
  if(isset($_POST['comment_status']))
  {
    $user_id = $_POST['user_id'];
    $testimony_id = $_POST['testimony_id'];
    $comment_content = $_POST['comment_content'];

    mysqli_query($connect, "INSERT INTO post_comment (user_id,testimony_id,comment_content,comment_date)
                VALUES('$user_id','$testimony_id','$comment_content', NOW())");
                if(mysqli_affected_rows($connect) > 0){
              }else {
                echo mysqli_error($connect);
                echo "Not Added!";
              }
    echo "<meta http-equiv='refresh' content='0'>";
  }
?>
