@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="float-left">
                <h2>My Tickets</h2>
            </div>
            <div class="text-right">
                <div class="btn-group mb-20" role="group" aria-label="Button group with nested dropdown">
                    <a href="{{ route('tickets.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> New Ticket</a>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filter
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="{{ route('tickets.index', ['filter' => 'all']) }}">All Tickets</a>
                            <a class="dropdown-item" href="{{ route('tickets.index', ['filter' => 'open']) }}">Open Tickets</a>
                            <a class="dropdown-item" href="{{ route('tickets.index', ['filter' => 'closed']) }}">Closed Tickets</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                @if(count($tickets))
                   <div class="table-responsive">
                       <table class="table">
                           <tbody>
                           @foreach($tickets as $ticket)
                               <tr>
                                   <td>#{{ $ticket->id }}</td>
                                   <td>
                                       @if($ticket->closed_at)
                                           <i class="fas fa-circle text-danger"></i>
                                       @else
                                           <i class="fas fa-circle text-success"></i>
                                       @endif
                                       <a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->subject }}</a>
                                   </td>
                                   <td>
                                       @if(isset($ticket->agent_id))
                                           {{ $ticket->agent->name }}
                                       @else
                                           Unassigned
                                       @endif
                                   </td>
                                   <td>Created at {{ $ticket->created_at->format('m/d/Y') }}</td>
                                   @if(isset($_GET['filter']) && $_GET['filter'] === 'closed')
                                       <td>Closed at {{ $ticket->closed_at->format('m/d/Y') }}</td>
                                   @endif
                               </tr>
                           @endforeach
                           </tbody>
                       </table>
                   </div>
                @else
                    <div class="card-body">
                        No tickets found
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
