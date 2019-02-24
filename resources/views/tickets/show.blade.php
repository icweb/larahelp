@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('errors'))
                <div class="alert alert-danger fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h6><b>Please fix the following error(s) and try again:</b></h6>
                    <ul class="no-mb">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(auth()->user()->is_agent)
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-body">
                        @if(empty($ticket->closed_at))
                            @if(empty($ticket->agent_id))
                                <form action="{{ route('tickets.assign', $ticket) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="type" value="assign">
                                    <button type="submit" class="btn btn-warning">Assign</button>
                                </form>
                            @else
                                <form action="{{ route('tickets.assign', $ticket) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="type" value="unassign">
                                    <button type="submit" class="btn btn-warning">Unassign</button>
                                </form>
                            @endif
                            <form action="{{ route('tickets.close', $ticket) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Close</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">Ticket ID {{ $ticket->id }}</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Ticket Category</b></label><br>
                        {{ $ticket->category->title }}
                    </div>
                    <div class="form-group">
                        <label for=""><b>Ticket Priority</b></label><br>
                        {{ $ticket->priority->title }}
                    </div>
                    <div class="form-group">
                        <label for=""><b>Ticket Author</b></label><br>
                        {{ $ticket->author->name }}
                    </div>
                    @if(isset($ticket->agent_id))
                        <div class="form-group">
                            <label for=""><b>Ticket Agent</b></label><br>
                            {{ $ticket->agent->name }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for=""><b>Ticket Subject</b></label><br>
                        {{ $ticket->subject }}
                    </div>
                    <div class="form-group">
                        <label for=""><b>Ticket Description</b></label><br>
                        {{ $ticket->body }}
                    </div>
                    <div class="form-group">
                        <label for=""><b>Ticket Opened At</b></label><br>
                        {{ $ticket->created_at->format('m/d/Y') }}
                    </div>
                    @if(!empty($ticket->closed_at))
                        <div class="form-group">
                            <label for=""><b>Ticket Closed At</b></label><br>
                            {{ $ticket->closed_at->format('m/d/Y') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">Attachments</div>
                <div class="card-body">
                    <form action="{{ route('attachment.upload', $ticket) }}" method="POST" enctype="multipart/form-data" id="attachment-form">
                        @csrf
                        <input type="file" name="attachment" onchange="$('#attachment-form').submit()" style="margin-bottom:20px">
                    </form>
                    @if(count($ticket->attachments))
                        <table class="table" style="margin-bottom:0">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ticket->attachments as $attachment)
                                    <tr>
                                        <td>{{ $attachment->file_name }}</td>
                                        <td class="text-right">
                                            <form action="{{ route('attachment.download', $attachment) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-success btn-sm">Download</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        No attachments found
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">Comments</div>
                <div class="card-body">
                    <form action="{{ route('tickets.comments.create', $ticket) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="comment" id="comment" placeholder="Enter comment here...">
                        </div>
                        @if(auth()->user()->is_agent)
                            <div class="form-group">
                                <input type="checkbox" value="internal" name="internal"> Internal Comment
                            </div>
                        @endif
                    </form>
                    @if(count($comments))
                        @foreach($comments as $comment)
                            <span class="small float-right">{{ $comment->created_at->format('M d h:ia') }}</span>
                            <div class="form-group">
                                @if($comment->is_internal)
                                    <span class="badge badge-danger float-left">Internal</span>
                                @endif
                                <label for=""><b>{{ $comment->author->name }}</b></label><br>
                                {{ $comment->body }}
                            </div>
                        @endforeach
                    @else
                        No comments found
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
