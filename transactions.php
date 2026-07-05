<?php
include 'db.php';

/* =======================
   ADD TRANSACTION (SIMPLE LOGIC)
======================= */
if(isset($_POST['add_transaction']))
{
    $account_id = $_POST['account_id'];
    $type = $_POST['transaction_type'];
    $amount = $_POST['amount'];

    // Get current balance
    $result = mysqli_query($conn, "SELECT balance FROM Account WHERE account_id=$account_id");
    $row = mysqli_fetch_assoc($result);

    if(!$row)
    {
        echo "<script>alert('Invalid Account ID'); window.location='transactions.php';</script>";
        exit();
    }

    $balance = $row['balance'];

    // Deposit
    if($type == "Deposit")
    {
        $balance = $balance + $amount;
    }

    // Withdraw
    else if($type == "Withdraw")
    {
        if($amount > $balance)
        {
            echo "<script>alert('Insufficient Balance'); window.location='transactions.php';</script>";
            exit();
        }

        $balance = $balance - $amount;
    }

    // Update Account Balance
    mysqli_query($conn,
    "UPDATE Account SET balance=$balance WHERE account_id=$account_id");

    // Insert Transaction Record
    mysqli_query($conn,
    "INSERT INTO Transactions(account_id, transaction_type, amount)
     VALUES('$account_id','$type','$amount')");

    header("Location: transactions.php");
    exit();
}

/* =======================
   DELETE TRANSACTION
======================= */
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM Transactions WHERE transaction_id=$id");

    header("Location: transactions.php");
    exit();
}

/* =======================
   LOAD DATA
======================= */
$result = mysqli_query($conn,"SELECT * FROM Transactions");
?>

<!DOCTYPE html>
<html>
<head>
<title>Transactions</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<a href="index.php" class="btn btn-secondary mb-3">← Dashboard</a>

<h2 class="text-center">💸 Transactions</h2>

<!-- FORM -->
<div class="card mb-3">

<div class="card-header bg-primary text-white">
Add Transaction
</div>

<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-4">
<input type="number" name="account_id" class="form-control"
placeholder="Account ID" required>
</div>

<div class="col-md-4">
<select name="transaction_type" class="form-control" required>
<option value="">Select Type</option>
<option value="Deposit">Deposit</option>
<option value="Withdraw">Withdraw</option>
</select>
</div>

<div class="col-md-4">
<input type="number" name="amount" class="form-control"
placeholder="Amount" required>
</div>

</div>

<br>

<button class="btn btn-success" name="add_transaction">
Submit
</button>

</form>

</div>
</div>

<!-- TABLE -->
<div class="card">

<div class="card-header bg-dark text-white">
Transaction History
</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Account ID</th>
<th>Type</th>
<th>Amount</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?= $row['transaction_id'] ?></td>
<td><?= $row['account_id'] ?></td>
<td><?= $row['transaction_type'] ?></td>
<td><?= $row['amount'] ?></td>

<td>
<a href="?delete=<?= $row['transaction_id'] ?>"
class="btn btn-danger btn-sm">Delete</a>
</td>

</tr>

<?php } ?>

</table>

</div>
</div>

</div>

</body>
</html>