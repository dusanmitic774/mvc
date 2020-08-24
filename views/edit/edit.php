<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update</title>
</head>
<body>

<form action="/users/update" method="post">
    <input type="hidden" name="token" value="<?php echo Token::set(); ?>">
    <input type="hidden" name="id" value="<?php echo $user->id; ?>">
    <label> Username:
        <input type="text" name="username" value="<?php echo $user->username ?>">
    </label><br>
    <?php if (Session::exists('username')): ?>
        <p>
            <?php echo Flash::msg('username'); ?>
        </p>
    <?php endif; ?>

    <label> Password:
        <input type="password" name="password">
    </label><br>
    <?php if (Session::exists('password')): ?>
        <p>
            <?php echo Flash::msg('password'); ?>
        </p>
    <?php endif; ?>

    <label> Email:
        <input type="email" name="email" value="<?php echo $user->email; ?>">
    </label><br>
    <?php if (Session::exists('email')): ?>
        <p>
            <?php echo Flash::msg('email'); ?>
        </p>
    <?php endif; ?>

    <input type="submit" name="btn">

</form>
</body>
</html>