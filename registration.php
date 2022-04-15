<?php
//rozpoczynamy sesję
    session_start();

//jeśli uzytkownik wypełnił formularz rejestracji i wysłał, to ten if zwróci wartość true,
//sprawdzamy czy zostało zarezerwowane miejsce w pamięci dla tej zmiennej, a nie jaka jest jej 
//wartość

    if(isset($_POST['username']))
    {
        //Zakładamy, ze walidacja jest udana
        $validation_OK = true;

        //Sprawdzam poprawność name

        $username=$_POST['username'];
    
        //sprawdzam długość nicka, zakładam ze minimum 3 znaki max 20 znaków
        if((strlen($username)<3)||(strlen($username)>20))
        {
            $validation_OK=false;
            //tworzę zmienną sesyjną błędny nick
            $_SESSION['error_username']="Username must be 3 to 20 characters long";
        }
        //sprawdzam czy w username nie wsytępują znaki alfanumeryczne

        if((ctype_alnum($username)==false))
        {
            $validation_OK=false;
            $_SESSION['error_username']="Username can only consist of numbers and letters without Polish characters";
        }

        //sprawdzam poprawność maila
        //email po sanityzacji -> jeśli w emailu były znaki polskie zostaną usunięte

        $email=$_POST['email'];
        $email_after_sanitize=filter_var($email, FILTER_SANITIZE_EMAIL);

        //email nie przeszedł walidacji
        if((filter_var($email_after_sanitize, FILTER_VALIDATE_EMAIL)==false)||($email_after_sanitize!=$email))
        {
            $validation_OK=false;
            $_SESSION['error_email']="Please enter a valid email!";
        }

        //Sprawdzenie poprawności haseł

        $pass1= $_POST['password1'];
        $pass2=$_POST['password2'];

        if((strlen($pass1))<3||(strlen($pass1)>20))
        {
            $validation_OK=false;
            $_SESSION['error_password']="Password must be 3 to 20 characters long";
        }

        //Sprawdzam czy dwa hasła są takie same

        if($pass1!=$pass2)
        {
            $validation_OK=false;
            $_SESSION['error_password']="Given passwords are different!";
        }

        //hashujemy hasła
        $passwordHash=password_hash($pass1, PASSWORD_DEFAULT);

        //CAPTCHA, BOT OR NOT?











        //Zapamiętaj wprowadzone dane

        $_SESSION['fr_username']=$username;
        $_SESSION['fr_email']=$emal;
        $_SESSION['fr_pass1']=$pass1;
        $_SESSION['fr_pass2']=$pass2;

    }





?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/0493276a63.js" crossorigin="anonymous"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Cookie&family=Pacifico&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cookie&family=Pacifico&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="registration.css">


    <title>Registration</title>

    <style>
        .error{
            color:red;
            margin-top: 10px;
            margin-bottom: 10px;
        }

    </style>
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
                    <div class="login">
                        <div class="title"><span>Registration</span></div>
                        
                        
                        <form method="post">
                            <div class="row mb-3">
                                <div class="input-group">
                                    <i class="fa-solid fa-user"></i>
                                    <input class="form-control" type="text" placeholder="Name" name="username" required
                                    value="<?php
                                        
                                        
                                        ?>">

                                </div>
                                <?php
                                        //pokaz komunikat o bledzie

                                        if(isset($_SESSION['error_username']))
                                        {
                                            echo '<div class="error">'.$_SESSION['error_username'].'</div>';
                                            unset ($_SESSION['error_username']);
                                        }

                                    ?>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group">
                                    <i class="fa-solid fa-envelope"></i>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="Email" required value="<?php
                                        
                                        
                                        ?>" name="email">
                                </div>
                                <?php
                                        //pokaz komunikat o bledzie

                                        if(isset($_SESSION['error_email']))
                                        {
                                            echo '<div class="error">'.$_SESSION['error_email'].'</div>';
                                            unset ($_SESSION['error_email']);
                                        }

                                    ?>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" class="form-control" id="password" placeholder="Password" 
                                    name="password1" required 
                                    value="<?php
                                        
                                        ?>">
                                </div>

                                <?php
                                if(isset($_SESSION['error_password']))
                                {
                                    echo '<div class="error">'.$_SESSION['error_password'].'</div>';
                                    unset($_SESSION['error_password']);
                                }

                                ?>
                                
                                <div>
                                    <input type="checkbox" id="checkbox" name="checkbox" onclick="showPassword()">
                                    <label for="checkbox">Show password</label>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="input-group">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" class="form-control" id="exampleInputPassword1"
                                        placeholder="Confirm password" name="password2" required
                                        value="<?php
                                        
                                        ?>">
                                </div>


                            </div>


                            <div class="button"><button type="submit" class="btn btn-warning">Sign up</button></div>

                            <div class="signin">Already have an account? <a href="index.php"> Sign in now!</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <script src="haslo.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>


</html>