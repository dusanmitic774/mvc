<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User</title>
</head>
<body>
<h2><?php echo $user->username; ?> profile</h2>
<?php echo Flash::msg('image'); ?>

<form action="<?php echo BASE_URL; ?>/users/upload/<?php echo $user->id; ?>" method="post"
      enctype="multipart/form-data">
    <input type="file" name="img">
    <input type="submit" name="btn" value="Upload">
</form>

<img src="<?php echo BASE_URL . '/' . $user->image; ?>" alt="This User Has No Image">
</body>
</html>