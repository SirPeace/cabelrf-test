@props(['users'])

<div class="flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      @if (!empty($users->first()))
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <form action="{{ route('users.destroy-multiple') }}" method="post" id="users.destroy-multiple">
            @csrf
            @method('DELETE')

            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="relative pl-4 py-3"></th>

                  <x-th sortable
                        name="id"
                        :href="route('users.index')">
                    Id
                  </x-th>

                  <x-th sortable
                        name="name"
                        :href="route('users.index')"
                        :value="__('Name')">
                  </x-th>

                  <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <span>{{ __('Avatar') }}</span>
                  </th>

                  <x-th sortable
                        name="age"
                        :href="route('users.index')"
                        :value="__('Age')">
                  </x-th>

                  <x-th sortable
                        name="role"
                        :href="route('users.index')"
                        :value="__('Role')">
                  </x-th>

                  <x-th sortable
                        name="sex"
                        :href="route('users.index')"
                        :value="__('Sex')">

                  </x-th>

                  <th scope="col" class="relative px-6 py-3"></th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                  <tr class="hover:bg-gray-50 cursor-pointer"
                      @click="
                        if ($event.target.matches(`td`) || $event.target.matches(`div`)) {
                            window.location = $event.target.closest('tr').dataset.href
                        }
                      "
                      data-href="{{ route('users.show', compact('user')) }}">
                    <td class="pl-4 py-4 whitespace-nowrap">
                      @can('edit-user', $user)
                        <input type="checkbox"
                               name="user-id:{{ $user->id }}"
                               class="rounded border-gray-500 cursor-pointer"
                               @click="selected = event.target.checked ? selected + 1 : selected - 1">
                      @endcan
                    </td>
                    <td class="pl-4 py-4 whitespace-nowrap">
                      <span class="text-sm text-gray-900 pl-2">{{ $user->id }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="">
                          <div class="text-sm font-medium text-gray-900">
                            {{ $user->name }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10">
                          <img class="rounded-full h-full w-full object-cover" src="{{ $user->avatar_url }}"
                               alt="{{ "User #{$user->id} avatar" }}">
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="text-sm text-gray-900 font-semibold">{{ $user->age }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        @if ($user->role->name === 'admin') bg-green-100
                        text-green-800 @endif
                        @if ($user->role->name === 'manager')
                          bg-gray-100 text-gray-800
                          @endif">
                          {{ __($user->role->alias) }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                      <span>
                        {{ __($user->sex) }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                      @can('edit-user', $user)
                        <a href="{{ route('users.edit', ['user' => $user]) }}"
                           class="text-indigo-600 hover:text-indigo-900" title="{{ __('Edit') }}">
                          <svg class="inline h-5 w-5 relative right-2" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                  d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                          </svg>
                        </a>
                        <x-delete-user-button class="inline h-5 w-5 relative right-2 text-gray-500 hover:text-red-700"
                                              :user="$user">
                          <svg viewBox="0 0 20 20" fill="currentColor" class="inline">
                            <path fill-rule="evenodd"
                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                  clip-rule="evenodd" />
                          </svg>
                        </x-delete-user-button>
                      @endcan
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </form>
        </div>
      @else
        <p class="p-4">No users found</p>
      @endif
    </div>
  </div>
</div>
