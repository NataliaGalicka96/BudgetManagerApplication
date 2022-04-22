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

        $sql = "SELECT eca.id, eca.name
        FROM  expenses_category_assigned_to_users AS eca
        WHERE eca.user_id=:userId";


        $expenseCategoryQuery = $db -> prepare($sql);
        $expenseCategoryQuery -> bindValue(':userId', $loggedUserId, PDO::PARAM_INT);
        $expenseCategoryQuery -> execute();

        $expenseCategoriesOfLoggedUser = $expenseCategoryQuery -> fetchAll();

       // print_r($expenseCategoriesOfLoggedUser);
        
        $sql2 = "SELECT pma.id, pma.name
        FROM  payment_methods_assigned_to_users AS pma
        WHERE pma.user_id=:userId";

        $paymentMethod = $db -> prepare($sql2);
        $paymentMethod -> bindValue(':userId', $loggedUserId, PDO::PARAM_INT);
        $paymentMethod -> execute();

        $paymentMethodOfLoggedUser = $paymentMethod -> fetchAll();

        // print_r($paymentMethodOfLoggedUser);

        $_SESSION['expenseAdded'] = false;

    
            if(isset($_POST['amount']))
            {
                
                if(!empty($_POST['amount']) && !empty($_POST['date']) && isset($_POST['category']) && isset($_POST['payment']))
                {
                    //Amount musi być liczbą, maksymalnie dwa miejsca po przecinku
                    //sprawdzam poprawność wprowadzonych danych

                    $validationOk=true;

                    $expenseAmount = number_format($_POST['amount'], 2, '.', '');
                    $amountArray = explode('.', $expenseAmount);

                    if(!is_numeric($expenseAmount) || strlen($expenseAmount) <0 ||strlen($expenseAmount) >10 || strlen($amountArray[1])>2 || strlen($amountArray[0])>8){
                        $_SESSION['error_expenseAmount'] = "Enter valid positive amount - maximum 8 integer digits and 2 decimal places.";
                        $validationOk=false;

                    }

                    $expenseComment = $_POST['comment'];

                    if(strlen($expenseComment)>100)
                    {
                        $_SESSION['error_comment'] = "Comment can contain up to 100 characters";
                        $validationOk=false;
                    }

                    $expenseDate=$_POST['date'];
                    $expenseCategory= $_POST['category'];
                    $expensePaymentMethod = $_POST['payment'];


                    foreach($expenseCategoriesOfLoggedUser as $category)
                    {
                        if($category['name']==$expenseCategory)
                        {
                            $expenseCatId = $category['id'];
                        }
                        
                    }
            
                   // echo $expenseCatId;
                    
                    
                    foreach($paymentMethodOfLoggedUser as $method)
                    {
                        if($method['name']==$expensePaymentMethod)
                        {
                    
                            $methodId = $method['id'];
                        }
                        
                    }
                   // echo $methodId;
                    


                    $_SESSION['fr_expenseAmount']=$expenseAmount;
                    $_SESSION['fr_expenseDate'] = $expenseDate;
                    $_SESSION['fr_paymentMethod'] = $expensePaymentMethod;
                    $_SESSION['fr_expenseCategory'] = $expenseCategory;
                    $_SESSION['fr_expenseComment'] = $expenseComment;

                    if($validationOk==true){
                        $sql = "INSERT INTO expenses VALUES(NULL, :userId, :cat, :pay, :amount, :dat, :comment)";

                        $addExpense = $db->prepare($sql);
                        $addExpense->execute([':userId' => $loggedUserId, 
                        ':cat' => $expenseCatId,
                        ':pay' => $methodId,
                        ':amount' => $expenseAmount,
                        ':dat' => $expenseDate,
                        ':comment' => $expenseComment]);


                        $_SESSION['expenseAdded'] = true;
                        $_SESSION['expenseAdded'] = "Expense has been added";

                    }

                    
                    
                }
                else{
                    $_SESSION['expenseAdded'] = false;
                    $_SESSION['error_expenseAdded'] = "Fill in the necessary fields";
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



    <link rel="stylesheet" href="expense.css">

    <title>Expense</title>
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
                    <div class="expense">
                        <div class="title"><span>Add Expense</span></div>
                        <form method="post">
                        
                        <?php
                                    if(isset($_SESSION['error_expenseAdded']))
                                    {
                                        echo '<div class="error">'.$_SESSION['error_expenseAdded'].'</div>';
                                        unset($_SESSION['error_expenseAdded']);
                                    }else if(isset($_SESSION['expenseAdded']))
                                    {
                                        echo '<div class="complete">'.$_SESSION['expenseAdded'].'</div>';
                                        unset($_SESSION['expenseAdded']);
                                    }
                        ?>



                            <div class="row mb-3">
                                <div class="input-group">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input id="amount" class="form-control" type="number" step="0.01" min="0"
                                        aria-label="default input example" name="amount"
                                        value="<?php
                                        
                                        if(isset($_SESSION['fr_expenseAmount'])){
                                            echo $_SESSION['fr_expenseAmount'];
                                            unset($_SESSION['fr_expenseAmount']);
                                        }
                                        
                                        ?>">
                                </div>

                                <?php
                                if(isset($_SESSION['error_expenseAmount'])){
                                        echo '<div class="error">'.$_SESSION['error_expenseAmount'].'</div>';
                                        unset($_SESSION['error_expenseAmount']);
                                    }
                                ?>



                            </div>

                            <div class="row mb-3">
                                <div class="input-group">
                                    <label for="date" class="form-label">Date</label>
                                    <input id="date" class="form-control" type="date" aria-label="default input example" name="date"
                                        required value="<?php
                                        
                                        if(isset($_SESSION['fr_expenseDate'])){
                                            echo $_SESSION['fr_expenseDate'];
                                            unset($_SESSION['fr_expenseDate']);
                                        }
                                        
                                    ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group">
                                    
                                    <label for="exampleDataList2" class="form-label text-center">Payment Methods</label>
                                    <select class="form-control userInput labeledInput" name="payment" id="exampleDataList2" >
                                    <?php

                                                
                                            foreach($paymentMethodOfLoggedUser as $method)
                                            {
                                                                                       
                                                    echo '<option selected>'.$method['name']."</option>";
                                        
                                            }
                                            
                                    
                                    ?>
                                    </select>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group">

                                    <label for="exampleDataList" class="form-label">Category</label>
                                    <select class="form-control userInput labeledInput" name="category" id="exampleDataList">
                                    <?php

                                                
                                            foreach($expenseCategoriesOfLoggedUser as $category)
                                            {                              
                                                    echo '<option selected>'.$category['name']."</option>";
                                            }
                                            
                                    
                                    ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="input-group">
                                    <label for="area" class="form-label">Comments</label>
                                    <input id="area" class="form-control" type="text" name="comment"
                                        aria-label="default input example"
                                        value="<?php
                                        
                                        if(isset( $_SESSION['fr_expenseComment'])){
                                            echo  $_SESSION['fr_expenseComment'];
                                            unset( $_SESSION['fr_expenseComment']);
                                        }
                                        
                                        ?>">
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