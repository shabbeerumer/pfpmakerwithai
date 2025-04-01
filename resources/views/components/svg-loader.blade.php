@props(['path', 'class' => '', 'fallback' => ''])

<div class="svg-loader {{ $class }}">
    @try
        {!! file_get_contents(public_path($path)) !!}
    @catch
        @if($fallback)
            <img src="{{ asset($fallback) }}" alt="Fallback image" class="img-fluid">
        @else
            <div class="svg-error">
                <i class="fas fa-image text-muted"></i>
            </div>
        @endif
    @endtry
</div> 