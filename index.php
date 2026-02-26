<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'helpers/validators.php';
require_once 'models/user.php';
require_once 'database/db.php';


$request = $_SERVER['REQUEST_URI'];

$path = parse_url($request, PHP_URL_PATH);
$file = __DIR__ . '/views/' . $path . '.php';
if (!file_exists($file)) {
    $file = __DIR__ . '/views/home.php';
}

?>

<head>
    <title>Exercise <?php echo $path; ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="flex flex-col items-center justify-center h-screen">
        <div class="flex flex-col items-center justify-center max-w-4xl">
            <?php include $file; ?>
        </div>
    </div>
</body>

</html>