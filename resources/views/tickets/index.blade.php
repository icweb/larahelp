@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('tickets.create') }}" class="btn btn-success">New Ticket</a>
            <div class="text-right">
                <div class="dropdown" style="margin-bottom:20px;">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('tickets.index', ['filter' => 'all']) }}">All Tickets</a>
                        <a class="dropdown-item" href="{{ route('tickets.index', ['filter' => 'open']) }}">Open Tickets</a>
                        <a class="dropdown-item" href="{{ route('tickets.index', ['filter' => 'closed']) }}">Closed Tickets</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Tickets Index</div>
                <div class="">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Created At</th>
                                @if(isset($_GET['filter']) && $_GET['filter'] === 'closed')
                                    <th>Closed At</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->subject }}</a>
                                        @if($ticket->closed_at)
                                            <span class="badge badge-danger">Closed</span>
                                        @else
                                            <span class="badge badge-success">Open</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->created_at->format('m/d/Y') }}</td>
                                    @if(isset($_GET['filter']) && $_GET['filter'] === 'closed')
                                        <td>{{ $ticket->closed_at->format('m/d/Y') }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
