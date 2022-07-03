@extends('v3.backend.layouts.app')

@php
use App\Models\User;
@endphp

@section('title') Dashboard @endsection

@section('css')
<style type="text/css">

</style>
@endsection

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-bar-chart bg-blue"></i>
                <div class="d-inline">
                    <h5>Dashboard</h5>
                    <span>Welcome to the Control Center of Mange Kimambi.</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="../../index.html"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-group mb-4">
    <div class="card bg-dark cursor-pointer" onClick="redirectToRoute();">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="state">
                    <h3 class="text-white">
                        {{ number_format( User::count()) }}
                    </h3>
                    <p class="card-subtitle text-white fw-500">Users Registered</p>
                </div>
                <div class="icon"><i class="ik ik-user-plus text-white"></i></div>
            </div>
        </div>
    </div>
    <div class="card bg-danger cursor-pointer" onClick="redirectToRoute();">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="state">
                    <h3 class="text-white">
                        {{ number_format(User::where('is_subscribed','true')->count()) }}
                    </h3>
                    <p class="card-subtitle text-white fw-500">Users Subscribed</p>
                </div>
                <div class="icon"><i class="ik ik-bookmark text-white"></i></div>
            </div>
        </div>
    </div>
    <div class="card bg-light cursor-pointer" onClick="redirectToRoute();">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="state">
                    <h3 class="text-dark">
                        {{ number_format(User::where('is_verified','true')->count()) }}
                    </h3>
                    <p class="card-subtitle text-dark fw-500">Users Verified</p>
                </div>
                <div class="icon"><i class="ik ik-check-square text-dark"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="card-group mb-4">
    <div class="card bg-success cursor-pointer" onClick="redirectToRoute();">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="state">
                    <h3 class="text-white">
                        {{ number_format(User::where('status','Banned')->count()) }}
                    </h3>
                    <p class="card-subtitle text-white fw-500">Users Banned </p>
                </div>
                <div class="icon"><i class="ik ik-user-x text-white"></i></div>
            </div>
        </div>
    </div>
    <div class="card bg-secondary cursor-pointer" onClick="redirectToRoute();">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="state">
                    <h3 class="text-white">
                        0
                    </h3>
                    <p class="card-subtitle text-white fw-500">New Hired Services</p>
                </div>
                <div class="icon"><i class="ik ik-user-minus text-white"></i></div>
            </div>
        </div>
    </div>
    <div class="card bg-primary cursor-pointer" onClick="redirectToRoute();">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="state">
                    <h3 class="text-white">
                        0
                    </h3>
                    <p class="card-subtitle text-white fw-500">New Appoint Services</p>
                </div>
                <div class="icon"><i class="ik ik-user-check text-white"></i></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
function redirectToRoute(){
    var url = "{{ route('users.allUsers') }}"; //"/management/users"
    location.href = url;
}
</script>
@endsection