<?php

namespace App\Exports\Sheets;

use App\Council;
use App\Shepherd;
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

        $pastorShepherdArrayThatFlowed = [];
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

            $personShepherdIDs = is_array($person->getShepherdsPresent($this->date)) ?
                $person->getShepherdsPresent($this->date) : [];

            foreach ($personShepherdIDs as $personShepherd_id) {
                $shepherd = Shepherd::find($personShepherd_id);
                if (!$shepherd) continue;
                $pastorShepherdArrayThatFlowed[] = [$person->name, $shepherd->shepherd_name];
            }
            //save the shepherds ids that were present for a council
            $council_shepherd_ids_that_flowed = array_merge(
                $council_shepherd_ids_that_flowed,
                is_array($person->getShepherdsPresent($this->date)) ?
                    $person->getShepherdsPresent($this->date) : []
            );
        }

        $exportArray[] = ['' => ''];
        $exportArray[] = ['SHEPHERDS'];
        $exportArray[] = ['Pastor/GWO/Minister Shepherds', 'Shepherd Name Who Flowed', 'List of Defaulting Shepherds', 'Branch/Assigned_pastor'];

        $lastRowOfExportSoFar = count($exportArray);

        foreach ($pastorShepherdArrayThatFlowed as $pastor_shepherd_row) {
            $exportArray[] = $pastor_shepherd_row;
        }

        $defaultingNames = $this->getDefaultingShepherds($council_shepherd_ids_that_flowed);

        foreach ($defaultingNames as $key => $shepherd) {
            $exportArray[$lastRowOfExportSoFar][4] = $shepherd->shepherd_name;
            $exportArray[$lastRowOfExportSoFar++][5] = ($shepherd->getAssigned() == true) ? $shepherd->getAssigned() : '';
        }
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

    public function getDefaultingShepherds(array $idsThatFlowed)
    {
        $shepherdIds = $this->council->shepherds->pluck('id')->toArray();
        $defaultingShepherd = [];
        $defaultingIDs = array_diff($shepherdIds, $idsThatFlowed);

        if (count($defaultingIDs) == 0) return [];

        foreach ($defaultingIDs as $defaultingID) {

            $shepherd = Shepherd::find($defaultingID);
            $defaultingShepherd[] = $shepherd;
        }
        return $defaultingShepherd;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->council->council;
    }
}
