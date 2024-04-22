<?php require_once("auth.php"); ?>
<?php
	require_once('config.php');
?>

<?php

    if(isset($_POST['add_post'])) {
        $name = $_POST["name"];

        $query = "INSERT INTO todos (name, status, date) VALUES ('$name','pending',now()) ";
        $row = $db->prepare($query);
		$row->execute($data);

        header("Location: timeline.php");
    }
    
    if(isset($_GET['edit'])) {
        $id = $_GET['edit'];

        $query = "UPDATE todos SET status='selesai' WHERE id='$id' ";
        $row = $db->prepare($query);
		$row->execute($data);

        header("Location: timeline.php");

    }

    if(isset($_GET['hapus'])) {
        $id = $_GET['hapus'];

        $query = "DELETE from todos WHERE id='$id' ";
        $row = $db->prepare($query);
		$row->execute($data);

        header("Location: timeline.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todolist</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">TODOLIST</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <img class="img img-responsive rounded-circle mb-3" width="50" src="img/<?php echo $_SESSION['user']['photo'] ?>" />
                    
                    <h3><?php echo  $_SESSION["user"]["username"] ?></h3>
                    <p><?php echo $_SESSION["user"]["email"] ?></p>

                    <p><a href="logout.php">Logout</a></p>
                </div>
            </div>                    
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <h3>Form Tambah Tugas</h3>
                <form method="post">
                    <div class="form-group">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Input nama Tugas">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="add_post" class="btn btn-primary btn-block">Tambah Tugas</button>
                    </div>
                </form>
                <h3>List Pending Tugas</h3>
                <ul class="list-group">
                    <?php
                        $query = "SELECT * FROM todos WHERE status='pending'";
                        $row = $db->prepare($query);
                        $row->execute();
                        $hasil = $row->fetchAll();
                        $a =1;
                        foreach($hasil as $isi) {
                    ?>
                        <li class="list-group-item">
                            <?php echo $isi['name']; ?>
                            <div class="float-right">
                                <a href="timeline.php?edit=<?php echo $isi['id']; ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Tandai sudah selesai">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                </svg>
                                </a>
                                <a href="timeline.php?hapus=<?php echo $isi['id']; ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Tugas">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        <?php  $a++; 
                    } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
                    <div class="card shadow-lg border-0">
                            <div class="card-body">
                                <h3>List Tugas Selesai</h3>
                                <?php
                                    $query = "SELECT * FROM todos WHERE status='selesai'";
                                    $row = $db->prepare($query);
                                    $row->execute();
                                    $result = $row->fetchAll();
                                    $a =1;
                                    
                                    foreach($result as $res) {
                                ?>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <?php echo $res['name']; ?>
                                        <div class="float-right">
                                            <span class="badge badge-primary"><?php echo $res['status']; ?></span>
                                        </div>
                                    </li>
                                    <?php $a++;
                                          }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</div>

</body>
</html>