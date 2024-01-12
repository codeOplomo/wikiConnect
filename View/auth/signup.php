<!-- At the top of your signup form -->
<?php
// use MyApp\Core\Session;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatein - Discover a place you'll love to live</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="../../Assets/css/authstyle.css" rel="stylesheet">

</head>
<style>
    .selected-button {
        background-color: white;
        color: rebeccapurple;
    }
</style>

<body class="custom-bg text-gray-400">
    <?php include '../../View/template/header.php'; ?>
    <div class="centred custom-bg rounded shadow-lg p-6 mt-12 md:flex md:items-center relative">
        <div class="md:w-1/2 relative">
            <img src="../../Assets/img/wikiHero.png" alt="Hero Image" class="w-full h-auto">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center">
                <h1 class="text-4xl font-bold" style=" line-height: 10vh; color: black; -webkit-text-stroke: 3px white; font-size: 4.5rem;">Discover a place you'll love to live</h1>
                </div>
            </div>
        </div>

        <!-- Sign up form -->
        <div class="md:w-1/2 mt-6 md:mt-0 md:ml-6">
            <div class="form-inputs-container">
                <div class="mb-4 text-center">
                    <h2 class="text-2xl font-bold text-white mb-4">Sign Up</h2>
                    <form action="../../App/Controllers/Register.php" method="post">

                        <label for="username">Username</label>
                        <input name="username" id="username" class="p-2 border border-gray-300 rounded" type="text"
                            placeholder="Full Name" />

                        <label for="phone">Phone</label>
                        <input name="phone" id="phone" class="p-2 border border-gray-300 rounded" type="tel"
                            placeholder="Phone Number" />

                        <label for="email">Email</label>
                        <input name="email" id="email" class="p-2 border border-gray-300 rounded" type="email"
                            placeholder="Email"/>


                    <label for=" password">Password</label>
                        <input name="password" id="password" class="p-2 border border-gray-300 rounded" type="password"
                            placeholder="Password" />


                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="sign-up-button bg-purple-600 text-white px-6 py-2 rounded transition duration-300 hover:bg-purple-700 focus:outline-none focus:ring">Sign
                                Up</button>
                            <p class="text-white ml-4"><a href="login.php"
                                    class="text-purple-300 hover:underline">Already have an account?</a></p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <?php include '../../View/template/footer.php'; ?>
    <script src="Assets/js/myscript.js"></script>
    <script>
        function setRole(role) {
            document.getElementById('role').value = role;
            const buyerButton = document.querySelector('.first-button');
            const sellerButton = document.querySelector('.second-button');

            if (role === 'Buyer') {
                buyerButton.classList.add('selected-button');
                sellerButton.classList.remove('selected-button');
            } else {
                sellerButton.classList.add('selected-button');
                buyerButton.classList.remove('selected-button');
            }
        }
    </script>

</body>

</html>