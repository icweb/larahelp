@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            @if(session('errors'))
                <div class="alert alert-danger fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h6><b>Please fix the following error(s) and try again:</b></h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row row-eq-height">

                <div class="col-md-8">
                    <div class="card mb-20">
                        <div class="card-body">
                        <span class="float-right small text-right">
                            <i class="far fa-user"></i>  {{ $ticket->author->name }} <br>
                            <i class="far fa-clock"></i>  {{ $ticket->created_at->format('m/d/Y') }}
                            @if(!empty($ticket->closed_at))
                                <br> <span class="text-danger">Closed {{ $ticket->closed_at->format('m/d/Y') }}</span>
                            @endif
                        </span>
                            <h2 class="mb-0">Ticket {{ $ticket->id }}</h2>
                            @if(auth()->user()->is_agent)
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    @if(empty($ticket->closed_at))
                                        @if(empty($ticket->agent_id))
                                            <form action="{{ route('tickets.assign', $ticket) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="type" value="assign">
                                                <button type="submit" class="btn btn-warning no-round-right">Assign</button>
                                            </form>
                                        @else
                                            <form action="{{ route('tickets.assign', $ticket) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="type" value="unassign">
                                                <button type="submit" class="btn btn-warning no-round-right">Unassign</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('tickets.close', $ticket) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger no-round-left"><i class="fas fa-times"></i> Close</button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for=""><b>Category</b></label><br>
                                    {{ $ticket->category->title }}
                                </div>
                                <div class="col-sm-4">
                                    <label for=""><b>Priority</b></label><br>
                                    @if($ticket->priority->title === 'Low')
                                        <i class="fas fa-circle text-success"></i>
                                    @elseif($ticket->priority->title === 'Medium')
                                        <i class="fas fa-circle text-warning"></i>
                                    @else
                                        <i class="fas fa-circle text-danger"></i>
                                    @endif
                                    {{ $ticket->priority->title }}
                                </div>
                                @if(isset($ticket->agent_id))
                                    <div class="col-sm-4">
                                        <label for=""><b>Agent</b></label><br>
                                        <i class="far fa-user"></i> {{ $ticket->agent->name }}
                                    </div>
                                @endif
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <label for=""><b>Subject</b></label><br>
                                    {{ $ticket->subject }}
                                </div>
                                <div class="col-12">
                                    <label for=""><b>Description</b></label><br>
                                    {{ $ticket->body }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-20 attachments-card">
                        <div class="card-header bg-dark text-white"><i class="fas fa-file-download"></i> Attachments</div>
                        <div class="card-body">
                            <form action="{{ route('attachment.upload', $ticket) }}" method="POST" enctype="multipart/form-data" id="attachment-form">
                                @csrf
                                <input type="file" name="attachment" onchange="$('#attachment-form').submit()" style="margin-bottom:20px">
                            </form>
                            @if(count($ticket->attachments))
                                <div class="table-responsive">
                                    <table class="table" style="margin-bottom:0">
                                        <tbody>
                                        @foreach($ticket->attachments as $attachment)
                                            <tr>
                                                <td style="width:100px">
                                                    <form action="{{ route('attachment.download', $attachment) }}" method="POST">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm">Download</button>
                                                    </form>
                                                </td>
                                                <td>{{ $attachment->file_name }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                No attachments found
                            @endif
                        </div>
                    </div>

                </div>

            </div>

            <div class="card">
                {{--<div class="card-header"><i class="far fa-comments"></i> Comments</div>--}}
                <div class="card-body">
                    <form action="{{ route('tickets.comments.create', $ticket) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="comment" id="comment" placeholder="Enter comment here..." autocomplete="off">
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
                            <div class="mb-10">
                                @if($comment->author->is_agent)
                                    <i class="far fa-user"></i>
                                @else
                                    <i class="fas fa-user"></i>
                                @endif
                                    <b>{{ $comment->author->name }}</b>
                                @if($comment->is_internal)
                                    <span class="badge badge-danger">Internal</span>
                                @endif
                                <br>
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
