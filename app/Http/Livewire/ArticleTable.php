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
        // Clickable Rows
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function ($row) {
                return route('welcome');
            })
            ->setTableRowUrlTarget(function ($row) {
                return '_blank';
            });

        // Sorting
        $this->setDefaultSort('id', 'asc');
        // Deshabilite la clasificación única para todo el componente.
        $this->setSingleSortingDisabled(); // Multi-column sorting

        // Pagination
        $this->setPageName('pagina');
        $this->setPerPageAccepted([
            10,
            25,
            50,
            100,
            -1 // Todo
        ]);
        $this->setPerPage(10);
        $this->setPaginationStatus(true); // enable/disable pagination for the component.
        $this->setPerPageVisibilityStatus(true); // enable/disable per page visibility.

    }

    public function columns(): array
    {
        return [
            Column::make('id')
                ->sortable(fn (Builder $query, string $direction) => $query->orderBy('id', $direction))
                ->collapseOnTablet(),
            Column::make('Autor', 'user.name')
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make('Título', 'title')
                ->sortable()
                ->searchable(
                    fn (Builder $query, $searchTerm) => $query->orWhere('title', 'like', '%' . $searchTerm . '%')
                )
                ->unclickable(),
            BooleanColumn::make('Publicado', 'is_published')
                ->sortable()
                ->collapseOnTablet(),
            ImageColumn::make('Imagen')
                ->location(fn () => 'https://cdn-icons-png.flaticon.com/128/2111/2111748.png')
                ->collapseOnTablet(),
            Column::make("Fecha creación", "created_at")
                ->sortable()
                ->format(
                    fn ($value) => $value->format('d/m/Y')
                )
                ->collapseOnTablet(),
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
                ])
                ->collapseOnTablet()
                ->unclickable(),
            // If you have a column that is not associated with a database column, you can chain the label method
            Column::make('Action with view')
                ->label(
                    fn ($row) => view('articles.tables.action', ['id' => $row->id])
                )
                ->collapseOnTablet()
                ->unclickable(),
        ];
    }

    public function builder(): Builder
    {
        return Article::query()
            ->with('user');
    }
}
