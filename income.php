<?php

	session_start();


    if (!isset($_SESSION['loggedUser']))
	{
		header('Location: index.php');
		exit();
	}else
    {
        require_once "database.php";


        $loggedUserId = $_SESSION['logged_id'];

        $sql = "SELECT ica.id, ica.name
        FROM  incomes_category_assigned_to_users AS ica
        WHERE ica.user_id=:userId";


        $incomeCategoryQuery = $db -> prepare($sql);
        $incomeCategoryQuery -> bindValue(':userId', $loggedUserId, PDO::PARAM_INT);
        $incomeCategoryQuery -> execute();

        $incomeCategoriesOfLoggedUser = $incomeCategoryQuery -> fetchAll();





        $_SESSION['incomeAdded'] = false;

    
            if(isset($_POST['amount']))
            {
                
                if(!empty($_POST['amount']) /*&& !empty($_POST['date']) && isset($_POST['category'])*/)
                {
                    //Amount musi być liczbą, maksymalnie dwa miejsca po przecinku
                    //sprawdzam poprawność wprowadzonych danych

                    $validationOk=true;

                    $incomeAmount = number_format($_POST['amount'], 2, '.', '');
                    $amountArray = explode('.', $incomeAmount);

                    if(!is_numeric($incomeAmount) || strlen($incomeAmount) <0 ||strlen($incomeAmount) >10 || strlen($amountArray[1])>2 || strlen($amountArray[0])>8){
                        $_SESSION['error_incomeAmount'] = "Enter valid positive amount - maximum 8 integer digits and 2 decimal places.";
                        $validationOk=false;

                    }

                    $incomeComment = $_POST['comment'];

                    if(strlen($incomeComment)>100)
                    {
                        $_SESSION['error_comment'] = "Comment can contain up to 100 characters";
                        $validationOk=false;
                    }

                    $incomeDate=$_POST['date'];
                    $incomeCategory= $_POST['category'];


                    foreach($incomeCategoriesOfLoggedUser as $category)
                    {
                        if($category['name']==$incomeCategory)
                        {
                            $incomeCatId = $category['id'];
                        }
                        
                    }
            
                    //echo $incomeCatId;

                    $_SESSION['fr_incomeAmount']=$incomeAmount;
                    $_SESSION['fr_incomeDate'] = $incomeDate;
                    $_SESSION['fr_incomeCategory'] = $incomeCategory;
                    $_SESSION['fr_incomeComment'] = $incomeComment;

                    if($validationOk==true){
                        $sql = "INSERT INTO incomes VALUES(NULL, :userId, :cat, :amount, :dat, :comment)";

                        $addIncome = $db->prepare($sql);
                        $addIncome->execute([':userId' => $loggedUserId, 
                        ':cat' => $incomeCatId,
                        ':amount' => $incomeAmount,
                        ':dat' => $incomeDate,
                        ':comment' => $incomeComment]);


                        $_SESSION['incomeAdded'] = true;
                        $_SESSION['incomeAdded'] = "Income has been added";

                    }

                    
                    
                }
                else{
                    $_SESSION['incomeAdded'] = false;
                    $_SESSION['error_incomeAdded'] = "Fill in the necessary fields";
                }

            }

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



    <link rel="stylesheet" href="income.css">

    <title>Income</title>
    <style>
        .error{
            color:red;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .complete{
            color:green;
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: center;
        }

    </style>
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
                            <a class="nav-link px-1" aria-current="page" href="menu.php"><i class="fa-solid fa-house me-2"></i>Home</a>           
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="income.php"><i class="fas fa-coins mr me-2"></i>Add Income</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="expense.php"><i class="fa-solid fa-money-bill-1-wave me-2"></i>Add
                                Expense</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="balance.php"><i class="fa-solid fa-chart-pie me-2"></i>View Balance</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Sign Out</a>   
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container" id="content">
            <div class="row justify-content-center mt-5">
                <div class="col-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="incomes">
                        <div class="title"><span>Add Income</span></div>


                        <form method="post">


                            <?php
                                if(isset($_SESSION['error_incomeAdded']))
                                {
                                    echo '<div class="error">'.$_SESSION['error_incomeAdded'].'</div>';
                                    unset($_SESSION['error_incomeAdded']);
                                }else if(isset( $_SESSION['incomeAdded'] ))
                                {
                                    echo '<div class="complete">'.$_SESSION['incomeAdded'].'</div>';
                                    unset($_SESSION['incomeAdded']);
                                }


                            ?>
                            <div class="row mb-3">
                                <div class="input-group">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input id="amount" class="form-control" type="number" step="0.01" min="0"
                                        aria-label="default input example"  name="amount">
                                </div>

                                <?php
                                    if(isset($_SESSION['error_incomeAmount'])){
                                        echo '<div class="error">'.$_SESSION['error_incomeAmount'].'</div>';
                                        unset($_SESSION['error_incomeAmount']);
                                    }
                                ?>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group">
                                    <label for="date" class="form-label">Date</label>
                                    <input id="date" class="form-control" type="date" aria-label="default input example" name="date"
                                        required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group">
                                    <label for="exampleDataList" class="form-label">Category</label>
                                    <input class="form-control" list="datalistOptions" id="exampleDataList"
                                        aria-label="default input example" name="category" required>
                                    <datalist id="datalistOptions">

                                    <?php
                                            
                                            foreach($incomeCategoriesOfLoggedUser as $category)
                                            {
                                                echo '<option value='.$category['name'].'>';
                                                
                                            }
                                            
                                    
                                    ?>
                                    </datalist>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group">
                                    <label for="area" class="form-label">Comments</label>
                                    <input id="area" class="form-control" type="text" name="comment"
                                        aria-label="default input example">
                                </div>

                                <?php
                                    if(isset($_SESSION['error_comment'])){
                                        echo '<div class="error">'.$_SESSION['error_comment'].'</div>';
                                        unset($_SESSION['error_comment']);
                                    }
                                ?>
                            </div>
                            
                            <div class="button">
                                <button type="submit" class="btn btn-success me-3">Save</button>
                                <button type="submit" class="btn btn-danger ms-3">Cancel</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="data.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>