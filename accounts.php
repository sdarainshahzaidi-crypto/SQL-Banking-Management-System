<?php
include 'db.php';

/* =======================
   ADD ACCOUNT
======================= */
if(isset($_POST['add_account']))
{
    $customer_id = $_POST['customer_id'];
    $branch_id = $_POST['branch_id'];
    $type = $_POST['account_type'];
    $balance = $_POST['balance'];

    mysqli_query($conn,
    "INSERT INTO Account(customer_id, branch_id, account_type, balance)
     VALUES('$customer_id','$branch_id','$type','$balance')");

    header("Location: accounts.php");
    exit();
}

/* =======================
   DELETE ACCOUNT
======================= */
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM Account WHERE account_id=$id");

    header("Location: accounts.php");
    exit();
}

/* =======================
   EDIT LOAD DATA
======================= */
$editMode = false;
$e_id = "";
$e_customer = "";
$e_branch = "";
$e_type = "";
$e_balance = "";

if(isset($_GET['edit']))
{
    $editMode = true;
    $id = $_GET['edit'];

    $data = mysqli_fetch_assoc(
        mysqli_query($conn,"SELECT * FROM Account WHERE account_id=$id")
    );

    $e_id = $data['account_id'];
    $e_customer = $data['customer_id'];
    $e_branch = $data['branch_id'];
    $e_type = $data['account_type'];
    $e_balance = $data['balance'];
}

/* =======================
   UPDATE ACCOUNT
======================= */
if(isset($_POST['update_account']))
{
    $id = $_POST['account_id'];
    $customer_id = $_POST['customer_id'];
    $branch_id = $_POST['branch_id'];
    $type = $_POST['account_type'];
    $balance = $_POST['balance'];

    mysqli_query($conn,
    "UPDATE Account SET
    customer_id='$customer_id',
    branch_id='$branch_id',
    account_type='$type',
    balance='$balance'
    WHERE account_id=$id");

    header("Location: accounts.php");
    exit();
}

/* =======================
   DATA FETCH
======================= */
$result = mysqli_query($conn,"SELECT * FROM Account");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<a href="index.php" class="btn btn-secondary mb-3">← Dashboard</a>

<h2>Accounts Management</h2>

<!-- ADD / EDIT FORM -->
<div class="card mb-3">
<div class="card-header bg-primary text-white">
<?= $editMode ? "Edit Account" : "Add Account" ?>
</div>

<div class="card-body">

<form method="POST">

<input type="hidden" name="account_id" value="<?= $e_id ?>">

<div class="row">

<div class="col-md-3">
<input type="text" name="customer_id" class="form-control"
placeholder="Customer ID" value="<?= $e_customer ?>" required>
</div>

<div class="col-md-3">
<input type="text" name="branch_id" class="form-control"
placeholder="Branch ID" value="<?= $e_branch ?>" required>
</div>

<div class="col-md-3">
<input type="text" name="account_type" class="form-control"
placeholder="Type (Savings/Current)" value="<?= $e_type ?>" required>
</div>

<div class="col-md-3">
<input type="number" name="balance" class="form-control"
placeholder="Balance" value="<?= $e_balance ?>" required>
</div>

</div>

<br>

<?php if($editMode){ ?>

<button name="update_account" class="btn btn-warning">
Update Account
</button>

<a href="accounts.php" class="btn btn-secondary">Cancel</a>

<?php } else { ?>

<button name="add_account" class="btn btn-success">
Add Account
</button>

<?php } ?>

</form>

</div>
</div>

<!-- TABLE -->
<div class="card">

<div class="card-header bg-dark text-white">
All Accounts
</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>Customer ID</th>
<th>Branch ID</th>
<th>Type</th>
<th>Balance</th>
<th>Actions</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?= $row['account_id'] ?></td>
<td><?= $row['customer_id'] ?></td>
<td><?= $row['branch_id'] ?></td>
<td><?= $row['account_type'] ?></td>
<td><?= $row['balance'] ?></td>

<td>

<a href="?edit=<?= $row['account_id'] ?>"
class="btn btn-warning btn-sm">Edit</a>

<a href="?delete=<?= $row['account_id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete account?')">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>
</div>

</div>