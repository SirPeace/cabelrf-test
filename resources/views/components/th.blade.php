@props(['sortable' => false, 'name', 'href', 'value'])

<?php
// Generate sorting URL for component

$sortURL = '';

if ($sortable) {
    $_order = 'asc';

    if (request('orderBy') === $name) {
        $_order = request('order') === 'desc' ? 'asc' : 'desc';
    }

    $sortURL = $href
        . '?orderBy=' . $name
        . '&order=' . $_order;
}
?>

<th scope="col"
    data-href="{{ $sortURL }}"
    {!! $attributes->merge(['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:underline']) !!}
    @click="location = $event.target.closest('th').dataset.href">
  <span>{{ $value ?? $slot }}</span>
  @if ($sortable && request('orderBy') === $name)
    @if (request('order') === 'desc')
      <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4" viewBox="0 0 20 20"
           fill="currentColor">
        <path fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd" />
      </svg>
    @else
      <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
              d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
              clip-rule="evenodd" />
      </svg>
    @endif
  @endif
</th>
