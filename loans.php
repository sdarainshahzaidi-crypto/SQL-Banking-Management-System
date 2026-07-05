<?php
include 'db.php';

/* =======================
   ADD LOAN
======================= */
if(isset($_POST['add_loan']))
{
    $customer_id = $_POST['customer_id'];
    $amount = $_POST['loan_amount'];
    $type = $_POST['loan_type'];

    mysqli_query($conn,
    "INSERT INTO Loan(customer_id, loan_amount, loan_type)
     VALUES('$customer_id','$amount','$type')");

    header("Location: loans.php");
    exit();
}

/* =======================
   DELETE LOAN
======================= */
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM Loan WHERE loan_id=$id");

    header("Location: loans.php");
    exit();
}

/* =======================
   EDIT LOAD DATA
======================= */
$editMode = false;
$e_id = "";
$e_customer = "";
$e_amount = "";
$e_type = "";

if(isset($_GET['edit']))
{
    $editMode = true;
    $id = $_GET['edit'];

    $data = mysqli_fetch_assoc(
        mysqli_query($conn,"SELECT * FROM Loan WHERE loan_id=$id")
    );

    $e_id = $data['loan_id'];
    $e_customer = $data['customer_id'];
    $e_amount = $data['loan_amount'];
    $e_type = $data['loan_type'];
}

/* =======================
   UPDATE LOAN
======================= */
if(isset($_POST['update_loan']))
{
    $id = $_POST['loan_id'];
    $customer_id = $_POST['customer_id'];
    $amount = $_POST['loan_amount'];
    $type = $_POST['loan_type'];

    mysqli_query($conn,
    "UPDATE Loan SET
    customer_id='$customer_id',
    loan_amount='$amount',
    loan_type='$type'
    WHERE loan_id=$id");

    header("Location: loans.php");
    exit();
}

/* =======================
   DATA FETCH
======================= */
$result = mysqli_query($conn,"SELECT * FROM Loan");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<a href="index.php" class="btn btn-secondary mb-3">← Dashboard</a>

<h2>Loans Management</h2>

<!-- FORM -->
<div class="card mb-3">

<div class="card-header bg-warning text-dark">
<?= $editMode ? "Edit Loan" : "Add Loan" ?>
</div>

<div class="card-body">

<form method="POST">

<input type="hidden" name="loan_id" value="<?= $e_id ?>">

<div class="row">

<div class="col-md-4">
<input type="text" name="customer_id" class="form-control"
placeholder="Customer ID" value="<?= $e_customer ?>" required>
</div>

<div class="col-md-4">
<input type="number" name="loan_amount" class="form-control"
placeholder="Loan Amount" value="<?= $e_amount ?>" required>
</div>

<div class="col-md-4">
<input type="text" name="loan_type" class="form-control"
placeholder="Loan Type (Home/Car/Personal)" value="<?= $e_type ?>" required>
</div>

</div>

<br>

<?php if($editMode){ ?>

<button name="update_loan" class="btn btn-warning">
Update Loan
</button>

<a href="loans.php" class="btn btn-secondary">Cancel</a>

<?php } else { ?>

<button name="add_loan" class="btn btn-success">
Add Loan
</button>

<?php } ?>

</form>

</div>
</div>

<!-- TABLE -->
<div class="card">

<div class="card-header bg-dark text-white">
All Loans
</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>Customer ID</th>
<th>Amount</th>
<th>Type</th>
<th>Actions</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?= $row['loan_id'] ?></td>
<td><?= $row['customer_id'] ?></td>
<td><?= $row['loan_amount'] ?></td>
<td><?= $row['loan_type'] ?></td>

<td>

<a href="?edit=<?= $row['loan_id'] ?>"
class="btn btn-warning btn-sm">Edit</a>

<a href="?delete=<?= $row['loan_id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete loan?')">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>
</div>

</div>