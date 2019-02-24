@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Ticket</div>
                <div class="card-body">
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
                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select name="priority" id="priority" class="form-control">
                                @foreach($priorities as $priority)
                                    <option value="{{ $priority->id }}">{{ $priority->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter subject here...">
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea name="body" id="body" cols="30" rows="3" class="form-control" placeholder="Enter body here..."></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success">Submit Ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
