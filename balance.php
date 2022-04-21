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
            <div class="row ms-4">
                <select class="custom-select" id="period">
                    <option value="1" selected>Current Month</option>
                    <option value="2">Previous Month</option>
                    <option value="3">Period of time</option>
                    <option value="4">Custom</option>
                </select>
            </div>
            <div class="row text-center " id="content">
                <span id="Date">01 Feb 2022 - 24 Feb 2022</span>
            </div>
            <div class="row" id="Table">
                <div class="col-12 col-xl-4 text-center">
                    <table class="table table-bordered">
                        <thead>
                            <tr id="titleOfTable1">
                                <th colspan="2">Expenses</th>
                            </tr>
                            <tr>
                                <th> Category </th>
                                <th> Expense </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> Food</td>
                                <td> 1000.00</td>
                            </tr>
                            <tr>
                                <td> Flat</td>
                                <td> 2000.00</td>
                            </tr>
                            <tr>
                                <td> Transport </td>
                                <td> 200.00 </td>
                            </tr>
                            <tr>
                                <td> Telecommunication </td>
                                <td> 60.00 </td>
                            </tr>
                            <tr>
                                <td> Healthcare </td>
                                <td> 0.00 </td>
                            </tr>
                            <tr>
                                <td> Clothes </td>
                                <td> 150.00 </td>
                            </tr>
                            <tr>
                                <td> Hygiene </td>
                                <td> 100.00</td>
                            </tr>
                            <tr>
                                <td> Kids </td>
                                <td> 250.00</td>
                            </tr>
                            <tr>
                                <td> Entertainment</td>
                                <td> 200.00</td>
                            </tr>
                            <tr>
                                <td> Trip</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td> Training</td>
                                <td>300.00</td>
                            </tr>
                            <tr>
                                <td> Books </td>
                                <td> 0.00 </td>
                            </tr>
                            <tr>
                                <td> Savings</td>
                                <td> 0.00</td>
                            </tr>
                            <tr>
                                <td> Retirement</td>
                                <td> 0.00</td>
                            </tr>
                            <tr>
                                <td> Debt repayment</td>
                                <td> 0.00</td>
                            </tr>
                            <tr>
                                <td> Donation</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td> Other expenses</td>
                                <td> 150.00</td>
                            </tr>
                            <tr>
                                <th>Sum</th>
                                <td>4410.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-xl-8 text-center">
                    <div class="row gx-0">
                        <div class=" col-12 col-xl-6 text-center">
                            <table class="table table-bordered">
                                <thead>
                                    <tr id="titleOfTable2">
                                        <th colspan="2">Incomes</th>
                                    </tr>
                                    <tr>
                                        <th> Category</th>
                                        <th> Income </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> Salary</td>
                                        <td> 3000.50</td>
                                    </tr>
                                    <tr>
                                        <td> Interest</td>
                                        <td> 800.00</td>
                                    </tr>
                                    <tr>
                                        <td> Sale on Allegro</td>
                                        <td> 560.00</td>
                                    </tr>
                                    <tr>
                                        <td> Another</td>
                                        <td> 200.00</td>
                                    </tr>
                                    <tr>
                                        <th>Sum</th>
                                        <td>4560.50</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-xl-6 text-center">
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
                                        <td> 4560.50</td>
                                        <td> 4410.00</td>
                                        <td>150.50</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="alert alert-success" role="alert">
                                Congratulations! You manage your finances great!
                            </div>
                        </div>

                        <div class="col-12 col-xl-6 text-center">
                            <div class="chart mt-5">
                                <p class="fs-3">Pie chart of expenses</p>
                                <div id="my-pie-chart-container">
                                    <div id="my-pie-chart"></div>
                                    <div id="legenda">
                                        <div class="entry">
                                            <div id="color-brown" class="entry-color"></div>
                                            <div class="entry-text">Other expenses</div>
                                        </div>
                                        <div class="entry">
                                            <div id="color-black" class="entry-color"></div>
                                            <div class="entry-text">Food</div>
                                        </div>
                                        <div class="entry">
                                            <div id="color-blue" class="entry-color"></div>
                                            <div class="entry-text">Training</div>
                                        </div>
                                        <div class="entry">
                                            <div id="color-green" class="entry-color"></div>
                                            <div class="entry-text">Entertainment</div>
                                        </div>
                                        <div class="entry">
                                            <div id="color-yellow" class="entry-color"></div>
                                            <div class="entry-text">Kids</div>
                                        </div>
                                        <div class="entry">
                                            <div id="color-orange" class="entry-color"></div>
                                            <div class="entry-text">Transport</div>
                                        </div>
                                        <div class="entry">
                                            <div id="color-red" class="entry-color"></div>
                                            <div class="entry-text">Flat</div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
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