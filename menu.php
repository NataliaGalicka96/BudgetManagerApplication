<?php

	session_start();

    require_once 'database.php';

    if (!isset($_SESSION['loggedUser']))
	{
		header('Location: index.php');
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
    <link rel="stylesheet" href="menu.css">


    <title>Menu</title>
</head>

<body>

    <div class="main">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid ">
                <a class="navbar-brand"><i class="fa-solid fa-hand-holding-dollar me-2"></i>PERSONAL BUDGET</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item px-1">

                                <?php
                                    echo '<a class="nav-link px-1" aria-current="page" href="menu.php"><i class="fa-solid fa-house me-2"></i>Home</a>'    
                                ?>
                                    
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="#"><i class="fas fa-coins mr me-2"></i>Add Income</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="#"><i class="fa-solid fa-money-bill-1-wave me-2"></i>Add
                                Expense</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="#"><i class="fa-solid fa-chart-pie me-2"></i>View Balance</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="#"><i class="fas fa-cog me-2"></i>Settings</a>
                        </li>
                        <li class="nav-item px-1">
                             
                            <?php
                            echo '<a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Sign Out</a>'    
                            ?>
                            
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row mx-auto">
                <div class="col text-center">

                <?php
                    echo "<p>Hello ".$_SESSION['username'].'!';
                    echo "<p> You are on the main page of the application. Select the options you are interested in from the
                    navigation bar. You can add income, add expense, view the balance for the selected period.</p> ";

                ?>

                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>