<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @if (session('product.create_status') === 'success')
        <div class="bg-green-50 bg-opacity-50 text-green-700 p-4 mb-4 rounded border border-green-600">
          <p>{{ __('The product was successfully updated!') }}</p>
        </div>
      @endif

      @if (session('product.delete_status') === 'success')
        <div class="bg-green-50 bg-opacity-50 text-green-700 p-4 mb-4 rounded border border-green-600">
          <p>{{ __('The product was successfully deleted!') }}</p>
        </div>
      @endif

      @if (session('product.multiple_delete_status') === 'success')
        <div class="bg-green-50 bg-opacity-50 text-green-700 p-4 mb-4 rounded border border-green-600">
          <p>{{ __('The selected products were successfully deleted!') }}</p>
        </div>
      @endif

      <div x-data="{ selected: 0 }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <div class="flex justify-between mb-2">
            <h1 class="text-2xl font-bold mb-4 ">{{ __('Products') }}</h1>
            <div class="flex items-center">
              <div class="space-x-1">
                <button x-show="selected > 0"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded text-white inline-flex items-center"
                        @click="document.forms['products.delete-multiple'].submit()">
                  <svg class="h-5 w-5 relative right-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                          clip-rule="evenodd" />
                  </svg>
                  <span class="text-sm">{{ __('Delete') }}</span>
                </button>
                <a href="{{ route('products.create') }}"
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded text-white inline-flex items-center">
                  <svg class="h-5 w-5 relative right-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                          clip-rule="evenodd" />
                  </svg>
                  <span class="text-sm">{{ __('Add') }}</span>
                </a>
              </div>
              <x-input x-data=""
                       @keydown.enter="
                         let queryArr = [
                           '?',
                           url.query.orderBy ? `orderBy=${url.query.orderBy}&` : '',
                           url.query.order ? `order=${url.query.order}&` : '',
                           `s=${$event.target.value}`
                         ]

                         location = url.origin + url.pathname + queryArr.join('')
                       "
                       type="search"
                       class="ml-4 w-96"
                       :placeholder="__('Search products')" />
            </div>
          </div>

          <div class="my-4">
            {{ $products->links() }}
          </div>

          <x-products-table :products="$products"></x-products-table>

          <div class="mt-4">
            {{ $products->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
