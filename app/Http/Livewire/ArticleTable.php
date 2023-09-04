<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

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
            Column::make('id')
                ->sortable(),
            Column::make('Autor', 'user.name')
                ->sortable(),
            Column::make('Título', 'title')
                ->sortable(),
            BooleanColumn::make('Publicado', 'is_published')
                ->sortable(),
            Column::make("Fecha creación", "created_at")
                ->sortable(),
            LinkColumn::make('Action')
                ->title(fn () => 'Editar')
                ->location(fn ($row) => route('dashboard', [
                    'prueba' => $row->id,
                ]))
                ->attributes(fn () => [
                    'class' => 'btn btn-blue',
                ]),
        ];
    }

    public function builder(): Builder
    {
        return Article::query()
            ->with('user');
    }
}
