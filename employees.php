<?php
include 'db.php';

/* =======================
   ADD EMPLOYEE
======================= */
if(isset($_POST['add_employee']))
{
    $name = $_POST['name'];
    $position = $_POST['position'];
    $branch_id = $_POST['branch_id'];

    mysqli_query($conn,
    "INSERT INTO Employee(name, position, branch_id)
     VALUES('$name','$position','$branch_id')");

    header("Location: employees.php");
    exit();
}

/* =======================
   DELETE EMPLOYEE
======================= */
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM Employee WHERE employee_id=$id");

    header("Location: employees.php");
    exit();
}

/* =======================
   EDIT LOAD DATA
======================= */
$editMode = false;
$e_id = "";
$e_name = "";
$e_position = "";
$e_branch = "";

if(isset($_GET['edit']))
{
    $editMode = true;
    $id = $_GET['edit'];

    $data = mysqli_fetch_assoc(
        mysqli_query($conn,"SELECT * FROM Employee WHERE employee_id=$id")
    );

    $e_id = $data['employee_id'];
    $e_name = $data['name'];
    $e_position = $data['position'];
    $e_branch = $data['branch_id'];
}

/* =======================
   UPDATE EMPLOYEE
======================= */
if(isset($_POST['update_employee']))
{
    $id = $_POST['employee_id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $branch_id = $_POST['branch_id'];

    mysqli_query($conn,
    "UPDATE Employee SET
    name='$name',
    position='$position',
    branch_id='$branch_id'
    WHERE employee_id=$id");

    header("Location: employees.php");
    exit();
}

/* =======================
   DATA FETCH
======================= */
$result = mysqli_query($conn,"SELECT * FROM Employee");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<a href="index.php" class="btn btn-secondary mb-3">← Dashboard</a>

<h2>Employees Management</h2>

<!-- FORM -->
<div class="card mb-3">

<div class="card-header bg-info text-white">
<?= $editMode ? "Edit Employee" : "Add Employee" ?>
</div>

<div class="card-body">

<form method="POST">

<input type="hidden" name="employee_id" value="<?= $e_id ?>">

<div class="row">

<div class="col-md-4">
<input type="text" name="name" class="form-control"
placeholder="Employee Name" value="<?= $e_name ?>" required>
</div>

<div class="col-md-4">
<input type="text" name="position" class="form-control"
placeholder="Position (Manager/Cashier/Clerk)" value="<?= $e_position ?>" required>
</div>

<div class="col-md-4">
<input type="text" name="branch_id" class="form-control"
placeholder="Branch ID" value="<?= $e_branch ?>" required>
</div>

</div>

<br>

<?php if($editMode){ ?>

<button name="update_employee" class="btn btn-warning">
Update Employee
</button>

<a href="employees.php" class="btn btn-secondary">Cancel</a>

<?php } else { ?>

<button name="add_employee" class="btn btn-success">
Add Employee
</button>

<?php } ?>

</form>

</div>
</div>

<!-- TABLE -->
<div class="card">

<div class="card-header bg-dark text-white">
All Employees
</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>Name</th>
<th>Position</th>
<th>Branch ID</th>
<th>Actions</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?= $row['employee_id'] ?></td>
<td><?= $row['name'] ?></td>
<td><?= $row['position'] ?></td>
<td><?= $row['branch_id'] ?></td>

<td>

<a href="?edit=<?= $row['employee_id'] ?>"
class="btn btn-warning btn-sm">Edit</a>

<a href="?delete=<?= $row['employee_id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete employee?')">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>
</div>

</div>