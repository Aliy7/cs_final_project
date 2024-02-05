{{-- <x-app-layout>
  <div class="map-content">
    <form>
      <div class="mb-3">
        <label for="address-input" class="block text-sm font-medium text-gray-700">Search Address</label>
        <input type="text" id="address-input" aria-describedby="emailHelp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 map-input">
        <div id="address-map-container" class="w-full h-96"> 
          <div id="address-map" class="w-full h-full"></div>
        </div>
        <hr class="my-4"> <!-- Adds margin on the y-axis (top & bottom) -->
        
        
     
      <div class="mb-3">
        <label for="address-latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
        <input type="text" id="address-latitude" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
      </div>
      <div class="mb-3">
        <label for="address-longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
        <input type="text" id="address-longitude" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
      </div>
      <button type="submit" class="px-4 py-2 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        Submit
      </button>
    </form>
  </div>
</x-app-layout>
 --}}
 <!DOCTYPE html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Shareme</title>
 
     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
     <!-- Example: Update the background color to light blue -->
     {{-- <style>
         body {
             background-color: #ADD8E6;
             /* Use your desired color code */
         }
     </style> --}}
     {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  --}}
     <!-- Scripts -->
 </head>
 
 
 <body class="antialiased">
 
     <div class="container m-5">
 
         <div class="alert alert-info">
  Comsuming Google map API
         </div>
         {{-- <div class="dashboard-content"> --}}
             <form>
                 <div class="mb-3">
                   <label for="address-input" class="form-label">Search Address address</label>
                   <input type="text" class="form-control map-input" id="address-input" aria-describedby="emailHelp">
                 </div>
                 <hr>
                 {{-- <div id="address-map-container" style="width:75%; height:300px; ">
                     <div style=width:100%; height:100% id="address-map"></div>
                   </div> --}}
                   <div id="address-map-container" style="width: 75%; height: 200px;">
                     <div style="width: 50%; height: 50%;" id="address-map"></div>
                 </div>
                 
                     <hr>
                 <div class="mb-3">
                   <label for="address-latitude" class="form-label">Latitude</label>
                   <input type="text" class="form-control " id="address-latitude">
                 </div>
                 <div class="mb-3">
                     <label class="address-longitude" for="address-longitude">Longitude</label>
                   <input type="text" class="form-control" id="address-longitude">
                 </div>
                 <button type="submit" class="btn btn-primary">Submit</button>
               </form>
             </div>
     {{-- </div>
       --}}
    
         <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
         @if (Route::has('login'))
             <livewire:welcome.navigation />
         @endif
 
 
     </div> 
    
  
 </body>
 
 </html>
 