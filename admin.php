<?php
// admin.php
require_once __DIR__ . '/connection.php';
session_start();
if($_SESSION["user_role"] != "admin"){
    header('location:login.php');
}
// Helper function
function e($v) { return htmlspecialchars(isset($v) ? $v : '', ENT_QUOTES, 'UTF-8'); }

// ---------- Handle POST actions ----------
// Add User
if (isset($_POST['add_user'])) {
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $income = intval(isset($_POST['income']) ? $_POST['income'] : 0);
    $user_role = isset($_POST['user_role']) ? $_POST['user_role'] : 'user';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $passHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (fname,lname,email,income,user_image,user_role,password) VALUES ('$fname', '$lname', '$email', $income, '', '$user_role', '$passHash')";
    $result = mysqli_query($GLOBALS['connection'], $sql);
    if($result){
        header('location:admin.php');
    }
    else {
        echo '<script>alert("Error Creating User")</script>';
    }
    exit;
}

// Edit User
if (isset($_POST['edit_user'])) {
    $user_id = (int)$_POST['user_id'];
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $income = isset($_POST['income']) ? $_POST['income'] : 0;
    $user_role = isset($_POST['user_role']) ? $_POST['user_role'] : 'user';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($password !== '') {
        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET fname='$fname',lname='$lname',email='$email',income=$income,user_role='$user_role',password='$password' WHERE user_id=$user_id";
        mysqli_query($GLOBALS['connection'], $sql);

    } else {
        $sql = "UPDATE users SET fname='$fname',lname='$lname',email='$email',income=$income,user_role='$user_role' WHERE user_id=$user_id";
        mysqli_query($GLOBALS['connection'],$sql);
    }
    header("Location: admin.php?user_id=$user_id");
    exit;
}

// Delete User
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['action']) && $_GET['action'] === 'delete_user' && !empty($_GET['user_id'])) {
    $user_id = (int)$_GET['user_id'];
    if ($user_id>0) {
        mysqli_query($GLOBALS['connection'],"DELETE FROM users WHERE user_id=".$user_id);
    }
    header("Location: admin.php");
    exit;
}

// Add Transaction
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action']) && $_POST['action']==='add_tx') {
    $user_id = (int)(isset($_POST['user_id']) ? $_POST['user_id'] : 0);
    $amount = floatval(isset($_POST['amount']) ? $_POST['amount'] : 0);
    $category = trim(isset($_POST['category']) ? $_POST['category'] : '');
    $date = trim(isset($_POST['date']) ? $_POST['date'] : '');
    if ($user_id>0 && $category!=='') {
        $stmt = mysqli_prepare($GLOBALS['connection'],"INSERT INTO transactions(user_id,amount,category,`date`) VALUES(?,?,?,?)");
        mysqli_stmt_bind_param($stmt,"idss",$user_id,$amount,$category,$date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: admin.php?user_id=$user_id");
    exit;
}

// Edit Transaction
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action']) && $_POST['action']==='edit_tx') {
    $t_id = (int)(isset($_POST['t_id']) ? $_POST['t_id'] : 0);
    $user_id = (int)(isset($_POST['user_id']) ? $_POST['user_id'] : 0);
    $amount = floatval(isset($_POST['amount']) ? $_POST['amount'] : 0);
    $category = trim(isset($_POST['category']) ? $_POST['category'] : '');
    $date = trim(isset($_POST['date']) ? $_POST['date'] : '');
    if ($t_id>0) {
        $stmt = mysqli_prepare($GLOBALS['connection'],"UPDATE transactions SET amount=?, category=?, `date`=? WHERE t_id=?");
        mysqli_stmt_bind_param($stmt,"dssi",$amount,$category,$date,$t_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: admin.php?user_id=$user_id");
    exit;
}

// Delete Transaction
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['action']) && $_GET['action']==='delete_tx' && !empty($_GET['t_id'])) {
    $t_id = (int)$_GET['t_id'];
    $uid = (int)(isset($_GET['user_id']) ? $_GET['user_id'] : 0);
    if ($t_id>0) { mysqli_query($GLOBALS['connection'],"DELETE FROM transactions WHERE t_id=$t_id"); }
    header("Location: admin.php?user_id=$uid");
    exit;
}

// ---------- Fetch Data ----------
$users=[];
$sql="SELECT user_id,fname,lname,email,income,user_image,user_role FROM users ORDER BY user_id ASC";
if($res=mysqli_query($GLOBALS['connection'],$sql)){
    while($r=mysqli_fetch_assoc($res)) $users[]=$r;
}

