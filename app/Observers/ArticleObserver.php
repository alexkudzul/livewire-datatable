<?php

namespace App\Observers;

use App\Models\Article;

class ArticleObserver
{
    public function creating(Article $article)
    {
        // Busca el mayor de sort y le suma 1
        $article->sort = Article::max('sort') + 1;
    }
}
