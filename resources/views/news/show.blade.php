@extends('layouts.main')

@section('container')

    <div id="progressBar"></div>

    {{-- Jumbotron --}}
    <div class="relative w-full h-[520px] rounded-3xl overflow-hidden shadow-2xl mb-14">
        <img src="https://picsum.photos/id/{{ $news->id }}/1920/1080" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/60 to-black/80"></div>
        <div class="absolute bottom-14 left-12 max-w-3xl">
            <h1 class="text-white text-5xl md:text-6xl font-extrabold leading-tight drop-shadow-xl">
                {{ $news->judul }}
            </h1>
        </div>
    </div>

    {{-- Content Utama --}}
    <div class="max-w-4xl mx-auto">
        {{-- Nama Penulis --}}
        <div class="flex items-center gap-5 mb-10 bg-white p-6 rounded-2xl shadow-md border border-gray-100">
            <img src="https://i.pravatar.cc/200?u={{ $news->wartawan->id }}"
                class="w-20 h-20 rounded-full object-cover shadow">
            <div>
                <p class="text-sm text-gray-500">Penulis</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $news->wartawan->nama }}</h3>
                <p class="text-gray-500 text-sm mt-1">
                    Dipublikasikan {{ $news->created_at->format('d M Y • H:i') }} 
                </p>
            </div>
        </div>

        {{-- Isi Berita --}}
        <article class="bg-white p-12 rounded-3xl shadow-xl border border-gray-100 mb-16">
            <div class="prose max-w-none text-justify leading-relaxed text-[20px] text-gray-800">
                <span class="float-left text-7xl font-black text-gray-900 mr-4 mt-3 leading-none select-none">
                    {{ Str::substr(strip_tags($news->isi), 0, 1) }}
                </span>
                {{ nl2br(e(Str::substr(strip_tags($news->isi), 1))) }}
            </div>
        </article>

        @php
            $related = \App\Models\News::where('id', '!=', $news->id)->latest()->get();
        @endphp

        {{-- Berita Terkait --}}
        @if ($related->count() > 0)
            <div class="mb-20" x-data="{ index: 0 }">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Berita Terkait</h2>

                <div class="relative">
                    {{-- Tombol kiri --}}
                    <button @click="index = Math.max(index - 1, 0)"
                        class="absolute left-4 top-1/2 -translate-y-1/2 z-20 flex items-center justify-center 
                                w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-blue-400 text-white 
                                shadow-lg hover:scale-110 hover:shadow-xl transition-all duration-200 
                                focus:outline-none focus:ring-4 focus:ring-blue-300 cursor-pointer active:scale-95"
                        x-show="index > 0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span class="sr-only">Sebelumnya</span>
                    </button>

                    {{-- Container berita --}}
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-700 ease-in-out"
                            :style="'transform: translateX(-' + (index * 100) + '%)'">
                            @foreach ($related->chunk(3) as $chunk)
                                <div class="flex-shrink-0 w-full grid grid-cols-1 md:grid-cols-3 gap-8 px-2">
                                    @foreach ($chunk as $item)
                                        <a href="{{ route('news.show', $item->id) }}"
                                            class="group rounded-xl overflow-hidden shadow hover:shadow-xl border border-gray-200 transition">
                                            <img src="https://picsum.photos/id/{{ $item->id }}/600/400"
                                                class="w-full h-40 object-cover group-hover:scale-110 transition duration-700">
                                            <div class="p-5">
                                                <h4
                                                    class="font-bold text-gray-900 text-lg group-hover:text-blue-600 transition">
                                                    {{  Str::limit($item->title, 60) }}
                                                </h4>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ $item->wartawan->nama }} • {{ $item->created_at->format('d M Y H:i') }}
                                                </p>
                                                <p class="text-gray-600 text-sm mt-3">
                                                    {{ Str::limit(strip_tags($item->isi), 80) }}
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Tombol kanan --}}
                    <button @click="index = Math.min(index + 1, {{ ceil($related->count() / 3) - 1 }})"
                        class="absolute right-4 top-1/2 -translate-y-1/2 z-20 flex items-center justify-center 
                                w-12 h-12 rounded-full bg-gradient-to-l from-blue-600 to-blue-400 text-white 
                                shadow-lg hover:scale-110 hover:shadow-xl transition-all duration-200 
                                focus:outline-none focus:ring-4 focus:ring-blue-300 cursor-pointer active:scale-95"
                        x-show="index < {{ ceil($related->count() / 3) - 1 }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="sr-only">Berikutnya</span>
                    </button>
                </div>

                {{-- Indikator bulat --}}
                <div class="flex justify-center mt-5 space-x-2">
                    @for ($i = 0; $i < ceil($related->count() / 3); $i++)
                        <div class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300"
                            :class="index === {{ $i }} ? 'bg-blue-600 scale-110' : 'bg-gray-300 hover:bg-gray-400'"
                            @click="index = {{ $i }}">
                        </div>
                    @endfor
                </div>
            </div>
        @endif

        {{-- Form Komentar --}}
        <div class="bg-white p-10 rounded-2xl shadow-xl border border-gray-100 mb-14">
            <h3 class="text-3xl font-bold text-gray-800 mb-6">Tinggalkan Komentar</h3>

            <div id="alert-success"
                class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                Komentar berhasil dikirim!
            </div>

            <form id="formKomentar" class="space-y-6" data-url="{{ route('komentar.store', $news->id) }}">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Nama</label>
                    <input type="text" name="nama"
                        class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-300 transition">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Komentar</label>
                    <textarea name="isi" rows="4"
                        class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-300 transition"></textarea>
                </div>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition">
                    Kirim Komentar
                </button>
            </form>
        </div>

        {{-- Daftar Komentar --}}
        <div id="komentarList" class="bg-white p-10 rounded-2xl shadow-xl border border-gray-100 mb-20">
            <h3 class="text-3xl font-bold text-gray-800 mb-8">Komentar</h3>

            @if ($news->komentar->count() == 0)
                <p class="text-gray-500 italic">Belum ada komentar.</p>
            @else
                <div class="space-y-6">
                    @foreach ($news->komentar as $komen)
                        @php
                            $initials = collect(explode(' ', $komen->nama))
                                ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                ->join('');
                        @endphp

                        <div class="border-b border-gray-200 pb-4 flex gap-4 items-start hover:bg-blue-50 p-2 rounded-lg transition">
                            <img src="https://ui-avatars.com/api/?name={{ $initials }}&background=2563eb&color=fff&size=128"
                                class="w-12 h-12 rounded-full shadow">
                            <div>
                                <p class="font-bold text-gray-900 text-lg">{{ $komen->nama }} | <span
                                        class="text-gray-400 text-sm">
                                        {{ $komen->created_at->format('d M Y H:i') }}
                                    </span>
                                </p>
                                <p class="text-gray-700 leading-relaxed text-justify">{{ $komen->isi }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('#formKomentar');
            const komentarList = document.querySelector('#komentarList .space-y-6') || document.createElement(
                'div');
            const alertBox = document.querySelector('#alert-success');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const url = form.getAttribute('data-url');
                const formData = new FormData(form);

                const btn = form.querySelector('button');
                btn.disabled = true;
                btn.textContent = 'Mengirim...';

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await res.json();

                    if (data.status === 'success' || data.komentar) {
                        alertBox.classList.remove('hidden');
                        form.reset();

                        const tanggalFormatted = data.komentar.waktu;
                        const div = document.createElement('div');
                        div.className = 'border-b border-gray-200 pb-4 flex gap-4 items-start hover:bg-blue-50 p-2 rounded-lg transition';
                        div.innerHTML = `
                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data.komentar.nama)}&background=2563eb&color=fff&size=128"
                                class="w-12 h-12 rounded-full shadow">
                            <div>
                                <p class="font-bold text-gray-900 text-lg">
                                    ${data.komentar.nama} | 
                                    <span class="text-gray-400 text-sm">${tanggalFormatted}</span>
                                </p>
                                <p class="text-gray-700 leading-relaxed text-justify">${data.komentar.isi}</p>
                            </div>
                        `;

                        const komentarContainer = document.querySelector('#komentarList .space-y-6');
                        const belumAda = document.querySelector('#komentarList p.text-gray-500');

                        if (!komentarContainer) {
                            const newContainer = document.createElement('div');
                            newContainer.classList.add('space-y-6');
                            newContainer.appendChild(div);

                            if (belumAda) belumAda.remove();

                            document.querySelector('#komentarList').appendChild(newContainer);
                        } else {
                            komentarContainer.prepend(div);

                            if (belumAda) belumAda.remove();
                        }

                        setTimeout(() => alertBox.classList.add('hidden'), 2000);
                    }
                    else {
                        alert('Gagal mengirim komentar.');
                        console.error('Respon tidak sesuai:', data);
                    }
                } catch (err) {
                    console.error('Error:', err);
                    alert('Gagal mengirim komentar.');
                }

                btn.disabled = false;
                btn.textContent = 'Kirim Komentar';
            });
        });
    </script>

@endsection
