<?php

namespace App\Exports;

use App\Models\ProductImage;
use App\Models\FailedProductImage;
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

class ImagesExport implements FromCollection, WithHeadings, WithMapping, WithDrawings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $paginatedList;

    public function __construct($paginatedList)
    {
        $this->paginatedList = $paginatedList;
    }
    public function collection()
    {
        // Transform the data
        $counter = 1;
        $this->paginatedList = $this->paginatedList->map(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;

            if (isset($item['name']) && $item['name'] != null) {
                if ($item instanceof ProductImage) {
                    $url = public_path('product_media/product_images/300/' . $item['name']);
                } else {
                    $url = public_path('product_media/failed_images/' . $item['name']);
                }
                $item['img'] = $url; // Store URL for Excel export
                $this->images[$counter] = $url; // Store images for use in drawings
            }
            $item['url'] = isset($url) ? $url : '';
            if (isset($item['product_id']) && $item['product_id'] != null) {
                if ($item['type'] == 'simple') {
                    $product = Product::where('id', $item['product_id'])->first();
                } else {
                    $product = VariantProduct::where('id', $item['product_id'])->first();
                }
            }

            if ($item instanceof ProductImage) {
                $item['sku'] = isset($product->p_sku) ? $product->p_sku : '-';
                $item['status'] = 'Completed';
            } else {
                $item['sku'] = isset($item['sku']) ? $item['sku'] : '-';
                $item['status'] = 'Product not found';
            }
            $item['i_priority'] = isset($item->priority) ? $item->priority : '-';
            $item['f_updated_at'] = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
            return $item;
        });

        return $this->paginatedList;
        
    }
    public function headings(): array
    {
        return [
            'Sr no.',
            'SKU',
            'Image',
            'Image URL',
            'Status',
            'Priority',
            'Updated At'
        ];
    }
    public function map($item): array
    {
        return [
            $item['ser_id'],
            $item['sku'],
            '', // Placeholder for image
            $item['url'],
            $item['status'],
            $item['i_priority'],
            $item['f_updated_at']
        ];
    }
    public function drawings()
    {
        $drawings = [];
        $row = 2; // Start after header row

        foreach ($this->images as $row => $path) {
            $drawing = new Drawing();
            $drawing->setName('Image');
            $drawing->setDescription('Image');
            $drawing->setPath($path);
            $drawing->setHeight(70);
            $drawing->setCoordinates('C' . $row);
            $drawings[] = $drawing;
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Adjust column width for better appearance
                $sheet->getColumnDimension('A')->setWidth(10);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(15); // Adjust width for images
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(20);
                $sheet->getColumnDimension('G')->setWidth(20);

                // Center the images and set row height
                foreach ($this->images as $row => $path) {
                    $sheet->getRowDimension($row)->setRowHeight(70); // Match image height
                    $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal('center')->setVertical('center');
                }
            },
        ];
    }
}
