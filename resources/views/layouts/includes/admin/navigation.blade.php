<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-900">
  <div class="flex flex-wrap items-center justify-between mx-auto p-4">
    
    <!-- LOGO / NOMBRE -->
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <span class="self-center text-2xl font-semibold whitespace-nowrap text-indigo-600">
        Dermatología Clínica Integral
      </span>
    </a>

    <!-- PERFIL / DROPDOWN -->
    <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
      <button 
        type="button" 
        class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" 
        id="user-menu-button" 
        aria-expanded="false" 
        data-dropdown-toggle="user-dropdown" 
        data-dropdown-placement="bottom"
      >
        <span class="sr-only">Abrir menú de usuario</span>
        <img 
          class="w-8 h-8 rounded-full object-cover" 
          src="{{ Auth::user()->profile_photo_url }}" 
          alt="{{ Auth::user()->name }}"
        >
      </button>

      <!-- Dropdown -->
      <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm" id="user-dropdown">
        <div class="px-4 py-3">
          <span class="block text-sm text-gray-900">{{ Auth::user()->name }}</span>
          <span class="block text-sm text-gray-500 truncate">{{ Auth::user()->email }}</span>
        </div>

        <ul class="py-2" aria-labelledby="user-menu-button">
          <li>
            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
              Perfil
            </a>
          </li>

          @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
          <li>
            <a href="{{ route('api-tokens.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
              API Tokens
            </a>
          </li>
          @endif

          <li>
            <form method="POST" action="{{ route('logout') }}" x-data>
              @csrf
              <button 
                type="submit" 
                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
              >
                Cerrar sesión
              </button>
            </form>
          </li>
        </ul>
      </div>

      <!-- Botón responsive -->
      <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400  dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
        <span class="sr-only">Abrir menú principal</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
      </button>
    </div>

    <!-- ENLACES DE NAVEGACIÓN -->
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
      <ul class="-ml-8 flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
        <li>
          <a href="/admin/doctors/1/edit" class="block py-2 px-3 text-infigo-700 rounded-sm md:bg-transparent md:text-infigo-700 md:p-0" aria-current="page">Mi perfil</a>
        </li>
        <li>
          <a href="{{ route('admin.patients.index') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:text-infigo-700 md:p-0">Pacientes</a>
        </li>
        <li>
          <a href="{{ route('admin.appointments.index') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:text-infigo-700 md:p-0">Citas Médicas</a>
        </li>
        <li>
          <a href="{{ route('admin.calendar.index') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:text-infigo-700 md:p-0">Calendario</a>
        </li>
        <li>
          <a href="https://docs.google.com/spreadsheets/d/18Kx1Ag493T5e69ckHhNcsU-jeTAmY20so7cIfNF21rA/edit?usp=sharing" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:text-infigo-700 md:p-0" target="_blank" >Inventario</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
