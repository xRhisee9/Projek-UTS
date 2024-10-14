<?php
session_start();

// Fungsi untuk memeriksa kredensial
function checkCredentials($username, $password) {
    $adminCredentials = ['username' => 'admin', 'password' => 'admin123'];
    $userCredentials = ['username' => 'user', 'password' => 'user123'];

    if ($username === $adminCredentials['username'] && $password === $adminCredentials['password']) {
        $_SESSION['role'] = 'admin';
        return true;
    } elseif ($username === $userCredentials['username'] && $password === $userCredentials['password']) {
        $_SESSION['role'] = 'user';
        return true;
    }
    return false;
}

$alertMessage = "";

// Proses login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (checkCredentials($username, $password)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $alertMessage = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://unpkg.com/@formkit/auto-animate"></script>
    <style>
        body {
            overflow: hidden; /* Prevent scrolling */
        }
        #video-background {
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            z-index: -1; /* Behind all other content */
        }
        #login-container {
            background: rgba(255, 255, 255, 0.1); /* White with transparency */
            backdrop-filter: blur(10px); /* Blur effect */
            border-radius: 15px; /* Rounded corners */
            border: 1px solid rgba(255, 255, 255, 0.3); /* Optional border */
        }
    </style>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">
    <!-- Background Video -->
    <video id="video-background" autoplay loop muted>
        <source src="backgroundvideo/164386-830461339.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div id="login-container" class="p-8 shadow-lg w-96 z-10"> <!-- Added z-10 to keep it above video -->
        <div class="flex justify-center mb-6">
            <svg fill="none" height="90" viewBox="0 0 32 32" width="90" xmlns="http://www.w3.org/2000/svg">
                <rect height="100%" rx="16" width="100%"></rect>
                <path clip-rule="evenodd" d="M17.6482 10.1305L15.8785 7.02583L7.02979 22.5499H10.5278L17.6482 10.1305ZM19.8798 14.0457L18.11 17.1983L19.394 19.4511H16.8453L15.1056 22.5499H24.7272L19.8798 14.0457Z" fill="#FFFFFF" fill-rule="evenodd"></path>
            </svg>
        </div>

        <h2 class="text-white text-2xl font-semibold text-center mb-6 my-2">
            Log In
        </h2>

        <!-- Alert message for login failure -->
        <?php if (!empty($alertMessage)) : ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Warning</p>
                <p><?php echo $alertMessage; ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label for="username" class="text-gray-400">Username</label>
                <input id="username" name="username" class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Username" type="text" required />
            </div>
            <div class="mb-4 relative">
                <label for="password" class="text-gray-400">Password</label>
                <input id="password" name="password" class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Password" type="password" required />
            </div>
            <button name="login" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700" type="submit">
                Login
            </button>
        </form>
    </div>

    <script>
        // GSAP animation for the login container
        gsap.from("#login-container", { duration: 1, y: -50, opacity: 0, ease: "fade" });

        // GSAP animation for input fields and labels
        gsap.from("label", { duration: 1, x: -50, opacity: 0, delay: 0.2, stagger: 0.2 });
        gsap.from("input", { duration: 1, x: 50, opacity: 0, delay: 0.2, stagger: 0.2 });

        // AutoAnimate
        autoAnimate(document.querySelector("#login-container"));
    </script>
</body>
</html>
