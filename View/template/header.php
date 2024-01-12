<header class="custom-bg2 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 nav-container">
        <a href="/immo/home" class="logo text-2xl font-extrabold text-purple-700">WikiConnect</a>
        <nav class="nav-menu hidden md:flex space-x-10">
            <a href="../user/wiki.php" class="text-base font-medium text-gray-500 hover:text-gray-900">Home</a>
            <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">About</a>
            <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">Services</a>
            <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">Contact Us</a>
        </nav>
        <?php if (isset($_SESSION['userId'])) { ?>
            <div class="nav-right hidden md:flex">
                <a href="../../App/Controllers/Logout.php" class="ml-8 whitespace-nowrap inline-flex items-center justify-center bg-purple-600 text-base font-medium text-white px-4 py-2 border border-transparent rounded-md shadow-sm hover:bg-purple-700">Log Out</a>
            </div>
        <?php } else { ?>
            <div class="nav-right hidden md:flex">
                <a href="../auth/login.php" class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">Log In</a>
                <a href="../auth/signup.php" class="ml-8 whitespace-nowrap inline-flex items-center justify-center bg-purple-600 text-base font-medium text-white px-4 py-2 border border-transparent rounded-md shadow-sm hover:bg-purple-700">Sign up</a>
            </div>
        <?php } ?>
        <div class="hamburger md:hidden" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</header>
