<?php
include 'db.php';

/* =======================
   ADD CARD
======================= */
if(isset($_POST['add_card']))
{
    $account_id = $_POST['account_id'];
    $type = $_POST['card_type'];
    $expiry = $_POST['expiry_date'];

    mysqli_query($conn,
    "INSERT INTO Card(account_id, card_type, expiry_date)
     VALUES('$account_id','$type','$expiry')");

    header("Location: cards.php");
    exit();
}

/* =======================
   DELETE CARD
======================= */
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM Card WHERE card_id=$id");

    header("Location: cards.php");
    exit();
}

/* =======================
   EDIT LOAD DATA
======================= */
$editMode = false;
$e_id = "";
$e_account = "";
$e_type = "";
$e_expiry = "";

if(isset($_GET['edit']))
{
    $editMode = true;
    $id = $_GET['edit'];

    $data = mysqli_fetch_assoc(
        mysqli_query($conn,"SELECT * FROM Card WHERE card_id=$id")
    );

    $e_id = $data['card_id'];
    $e_account = $data['account_id'];
    $e_type = $data['card_type'];
    $e_expiry = $data['expiry_date'];
}

/* =======================
   UPDATE CARD
======================= */
if(isset($_POST['update_card']))
{
    $id = $_POST['card_id'];
    $account_id = $_POST['account_id'];
    $type = $_POST['card_type'];
    $expiry = $_POST['expiry_date'];

    mysqli_query($conn,
    "UPDATE Card SET
    account_id='$account_id',
    card_type='$type',
    expiry_date='$expiry'
    WHERE card_id=$id");

    header("Location: cards.php");
    exit();
}

/* =======================
   DATA FETCH
======================= */
$result = mysqli_query($conn,"SELECT * FROM Card");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<a href="index.php" class="btn btn-secondary mb-3">← Dashboard</a>

<h2>Cards Management</h2>

<!-- FORM -->
<div class="card mb-3">

<div class="card-header bg-danger text-white">
<?= $editMode ? "Edit Card" : "Add Card" ?>
</div>

<div class="card-body">

<form method="POST">

<input type="hidden" name="card_id" value="<?= $e_id ?>">

<div class="row">

<div class="col-md-4">
<input type="text" name="account_id" class="form-control"
placeholder="Account ID" value="<?= $e_account ?>" required>
</div>

<div class="col-md-4">
<input type="text" name="card_type" class="form-control"
placeholder="Card Type (Debit/Credit)" value="<?= $e_type ?>" required>
</div>

<div class="col-md-4">
<input type="date" name="expiry_date" class="form-control"
value="<?= $e_expiry ?>" required>
</div>

</div>

<br>

<?php if($editMode){ ?>

<button name="update_card" class="btn btn-warning">
Update Card
</button>

<a href="cards.php" class="btn btn-secondary">Cancel</a>

<?php } else { ?>

<button name="add_card" class="btn btn-success">
Add Card
</button>

<?php } ?>

</form>

</div>
</div>

<!-- TABLE -->
<div class="card">

<div class="card-header bg-dark text-white">
All Cards
</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>Account ID</th>
<th>Type</th>
<th>Expiry Date</th>
<th>Actions</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?= $row['card_id'] ?></td>
<td><?= $row['account_id'] ?></td>
<td><?= $row['card_type'] ?></td>
<td><?= $row['expiry_date'] ?></td>

<td>

<a href="?edit=<?= $row['card_id'] ?>"
class="btn btn-warning btn-sm">Edit</a>

<a href="?delete=<?= $row['card_id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete card?')">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>
</div>

</div>