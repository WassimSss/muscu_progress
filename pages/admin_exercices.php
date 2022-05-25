<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['email']) && $_SESSION['role_admin'] == 1) {
    require '../model/User.php';
    $title = "Admin";
    
    $user = new User;
    require '../model/Exercise.php';
    $exercise = new Exercise;

    $allUsers = $user->allUsersNumber();
    if (isset($_GET['user']) && !empty($_GET['user'] && $_GET['user'] > 5)) {
        $userPerPage = $_GET['user'];
    } else {
        $userPerPage = 5;
    }
    
    
    $pagesTotales = ceil($allUsers / $userPerPage);

    if (isset($_GET['page']) && !empty($_GET['page'] && $_GET['page'] > 0 && $_GET['page'] <= $pagesTotales)) {
        $_GET['page'] = intval($_GET['page']);
        $pageCourante = $_GET['page'];
    } else {
        $pageCourante = 1;
    }

    $depart = ($pageCourante - 1) * $userPerPage;
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/admin.css">
        <title><?=$title?> - Exercices</title>
        </head>

    <body>
    <?php require '../pages/navBarApp.php'; ?>

        <div>
            <a href="../pages/admin/users.php">Utilisateurs</a>
            <a href="../pages/admin/exercices.php">Exercices</a>
        </div>
        <div class="setting">
            <form action=""  method="GET">
                <label for="user_per_page">Nombre d'utilisateur par page</label>

                <select name="user" id="user_per_page">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="40">40</option>
                    <option value="60">60</option>
                    <option value="80">80</option>
                    <option value="100">100</option>
                </select>

                <input type="submit">
            </form>

        </div>
        <table id="table_users">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($user->fetchAllUsers($depart, $userPerPage) as $key) { ?>
                    <tr>
                        <td><?= $key['id'] ?></td>
                        <td><?= $key['username'] ?></td>
                        <td><?= $key['email'] ?></td>
                        <td><?= $key['role_admin'] ?></td>
                        <!--<td><a class="deletion_request" href="../config/deleteUser.php?id=<?= $key['id'] ?>">Supprimer</a></td>-->
                        <td><a href="../config/deleteUser.php?id=<?= $key['id'] ?>" onclick="Supp(this.href); return(false);"><ion-icon name="trash-outline"></ion-icon></a></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php
            for ($i = 1; $i <= $pagesTotales; $i++) { ?>
                <a <?php
                if ($i == $pageCourante) {?>
                    class="active"
                <?php } ?>
                href="admin.php?page=<?= $i ?>&user=<?= $userPerPage ?>"><?= $i ?></a>
            <?php } ?>
        </div>

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="../js/admin.js"></script>
    </body>

    </html>

<?php } ?>