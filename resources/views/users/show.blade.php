<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <a href="{{ route('users.index') }}" class="inline-flex items-center mb-4 hover:underline">
        <svg class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span>{{ __('Back to users list') }}</span>
      </a>

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <div class="mb-4 border-gray-100 border-b-2 w-full flex justify-between items-center">
            <h1 class="text-2xl font-bold">
              {{ $user->name }}
            </h1>
          </div>

          <div class="flex justify-between">
            <div class="flex-grow max-w-3xl">
              <div>
                <span class="font-bold text-lg underline">ID</span>
                <p>{{ $user->id }}</p>
              </div>

              <div class="mt-4">
                <span class="font-bold text-lg underline">{{ __('Role') }}</span>
                <p>{{ __($user->role->alias) }}</p>
              </div>

              <div class="mt-4">
                <span class="font-bold text-lg underline">{{ __('Age') }}</span>
                <p>{{ $user->age }}</p>
              </div>

              <div class="mt-4">
                <span class="font-bold text-lg underline">{{ __('Sex') }}</span>
                <p>{{ __($user->sex) }}</p>
              </div>
            </div>

            <div class="w-72 ml-8 mr-4">
              <div class="border border-gray-200 rounded mb-7">
                <img src="{{ $user->avatar_url }}" alt="{{ "User #{$user->id} avatar" }}">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
