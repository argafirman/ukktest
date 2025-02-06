@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Users
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ \App\Models\User::count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
