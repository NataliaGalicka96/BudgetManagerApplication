<?php
//rozpoczynamy sesję
    session_start();

//jeśli uzytkownik wypełnił formularz rejestracji i wysłał, to ten if zwróci wartość true,
//sprawdzamy czy zostało zarezerwowane miejsce w pamięci dla tej zmiennej, a nie jaka jest jej 
//wartość

if(isset($_SESSION['loggedUser'])){
    header('Location: menu.php');
    exit();
}



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

        $pass1=$_POST['password1'];
        $pass2=$_POST['password2'];

        if((strlen($pass1))<8||(strlen($pass1)>20))
        {
            $validation_OK=false;
            $_SESSION['error_password']="Password must be 8 to 20 characters long";
        }

        //Sprawdzam czy dwa hasła są takie same

        if($pass1!=$pass2)
        {
            $validation_OK=false;
            $_SESSION['error_password']="Given passwords are different!";
        }

        //hashujemy hasła
        $passwordHash=password_hash($pass1, PASSWORD_DEFAULT);

      //  echo $passwordHash;
      //  exit();


        //Zapamiętaj wprowadzone dane

        $_SESSION['fr_username']=$username;
        $_SESSION['fr_email']=$email;
        $_SESSION['fr_pass1']=$pass1;
        $_SESSION['fr_pass2']=$pass2;

        require_once 'database.php';

        //pobieram dane  formularza username oraz email

        $username = filter_input(INPUT_POST, 'username');
        $email = filter_input(INPUT_POST, 'email');

        //łącze z bazą danych, piszę zapytanie query
        //sprawdzam czy jest w bazie danych już taki email

        $sql = "SELECT email FROM users WHERE email=:email";

        $userQuery = $db->prepare($sql);
        $userQuery->bindValue(':email', $email, PDO::PARAM_STR);
        $userQuery->execute();

        //łapiemy wyjątek gdy zapytanie nie zwróci nam żadnego rekordu, tzn: nie istnieje login

        $user=$userQuery->fetch();

        if($user){
            $validation_OK=false;
            $_SESSION['error_email']="There is already an account assigned to this email address!";
        }


        //sprawdzam czy jest w bazie dancyh już taki username

        $sql2 = "SELECT username FROM users WHERE username=:username";

        $userQuery2 = $db->prepare($sql2);
        $userQuery2->bindValue(':username', $username, PDO::PARAM_STR);
        $userQuery2->execute();

        //łapiemy wyjątek gdy zapytanie nie zwróci nam żadnego rekordu, tzn: nie istnieje login

        $user2=$userQuery2->fetch();

        if($user2){
            $validation_OK=false;
            $_SESSION['error_username']="There is already an account assigned to this email address!";
        }

        if($validation_OK==true)
        {
            //Hurra, wszystkie testy zaliczone, dodajemy uzytkownika do bazy
            
            //Polecenie INSERT INTO - dodaje nowy wiersz 
                    //tu podajemy nasz stworozny obiekt PDO
            $query = $db -> prepare('INSERT INTO users VALUES (:id, :username, :pass, :email)');

            //posyłamy do zapytania nasz zwalidowany adres email
            //przypiszemy wartość $email w miejsce :email
            //bindValue(gdzie ma trafić parametr, co ma trafić, PDO::PARAM_STR)
            $query->bindValue(':id', NULL, PDO::PARAM_INT);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':username', $username, PDO::PARAM_STR);
            $query->bindValue(':pass', $passwordHash, PDO::PARAM_STR);

            if($query->execute())


            

            $sql = "SELECT id FROM users WHERE username = :username";
            
            
            $getUserId = $db->prepare($sql);
            $getUserId -> bindValue(':username', $username, PDO::PARAM_STR);
            $getUserId -> execute();

            $result = $getUserId -> fetch();
            $userId = $result['id'];
        

            $sql1="INSERT INTO incomes_category_assigned_to_users (user_id, name)
            SELECT users.id, incomes_category_default.name FROM users, incomes_category_default WHERE users.id = $userId"; 
            /* VALUES(NULL,$userId, 1),(NULL,$userId, 2),(NULL,$userId, 3),(NULL,$userId, 4)";*/
            
            $assignIncomeCategoriesToUser = $db->prepare($sql1);
            $assignIncomeCategoriesToUser -> execute();


            
            $sql2="INSERT INTO payment_methods_assigned_to_users (user_id, name)
            SELECT users.id, payment_methods_default.name FROM users, payment_methods_default  WHERE users.id = $userId";

    
            $assignPaymentMethodsToUser = $db->prepare($sql2);
            $assignPaymentMethodsToUser -> execute();

            $sql3="INSERT INTO expenses_category_assigned_to_users (user_id, name)
            SELECT users.id, expenses_category_default.name FROM users, expenses_category_default WHERE users.id = $userId";
            
            $assignExpenseCategoriesToUser = $db->prepare($sql3);
            $assignExpenseCategoriesToUser -> execute();

            $_SESSION['successfulRegistration']=true; //nowa sesja
            header ('Location: welcome.php');

        }
    else{
            //nie wypełniono formularza, przekieruj an strone registration.php
            $_SESSION['bad_attempt'] = '<span style="color:red">The username or password you have entered is incorrect!</span>';
            header ('Location: registration.php');
            exit(); 
        }

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
                                        if(isset($_SESSION['fr_username'])) //jesli zmienna sesyjna jest ustawiona pokazujemy na ekranie

                                        {
                                            echo $_SESSION['fr_username'];
                                            unset($_SESSION['fr_username']);
                                        }
                                        
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
                                        if(isset($_SESSION['fr_email'])) //jesli zmienna sesyjna jest ustawiona pokazujemy na ekranie

                                        {
                                            echo $_SESSION['fr_email'];
                                            unset($_SESSION['fr_email']);
                                        }
                                    
                                        
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
                                        if(isset($_SESSION['fr_pass1'])) //jesli zmienna sesyjna jest ustawiona pokazujemy na ekranie

                                        {
                                            echo $_SESSION['fr_pass1'];
                                            unset($_SESSION['fr_pass1']);
                                        }
                                    
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
                                            if(isset($_SESSION['fr_pass2'])) //jesli zmienna sesyjna jest ustawiona pokazujemy na ekranie

                                            {
                                                echo $_SESSION['fr_pass2'];
                                                unset($_SESSION['fr_pass2']);
                                            }
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