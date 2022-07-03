{{-- <div class="card">
    <div class="card-body"> --}}
        <div class="row">
            <div class="col-md-5 text-center">
                @if(!filter_var($row->img_url, FILTER_VALIDATE_URL))
                    <img src="{{ url('/'.App\Models\SysConfig::set()['logo']) }}"  class="img-responsive pad"  alt="Photo" height="300px;">
                @else
                    <img class="img-responsive pad" src="{{ $row->img_url }}" alt="Photo" height="300px;">
                @endif
            </div>

            <div class="col-md-7">
                <h3>{{ $row->name }} </h3>
                
                @if($row->person) Personn Take  {{ $row->person }} @endif 
                <strong style="color:blue"> 
                    @if($row->person) ::  Take Times  {{ $row->takes_time }} @endif 
                </strong>
                
                @if($row->entered_by)
                    <small class="text-secondary">Added By   {{ $row->entered_by->name }} at {{ $row->created_at }}</small>
                @endif

                <p class="mt-3">
                    {!! $row->description !!} 
                </p>
            </div>
        </div>
    {{-- </div>
</div> --}}