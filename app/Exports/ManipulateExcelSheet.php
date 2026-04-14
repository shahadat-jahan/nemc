<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 4/5/19
 * Time: 12:19 PM
 */

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class ManipulateExcelSheet implements WithEvents
{

    protected $rowToMerge;

    public function __construct($rowToMerge)
    {
        $this->rowToMerge = $rowToMerge;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->setCreator('North East Medical College');
            },
            AfterSheet::class    => function(AfterSheet $event) {

                $maxColumn = $event->sheet->getDelegate()->getHighestColumn();
                $maxRow = $event->sheet->getDelegate()->getHighestRow();

                $centerAlign = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                ];

                $i=1;

                $event->sheet->getDelegate()->calculateColumnWidths();
                $event->sheet->getDelegate()->getStyle('A7:'.$maxColumn.$maxRow)->getAlignment()->setWrapText(true);

                while ($i <= $this->rowToMerge){
                    $event->sheet->mergeCells('A'.$i.':'.$maxColumn.$i);
                    $event->sheet->getDelegate()->getStyle('A'.$i.':'.$maxColumn.$i)->applyFromArray($centerAlign);
                    $i++;
                }

            },
        ];
    }

}