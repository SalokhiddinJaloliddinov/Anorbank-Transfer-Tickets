<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'process.php'; ?>

    <?php
    
        if (isset($_SESSION['message'])):   ?>
        
        <div class="alert alert-<?=$_SESSION['msg_type']?>">
            
            <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>

        </div>
        <?php endif ?>
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="process.php" method="POST">
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" name="id" class="form-control" required>
                    <label for="cars">Перекинуть на:</label>
                    <select name="transfer_to" value="" selected>
                        <option value="R">UserRequest</option>
                        <option value="I">Incident</option>
                        <option value="D">DeliveryRequest</option>
                    </select>
                    <label for="cars">Перекинуть на:</label>
                    <button type="submit" class="btn btn-danger" name="save">Execute</button>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>