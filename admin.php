<?php session_start(); ?> 
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - ECVCI Taxes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Include Your Custom CSS -->
    <!-- <link rel="stylesheet" href="resources/css/styles1.css"> -->
</head>
<body>
    <div class="col-lg-6">
    <?php if(isset($_SESSION["success_message"])): ?>
    <div class="alert alert-success">
    <?php echo $_SESSION["success_message"]; ?>
    <?php unset($_SESSION["success_message"]); ?>
    <?php endif; ?>
    </div>     
        <h2>Admin Login</h2>
        <form action="insert_client.php" method="post">
            <div class="form-group">
                <label for="adminUsername">Username:</label>
                <input type="text" name="username" id="adminUsername" required>
            </div>
            <div class="form-group">
                <label for="adminPassword">Password:</label>
                <input type="password" name="password" id="adminPassword" required>
            </div>
            <button type="submit" class="btn btn-primary" name="adminLogin">Login</button>
        </form>
        <hr>
        <h2>Add New Client</h2>
        <form action="insert_client.php" method="post">
            <div class="form-group">
                <label for="clientUsername">Client Username:</label>
                <input type="text" name="clientUsername" id="clientUsername" required>
            </div>
            <div class="form-group">
                <label for="clientPassword">Client Password:</label>
                <input type="password" name="clientPassword" id="clientPassword" required>
            </div>
            <button type="submit" class="btn btn-primary" name="addClient">Add Client</button>
        </form>
    </div>
    
</body>
</html>
