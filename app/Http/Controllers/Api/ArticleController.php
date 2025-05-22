<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
        public function index()
    {
        // Ambil semua artikel dengan relasi vet
        $articles = Article::with('vet')->get();

        return response()->json([
            'success' => true,
            'data' => $articles
        ]);
    }


    public function getByVet($vet_id)
    {
        $articles = Article::with('vet')->where('vet_id', $vet_id)->get();

        return response()->json([
            'success' => true,
            'data' => $articles
        ]);
    }
}
