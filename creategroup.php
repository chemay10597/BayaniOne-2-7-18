<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php

    include_once("header.php");
    //session_start();
    if(!isset($_SESSION["username"])){
        header("location:index.php");
    } else {
?>
<?php include 'databaseconn.php' ?>

  <body style="background-color:#b3b3b3;">
      <div>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class = "navbar-brand" href="home.php"><span><image src = "../images/logo.png" height= "50px" width="50px"></span><span><image src = "../images/logotext.png" id="logotext" height= "50px" width="200px"></span></a>
              </div>

              <div class="collapse navbar-collapse" id="myNavbar">

                <ul class="nav navbar-nav navbar-right">
                  <form action="search.php" method="GET" style="height:40px;">
                    <input class="form-control" name="datainput" type="text" style="width:100%; position:bottom;" placeholder="Search users, posts, groups...">
                    <input style="width:0;height:0;display: none;" class="btnlogin" type="submit" value="Search" name="search" />
                  </form>
                  <li>
                    <div class="dropdown">
                  		<button id="notification-icon" name="button" onclick="myFunction()" class="dropbtn"><span id="notification-count"><?php if($count>0) { echo $count; } ?></span><img height="30px" weight="30px" src="images/notif.png" /></button>
                      <div class="dropdown-content" style="height-max:500px;overflow:auto;" id="nav">
                      <?php if(isset($message)) { ?> <div class="error"><?php echo $message; ?></div> <?php } ?>
                    	<?php if(isset($success)) { ?> <div class="success"><?php echo $success;?></div> <?php } ?>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="dropdown">
                      <button class="dropbtn">Delivery Courier</button>
                      <div class="dropdown-content" id="nav">
                        <a href="http://www.air21.com.ph/main/">AIR21</a>
                        <a href="https://express.2go.com.ph/">2GO Express</a>
                        <a href="http://www.lbcexpress.com/">LBC Express</a>
                        <a href="http://new.xend.com.ph/">Xend Business Solutions</a>
                        <a href="http://www.jrs-express.com/">JRS Express</a>
                        <a href="http://abestexpress.com/">ABest Express</a>
                        <a href="http://www.dhl.com.ph/en.html">DHL Express</a>
                      </div>
                    </div>
                  </li>
                  <li>
                    <a href= "viewmap.php">View Map</a>
                  </li>
                  <li>
                    <div class="dropdown">
                      <button class="dropbtn">Community Updates</button>
                      <div class="dropdown-content" id="nav">
                        <a href="publicupdate.php">Public Update</a>
                        <a href="privateupdate.php">Private Update</a>
                      </div>
                    </div>
                  </li>
                  <li>
                    <!--<a href="#mygroup">My Group</a>-->
                    <div class="dropdown">
                      <button class="dropbtn">My Group</button>
                      <div class="dropdown-content" id="nav">
                        <a href="creategroup.php">Create Group</a>
                        <?php
                        //code to get the user_id that is used in inserting record in post table
                          $connect=mysqli_connect("localhost","root","","bayanion_db");
                          // Check connection
                          if (mysqli_connect_errno())
                          {
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                          }

                          $result = mysqli_query($connect,"SELECT group_name FROM groups INNER JOIN users ON groups.user_id=users.user_id WHERE username='". $_SESSION["username"] ."'");
                            while($row = mysqli_fetch_array($result))
                            {
                              echo "<a href='groupprofile.php'>". $row['group_name'] ."</a>";
                            }
                          mysqli_close($connect);
                        ?>
                      </div>
                  </li>
                  <li>
                    <!--<a href= "#posts">Post</a>-->
                    <div class="dropdown">
                      <button class="dropbtn">Post</button>
                      <div class="dropdown-content" id="nav">
                        <a href="donationcampaign.php">DonationCampaign</a>
                        <a href="testimonies.php">Testimonies</a>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="dropdown">
                      <button class="dropbtn">
                        <?php
                        //code to get the user_id that is used in inserting record in post table
                          $connect=mysqli_connect("localhost","root","","bayanion_db");
                          // Check connection
                          if (mysqli_connect_errno())
                          {
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                          }
                          $result = mysqli_query($connect,"SELECT username FROM users WHERE username='". $_SESSION["username"] ."'");
                            while($row = mysqli_fetch_array($result))
                            {
                              echo $row['username'];
                            }
                          mysqli_close($connect);
                        ?>
                      </button>
                        <div class="dropdown-content" id="nav">
                          <a href="userinfo.php">AccountSetting</a>
                          <?php
                          //code to get login user info for individual_user
                          $connect=mysqli_connect("localhost","root","","bayanion_db");
                          // Check connection
                          if (mysqli_connect_errno())
                          {
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                          }
                          //code to get the login user info based on account_type (individual user)
                            $result = mysqli_query($connect,"SELECT * FROM users WHERE username = '".$_SESSION['username']."'");
                            while($row = mysqli_fetch_assoc($result))
                              {
                                if($row['account_type'] == "admin") {
                                echo "<a href='adminsignup.php'>".'Add admin'."</a>";
                                echo "<a href='reports.php'>".'View Reports'."</a>";
                                }
                              }
                            mysqli_close($connect);
                          ?>
                        </div>
                    </div>
                  </li>
                  <li>
                    <a class="btn-logout" href= "logout.php">Logout</a>
                  </li>
                </ul>
              </div>
            </div>
        </nav>

        <center><div class="scroll">
        </br>
          <div class="creategroup" style="height:auto;">
            </br>
              <form id="create_group" name="create_group" action="" method="post">
                <h2>Create Group</h2>
                </br>
                <fieldset>
                  <?php
                  //code to get the user_id that is used in inserting record in post table
                    $connect=mysqli_connect("localhost","root","","bayanion_db");
                    // Check connection
                    if (mysqli_connect_errno())
                    {
                      echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }

                    $result = mysqli_query($connect,"SELECT user_id FROM users WHERE username = '".$_SESSION['username']."'");
                    while($row = mysqli_fetch_assoc($result))
                    {
                      echo "<input type=hidden name='user_id' id='user_id' value =" . $row['user_id']. ">";
                    }
                    mysqli_close($connect);
                  ?>
                  <input type="text" id="group_name" name="group_name" placeholder="Group name" value=""/>
                  </br>
                  </br>
                  <img id="group_image" name="group_image" runat="server" height="150" width="150"/>
                  <input type="file" id="group_logo" name="group_logo" accept="image/*" onchange="READURL(this);"/>
                  <!-- script to display image on select -->
                  <script>
                    //script code to display photo during selection
                    function READURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    $('#group_image')
                                        .attr('src', e.target.result)
                                        .width(150)
                                        .height(150);
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                    }
                  </script>
                  </br>
                  <textarea name="group_description" rows="7" cols="64" style="text-align:left;resize:none;" placeholder=".........Write Something........"></textarea>
                  </br>
                  <label>Admin:</label>
                  <?php
                  //code to get the user_id that is used in inserting record in post table
                    $connect=mysqli_connect("localhost","root","","bayanion_db");
                    // Check connection
                    if (mysqli_connect_errno())
                    {
                      echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }

                    $result = mysqli_query($connect,"SELECT username FROM users WHERE username = '".$_SESSION['username']."'");
                    while($row = mysqli_fetch_assoc($result))
                    {
                      echo "<input type='text' name='admin' id='admin' value =" . $row['username']. ">";
                    }
                    mysqli_close($connect);
                  ?>
                  &nbsp;&nbsp;
                  <label>Add Members:</label>
                  <?php
                  //code to get the user_id that is used in inserting record in post table
                    $connect=mysqli_connect("localhost","root","","bayanion_db");
                    // Check connection
                    if (mysqli_connect_errno())
                    {
                      echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }

                    $result = mysqli_query($connect,"SELECT username FROM users");
                    echo "<select name='members' id='members' value=''>";
                    echo "<option value =''>" .'choose username..'. "</option>";
                    while($row = mysqli_fetch_assoc($result))
                      {
                        echo "<option value =" . $row['username']. ">" .$row['username']. "</option>";
                      }
                      echo "<select>";
                    mysqli_close($connect);
                  ?>
                </br>
                <input type='hidden' id="create_date" name="create_date"/>
                </br>
                <input class="btnlogin" type="submit" id="post_group" name="post_group" value="Create"/>
              </fieldset>
              </form>

              <?php include 'databaseconn.php' ?>
              <?php
                //code to insert record in post table
                if(isset($_POST['post_group']))
                {
                  //variables
                  $user_id = $_POST['user_id'];
                  $group_logo = $_POST['group_logo'];
                  $group_name = $_POST['group_name'];
                  $group_description = $_POST['group_description'];
                  $admin = $_POST['admin'];
                  $members = $_POST['members'];
                  $create_date= $_POST['create_date'];

                  if(isset($_FILES['group_logo'])) {
                    $group_logo=addslashes(file_get_contents($_FILES['group_logo']['temp_name'])); //will store the image to fp
                  }
                  //query to insert data
                  if($group_logo!='' && $group_name!='' && $group_description!='')
                  {
                  mysqli_query($connect, "INSERT INTO groups (user_id,group_logo,group_name,group_description,admin,members,create_date)
                              VALUES('$user_id','$group_logo','$group_name','$group_description','$admin','$members',NOW())");
                              if(mysqli_affected_rows($connect) > 0){
                              echo "      ";
                            }else {
                              echo mysqli_error($connect);
                              echo "Not Added!";
                            }
                  }
                }
              ?>
          </div>
          </br>
        </div></center>
      </div>
    </div>
    <footer id="myFooter">
      <center>
      <div class="container">
        <div class="row">
          <ul>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">FAQ</a></li>
              <li><a href="#">About Us</a></li>
            </ul>
          </div>
        </div>
        </center>
        <div class="footer-copyright">
            <p>© 2017 BayaniOne </p>
        </div>
    </footer>
    <script src="../jquery/jquery.min.js"></script>
    <script src="../jquery/bootstrap.min.js"></script>
</body>
<?php } ?>
</html>
