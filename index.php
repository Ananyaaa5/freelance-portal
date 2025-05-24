<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Freelance Platform - Home</title>
</head>

<body>
  <div class="bg-white">
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
        <div class="relative left-[calc(50%-11rem)] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#f5f5dc] to-[#d2b48c] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" 
             style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
      </div>
    <!-- Header/Navbar -->
    <header class="absolute inset-x-0 top-0 z-50">
      <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
          <a href="#" class="-m-1.5 p-1.5">
            <span class="sr-only">Freelance Platform</span>
            
          </a>
        </div>
        <div class="flex lg:hidden">
          <button type="button" class="menu-open -m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
            <span class="sr-only">Open main menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
          </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
          <a href="index.php" class="text-sm font-semibold text-gray-900">Home</a>
          <a href="dashfreelancer.php" class="text-sm font-semibold text-gray-900">Browse Jobs</a>
          <a href="login.html" class="text-sm font-semibold text-gray-900">Post Job</a>
          <a href="profile.php" class="text-sm font-semibold text-gray-900">Profile</a>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
          <a href="login.html" class="text-sm font-semibold text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
        </div>
      </nav>

      <!-- Mobile Menu -->
      <div class="mobile-menu lg:hidden hidden fixed inset-0 z-50 bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
        <div class="flex items-center justify-between">
          <a href="#" class="-m-1.5 p-1.5">
            
          </a>
          <button type="button" class="menu-close -m-2.5 rounded-md p-2.5 text-gray-700">
            <span class="sr-only">Close menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="mt-6">
          <a href="index.php" class="block px-3 py-2 text-base font-semibold text-gray-900 hover:bg-gray-100">Home</a>
          <a href="dashfreelancer.php" class="block px-3 py-2 text-base font-semibold text-gray-900 hover:bg-gray-100">Browse Jobs</a>
          <a href="login.html" class="block px-3 py-2 text-base font-semibold text-gray-900 hover:bg-gray-100">Post Job</a>
          <a href="profile.php" class="block px-3 py-2 text-base font-semibold text-gray-900 hover:bg-gray-100">Profile</a>
          <a href="login.html" class="block mt-4 px-3 py-2 text-base font-semibold text-gray-900 hover:bg-gray-100">Log in</a>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <main class="relative isolate px-6 pt-1 lg:px-8">
      <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
        <div class="relative left-[calc(50%-11rem)] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#f5f5dc] to-[#d2b48c] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" 
             style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
      </div>

      <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56 text-center">
        <h1 class="text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">The Future of Work is Here.</h1>
        <p class="mt-8 text-lg font-medium text-gray-500 sm:text-xl">Hire top talent or get hired. An all-in-one freelance platform built for success.</p>
        <div class="mt-10 flex justify-center gap-x-6">
          <a href="login.html" class="rounded-md bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-800">Post a Job</a>
          <a href="dashfreelancer.php" class="rounded-md bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-green-200">Browse Jobs →</a>
        </div>
      </div>

      <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
        <div class="relative left-[calc(50%+3rem)] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#80ffb9] to-[#187e42] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" 
             style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
      </div>
    </main>
  </div>

  <!-- JS for Mobile Menu Toggle -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const menuOpen = document.querySelector('.menu-open');
      const menuClose = document.querySelector('.menu-close');
      const mobileMenu = document.querySelector('.mobile-menu');

      menuOpen?.addEventListener('click', () => mobileMenu?.classList.remove('hidden'));
      menuClose?.addEventListener('click', () => mobileMenu?.classList.add('hidden'));
    });
  </script>
</body>

</html>
