@php
$pdf_sec = App\Models\MediaSection::where('id', $section->section_id)->first();
$pdf_list = App\Models\PdfList::where('type', $pdf_sec->slug)->where('status', 1)->latest()->get();
@endphp

@if(isset($pdf_list) && $pdf_list->isNotEmpty())

<section class="common-padding common-section pdf-section">
    <div class="container-md">
        @if($section->checked_title == 1)
            <h2>{{$section->title}}</h2>
        @endif
        
        <div class="pdf-logo-icon owl-loaded">
        @foreach($pdf_list as $pdf_list_value)
            <div class="gallery-item">
                    @if(isset($pdf_list_value->file) && $pdf_list_value->file != '')
                        <a href="{{asset('uploads/pdf_file/'.$pdf_list_value->file)}}" class="product-logo-icon-link" target="new">
                    @endif
                    @if(isset($pdf_list_value->cover_image) && $pdf_list_value->cover_image != null)
                        <img src="{{ asset('uploads/media/'. $pdf_list_value->cover_image) }}" alt="{{ isset($pdf_list_value->name) ? $pdf_list_value->name : '' }}">
                    @else
                        <img src="{{ asset('uploads/Group 1645.jpg') }}" alt="{{ isset($pdf_list_value->name) ? $pdf_list_value->name : '' }}">
                    @endif
                    @if(isset($pdf_list_value->file) && $pdf_list_value->file != '')
                        </a>
                    @endif
                    @if(isset($pdf_list_value->title) && $pdf_list_value->title != '')
                        <h4>{{$pdf_list_value->title}}</h4>
                    @endif
            </div>
        @endforeach
        </div>
    </div>
</section>
@endif



