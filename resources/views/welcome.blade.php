<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-public-header-nav />

    <main class=" lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">
        <div class="text-center">
            <h1 class="text-xl font-bold">Cari Lomba di Lombaku!</h1>
            <p class="text-sm text-black/60 mt-2">Update terus info lomba terkini, dari kampus sampai internasional – semua ada di sini.</p>
        </div>

        <!-- lomba cards -->
        <section class="grid place-items-center grid-cols-4 lg:grid-cols-12 gap-4 mt-5">
            <!-- card -->
            <div class="bg-white col-span-2 lg:col-span-3 rounded-lg overflow-hidden shadow-md">
                <img class="aspect-square object-cover rounded-lg overflow-hidden" src="https://images.unsplash.com/photo-1604134967494-8a9ed3adea0d?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                <div class="p-3 ">
                    <div class="flex gap-1 items-center text-black/60"><span class="material-symbols-outlined">calendar_month</span>
                        <p class="text-xs ">12 April 2025</p>

                    </div>
                    <h2 class="text-sm font-medium mt-2">Lorem ipsum dolor sit amet</h2>
                </div>
            </div>
            <!-- card -->
            <div class="bg-white col-span-2 lg:col-span-3 rounded-lg overflow-hidden shadow-md">
                <img class="aspect-square object-cover rounded-lg overflow-hidden" src="https://images.unsplash.com/photo-1604134967494-8a9ed3adea0d?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                <div class="p-3 ">
                    <div class="flex gap-1 items-center text-black/60"><span class="material-symbols-outlined">calendar_month</span>
                        <p class="text-xs ">12 April 2025</p>

                    </div>
                    <h2 class="text-sm font-medium mt-2">Lorem ipsum dolor sit amet</h2>
                </div>
            </div>
        </section>

        <div class="w-full flex justify-center mt-5">
            <a href="/lomba" class="py-2 px-3 bg-white border border-blue-500 text-blue-500 rounded-lg text-sm font-semibold mt-0">Lihat semua lomba</a>
        </div>
    </main>

    <section class="mt-10 bg-blue-50 px-4 py-8 flex flex-col items-center gap-2 ">
        <h2 class="text-base font-semibold text-center">Butuh mahasiswa potensial untuk mengikuti lomba anda?</h2>
        <a href="/login" class="py-2 px-3 text-white bg-blue-500 rounded-lg text-sm font-semibold mt-0">Daftar Sebagai Admin Lomba</a>
    </section>

    <x-footer />
</body>

</html>