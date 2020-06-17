<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= config('app.appname') ?></title>

    <?php self::css() ?>
    <?php self::js() ?>

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <?php self::content() ?>
    </div>

</body>

</html>
