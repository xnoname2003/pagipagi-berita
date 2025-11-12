<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Komentar;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index(Request $request)
    {
        $keyword = $request->input('search');

        // Query dasar
        $query = News::with('wartawan', 'komentar')->latest();

        // Jika user mengetik sesuatu
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('ringkasan', 'like', "%{$keyword}%")
                    ->orWhere('isi', 'like', "%{$keyword}%")
                    ->orWhereHas('wartawan', function ($qw) use ($keyword) {
                        $qw->where('nama', 'like', "%{$keyword}%");
                    });
            });
        }

        $headline = $query->first();
        $beritaLain = $query->skip(1)->paginate(9);

        return view('news.index', compact('headline', 'beritaLain', 'keyword'));
    }

    public function show(News $news)
    {
        // load relasi wartawan dan komentar
        $news->load('wartawan', 'komentar')->latest();


        return view('news.show', [
            'news' => $news
        ]);
    }

    public function storeKomentar(Request $request, News $news)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'isi' => 'required|string|max:1000',
        ]);

        $komentar = $news->komentar()->create($validated);

        // Jika request datang dari AJAX
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Komentar berhasil dikirim!',
                'komentar' => [
                    'nama' => $komentar->nama,
                    'isi' => $komentar->isi,
                    'waktu' => $komentar->created_at->format('d M Y H:i'),
                ],
            ]);
        }

        // fallback jika bukan AJAX
        return redirect()->route('news.show', $news->id)->with('success', \Log::info('Komentar berhasil disimpan', $validated));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q', '');

        // Jika kolom pencarian kosong, tampilkan semua berita
        if (trim($keyword) === '') {
            $news = News::with('wartawan')
                ->latest()
                ->take(12)
                ->get(['id', 'judul', 'isi', 'wartawan_id', 'created_at']);

            return response()->json($news);
        }

        // Jika ada kata kunci, lakukan pencarian
        $news = News::with('wartawan')
            ->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('isi', 'like', "%{$keyword}%")
                    ->orWhereHas('wartawan', function ($qw) use ($keyword) {
                        $qw->where('nama', 'like', "%{$keyword}%");
                    });
            })
            ->latest()
            ->take(12)
            ->get(['id', 'judul', 'isi', 'wartawan_id', 'created_at']);

        return response()->json($news);
    }





}
