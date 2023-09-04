<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class ArticleTable extends DataTableComponent
{
    // protected $model = Article::class; // Using the builder method

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'asc');
        // Deshabilite la clasificación única para todo el componente.
        $this->setSingleSortingDisabled(); // Multi-column sorting
    }

    public function columns(): array
    {
        return [
            Column::make('id')
                ->sortable(fn (Builder $query, string $direction) => $query->orderBy('id', $direction)),
            Column::make('Autor', 'user.name')
                ->sortable()
                ->searchable(),
            Column::make('Título', 'title')
                ->sortable()
                ->searchable(
                    fn (Builder $query, $searchTerm) => $query->orWhere('title', 'like', '%' . $searchTerm . '%')
                ),
            BooleanColumn::make('Publicado', 'is_published')
                ->sortable(),
            ImageColumn::make('Imagen')
                ->location(fn () => 'https://cdn-icons-png.flaticon.com/128/2111/2111748.png'),
            Column::make("Fecha creación", "created_at")
                ->sortable()
                ->format(
                    fn ($value) => $value->format('d/m/Y')
                ),
            ButtonGroupColumn::make('Action')
                ->buttons([
                    LinkColumn::make('Ver')
                        ->title(fn () => 'Ver')
                        ->location(fn ($row) => route('dashboard', [
                            'prueba' => $row->id,
                        ]))
                        ->attributes(fn () => [
                            'class' => 'btn btn-green',
                        ]),
                    LinkColumn::make('Editar')
                        ->title(fn () => 'Editar')
                        ->location(fn ($row) => route('dashboard', [
                            'prueba' => $row->id,
                        ]))
                        ->attributes(fn () => [
                            'class' => 'btn btn-blue',
                        ]),
                ]),
            // If you have a column that is not associated with a database column, you can chain the label method
            Column::make('Action with view')
                ->label(
                    fn ($row) => view('articles.tables.action', ['id' => $row->id])
                ),
        ];
    }

    public function builder(): Builder
    {
        return Article::query()
            ->with('user');
    }
}
