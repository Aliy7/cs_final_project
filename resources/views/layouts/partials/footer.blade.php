<footer class="relative inset-x-0 bottom-0 z-10 bg-violet-400		 rounded-lg shadow px-4 py-6 lg:ml-60" class="footer">
    <div class="w-full mx-auto max-w-screen-xl font-extrabold">
        <div class="flex justify-between items-center">
            <span class=" text-2xl text-black font-extrabold">© <span id="year"></span> Food Sharing App. All Rights Reserved.</span>
            <ul class="flex items-center font-bold  text-sm font-medium text-white">
                <li>
                    <a href="{{route('showHelp-page')}}" class="  text-blue-700 font-extrabold hover:underline mx-2">Help Page</a>
                </li>
                <li>
                    <a href="{{route('privacy-policy')}}" class=" text-blue-700 font-extrabold hover:underline mx-2">Privacy Policy</a>
                </li>
                <li>
                    <a href="{{ route('contactUs-email') }}" class="  text-blue-700 font-extrabold hover:underline mx-2">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</footer>
<script>
    // Set the current year in the footer
    document.getElementById('year').textContent = new Date().getFullYear();
</script>