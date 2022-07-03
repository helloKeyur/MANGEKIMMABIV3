@extends('main')
@section('css')

@endsection
@section('content')
	<section class="content-header">
      <h1>
        {{{ $vars['title'] }}}
        <small>{{{ $vars['sub_title'] }}}</small>
      </h1>
     
    </section>

    <section class="content">
    	<div class="col-md-12">
           <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Posts List</h3>

            <div class="box-body ">
              <table class="table table-striped data-table" id="user_table">
                  <thead>
                <tr>
                  <th>Blog</th>
                  <th>Status</th>
                  <th>Publish DateTime </th>
                  <th>Created By</th>
                  <th>View</th>
                  <th>Comments</th>
                  <th>Reactions</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                {{-- 
                   @foreach($vars['posts'] as  $row)

                  
                   @endforeach --}}

                </tbody>
              </table>
            </div>
           </div>
           </div>
            <!-- /.box-body -->
      </div>
    </section>

  

@endsection


@section('js')



@endsection
