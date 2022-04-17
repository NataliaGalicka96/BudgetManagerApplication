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
                            <a class="nav-link px-1" aria-current="page" href="#"><i
                                    class="fa-solid fa-house me-2"></i>Home</a>
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
                            <a class="nav-link" href="#"><i class="fas fa-sign-out-alt me-2"></i>Sign Out</a>
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
                        <form>
                            <div class="row mb-3">
                                <div class="input-group">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input id="amount" class="form-control" type="number" step="0.01" min="0"
                                        aria-label="default input example" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group">
                                    <label for="date" class="form-label">Date</label>
                                    <input id="date" class="form-control" type="date" aria-label="default input example"
                                        required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group">
                                    <label for="exampleDataList" class="form-label">Category</label>
                                    <input class="form-control" list="datalistOptions" id="exampleDataList"
                                        aria-label="default input example" required>
                                    <datalist id="datalistOptions">
                                        <option value="Salary" selected>
                                        <option value="Interest">
                                        <option value="Sale">
                                        <option value="Another">
                                    </datalist>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group">
                                    <label for="area" class="form-label">Comments</label>
                                    <input id="area" class="form-control" type="text"
                                        aria-label="default input example">
                                </div>
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