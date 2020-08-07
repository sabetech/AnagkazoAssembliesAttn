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
        $exportArray[] = ['' => ''];
        $exportArray[] = $this->getSecondHeadings();

        $council_shepherd_ids_that_flowed = [];

        foreach ($this->council->persons as $person) {

            $row = [];
            $row[] = $person->name;
            $row[] = $person->rank;
            $row[] = (isset($person->Branch)) ? $person->Branch->branch_name : "";
            $row[] = $person->Council->council;
            $row[] = $person->wasPresent_council($this->date);
            $row[] = $person->getNumberOfShepherdsPresent($this->date);
            $row[] = $person->getNumberOfMembersPresent($this->date);

            $exportArray[] = $row;

            dd($person->getShepherdsPresent($this->date));

            //save the shepherds ids that were present for a council
            $council_shepherd_ids_that_flowed = array_merge(
                $council_shepherd_ids_that_flowed,
                $person->getShepherdsPresent($this->date)
            );
        }

        $exportArray[] = ['' => ''];

        $this->getDefaultingShepherds($council, $council_shepherd_ids_that_flowed);

        return $exportArray;
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

    public function getSecondHeadings(): array
    {
        return [
            'Name',
            'Rank',
            'Branch',
            'Council',
            'Was Present',
            'Number of Spepherds Who Watched',
            'Number of Members Who Watched'
        ];
    }

    public function getDefaultingShepherds(Council $council, array $idsThatFlowed)
    {
        $shepherdIds = $council->shepherds->pluck('id');
        dd($shepherdIds);
        //array_diff($idsThatFlowed,)
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->council->council;
    }
}
