<!-- Card Profil -->
<div id="userCard"
  class="hidden absolute right-20 top-20 bg-white rounded-2xl p-6 w-64 text-center z-50
         shadow-[0_10px_25px_rgba(0,0,0,0.15)] ring-1 ring-gray-200 transition-all duration-300 transform scale-95 opacity-0">

  <!-- Mode Tampilan -->
  <div id="profileView" class="flex flex-col items-center">
    <div class="w-20 h-20 bg-gray-400 rounded-full flex items-center justify-center mb-3 overflow-hidden shadow-inner">
      <img id="profileImage" src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="User" class="w-20 h-20 object-cover">
    </div>
    <h3 id="profileName" class="font-semibold text-lg text-black">User</h3>
    <p id="profileEmail" class="text-gray-600 text-sm">user@gmail.com</p>
    <p id="profilePhone" class="text-gray-600 text-sm mb-4">085000000000</p>

    <div class="flex justify-center gap-3">
      <button id="editBtn" class="bg-green-300 hover:bg-green-400 text-black px-4 py-1 rounded-full font-semibold shadow-md hover:shadow-lg transition">Edit</button>
      <button id="logoutBtn" class="bg-red-300 hover:bg-red-400 text-black px-4 py-1 rounded-full font-semibold shadow-md hover:shadow-lg transition">Keluar</button>
    </div>
  </div>

  <!-- Mode Edit -->
  <div id="editView" class="hidden flex flex-col items-center">
    <label for="editImage" class="cursor-pointer w-20 h-20 bg-gray-300 rounded-full flex items-center justify-center mb-3 overflow-hidden hover:ring-2 hover:ring-green-400 transition">
      <img id="editPreview" src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Preview" class="w-20 h-20 object-cover">
      <input type="file" id="editImage" accept="image/*" class="hidden">
    </label>

    <input id="editName" type="text" class="border border-gray-300 rounded-md px-3 py-1 w-full mb-2 text-center text-sm text-black" value="user">
    <input id="editEmail" type="email" class="border border-gray-300 rounded-md px-3 py-1 w-full mb-2 text-center text-sm text-black" value="user@gmail.com">
    <input id="editPhone" type="text" class="border border-gray-300 rounded-md px-3 py-1 w-full mb-4 text-center text-sm text-black" value="085000000000">

    <button id="saveBtn" class="bg-green-400 hover:bg-green-500 text-black px-5 py-1 rounded-full font-semibold shadow-md hover:shadow-lg transition">Save</button>
  </div>
</div>
