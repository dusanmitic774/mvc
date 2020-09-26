<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add News</title>
</head>
<body>

<form action=<?php echo route('users.store') ?> method="post">
    <input type="hidden" name="token" value="<?php echo Token::set(); ?>">
    <label> Username:
        <input type="text" name="username" value="<?php echo Input::postData('username'); ?>">
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
        <input type="email" name="email" value="<?php echo Input::postData('email') ?>">
    </label><br>
    <?php if (Session::exists('email')): ?>
        <p>
            <?php echo Flash::msg('email'); ?>
        </p>
    <?php endif; ?>

    <input type="submit" name="btn" value="Register">

</form>
</body>
</html>
