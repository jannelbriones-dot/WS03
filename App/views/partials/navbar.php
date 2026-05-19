<?php
    use framework\Session;
    
    // Ensure session is started
    Session::start();
?>

<header class="site-header bg-white shadow-sm">
  <div class="container mx-auto px-4 py-3">
    <div class="flex items-center justify-between">

      <a href="/" class="brand" style="color: #00796b; font-weight: 700; transition: color 0.2s; font-family: 'Poppins', sans-serif; font-size: 1.8rem; text-decoration: none;">
        Prosple
      </a>

      <div class="nav-actions">
        <?php if (Session::has('user')) : ?>

          <div class="flex items-center gap-4">

            <span class="text-gray-700" style="font-family: 'Poppins', sans-serif; font-size: 1rem;">
              Welcome, <?= htmlspecialchars(Session::get('user')['name'] ?? 'User') ?>
            </span>

            <form method="POST" action="/logout" style="display:inline">
              <button type="submit" class="text-red-600 hover:text-red-800 font-semibold" style="font-family: 'Poppins', sans-serif; font-size: 1rem;">
                Logout
              </button>
            </form>

            <a href="/listings/create"
               class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded" 
               style="font-family: 'Poppins', sans-serif; font-size: 0.9rem;">
               Post a Job
            </a>

          </div>

        <?php else : ?>

          <div class="flex items-center gap-4">
            <a href="/login" class="text-blue-600 hover:text-blue-800 font-semibold" 
               style="font-family: 'Poppins', sans-serif; font-size: 1rem; text-decoration: none;">Login</a>
            <a href="/register" class="text-blue-600 hover:text-blue-800 font-semibold" 
               style="font-family: 'Poppins', sans-serif; font-size: 1rem; text-decoration: none;">Register</a>
          </div>

        <?php endif; ?>
      </div>

    </div>
  </div>
</header>

<main class="site-main">