@props(['multiple' => false, 'name', 'id'])

<div class="flex flex-col flex-grow mb-3">
  <div x-data="{ files: [] }"
       {!! $attributes->merge(['class' => 'file-uploader block w-full py-4 px-3 relative bg-white appearance-none border border-gray-300 border-solid rounded-md hover:shadow-outline-gray']) !!}>
    <input type="file" {{ $multiple ? 'multiple' : '' }}
           {{ $id ? "id=\"$id\"" : '' }}
           name="{{ $name }}"
           class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0 cursor-pointer"
           x-on:change="files = $event.target.files; console.log($event.target.files);"
           x-on:dragover="$el.classList.add('active')"
           x-on:dragleave="$el.classList.remove('active')"
           x-on:drop="$el.classList.remove('active')">
    <template x-if="files.length > 0">
      <div class="flex flex-col space-y-1">
        <template x-for="(_,index) in Array.from({ length: files.length })">
          <div class="flex flex-row items-center space-x-2">
            <template x-if="files[index].type.includes('audio/')">
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path
                      d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
              </svg>
            </template>
            <template x-if="files[index].type.includes('application/')">
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                      clip-rule="evenodd" />
              </svg>
            </template>
            <template x-if="files[index].type.includes('image/')">
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                      clip-rule="evenodd" />
              </svg>
            </template>
            <template x-if="files[index].type.includes('video/')">
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path
                      d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
              </svg>
            </template>
            <span class="text-sm font-medium text-gray-900"
                  x-text="
                  files[index].name.length > 14
                    ? files[index].name.substr(0, 16) + '…'
                    : files[index].name
                  ">
              Uploading
            </span>
            <span class="text-xs self-end text-gray-500" x-text="filesize(files[index].size)">...</span>
          </div>
        </template>
      </div>
    </template>
    <template x-if="files.length === 0">
      <div class="flex flex-col space-y-2 items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
        </svg>
        <p class="text-gray-700 text-center px-4">Drag your files here or click in this area.</p>
      </div>
    </template>
  </div>
</div>
