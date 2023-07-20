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
        // Set empty message
        $this->setEmptyMessage('No system logs have been generated yet');
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
                ->format(
                    fn($value, $row, Column $column) => $this->getFacilityName($row, $column),
                )
                ->sortable()
                ->searchable(),
            Column::make("Priority", "Priority")
                ->format(
                    fn($value, $row, Column $column) => $this->getPriorityName($row, $column),
                )
                ->sortable()
                ->searchable(),
            Column::make('Message')
                ->sortable()
                ->searchable(),
        ];
    }

    /**
     * Gets the facility name from ID
     * 
     * @param Row    $row    The row
     * @param Column $column The column
     * 
     * @return string|NULL The facility name
     */
    public function getFacilityName($row, $column): ?string
    {
        $facilities = [
            0 => 'kern',
            1 => 'user',
            2 => 'mail',
            3 => 'daemon',
            4 => 'auth',
            5 => 'syslog',
            6 => 'lpr',
            7 => 'news',
            8 => 'uucp',
            9 => 'cron',
            10 => 'authpriv',
            11 => 'ftp',
            12 => 'ntp',
            13 => 'security',
            14 => 'console',
            15 => 'solaris-cron',
            16 => 'local0',
            17 => 'local1',
            18 => 'local2',
            19 => 'local3',
            20 => 'local4',
            21 => 'local5',
            22 => 'local6',
            23 => 'local7',
        ];
        return $facilities[$row->Facility];
    }

    /**
     * Gets the priority name from ID
     * 
     * @param Row    $row    The row
     * @param Column $column The column
     * 
     * @return string|NULL The priority name
     */
    public function getPriorityName($row, $column): ?string
    {
        $priorities = [
            0 => 'emergency',
            1 => 'alert',
            2 => 'critical',
            3 => 'error',
            4 => 'warning',
            5 => 'notice',
            6 => 'info',
            7 => 'debug',
        ];
        return $priorities[$row->Priority];
    }

}
