<?php
session_start();

if (isset($_SESSION['loggedUser'])){
	header('Location: menu.php');
	exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/0493276a63.js" crossorigin="anonymous"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Cookie&family=Pacifico&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cookie&family=Pacifico&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">


    <title>Login</title>
</head>

<body>
    <div class="main">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid ">
                <a class="navbar-brand"><i class="fa-solid fa-hand-holding-dollar me-2"></i>PERSONAL BUDGET</a>
            </div>
        </nav>

        <div class="container">

            <div class="row justify-content-between">
                <div class="col-8 col-lg-5">
                    <div class="sentence">
                        <p class="h2"><span>Budgets</span> can open your life to achieving goals you never thought
                            possible.
                        </p>
                        <blockquote class="blockquote">
                            <p class="h5 mt-5"><em>Don’t let your finances stress you out to the point of inaction.
                                    Instead, take control of your finances.</em></p>
                        </blockquote>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="login" style="height: auto;">
                        <div class="title"><span>Member login</span></div>
                        
                        <form action = "logIn.php" method="post">

                            <div class="row mb-3">
                                <div class="input-group">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="Username" name="username" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" class="form-control" id="exampleInputPassword1"
                                        placeholder="Password" name="password" required>
                                </div>
                            </div>
                            <div class="row mb-3 form-check">
                                <div class="pass">
                                    <div class="input-group">
                                        <input type="checkbox" class="form-check-input me-2" id="remember">
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>
                                    <a href="#">Forgot password?</a>
                                </div>
                            </div>
                            <div class="button"><button type="submit" class="btn btn-warning">Sign in</button></div>

                            <?php
                                if (isset($_SESSION['bad_attempt'])) 
                                {
                                    echo '<div class="error mt-1 text-center">'.$_SESSION['bad_attempt'].'</div>';
                                    unset($_SESSION['bad_attempt']);
                                }
                            ?>

                            <div class="signup">Not a memeber? <a href="registration.php"> Sign up now!</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>




</body>

</html>