@props(['products'])

<div class="flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="relative pl-4 py-3"></th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Id
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Title
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Thumbnail
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Price
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Avialable count
              </th>
              <th scope="col" class="relative px-6 py-3"></th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($products as $product)
              <tr class="hover:bg-gray-50">
                <td class="pl-4 py-4 whitespace-nowrap">
                  <input type="checkbox" name="select" id="select-product"
                         class="rounded border-gray-500 cursor-pointer">
                </td>
                <td class="pl-4 py-4 whitespace-nowrap">
                  <span class="text-sm text-gray-900 pl-2">{{ $product->id }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="">
                      <div class="text-sm font-medium text-gray-900">
                        {{ $product->title }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10">
                      <img class="rounded-full h-full w-full object-cover" src="{{ $product->thumbnail_url }}"
                           alt="{{ "Product #{$product->id} thumbnail" }}">
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm text-gray-900 font-semibold">${{ $product->price }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="
                    px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                    @if ($product->status->name === 'active') bg-green-100
                    text-green-800 @endif
                    @if ($product->status->name === 'archived')
                      bg-gray-100 text-gray-800
                    @endif
                    @if ($product->status->name === 'out-of-stock')
                      bg-yellow-100 text-yellow-800
                    @endif
                    ">
                    {{ $product->status->alias }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                  <span class="
                    @if ($product->available_count > 100) text-green-600 @endif
                    @if ($product->available_count < 100 && $product->available_count > 10)
                      text-yellow-500
                    @endif
                    @if ($product->available_count < 10)
                      text-red-600
                    @endif
                    ">
                    {{ $product->available_count }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                  <a href="{{ route('products.edit', ['product' => $product]) }}"
                     class="text-indigo-600 hover:text-indigo-900" title="{{ __('Edit') }}">
                    <svg class="inline h-5 w-5 relative right-2" viewBox="0 0 20 20" fill="currentColor">
                      <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                  </a>
                  <x-delete-product-button class="inline h-5 w-5 relative right-2 text-gray-500 hover:text-red-700"
                                           :product="$product">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="inline">
                      <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                  </x-delete-product-button>
                </td>
              </tr>
            @empty
              <p>{{ __('No products were added yet...') }}</p>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
