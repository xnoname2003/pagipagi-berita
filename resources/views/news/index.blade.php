@extends('layouts.main')

@section('container')
    <div class="max-w-7xl mx-auto py-12">

        {{-- Hero Section Utama --}}
        <div id="heroSection">
            @php
                $headline = $headline ?? null;
            @endphp

            @if ($headline)
                <div class="mb-16 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                    <div class="overflow-hidden rounded-3xl shadow-xl border border-gray-200">
                        <img src="{{ $headline->thumbnail_url ?? "https://picsum.photos/id/{$headline->id}/1920/1080" }}"
                            class="w-full h-[380px] md:h-[450px] object-cover hover:scale-105 transition duration-700" />
                    </div>

                    <div>
                        <span class="text-blue-600 font-semibold tracking-wide uppercase">Berita Utama</span>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-3 leading-tight">
                            {{ $headline->judul }}
                        </h1>
                        <p class="text-gray-500 mt-3 text-sm">
                            Oleh <span class="font-medium">{{ $headline->wartawan->nama }}</span>
                            • {{ $headline->created_at->format('d M Y') }}
                        </p>
                        <p class="text-gray-700 mt-5 text-lg leading-relaxed text-justify">
                            {{ Str::limit($headline->ringkasan, 220) }}
                        </p>
                        <a href="{{ route('news.show', $headline->id) }}"
                            class="mt-6 inline-block px-6 py-3 text-white font-semibold bg-blue-600 hover:bg-blue-700
                        rounded-lg shadow-md transition">
                            Baca Berita Utama →
                        </a>
                    </div>
                </div>
            @endif
        </div>

        @if ($beritaLain->isEmpty())
            <p class="text-center text-gray-500 italic col-span-3">
                Tidak ada berita yang cocok dengan kata kunci "{{ request('search') }}"
            </p>
        @endif


        {{-- Daftar Berita Lainnya --}}
        <div id="search-results-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach ($beritaLain as $news)
                <div
                    class="group bg-white rounded-2xl overflow-hidden shadow-md border border-gray-200
                    hover:shadow-2xl hover:-translate-y-1 transition duration-300">

                    {{-- Thumbnail --}}
                    <div class="overflow-hidden h-52 bg-gray-200">
                        <img src="{{ $news->thumbnail_url ?? 'https://picsum.photos/id/' . $news->id . '/1920/1080' }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700" />
                    </div>

                    {{-- Text --}}
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-700 transition ">
                            <a href="{{ route('news.show', $news->id) }}">
                                {{ $news->judul }}
                            </a>
                        </h3>

                        <p class="text-gray-500 text-sm mb-4">
                            Oleh <span class="font-medium">{{ $news->wartawan->nama }}</span> •
                            {{ $news->created_at->format('d M Y') }}
                        </p>

                        <p class="text-gray-700 mb-5 leading-relaxed text-justify">
                            {{ Str::limit($news->ringkasan, 130) }}
                        </p>

                        <a href="{{ route('news.show', $news->id) }}"
                            class="text-blue-600 font-semibold hover:text-blue-800">
                            Baca Selengkapnya →
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-12 justify-center">
            {{ $beritaLain->links('pagination::tailwind') }}
        </div>
    </div>

    <script>
        const searchInput = document.querySelector('#searchInput');
        const container = document.querySelector('#search-results-container');
        const heroSection = document.querySelector('#heroSection');
        const paginationSection = document.querySelector('#paginationSection');

        function renderNews(data) {
            container.innerHTML = '';

            if (!data.length) {
                container.innerHTML = `
        <p class="text-center text-gray-500 italic col-span-3">
          Tidak ada berita yang cocok dengan kata kunci "${searchInput.value}"
        </p>
      `;
                return;
            }

            data.forEach(news => {
                container.innerHTML += `
        <div class="group bg-white rounded-2xl overflow-hidden shadow-md border border-gray-200 hover:shadow-2xl hover:-translate-y-1 transition duration-300">
          <div class="overflow-hidden h-52 bg-gray-200">
            <img src="https://picsum.photos/id/${news.id}/1920/1080" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" />
          </div>
          <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-700 transition">
              <a href="/news/${news.id}">${news.judul}</a>
            </h3>
            <p class="text-gray-500 text-sm mb-4">
              Oleh <span class="font-medium">${news.wartawan?.nama ?? 'Tidak diketahui'}</span> • ${new Date(news.created_at).toLocaleDateString('id-ID')}
            </p>
            <p class="text-gray-700 mb-5 leading-relaxed text-justify">${news.isi.substring(0, 130)}...</p>
            <a href="/news/${news.id}" class="text-blue-600 font-semibold hover:text-blue-800">Baca Selengkapnya →</a>
          </div>
        </div>
      `;
            });
        }

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (query === '') {
                // tampilkan kembali hero dan pagination kalau search kosong
                heroSection.style.display = '';
                paginationSection.style.display = '';

                // reload daftar awal
                fetch(`/search?q=`)
                    .then(res => res.json())
                    .then(data => renderNews(data))
                    .catch(err => console.error(err));
                return;
            }

            // sembunyikan hero & pagination saat sedang search
            heroSection.style.display = 'none';
            paginationSection.style.display = 'none';

            fetch(`/search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => renderNews(data))
                .catch(err => console.error(err));
        });
    </script>
    
@endsection
