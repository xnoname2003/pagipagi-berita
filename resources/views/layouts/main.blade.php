<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PagiPagi Berita</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <nav x-data="{ open: false }" class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <a href="{{ route('news.index') }}" class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600" viewBox="0 0 576 512">
                        <path fill="#2652e7"
                            d="M178.2-10.1c7.4-3.1 15.8-2.2 22.5 2.2l87.8 58.2 87.8-58.2c6.7-4.4 15.1-5.2 22.5-2.2S411.4-.5 413 7.3l20.9 103.2 103.2 20.9c7.8 1.6 14.4 7 17.4 14.3s2.2 15.8-2.2 22.5l-58.2 87.8 58.2 87.8c4.4 6.7 5.2 15.1 2.2 22.5s-9.6 12.8-17.4 14.3L433.8 401.4 413 504.7c-1.6 7.8-7 14.4-14.3 17.4s-15.8 2.2-22.5-2.2l-87.8-58.2-87.8 58.2c-6.7 4.4-15.1 5.2-22.5 2.2s-12.8-9.6-14.3-17.4L143 401.4 39.7 380.5c-7.8-1.6-14.4-7-17.4-14.3s-2.2-15.8 2.2-22.5L82.7 256 24.5 168.2c-4.4-6.7-5.2-15.1-2.2-22.5s9.6-12.8 17.4-14.3L143 110.6 163.9 7.3c1.6-7.8 7-14.4 14.3-17.4zM207.6 256a80.4 80.4 0 1 1 160.8 0 80.4 80.4 0 1 1 -160.8 0zm208.8 0a128.4 128.4 0 1 0 -256.8 0 128.4 128.4 0 1 0 256.8 0z" />
                    </svg>
                    <span class="text-2xl font-extrabold text-blue-600 tracking-tight">PagiPagi Berita</span>
                </a>

                <!-- Menu (Desktop) -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('news.index') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">Beranda</a>
                    <a href="/admin" class="text-gray-700 hover:text-blue-600 font-medium transition">Admin</a>
                </div>

                <!-- Pencarian -->
                <div class="hidden md:block">
                    <form id="search-form" class="relative" onsubmit="return false;">
                        <input id="search-input" name="search" type="text" placeholder="Cari berita..."
                            autocomplete="off"
                            class="pl-10 pr-4 py-2 w-60 rounded-full border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-3 top-2.5 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.65 16.65z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-3 top-2.5"
                            viewBox="0 0 512 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                            <path fill="#205ae6"
                                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376C296.3 401.1 253.9 416 208 416 93.1 416 0 322.9 0 208S93.1 0 208 0 416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                        </svg>
                    </form>
                </div>

                <!-- Tombol Mobile -->
                <button @click="open = !open"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-blue-600 focus:outline-none transition">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menu Dropdown Mobile -->
        <div x-show="open" x-transition class="md:hidden bg-white border-t border-gray-200">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('news.index') }}"
                    class="block text-gray-700 hover:text-blue-600 font-medium">Beranda</a>
                <a href="#kategori" class="block text-gray-700 hover:text-blue-600 font-medium">Kategori</a>
                <a href="#trending" class="block text-gray-700 hover:text-blue-600 font-medium">Trending</a>
                <a href="#tentang" class="block text-gray-700 hover:text-blue-600 font-medium">Tentang</a>

                <form class="mt-3">
                    <input type="text" placeholder="Cari berita..."
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('container')
    </main>

    {{-- Script Search --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.querySelector('#search-input');
            const form = document.querySelector('#search-form');
            const container = document.querySelector('#search-results-container');

            if (!input || !container) return;

            // Cegah form reload
            form.addEventListener('submit', e => e.preventDefault());

            let timeout;

            input.addEventListener('input', () => {
                clearTimeout(timeout);
                const q = input.value.trim();

                if (q === '') {
                    container.innerHTML =
                        '<p class="text-center text-gray-500 italic col-span-3">Ketik untuk mencari berita...</p>';
                    return;
                }

                timeout = setTimeout(async () => {
                    try {
                        const res = await fetch(`/search?q=${encodeURIComponent(q)}`);
                        const data = await res.json();

                        if (data.length === 0) {
                            container.innerHTML =
                                `<p class="text-center text-gray-500 italic col-span-3">Tidak ada hasil untuk "${q}"</p>`;
                            return;
                        }

                        container.innerHTML = data.map(item => `
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-md border border-gray-200 hover:shadow-2xl hover:-translate-y-1 transition duration-300">
                        <div class="overflow-hidden h-52 bg-gray-200">
                            <img src="${item.thumbnail_url ?? `https://picsum.photos/id/${item.id}/1920/1080`}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700" />
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-700 transition">
                                <a href="/news/${item.id}">
                                    ${item.judul}
                                </a>
                            </h3>
                            <p class="text-gray-500 text-sm mb-4">
                                Oleh <span class="font-medium">${item.wartawan?.nama ?? 'Tidak diketahui'}</span> •
                                ${new Date(item.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}
                            </p>
                            <p class="text-gray-700 mb-5 leading-relaxed text-justify">
                                ${item.ringkasan ? item.ringkasan.slice(0, 130) + '...' : ''}
                            </p>
                            <a href="/news/${item.id}" class="text-blue-600 font-semibold hover:text-blue-800">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </div>
                `).join('');

                    } catch (err) {
                        console.error('Error:', err);
                    }
                }, 400);
            });
        });
    </script>

</body>

</html>
