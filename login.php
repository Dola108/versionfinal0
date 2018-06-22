<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['login'])) {
            include('connection.php');

            $uname = mysqli_real_escape_string($dbc, $_POST['uname']);
            $email = mysqli_real_escape_string($dbc, $_POST['email']);
            $pass = mysqli_real_escape_string($dbc, $_POST['psw']);
            
            $stmt = $dbc->prepare('SELECT * FROM registration WHERE username = ?');
            $stmt->bind_param('s', $uname); // 's' specifies the variable type => 'string'

            $stmt->execute();

            $result = $stmt->get_result();

            if(!empty($_POST["remember"]))  {
              setcookie ("uname",$uname,time()+130);  
              setcookie ("email",$email,time()+130);  
              setcookie ("psw",$pass,time()+130);
              //$_SESSION["admin_name"] = $name;
            } else {  
                if(isset($_COOKIE["uname"])) {  
                    setcookie ("uname","");  
                }
                if(isset($_COOKIE["email"])) {  
                    setcookie ("email","");  
                }
                if(isset($_COOKIE["psw"])) {  
                    setcookie ("psw","");  
                } 
            }
              setcookie ("session", 1,time()+120);

            if($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $dbmail = $row['email'];
                $dbuname = $row['username'];
                $dbpass = $row['password'];
                $_SESSION['uname'] = $uname;

                if ($email == $dbmail) {
                    if (password_verify($pass, $dbpass)) {
                        if ($uname == $dbuname) {
                            $stmt->close();                   
                            if (strpos($uname, 'Admin') !== false) {
                              header('Location: admin_page.php?uname='.$_SESSION['uname']);
                              exit;
                            }
                            header('Location: profile.php?uname='.$_SESSION['uname']);
                        } else {
                            if (isset($_POST['uname'])) {
                              $email = null;
                              session_destroy();
                            }
                            $stmt->close();
                            echo "<script>
                                    alert('Wrong Username!!');
                                      window.location.href = 'homepage.php';
                                </script>";
                                exit;
                        }
                    } else {
                            if (isset($_POST['uname'])) {
                              $email = null;
                              session_destroy();
                            }
                            $stmt->close();
                            echo "<script>
                                    alert('Wrong Password!!');
                                      window.location.href = 'homepage.php';
                                </script>";
                                exit;
                    }
                } else {
                      if (isset($_POST['uname'])) {
                              $email = null;
                              session_destroy();
                            }
                            $stmt->close();
                            echo "<script>
                                    alert('Wrong E-mail Id!!');
                                      window.location.href = 'homepage.php';
                                </script>";
                                exit;
                }
              }
            } else {
                $stmt->close();
                echo "<script>
                      alert('You have to register first!!');
                            window.location.href = 'homepage.php'; 
                      </script>";
            }
        }
    }
?>