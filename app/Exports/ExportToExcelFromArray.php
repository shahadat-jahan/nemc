<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportToExcelFromArray implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    private $fromArray;
    private $headings;

    public function __construct($headings,$fromArray)
    {
        $this->fromArray = $fromArray;
        $this->headings = $headings;
    }

    public function array(): array
    {
        return $this->fromArray;
    }

    public function headings(): array
    {
        //$headings is the array of column name
        $headings = $this->headings;
        return $headings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:Z1'; // All headers
                $event->sheet->freezePane('A2');
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
