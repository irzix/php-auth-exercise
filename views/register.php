<?php

require './controllers/register.php';


if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard");
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];

?>


<h1 class="text-2xl mb-3">Register</h1>
<?php if ($error) { ?>
    <p class="text-red-500 mb-3 bg-red-100 p-2 w-full text-center border border-red-500 mb-3"><?php echo $error; ?></p>
<?php } ?>
<form method="post" onSubmit="validate(event)">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>" />
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 min-w-[300px]">
        <input name="fname" type="text" minlength="3" required placeholder="First Name"
            class="rounded-sm border border-gray-300 p-2" />
        <input name="lname" type="text" minlength="3" required placeholder="Last Name"
            class="rounded-sm border border-gray-300 p-2" />
        <select name="country" class="rounded-sm border border-gray-300 p-2" required id="country"
            onchange="myFunction()">
            <option value="">Select Country</option>
            <option value="US" data-code="1">United States</option>
            <option value="CY" data-code="357">Cyprus</option>
            <option value="GB" data-code="44">United Kingdom</option>
        </select>
        <div class="flex gap-2">
            <input name="prefix" type="number" placeholder="Prefix"
                class="rounded-sm border border-gray-300 p-2 max-w-[100px]" id="prefix" />
            <input name="phone" type="number" required placeholder="Phone"
                class="rounded-sm border border-gray-300 p-2" />
        </div>
        <input name="email" id="email" type="email" required placeholder="Email"
            class="rounded-sm border border-gray-300 p-2" />
        <input name="password" id="password" type="password" required placeholder="Password"
            class="rounded-sm border border-gray-300 p-2" />
    </div>
    <label class="my-2 block">
        <input type="checkbox" required />
        I agree to the terms and conditions
    </label>
    <div>
        <button type="submit"
            class="bg-blue-500 text-white w-full py-2 mt-3 rounded-sm hover:bg-blue-600">Register</button>
    </div>
</form>
</div>
</div>

<script>
    function myFunction() {
        const country = document.getElementById("country");
        const code = country.options[country.selectedIndex].dataset.code;
        document.getElementById('prefix').value = code;
    }

    function validate(e) {

        e.preventDefault();

        const email = document.getElementById('email');
        const password = document.getElementById('password');

        if (email.value === '' || password.value === '' || email.value.includes('@') === false) {
            alert('Please fill in all fields');
            return false;
        }

        if (password.value.length < 8) {
            alert('Password must be at least 8 characters long');
            return false;
        }

        const upper = new RegExp('^(?=.*[A-Z])');
        if (!upper.test(password.value)) {
            alert('Password must contain at least one uppercase letter');
            return false;
        }

        const number = new RegExp('^(?=.*[0-9])');
        if (!number.test(password.value)) {
            alert('Password must contain at least one number');
            return false;
        }

        const special = /(?=.*[!@#$%^&*()_+\-=\[\]{};":\\|,.<>\/?`~])/;
        if (!special.test(password.value)) {
            alert('Password must contain at least one special character');
            return false;
        }

        submitForm();
    }

    function submitForm() {
        document.querySelector('form').submit();
    }
</script>