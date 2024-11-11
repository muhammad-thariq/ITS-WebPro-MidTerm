<x-app-layout>
    <div class="py-6 pt-32">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg font-semibold">
                <div class="p-6 text-black text-2xl flex justify-center ">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg font-semibold">
                <div class="p-6 text-black text-2xl">
                    {{ __("At Bit Store, we prioritize user experience and simplicity, allowing you to focus on what truly matters: finding the perfect electronic device. Join us in exploring cutting-edge technology through a beautifully designed platform that makes shopping effortless.") }}
                </div>
                <div class="flex justify-center">
                    <img src="{{ url('bit.png') }}" alt="no image" class="h-16">
                </div>
                <br>
            </div>
        </div>
    </div>

</x-app-layout>
