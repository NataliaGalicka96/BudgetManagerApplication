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

    <link rel="stylesheet" href="balance.css">

    <title>Balance</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body>

    <div class="main">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
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
        <div class="container">
            <form method="post">
                <div  class="row ms-4">
                <select class="custom-select" id="period" name = "selectPeriodTime" onchange="location = this.value;">>
                    <option value="balance.php" selected>Current Month</option>
                    <option value="balancePrevious.php">Previous Month</option>
                    <option value="balancePeriod.php">Period of time</option>
                </select> 
            </div>
            <div class="row text-center " id="content" name="periodTime">
                <?php
                    
                    //date 1

                    //date 2 


                ?>
            </div>
            <div class="row" id="Table">
                <div class="col-12 col-xl-4 text-center">

                    <?php

                    // require_once "database.php";

                        $loggedUserId = $_SESSION['logged_id'];

                        $sql = "SELECT eca.name ,SUM(e.amount) AS sum
                        FROM expenses e
                        INNER JOIN expenses_category_assigned_to_users eca
                        ON e.expense_category_assigned_to_user_id = eca.id
                        WHERE e.user_id =:userId AND
                        e.date_of_expense BETWEEN :startDate AND :endDate
                        GROUP BY eca.name
                        ORDER BY SUM(e.amount)";


                        $expenseCategoryQuery = $db -> prepare($sql);
                        $expenseCategoryQuery -> bindValue(':userId', $loggedUserId, PDO::PARAM_INT);
                        $expenseCategoryQuery -> bindValue(':startDate', $firstDayOfCurrentDate, PDO::PARAM_STR);
                        $expenseCategoryQuery -> bindValue(':endDate', $currentDate, PDO::PARAM_STR);
                        $expenseCategoryQuery -> execute();

                        $expenseCategoriesOfLoggedUser = $expenseCategoryQuery -> fetchAll();


                        //print_r($expenseCategoriesOfLoggedUser);

                        echo<<<END
                        <table class="table table-bordered">
                            <thead>
                                <tr id="titleOfTable1">
                                    <th colspan="2">Expenses</th>
                                </tr>
                                <tr>
                                    <th> Category </th>
                                    <th> Total  </th>
                                </tr>
                            </thead>
                            <tbody>
                        END;

                        $sumOfAllExpenses = 0;
                        foreach($expenseCategoriesOfLoggedUser as $category)
                        {
                            
                            echo '<tr>';
                            echo '<td>'.$category['name'].'</td>';
                            echo '<td>'. $category['sum'].'</td>';
                            echo '</tr>' ;

                            $sumOfAllExpenses+=$category['sum'];
                                
                        }

                        $sumOfAllExpenses = number_format( $sumOfAllExpenses, 2, '.', '' );
                        
                        echo<<<END
                        
                        <tr>
                                <th>Sum</th>
                                <td>$sumOfAllExpenses</td>
                                </tr>
                            </tbody>
                        </table>

                        END;

                        $rows_count = $expenseCategoryQuery->rowCount();

                        if($rows_count>0){

                    ?>

                    <script type="text/javascript">
                        google.charts.load("current", {packages:["corechart"]});
                        google.charts.setOnLoadCallback(drawChart);
                
                
                        function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Category', 'Amount'],
                        <?php
                            foreach($expenseCategoriesOfLoggedUser as $category){
                                
                                extract($category);

                                echo  "['$name', $sum],";
                            }

                        ?>
                        ]);

                        var options = {
                        is3D: true,
                        legend: {
                        textStyle: { color: 'white' }
                        },
                        backgroundColor: 'transparent',
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                        chart.draw(data, options);
                        }
                    </script>

                        <?php

                            echo '<p class="fs-3">Pie chart of expenses</p>';
                            
                            echo '<div  class="d-flex justify-content-center" id="piechart_3d"></div>';


                        }
                    ?>

                </div>
                <div class="col-12 col-xl-4 text-center">

                    <?php

                    //require_once "database.php";

                    $loggedUserId = $_SESSION['logged_id'];


                    $sql = "SELECT ica.name ,SUM(i.amount) AS sum
                    FROM incomes i
                    INNER JOIN incomes_category_assigned_to_users	 ica
                    ON i.income_category_assigned_to_user_id = ica.id
                    WHERE i.user_id =:userId AND
                    i.date_of_income BETWEEN :startDate AND :endDate
                    GROUP BY ica.name
                    ORDER BY SUM(i.amount)";


                    $incomeCategoryQuery = $db -> prepare($sql);
                    $incomeCategoryQuery -> bindValue(':userId', $loggedUserId, PDO::PARAM_INT);
                    $incomeCategoryQuery -> bindValue(':startDate', $firstDayOfCurrentDate, PDO::PARAM_STR);
                    $incomeCategoryQuery -> bindValue(':endDate', $currentDate, PDO::PARAM_STR);
                    $incomeCategoryQuery -> execute();

                    $incomeCategoriesOfLoggedUser = $incomeCategoryQuery -> fetchAll();

                    //print_r($incomeCategoriesOfLoggedUser);

                    echo<<<END
                    <table class="table table-bordered">
                        <thead>
                            <tr id="titleOfTable2">
                                <th colspan="2">Incomes</th>
                            </tr>
                            <tr>
                                <th> Category </th>
                                <th> Total  </th>
                            </tr>
                        </thead>
                        <tbody>
                    END;

                    $sumOfAllIncomes = 0;
                    foreach($incomeCategoriesOfLoggedUser as $category)
                    {
                        
                        echo '<tr>';
                        echo '<td>'.$category['name'].'</td>';
                        echo '<td>'. $category['sum'].'</td>';
                        echo '</tr>' ;

                        $sumOfAllIncomes+=$category['sum'];
                            
                    }

                    $sumOfAllIncomes = number_format( $sumOfAllIncomes, 2, '.', '' );
                    
                    echo<<<END

                    
                    <tr>
                            <th>Sum</th>
                            <td>$sumOfAllIncomes</td>
                            </tr>
                        </tbody>
                    </table>

                    END;

                    $rows_count = $incomeCategoryQuery->rowCount();

                    if($rows_count>0){

                        ?>
        
                        <script type="text/javascript">
                            google.charts.load("current", {packages:["corechart"]});
                            google.charts.setOnLoadCallback(drawChart);
                    
                    
                            function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Category', 'Amount'],
                            <?php
                                foreach($incomeCategoriesOfLoggedUser as $category){
                                    
                                    extract($category);
        
                                    echo  "['$name', $sum],";
                                }
        
                            ?>
                            ]);
        
                            var options = {
                            is3D: true,
                            legend: {
                            textStyle: { color: 'white' }
                            },
                            backgroundColor: 'transparent',
                            };
        
                            var chart = new google.visualization.PieChart(document.getElementById('piechart_incomes'));
                            chart.draw(data, options);
                            }
                        </script>
        
                    <?php

                        echo '<p class="fs-3">Pie chart of incomes</p>';
                        
                        echo '<div class="d-flex justify-content-center" id="piechart_incomes"></div>';


                     }
                    ?>
  
                </div>
                <div class="col-12 col-xl-4 text-center">
                            <?php
                            $balance = $sumOfAllIncomes-$sumOfAllExpenses;
                            $balance = number_format( $balance, 2, '.', '' );

                        echo<<<END

                        <table class="table table-bordered">
                        <thead>
                            <tr id="titleOfTable3">
                                <th colspan="3">Balance</th>
                            </tr>
                            <tr>
                                        <th> Incomes </th>
                                        <th> Expenses </th>
                                        <th> Balance </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>$sumOfAllIncomes</td>
                                            <td>$sumOfAllExpenses</td>
                                            <td>$balance</td>
                                        </tr>
                                    </tbody>
                                </table>
                        </thead>
                        <tbody>

                    END;
                    ?>

                            <?php
                            if($balance>0){
                                echo<<<END

                                <div class="alert alert-success" role="alert">

                                Congratulations! You manage your finances great!
                            </div>
                            END;

                            }else{
                                echo<<<END

                                <div class="alert alert-danger" role="alert">

                                Ups! You are getting into Debt! Try to plan your expenses better!
                            </div>
                            END;

                            }
                            ?>

                        </div>

                        

                        </div>

                    </div>
                </div>
            </div>
                        </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>