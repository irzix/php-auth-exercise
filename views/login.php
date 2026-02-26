<?php

require './controllers/login.php';

if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard");
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];


?>

<div class="shadow-xl rounded-sm p-5">

    <h1 class="text-2xl mb-3">Login</h1>
    <?php if ($error) { ?>
        <p class="text-red-500 mb-3 bg-red-100 p-2 w-full text-center border border-red-500 mb-3"><?php echo $error; ?></p>
    <?php } ?>
    <form method="post">
        <input type="hidden" name="csrf_token"
            value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>" />
        <div class="grid grid-cols-1 gap-2 min-w-[300px]">
            <input name="email" id="email" type="email" required placeholder="Email"
                class="rounded-sm border border-gray-300 p-2" />
            <input name="password" id="password" type="password" required placeholder="Password"
                class="rounded-sm border border-gray-300 p-2" />
        </div>
        <div>
            <button type="submit"
                class="bg-blue-500 text-white w-full py-2 mt-3 rounded-sm hover:bg-blue-600">Login</button>
        </div>
    </form>
</div>