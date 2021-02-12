<?php
require_once 'process.php'
?>
<!DOCTYPE html>
<html>
<head>
    <title>ma page</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>

<?php
if (isset($_SESSION['message'])): ?>
<div>
    <?php
    echo $_SESSION['message'];
    unset($_SESSION['message']);
    ?>
</div>
<?php endif ?>


    <?php

    $mysqli = new mysqli('localhost','root','','test');

        if ( ! isset( $_GET['startrow'] ) or ! is_numeric( $_GET['startrow'] ) ) {
            $startrow = 0;
        } else {
            $startrow = (int) $_GET['startrow'];
        }

    $result = $mysqli->query("SELECT * FROM users WHERE supprime='0' LIMIT 20");

    ?>
    <h1>Users</h1>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Type</th>
            <th>Adresse</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_users']) ?></td>
                <td><?php echo htmlspecialchars($row['type']); ?></td>
                <td><?php echo htmlspecialchars($row['adresse']); ?></td>
                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><a href="index.php?edit=<?php echo $row['id_users']; ?>">Edit</a></td>
                <td><a href="process.php?delete=<?php echo $row['id_users']; ?>">Del</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

<br><br>

<form action="process.php" method="post" class="form_add">
    <input type="hidden" name="id" value="<?php echo $id?>">
    <div class="form_add">
        <label for="type">Type</label>
        <input type="text" name="type" id="type" value="<?php echo $type; ?>" required>
    </div>
    <div class="form_add">
        <label for="adresse">Adresse</label>
        <input type="text" name="adresse" id="adresse" value="<?php echo $adresse; ?>" required>
    </div>
    <div class="form_add">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="<?php echo $name; ?>" required>
    </div>
    <div class="form_add">
        <label for="email">Email </label>
        <input type="text" name="email" id="email" value="<?php echo $email; ?>" required>
    </div>
    <br>
    <?php if($update == true): ?>
    <div class="form-example">
        <input type="submit" value="update" name="update">
    </div>
    <?php else :?>
    <div class="form-example">
        <input type="submit" value="add" name="save">
    </div>
    <?php endif; ?>
</form>
<br><br><br>
<form action="process.php" method="post" class="test">
    <div class="form-example">
        <!-- <input type="submit" value="add 5million users V1 = infini" name="add5mV1"> -->
        <input type="submit" value="add 5million users V2 = infini" name="add5mV2">
        <input type="submit" value="add 5million users V3 = 50 sec" name="add5mV3">
        <!-- <input type="submit" value="add 5million users V4 = infini" name="add5mV4"> -->
        <!-- <input type="submit" value="add 5million users V5 = infini" name="add5mV5"> -->
        <input type="submit" value="add 5million users V6 = 40 sec" name="add5mV6">
        <br>
        <input type="submit" value="add Index on Type" name="addIndexOnType">
        <input type="submit" value="add Index on Email and Supprime" name="addUnique">
        <input type="submit" value="delete Index on Email" name="dropUnique">
        <input type="submit" value="add 1million and email index" name="1m&index">
        <br>
        <input type="submit" value="vider" name="vider">
        <br>
        <input type="submit" value="select 2000 lignes" name="select2000">
        <input type="submit" value="sommes des 1 millions de première lignes" name="count1mil">
    </div>
</form>

</body>
</html>