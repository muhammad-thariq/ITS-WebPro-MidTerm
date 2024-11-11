<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> -->


  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-8">

    @if (session()->has('success'))
      <x-alert message="{{ session('success') }}" />
    @endif

    <!-- Export Button -->
    
    <div class="flex flex-col md:flex-row my-9 items-start md:items-center justify-between px-6">
      <h2 class="text-white text-3xl font-semibold mb-4 md:mb-0">List Products</h2>
    
      <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
        <a href="{{ route('products.exportActivityLog') }}" 
           class="bg-white px-10 py-2 rounded-md font-semibold hover:bg-black hover:text-white hover:outline-none hover:ring-2 hover:ring-white hover:ring-offset-2 transition ease-in-out duration-150 w-full md:w-auto text-center">
          Download Activity Log
        </a>
      
        <a href="{{ route('products.export') }}" 
           class="bg-white px-10 py-2 rounded-md font-semibold hover:bg-black hover:text-white hover:outline-none hover:ring-2 hover:ring-white hover:ring-offset-2 transition ease-in-out duration-150 w-full md:w-auto text-center">
          Export List as Excel
        </a>
           
        <a href="{{ route('products.create') }}" class="w-full md:w-auto">
          <button class="bg-white px-10 py-2 rounded-md font-semibold hover:bg-black hover:text-white hover:outline-none hover:ring-2 hover:ring-white hover:ring-offset-2 transition ease-in-out duration-150 w-full md:w-auto text-center">+ Add</button>
        </a>
      </div>
      
    </div>
     
    <div class="grid md:grid-cols-3 grid-cols-1 mt-4 gap-6 px-6">  
      @foreach($products as $product)
      <div>
        <img src="{{ asset($product->Photo) }}" class="rounded-md w-[390px] h-[390px] object-cover">

        <div class="my-2">
          <p class="text-xl text-white font-semibold">
            {{ $product->Name}}
          </p>
          <p class="text-gray-400">
            Rp. {{ number_format($product->Price)}}
          </p>
        </div>
        <a href="{{ route('products.edit', $product) }}">
          <button class="bg-white px-10 py-2 w-full rounded-md font-semibold my-4 hover:bg-black hover:text-white  hover:outline-none hover:ring-2 hover:ring-white hover:ring-offset-2 transition ease-in-out duration-150">Edit</button>
        </a>
      </div>
      @endforeach
    </div>

</x-app-layout>
 