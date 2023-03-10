<?php

// Start session 
if (!session_id()) {
    session_start();
}

// Retrieve session data 
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Get status message from session 
if (!empty($sessData['status']['msg'])) {
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Include database configuration file 
require_once 'dbConfig.php';

// Fetch the data from SQL server 
$sql = "SELECT * FROM Members ORDER BY ID DESC";
$query = $conn->prepare($sql);
$query->execute();
$members = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Display status message -->
<?php if (!empty($statusMsg) && ($statusMsgType == 'success')) { ?>
    <div class="col-xs-12">
        <div class="alert alert-success"><?php echo $statusMsg; ?></div>
    </div>
<?php } elseif (!empty($statusMsg) && ($statusMsgType == 'error')) { ?>
    <div class="col-xs-12">
        <div class="alert alert-danger"><?php echo $statusMsg; ?></div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12 head">
        <h5>Mahasiswa</h5>
        <!-- Add link -->
        <div class="float-right">
            <a href="addEdit.php" class="btn btn-success"><i class="plus"></i> Tambah</a>
        </div>
    </div>

    <!-- List the members -->
    <table class="table table-striped table-bordered ml-2">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>NIM</th>
                <th>Nama </th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Tanggal di buat</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($members)) {
                $count = 0;
                foreach ($members as $row) {
                    $count++; ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['NIM']; ?></td>
                        <td><?php echo $row['Nama']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['Alamat']; ?></td>
                        <td><?php echo $row['Created']; ?></td>
                        <td>
                            <a href="addEdit.php?id=<?php echo $row['ID']; ?>" class="btn btn-warning">edit</a>
                            <a href="userAction.php?action_type=delete&id=<?php echo $row['ID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">delete</a>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="7">Mahasiswa(s) found...</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">