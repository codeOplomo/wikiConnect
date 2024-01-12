<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WikiConnect - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="../../Assets/css/authstyle.css" rel="stylesheet">
</head>

<body class="custom-bg text-gray-400">
    <?php include '../../View/template/header.php'; ?>

    <div class="custom-bg rounded shadow-lg p-6 mt-12 md:flex md:items-center relative">
        <div class="centred md:w-1/2 relative">
            <img src="../../Assets/img/wikiHero.png" alt="Hero Image" class="w-full h-auto">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center">
                    <h1 class="text-4xl font-bold"
                        style="color: #703BF7; -webkit-text-stroke: 2px white; font-size: 4.5rem;">Welcome Back</h1>
                </div>

            </div>
        </div>

        <!-- Login form -->
        <div class="md:w-1/2 mt-6 md:mt-0 md:ml-6">
            <div class="form-inputs-container bg-custom-dark p-8 rounded-lg shadow-md">
                <h2 class="text-3xl font-bold text-white mb-8 text-center">Login</h2>
                <div class="alert alert-danger text-red-500 mt-2" id="login-error">
                </div>
                <form action="../../App/Controllers/Login.php" method="post">
                    <div class="mb-6">
                        <label for="email" class="block text-white text-sm font-bold mb-2">Email:</label>
                        <input name="email" id="email" type="email" placeholder="Enter your email"
                            class="more-width p-2 rounded focus:outline-none focus:shadow-outline" />
                        <div class="error-message  text-red-500 mt-2" id="email-error"></div>
                    </div>

                    <div class="mb-8">
                        <label for="password" class="block text-white text-sm font-bold mb-2">Password:</label>
                        <input name="password" id="password" type="password" placeholder="Enter your password"
                            class="more-width p-2 rounded focus:outline-none focus:shadow-outline" />
                        <div class="error-message  text-red-500 mt-2" id="password-error"></div>
                    </div>

                    <div class="flex items-center justify-between">
                        <button name="processLogin" type="submit"
                            class="sign-up-button bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">Login</button>
                    </div>
                </form>

                <div class="text-center mt-6">
                    <p class="text-white">
                        Don't have an account? <a href="signup.php" class="text-purple-300 hover:text-purple-500">Sign
                            up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../View/template/footer.php'; ?>
    <script src="../../Assets/js/login.js"></script>

</body>

</html>