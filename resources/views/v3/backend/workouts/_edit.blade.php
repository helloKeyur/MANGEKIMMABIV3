<form  class="prevent-resubmit-form" id="edit_workout_form" 
action="{{ route('workouts.update',$row->id) }}"
{{-- action="/management/workouts/{{ $row->id }}"  --}}
enctype="multipart/form-data">

    @csrf
    @method("PUT")
    <div class="row">

        <div class="form-group col-md-4">
            <label>Workout Category</label>
            <select class="form-control select2" name="circuit" style="width: 100%;" required>
                <option></option>
                @foreach(\App\Models\Workout::category() as $cat)
                    <option value="{{ $cat }}" @if($cat == $row->circuit) selected @endif>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4">
            <label>Workout Title</label>
            <input class="form-control" type="text" value="{{ $row->name }}" name="name">
        </div>


        <div class="form-group col-md-4">
            <label>Date</label>
            <input class="form-control datetimepicker-input"
            data-toggle="datetimepicker" data-target="#pick_date_edit"
            type="text" data-date-value="{{ date('m/d/Y',strtotime($row->date)) }}" id="pick_date_edit" name="date" required autocomplete="false" >
        </div>
    
        <div class="form-group col-md-4">
            <label>Food Image</label>
            <input class="form-control" type="text" value="{{ $row->img_url }}" name="img_url">
            @if(!filter_var($row->img_url, FILTER_VALIDATE_URL))
                <img src="{{ url('/'.App\Models\SysConfig::set()['logo']) }}" alt="Food Image" class="mt-2 " width="150px" height="100px" >
            @else
                <img alt="Food Image" class="mt-2 " width="150px" height="100px" src="{{ $row->img_url }}" onerror="this.src='http://placehold.it/150x100';">
            @endif
            <br>
        </div>

        <div class="form-group col-md-4">
            <label>Workout Video</label>
            <input class="form-control" type="text" value="{{ $row->video_url }}" name="video_url">
            @if(filter_var($row->video_url, FILTER_VALIDATE_URL))
            <iframe src="{{ $row->video_url }}" width="150px" height="110px" frameborder="0" allowfullscreen></iframe>
            @else 
                <small class="text-danger">Video URL is not Valid.</small>
            @endif
            <br>
        </div>

        <div class="form-group col-md-4">
            <label>Exercise Time</label>  
            <input type="time" class="form-control" value="{{ $row->exercise_time }}"  name="exercise_time"/>
        </div>

        <div class="form-group col-md-12">
            <label>Description</label>
            <textarea class="form-control editor" name="description"  name="name" id="edit-textarea" required >{!! $row->description !!} </textarea>
        </div>
        
        <div class="form-group col-md-12 text-right">
            <button type="submit" class="btn btn-primary prevent-resubmit-button"><i class="ik ik-save"></i> Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ik ik-x"></i> Close</button>
        </div>

    </div>
</form>