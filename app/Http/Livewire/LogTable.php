<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Log;

class LogTable extends DataTableComponent
{
    protected $model = Log::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('datetime', 'desc');
        $this->setRefreshTime(2000);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->hideIf(TRUE),
            Column::make("Received", "datetime")
                ->sortable()
                ->searchable(),
            Column::make("Level", "level_name")
                ->sortable()
                ->searchable(),
            Column::make('Message', 'message')
                ->sortable()
                ->searchable(),
        ];
    }

}
