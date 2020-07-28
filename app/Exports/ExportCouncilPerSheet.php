<?php

namespace App\Exports\Sheets;

use App\Council;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportCouncilPerSheet implements FromArray, WithTitle
{
    private $council;
    private $date;

    public function __construct($council, $date)
    {
        $this->council = $council;
        $this->date = $date;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $exportArray = [];
        $exportArray[] = $this->headings();
        $exportArray[] = $this->getFirstSummaries($this->council);
        $exportArray[] = [];

        foreach ($this->council->persons as $person) {

            $row = [];
            $row[] = $person->name;
            $row[] = $person->rank;
            $row[] = $person->Branch->branch_name;
            $row[] = $person->Council->council;

            $exportArray[] = $row;
        }



        return [];
    }

    public function headings(): array
    {
        return [
            'Pastors Who FLOWED',
            'Minister Shepherds Who FLOWED',
            'Number of GWOs who FLOWED',
            'Number of Shepherds Who FLOWED',
            'Number of Members Who FLOWED'
        ];
    }

    public function getFirstSummaries($council): array
    {
        $row = [];
        $row[] = $council->getPastorsFlowRatio($this->date);
        $row[] = $council->getMinisterShepheredFlowRatio($this->date);
        $row[] = $council->getGWO_FlowRatio($this->date);
        $row[] = $council->getShepherdsWhoFlowed($this->date) . ' / ' . $council->getTotalShepherds()->count();
        $row[] = $council->getTotalMembersWhoFlowed($this->date) . '/' . $council->getTotalMembersAvg();

        return $row;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Month ' . $this->council->council;
    }
}
