@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @php
                        $users = App\User::where('refferBy',auth()->user()->name)->get();
                    @endphp
                    @if(count($users) > 0)
                        <h6>You're Total Refferal Users List : <b>{{ count($users)}} Person(s) and earn Rs. {{ auth()->user()->amount}}</b></h6>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Reffer Cashback</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>Rs. {{ $user->amount ? $user->amount : 0 }} /-</td>
                                    <td>{{ $user->created_at->format('d F Y')}}</td>
                                    <td><a href="{{ route('view-earning',$user->name)}}"> view</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                    @endif

                    <h6>You're Refferal Link : </h6>
                    @php
                    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                        $url = "https://";
                    else
                        $url = "http://";
                        $url.= $_SERVER['HTTP_HOST'];
                    @endphp
                    <a href="{{ $url }}/register-reffer/{{ auth()->user()->name}}" target="_blank">{{ $url }}/register-reffer/{{ auth()->user()->name}}</a>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
