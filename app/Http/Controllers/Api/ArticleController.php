<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Menampilkan semua artikel.
     */
    public function index()
    {
        $articles = Article::select('id', 'judul', 'gambar')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar semua artikel',
            'data' => $articles
        ]);
    }

    /**
     * Menampilkan detail artikel berdasarkan ID.
     */
    public function show($id)
    {
        $article = Article::with('vet')->find($id);

        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail artikel ditemukan',
            'data' => $article
        ]);
    }
}
