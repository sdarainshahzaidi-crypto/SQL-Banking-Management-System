<?php
include 'db.php';

// ADD
if(isset($_POST['add_customer']))
{
    mysqli_query($conn,"INSERT INTO Customer(name,phone,address)
    VALUES('{$_POST['name']}','{$_POST['phone']}','{$_POST['address']}')");

    header("Location: customers.php");
}

// DELETE
if(isset($_GET['delete']))
{
    mysqli_query($conn,"DELETE FROM Customer WHERE customer_id={$_GET['delete']}");
    header("Location: customers.php");
}

$result = mysqli_query($conn,"SELECT * FROM Customer");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<a href="index.php" class="btn btn-secondary">Back</a>

<h2>Customers</h2>

<!-- ADD FORM -->
<form method="POST" class="row g-2">
<input name="name" class="form-control col" placeholder="Name">
<input name="phone" class="form-control col" placeholder="Phone">
<input name="address" class="form-control col" placeholder="Address">
<button class="btn btn-success col" name="add_customer">Add</button>
</form>

<br>

<table class="table table-bordered">

<tr>
<th>ID</th><th>Name</th><th>Phone</th><th>Address</th><th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?= $row['customer_id'] ?></td>
<td><?= $row['name'] ?></td>
<td><?= $row['phone'] ?></td>
<td><?= $row['address'] ?></td>
<td>
<a href="?delete=<?= $row['customer_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
</td>
</tr>

<?php } ?>

</table>

</div>