$selectedUser=null; $transactions=[]; $totalAmount=0.0;
if(!empty($_GET['user_id'])){
    $uid=(int)$_GET['user_id'];
    $ru=mysqli_query($GLOBALS['connection'],"SELECT user_id,fname,lname,email,income,user_image,user_role FROM users WHERE user_id=$uid LIMIT 1");
    $selectedUser=mysqli_fetch_assoc($ru);

    $rt=mysqli_query($GLOBALS['connection'],"SELECT t_id,amount,category,`date` FROM transactions WHERE user_id=$uid ORDER BY `date` DESC,t_id DESC");
    while($tr=mysqli_fetch_assoc($rt)){
        $transactions[]=$tr;
        $totalAmount += (int)$tr['amount'];
    }
}
?>
<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin — Expense Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .avatar {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 6px;
        }

        .main-container {
            max-width: 1100px;
            margin: 24px auto;
        }

        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Expense Tracker • Admin</a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-secondary btn-sm" href="index.php"><i class="bi bi-house me-1"></i>Home</a>
                <a class="btn btn-outline-danger btn-sm" href="admin.php?logout=true"><i
                        class="bi bi-box-arrow-right me-1"></i>Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="row g-4">
            <div class="col-12 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Users</span>
                        <div>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalAddUser"><i class="bi bi-person-plus me-1"></i>Add User</button>
                            <a class="btn btn-sm btn-outline-secondary" href="admin.php"><i
                                    class="bi bi-arrow-clockwise me-1"></i>Refresh</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="mb-2 p-2">
                        </div>
                        <div class="list-group list-group-flush" id="usersList">
                            <?php foreach($users as $u):
                                $fullname=trim($u['fname'].' '.$u['lname']);
                                $imgHtml='<div class="bg-secondary bg-opacity-10 rounded d-flex align-items-center justify-content-center" style="width:48px;height:48px;">N/A</div>';
                                if(!empty($u['user_image'])){
                                    $imgHtml = 'Image';
                                }
                                ?>
                            <div class="list-group-item d-flex gap-3 align-items-center userItem">
                                <div>
                                    <?php echo $imgHtml;?>
                                </div>
                                <div class="flex-fill">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fw-semibold">
                                                <?php echo e($fullname);?>
                                            </div>
                                            <div class="small text-muted truncate">
                                                <?php echo e($u['email']);?>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="small text-muted">
                                                <?php echo e($u['user_role']);?>
                                            </div>
                                            <div class="fw-semibold">TK
                                                <?php echo number_format((float)$u['income'],2);?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 d-flex gap-2">
                                        <a class="btn btn-sm btn-outline-primary"
                                            href="admin.php?user_id=<?php echo (int)$u['user_id'];?>"><i
                                                class="bi bi-eye me-1"></i>View</a>
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                            data-bs-target="#modalEditUser<?php echo (int)$u['user_id'];?>"><i
                                                class="bi bi-pencil me-1"></i>Edit</button>
                                        <a class="btn btn-sm btn-outline-danger"
                                            href="admin.php?action=delete_user&user_id=<?php echo (int)$u['user_id'];?>"><i
                                                class="bi bi-trash me-1"></i>Delete</a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions / Details -->
            <div class="col-12 col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-semibold">User Transactions</span>

                            <?php if($selectedUser):?>
                            <div class="small text-muted">Showing:
                                <?php echo e($selectedUser['fname'].' '.$selectedUser['lname']);?> (ID:
                                <?php echo (int)$selectedUser['user_id'];?>)
                            </div>
                            <?php endif;?>

                        </div>
                        <?php if($selectedUser):?>
                        <div class="text-end">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalAddTx"><i class="bi bi-plus-lg me-1"></i>Add Tx</button>
                            <a class="btn btn-sm btn-outline-secondary ms-2" href="admin.php"><i
                                    class="bi bi-arrow-left-circle me-1"></i>Back</a>
                            <div class="fw-semibold">Balance: TK <span id="userBalance">
                                    <?php echo number_format((float)$selectedUser['income']-$totalAmount,2);?>
                                </span></div>
                        </div>
                        <?php endif;?>
                    </div>
                    <div class="card-body">
                        <?php if(!$selectedUser):?>
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-info-circle fs-3"></i>
                            <div class="mt-2">No user selected</div>
                        </div>
                        <?php else:?>
                        <?php if(empty($transactions)):?>
                        <div class="alert alert-warning mb-0">This user has no transactions recorded.</div>
                        <?php else:?>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle" id="txTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th class="text-end">Amount (TK)</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach($transactions as $tr): $i++; ?>
                                    <tr data-amount="<?php echo (float)$tr['amount'];?>">
                                        <td>
                                            <?php echo $i;?>
                                        </td>
                                        <td>
                                            <?php echo e($tr['date']);?>
                                        </td>
                                        <td>
                                            <?php echo e($tr['category']);?>
                                        </td>
                                        <td class="text-end">
                                            <?php echo number_format((float)$tr['amount'],2);?>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                                data-bs-target="#modalEditTx<?php echo (int)$tr['t_id'];?>"><i
                                                    class="bi bi-pencil"></i></button>
                                            <a class="btn btn-sm btn-outline-danger"
                                                href="admin.php?action=delete_tx&t_id=<?php echo (int)$tr['t_id'];?>&user_id=<?php echo (int)$selectedUser['user_id'];?>"
                                                onclick="return confirm('Delete this transaction?');"><i
                                                    class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif;?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="modalAddUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="admin.php">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5><button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">First name</label><input name="fname"
                            class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Last name</label><input name="lname"
                            class="form-control"></div>
                    <div class="mb-2"><label class="form-label">Email</label><input name="email" type="email"
                            class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Income</label><input name="income" type="number"
                            step="0.01" class="form-control" value="0.00"></div>
                    <div class="mb-2"><label class="form-label">Role</label><select name="user_role"
                            class="form-select">
                            <option>admin</option>
                            <option selected>user</option>
                        </select></div>
                    <div class="mb-2"><label class="form-label">Password</label><input name="password" type="password"
                            class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" name="add_user" class="btn btn-primary" value="Create User"></div>
            </form>
        </div>
    </div>

    <?php foreach($users as $u): ?>
    <!-- Edit User Modal -->
    <div class="modal fade" id="modalEditUser<?php echo (int)$u['user_id'];?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="admin.php">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User #
                        <?php echo (int)$u['user_id'];?>
                    </h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="<?php echo (int)$u['user_id']; ?>">
                    <div class="mb-2"><label class="form-label">First name</label><input name="fname"
                            class="form-control" value="<?php echo e($u['fname']);?>"></div>
                    <div class="mb-2"><label class="form-label">Last name</label><input name="lname"
                            class="form-control" value="<?php echo e($u['lname']);?>"></div>
                    <div class="mb-2"><label class="form-label">Email</label><input name="email" type="email"
                            class="form-control" value="<?php echo e($u['email']);?>"></div>
                    <div class="mb-2"><label class="form-label">Income</label><input name="income" type="number"
                            step="0.01" class="form-control" value="<?php echo e($u['income']);?>"></div>
                    <div class="mb-2"><label class="form-label">Role</label><select name="user_role"
                            class="form-select">
                            <option <?php if($u['user_role']=='admin' ) echo 'selected' ;?>>admin</option>
                            <option <?php if($u['user_role']=='user' ) echo 'selected' ;?>>user</option>
                        </select></div>
                    <div class="mb-2"><label class="form-label">Password (leave blank to keep)</label><input
                            name="password" type="password" class="form-control"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" name="edit_user" class="btn btn-primary" value="Save Changes">
                </div>
            </form>
        </div>
    </div>
    <?php endforeach;?>

    <?php if($selectedUser): ?>
    <!-- Add Transaction Modal -->
    <div class="modal fade" id="modalAddTx" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="admin.php">
                <input type="hidden" name="action" value="add_tx">
                <input type="hidden" name="user_id" value="<?php echo (int)$selectedUser['user_id'];?>">
                <div class="modal-header">
                    <h5 class="modal-title">Add Transaction</h5><button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">Amount</label><input name="amount" type="number"
                            step="0.01" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Category</label><input name="category"
                            class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Date</label><input name="date" type="date"
                            class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Add
                        Transaction</button></div>
            </form>
        </div>
    </div>

    <?php foreach($transactions as $tr): ?>
    <!-- Edit Transaction Modal -->
    <div class="modal fade" id="modalEditTx<?php echo (int)$tr['t_id'];?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="admin.php">
                <input type="hidden" name="action" value="edit_tx">
                <input type="hidden" name="t_id" value="<?php echo (int)$tr['t_id'];?>">
                <input type="hidden" name="user_id" value="<?php echo (int)$selectedUser['user_id'];?>">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Transaction #
                        <?php echo (int)$tr['t_id'];?>
                    </h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">Amount</label><input name="amount" type="number"
                            step="0.01" class="form-control" value="<?php echo e($tr['amount']);?>" required></div>
                    <div class="mb-2"><label class="form-label">Category</label><input name="category"
                            class="form-control" value="<?php echo e($tr['category']);?>" required></div>
                    <div class="mb-2"><label class="form-label">Date</label><input name="date" type="date"
                            class="form-control" value="<?php echo e($tr['date']);?>" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Save
                        Changes</button></div>
            </form>
        </div>
    </div>
    <?php endforeach;?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <?php
            if(isset($_GET['logout'])){
                session_destroy();
                echo "<script>window.location.href='index.php';</script>";
            }
        ?>
</body >
</html >