<?php
include 'db.php';

/* =======================
   ADD BRANCH
======================= */
if(isset($_POST['add_branch']))
{
    $name = $_POST['branch_name'];
    $city = $_POST['branch_city'];

    mysqli_query($conn,
    "INSERT INTO Branch(branch_name, branch_city)
     VALUES('$name','$city')");

    header("Location: branches.php");
    exit();
}

/* =======================
   DELETE BRANCH
======================= */
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM Branch WHERE branch_id=$id");

    header("Location: branches.php");
    exit();
}

/* =======================
   EDIT LOAD DATA
======================= */
$editMode = false;
$e_id = "";
$e_name = "";
$e_city = "";

if(isset($_GET['edit']))
{
    $editMode = true;
    $id = $_GET['edit'];

    $data = mysqli_fetch_assoc(
        mysqli_query($conn,"SELECT * FROM Branch WHERE branch_id=$id")
    );

    $e_id = $data['branch_id'];
    $e_name = $data['branch_name'];
    $e_city = $data['branch_city'];
}

/* =======================
   UPDATE BRANCH
======================= */
if(isset($_POST['update_branch']))
{
    $id = $_POST['branch_id'];
    $name = $_POST['branch_name'];
    $city = $_POST['branch_city'];

    mysqli_query($conn,
    "UPDATE Branch SET
    branch_name='$name',
    branch_city='$city'
    WHERE branch_id=$id");

    header("Location: branches.php");
    exit();
}

/* =======================
   DATA FETCH
======================= */
$result = mysqli_query($conn,"SELECT * FROM Branch");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<a href="index.php" class="btn btn-secondary mb-3">← Dashboard</a>

<h2>Branches Management</h2>

<!-- FORM -->
<div class="card mb-3">

<div class="card-header bg-secondary text-white">
<?= $editMode ? "Edit Branch" : "Add Branch" ?>
</div>

<div class="card-body">

<form method="POST">

<input type="hidden" name="branch_id" value="<?= $e_id ?>">

<div class="row">

<div class="col-md-6">
<input type="text" name="branch_name" class="form-control"
placeholder="Branch Name" value="<?= $e_name ?>" required>
</div>

<div class="col-md-6">
<input type="text" name="branch_city" class="form-control"
placeholder="Branch City" value="<?= $e_city ?>" required>
</div>

</div>

<br>

<?php if($editMode){ ?>

<button name="update_branch" class="btn btn-warning">
Update Branch
</button>

<a href="branches.php" class="btn btn-secondary">Cancel</a>

<?php } else { ?>

<button name="add_branch" class="btn btn-success">
Add Branch
</button>

<?php } ?>

</form>

</div>
</div>

<!-- TABLE -->
<div class="card">

<div class="card-header bg-dark text-white">
All Branches
</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>Branch Name</th>
<th>City</th>
<th>Actions</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?= $row['branch_id'] ?></td>
<td><?= $row['branch_name'] ?></td>
<td><?= $row['branch_city'] ?></td>

<td>

<a href="?edit=<?= $row['branch_id'] ?>"
class="btn btn-warning btn-sm">Edit</a>

<a href="?delete=<?= $row['branch_id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete branch?')">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>
</div>

</div>