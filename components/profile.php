
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Edit Profile</h1>
    <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="customer_name" class="form-control" value="<?php echo $row['customer_name']; ?>" required>
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="customer_name" class="form-control" value="<?php echo $row['customer_name']; ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
        </div>
    
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
