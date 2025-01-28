<?php

namespace App\Exports;

use App\Models\ImportedFile;
use App\Models\Product;
use App\Models\VariantProduct;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Collection;

class VideosExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $video_list;

    public function __construct($video_list)
    {
        $this->video_list = $video_list;
    }
    public function collection()
    {
        
        $counter = 1;
        $this->video_list->transform(function ($item) use (&$counter, &$request) {
            // dd($item);
            $item['ser_id'] = $counter++;

            $item['sku'] = isset($item['sku']) ? $item['sku'] : '-';
            if(isset($item->status) && $item->status == 'Completed')
            {
                $item['status'] = 'Completed';
                $item['url'] = asset('product_media/product_videos/'.$item->name);
            }else{
                $item['status'] = 'Product Not Found';
                $item['url'] = asset('product_media/failed_videos/'.$item->name);
            }
            
            $item['f_updated_at'] = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
            return $item;
        });
        return $this->video_list;
    }
    public function headings(): array
    {
        return [
            'Sr no.',
            'SKU',
            'Video URL',
            'Status',
            'Updated At'
        ];
    }
    public function map($item): array
    {
        return [
            $item['ser_id'],
            $item['sku'],
            $item['url'],
            $item['status'],
            $item['f_updated_at']
        ];
    }
}
