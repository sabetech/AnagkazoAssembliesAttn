<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromArray;
use App\Person;

class ExportAttendance implements FromArray
{

    protected $date;
    protected $filter_option;

    public function __construct($date, $filter_option)
    {
        $this->date = $date;
        $this->filter_option = $filter_option;
    }

    public function array(): array
    {
        $allPersons = Person::getAllPerson();
        $exportArray = [];
        $exportArray[] = ['Name', 'Council', 'Status', 'TV or Online'];

        foreach($allPersons as $person){
            $row = [];
            if ($this->filter_option == 'filled') {
                if (! $person->wasPresent($this->date)){
                    continue;
                }
            }

            if ($this->filter_option == 'not_filled') {
                if ($person->wasPresent($this->date)){
                    continue;
                }
            }

            $row[] = $person->name;
            $row[] = $person->Council->council;
            $row[] = ($person->wasPresent($this->date) ? "Form Filled" : "Form Not Filled");
            $row[] = $person->tvOrOnline;
            
            $exportArray[] = $row;
        }

        return $exportArray;
    }
}