<div class="box box-primary" id="edit_tags_modal">
            <div class="box-header with-border">
        <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
         <br>
              <h3 class="box-title">Edit Workout</h3>
            </div>
            <form  class="prevent-resubmit-form" id="edit_workout_form" action="/management/workouts/{{ $row->id }}" enctype="multipart/form-data">

                             {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                <div class="box-body ">
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
                  <input class="form-control datepicker" type="text" value="{{ $row->date }}" id="pick_date_edit" name="date" required autocomplete="false" >
                </div>
                </div>


                <div class="form-group col-md-4">
                <label>Workout Image</label>
              <img alt="..." width="150px" height="100px" src="{{ $row->img_url }}" onerror="this.src='http://placehold.it/150x100';">
                <br>

                <input class="form-control" type="text" value="{{ $row->img_url }}" name="img_url" required>
              </div>

                <div class="form-group col-md-4">
                <label>Workout Video</label>
               <iframe src="{{ $row->video_url }}" width="150px" height="110px" frameborder="0" allowfullscreen></iframe>
                <br>

                <input class="form-control" type="text" value="{{ $row->video_url }}" name="video_url" required>
              </div>


                  <div class="form-group col-md-4">
                  <label>Exercise Time</label>  
                  {{-- <input class="form-control" type="number" name="exercise_time"> --}}
                  <input type="time" class="form-control" value="{{ $row->exercise_time }}"  name="exercise_time"/>
                </div>


                 <div class="form-group col-md-12">
                  <label>Description</label>
                  <textarea class="form-control " name="description"  name="name" id="edit-textarea">{!! $row->description !!} </textarea>
                </div>
              </div>
              <div class="box-footer">
               <button type="submit" class="btn btn-primary prevent-resubmit-button">Update</button>
              </div>
              </form>
          </div>
      
