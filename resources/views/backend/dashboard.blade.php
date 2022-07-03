@extends('main')
@section('css')
@php
use App\Models\User;
@endphp
@endsection
@section('content')
 <section class="content-header">
      <h1>
        {{-- {{{ $vars['title'] }}} --}}
        <small></small>
      </h1>
    </section>
     <!-- Main content -->
    <section class="content">
    	   <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-navy">
            <div class="inner">
              <h3>{{ number_format( User::count()) }}</h3>

              <p>Users Registered</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
        
            <a href="/management/users" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>

          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
               <h3>{{ number_format(User::where('is_subscribed','true')->count()) }}</h3>

              <p>Users Subscribed</p>
            </div>
            <div class="icon">
              <i class="fa fa-bookmark-o"></i>
            </div>
            <a href="/management/users" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
              <h3>{{ number_format(User::where('is_verified','true')->count()) }}</h3>

              <p>Users Verified </p>
            </div>
            <div class="icon">
              <i class="fa fa-check-square-o"></i>
            </div>
            <a href="/management/users" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

         <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ number_format(User::where('status','Banned')->count()) }}</h3>

              <p>Users Banned </p>
            </div>
            <div class="icon">
              <i class="fa fa-user-times"></i>
            </div>
            <a href="/management/users" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
    
    </div>
</section>

@endsection


@section('js')



@endsection
