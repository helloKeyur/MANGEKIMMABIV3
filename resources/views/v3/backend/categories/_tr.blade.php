<div class="col-lg-3 col-md-6 col-sm-12 connectedSortable">
    <div class="widget">
        <div class="widget-header cursor-move">
            <h3 class="widget-title">{{  $row->name }}</h3>
            <div class="widget-tools pull-right">
                <button type="button" class="btn btn-widget-tool minimize-widget ik ik-minus"></button>
                @if(\Auth::user()->userHasRole('admin')) 
                    <button type="button" class="btn btn-widget-tool ik ik-edit-2 edit_categories"
                    data-id="{{$row->id}}" data-toggle="tooltip" title="Edit Category" data-widget="chat-pane-toggle"
                    ></button>
                @endif
                <button type="button" class="btn btn-widget-tool ik ik-x hidden close_panel_{{ $row->id }}"></button>
            </div>
        </div>
        <div class="widget-body p-0 categories_divs" style="">
            <div class="list-group" data-id="{{$row->id}}">
                <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="row">
                        <div class="col-md-12 my-auto text-center">
                            <label class="text-danger font-weight-bold">Offline</label>
                            <input type="checkbox" class="js-switch js-single-{{ $row->id }} category_state"
                            name="state" @if($row->state == "online") checked @endif  data-id="{{$row->id}}"
                                />
                            <label class="text-success font-weight-bold">Online</label>
                        </div>
                    </div>
                </a>
                <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="row">
                    <div class="col-md-3 text-right my-auto">
                        <b data-toggle="tooltip" data-title="Created By"><i class="ik ik-user"></i></b>
                    </div>
                    <div class="col-md-9 text-left">
                        @if($row->enteredBy){{ $row->enteredBy->name }}@endif
                    </div>
                    </div>
                </a>
                <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="row">
                    <div class="col-md-3 text-right my-auto">
                        <b data-toggle="tooltip" data-title="Created At"><i class="ik ik-calendar"></i> </b>
                    </div>
                    <div class="col-md-9 text-left">
                        {{  $row->created_at }}
                    </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var key = "{{ $row->id }}"
    var elemsingle = document.querySelector('.js-single-'+key);
    var switchery = new Switchery(elemsingle, {
        // color: '#4099ff', //PRIMARY
        color: '#2ed8b6', // SUCCESS
        secondaryColor: '#FF5370', //DANGER
        jackColor: '#fff',
        size: 'small'
    });
</script>