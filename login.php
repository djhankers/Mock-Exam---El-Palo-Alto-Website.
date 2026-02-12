<?php
session_start();

$error = '';
$DEMO_USER = 'admin';
$DEMO_PASS = 'password';

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = isset($_POST['uname']) ? trim($_POST['uname']) : '';
    $psw = isset($_POST['psw']) ? $_POST['psw'] : '';

    if ($uname === $DEMO_USER && $psw === $DEMO_PASS) {
        $_SESSION['user'] = $uname;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-900">

  <nav class="sticky top-0 z-50 bg-white px-6 md:px-12 py-4 flex justify-between items-center border-b border-gray-200">
    <a href="index.html" class="transition-transform hover:scale-105">
        <img src="assets/images/logo.png" alt="Logo" class="h-12 w-auto"> </a>

    <div class="hidden md:flex gap-8 font-semibold text-sm uppercase tracking-widest">
      <a href="index.html" class="hover:text-gray-500 transition">Home</a>
      <a href="" class="hover:text-gray-500 transition">About Us</a>
      <a href="" class="hover:text-gray-500 transition">Our Brewery</a>
      <a href="" class="hover:text-gray-500 transition">Our Menu</a>
      <a href="" class="hover:text-gray-500 transition">Reserve A Table</a>
    </div>
    
    <div class="flex items-center gap-4">
      <button class="hover:bg-gray-100 p-2 rounded-full transition text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </button>
      <a href="login.php" class="bg-gray-900 text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-gray-800 transition shadow-sm">
        Log in
      </a>
    </div>
  </nav> <main class="min-h-[calc(100vh-80px)] flex items-center justify-center px-4 py-12">
      <div class="w-full max-w-md bg-white p-10 rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100">
        <div class="flex flex-col items-center mb-8">
          <div class="bg-indigo-50 p-3 rounded-2xl mb-4">
              <img src="assets/images/logo.png" alt="logo" class="h-10">
          </div>
          <h2 class="text-2xl font-bold tracking-tight text-gray-900">Admin Login</h2>
          <p class="text-sm text-gray-500 mt-1">Sign in to access the dashboard</p>
        </div>

        <?php if ($error): ?>
          <div class="text-sm font-medium text-red-600 bg-red-50 p-3 rounded-lg border border-red-100 mb-6 text-center">
            <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>

        <form action="" method="post" class="space-y-5">
          <div>
            <label for="uname" class="block text-sm font-semibold text-gray-700 mb-1.5">Username</label>
            <input id="uname" name="uname" type="text" required autofocus 
              class="block w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition border" 
              value="<?php echo isset($_POST['uname']) ? htmlspecialchars($_POST['uname']) : ''; ?>">
          </div>

          <div>
            <div class="flex justify-between mb-1.5">
                <label for="psw" class="block text-sm font-semibold text-gray-700">Password</label>
                <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">Forgot?</a>
            </div>
            <input id="psw" name="psw" type="password" required 
              class="block w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition border">
          </div>

          <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            <label for="remember" class="ml-2 block text-sm text-gray-600">Remember me for 30 days</label>
          </div>

          <div class="pt-2">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow-md shadow-indigo-200 transition-all active:scale-[0.98]">
                Sign In
            </button>
          </div>
        </form>

        <p class="mt-8 text-center text-xs text-gray-400 uppercase tracking-widest">
            &copy; <?php echo date("Y"); ?> El Palo Alto. <i>All rights reserved.<i>
        </p>
      </div>
  </main>
</body>
</html>