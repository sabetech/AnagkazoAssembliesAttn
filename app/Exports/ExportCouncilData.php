<?php

namespace App\Exports;

use App\Council;
use App\Exports\Sheets\ExportCouncilPerSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportCouncilData implements WithMultipleSheets
{
    use Exportable;
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $allCouncils = Council::all();
        foreach ($allCouncils as $council) {
            $sheets[] = new ExportCouncilPerSheet($council, $this->date);
        }

        return $sheets;
    }
}
