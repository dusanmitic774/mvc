<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
<h2>All users</h2>
<?php echo Flash::msg('loggedin'); ?>
<?php if (isset($users) && ! empty($users)): ?>
    <?php foreach ($users as $user): ?>

        <div class="container"><a href="users/show/<?php echo $user->id; ?>"><?php echo $user->username; ?></a>
            <form action="users/delete" method="post">
                <input type="hidden" name="token">
                <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                <input type="submit" value="delete">
            </form>

            <a class="edit" href="users/edit/<?php echo $user->id ?>">edit</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<a href="users/create">Create New User</a>
<br>
<a href="users/logout">Log Out</a>
<br>
<a href="users/login">Log In</a>

</body>
</html>