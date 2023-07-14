<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Syslog;

class SyslogTable extends DataTableComponent
{
    protected $model = Syslog::class;

    public function configure(): void
    {
        $this->setPrimaryKey('ID');
        $this->setDefaultSort('ReceivedAt', 'desc');
        $this->setRefreshTime(2000);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "ID")
                ->sortable()
                ->hideIf(TRUE),
            Column::make("Received", "ReceivedAt")
                ->sortable()
                ->searchable(),
            Column::make("Facility", "Facility")
                ->sortable()
                ->searchable(),
            Column::make("Priority", "Priority")
                ->sortable()
                ->searchable(),
            Column::make('Message')
                ->sortable()
                ->searchable(),
        ];
    }

}
