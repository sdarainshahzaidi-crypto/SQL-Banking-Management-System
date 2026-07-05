
<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

$conn = mysqli_connect("localhost","root","","BankDB");

if(!$conn)
{
    die("Connection Failed");
}
// Add Customer

if(isset($_POST['add_customer']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    mysqli_query($conn,
    "INSERT INTO Customer(name,phone,address)
     VALUES('$name','$phone','$address')");

    header("Location: index.php");
    exit();
}
// Delete Customer

if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM Customer
     WHERE customer_id=$id");

    header("Location: index.php");
    exit();
}

// Statistics
$customerCount = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM Customer")
)['total'];

$accountCount = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM Account")
)['total'];

$loanCount = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM Loan")
)['total'];

$totalBalance = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT SUM(balance) AS total FROM Account")
)['total'];

// Customer Data
$result = mysqli_query($conn,"SELECT * FROM Customer");

?>

<!DOCTYPE html>
<html>
<head>

<title>Bank Management Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f5;
}

.card{
    box-shadow:0px 2px 10px rgba(0,0,0,0.2);
}

h1{
    font-weight:bold;
}

</style>

</head>

<body>

<div class="d-flex">

<!-- SIDEBAR -->
<div class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">

<h4>🏦 Banking Management System</h4>

<hr>

<a href="index.php" class="text-white d-block mb-2">Dashboard</a>
<a href="customers.php" class="text-white d-block mb-2">Customers</a>
<a href="accounts.php" class="text-white d-block mb-2">Accounts</a>
<a href="loans.php" class="text-white d-block mb-2">Loans</a>
<a href="employees.php" class="text-white d-block mb-2">Employees</a>
<a href="branches.php" class="text-white d-block mb-2">Branches</a>
<a href="cards.php" class="text-white d-block mb-2">Cards</a>
<a href="transactions.php" class="text-white d-block mb-2">Transactions</a>

</div>

<!-- MAIN CONTENT -->
<div class="container p-4">
    

<div class="row mb-4">

<div class="col-md-3">
<div class="card text-bg-primary">
<div class="card-body text-center">
<h2><?php echo $customerCount; ?></h2>
<p>Total Customers</p>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-bg-success">
<div class="card-body text-center">
<h2><?php echo $accountCount; ?></h2>
<p>Total Accounts</p>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-bg-warning">
<div class="card-body text-center">
<h2><?php echo $loanCount; ?></h2>
<p>Total Loans</p>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-bg-danger">
<div class="card-body text-center">
<h2>Rs. <?php echo $totalBalance; ?></h2>
<p>Total Balance</p>
</div>
</div>
</div>

</div>
<div class="card mb-4">

<div class="card-header bg-success text-white">
Add New Customer
</div>

<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-4">
<input type="text"
name="name"
class="form-control"
placeholder="Customer Name"
required>
</div>

<div class="col-md-4">
<input type="text"
name="phone"
class="form-control"
placeholder="Phone Number"
required>
</div>

<div class="col-md-4">
<input type="text"
name="address"
class="form-control"
placeholder="Address"
required>
</div>

</div>

<br>

<button
type="submit"
name="add_customer"
class="btn btn-success">
Add Customer
</button>

</form>

</div>
</div>

<!-- Customer Table Starts Here -->

<div class="card">

<div class="card-header bg-dark text-white">
Customer Records
</div>

<div class="card">

<div class="card-header bg-dark text-white">
Customer Records
</div>

<div class="card-body">

<table class="table table-bordered table-striped table-hover">

<tr class="table-primary">
<th>ID</th>
<th>Name</th>
<th>Phone</th>
<th>Address</th>
<th>Actions</th>
</tr>

<?php

while($row = mysqli_fetch_assoc($result))
{
?>

<tr>
<td><?php echo $row['customer_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td><?php echo $row['address']; ?></td>

<td>

<a href="?delete=<?php echo $row['customer_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this customer?')">

Delete

</a>

</td>

</tr>

<?php
}
?>

</table>

</div>
</div>

</div>

</body>
</html>
```
