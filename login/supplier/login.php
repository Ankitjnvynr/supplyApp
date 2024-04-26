<?php
require_once '../../partials/_db.php';

if (isset($_POST['loginbtn']))
{
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];

    $sql = "SELECT * FROM `users` WHERE email = '$userEmail' ";
    $res = $conn->query($sql);
    if ($res)
    {
        $nums = $res->num_rows;
        if ($nums > 0)
        {
            while($row = mysqli_fetch_assoc($res)){
                if($row['password']==md5($userPassword)){
                    echo $_SESSION['loggedin'] = true;
                    echo $_SESSION['userId'] = $row['id'];
                    echo $_SESSION['userEmail'] = $row['email'];
                    header("location: ../handlelogin.php");
                    exit;
                }else{
                    $notPwdMatch = "Wrong Password";
                }
            }
        } else
            $notFoundMsg = "Wrong! email or username";
        {
        }
    }
}
?>
<form class="w-100 rounded shadow p-3" action="" method="POST">
    <div class="text-center text-success mb-3">
        <h4>Login</h4>
    </div>
    <div class="mb-3">
        <label for="userEmail" class="form-label">Email address</label>
        <input type="email" name="userEmail" class="form-control" id="userEmail" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text text-danger">
            <?php
                if(isset($notFoundMsg)){
                echo $notFoundMsg;
                }
            ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="userPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="userPassword" name="userPassword" aria-describedby="pshelp">
        <div id="pshelp" class="form-text text-danger">
            <?php
            if (isset($notPwdMatch))
            {
                echo $notPwdMatch;
            }
            ?>
        </div>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button name="loginbtn" type="submit" style="width: 100%;" class="btn btn-success text-center">Login to Account</button>
    <p class="m-0 mt-3">Forgot Password ? <a class="text-success fw-bold p-0 m-0" href="../supplier?signup">Reset </a></p>
    <p class="m-0">Not registered yet, <a class="text-success fw-bold p-0 m-0" href="../supplier?signup">Sign Up</a></p>
</form>