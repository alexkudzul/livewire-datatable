<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;

class ArticleTable extends DataTableComponent
{
    // protected $model = Article::class; // Using the builder method

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('Orden', 'sort')
                ->sortable(),
            Column::make('Título', 'title')
                ->sortable(),
            Column::make('Publicado', 'is_published')
                ->sortable(),
            Column::make("Fecha creación", "created_at")
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return Article::query()
            ->with('user');
    }
}
