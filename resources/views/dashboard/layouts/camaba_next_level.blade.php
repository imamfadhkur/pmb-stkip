<h4>
    Informasi Terbaru:
</h4>
{{-- @php
    $data = optional(App\Models\Informasi::where('jenis' , 'daftar-ulang')->get())->first();
@endphp
@if ($data !== null)
    {!! $data->content !!}
@endif --}}