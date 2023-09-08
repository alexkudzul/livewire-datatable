<?php

namespace App\Exports;

use App\Models\Article;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArticlesExport implements FromCollection
{
    public $articles;

    public function __construct($articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->articles;
    }
}
