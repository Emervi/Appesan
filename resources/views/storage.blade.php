<div class="flex h-screen">
    <!-- Sidebar -->
    <div id="sidebar" class="w-64 bg-gray-800 text-white p-4 transform -translate-x-full transition-transform duration-300">
      <h2 class="text-lg font-bold mb-4">Sidebar</h2>
      <ul>
        <li><a href="#" class="block py-2 hover:bg-gray-700">Dashboard</a></li>
        <li><a href="#" class="block py-2 hover:bg-gray-700">Profile</a></li>
        <li><a href="#" class="block py-2 hover:bg-gray-700">Settings</a></li>
      </ul>
    </div>
  
    <!-- Main Content -->
    <div class="flex-1 bg-gray-100 p-4">
      <button id="toggleButton" class="bg-blue-500 text-white px-4 py-2 rounded">
        Toggle Sidebar
      </button>
      <div class="mt-4">
        <h1 class="text-2xl font-bold">Main Content</h1>
        <p>This is the main content area.</p>
      </div>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById("sidebar");
    const toggleButton = document.getElementById("toggleButton");
  
    toggleButton.addEventListener("click", () => {
      sidebar.classList.toggle("-translate-x-full"); // Toggle class untuk menampilkan/menyembunyikan sidebar
    });
  </script>      