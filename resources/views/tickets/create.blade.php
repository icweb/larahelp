@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white"><i class="fas fa-plus"></i> Create Ticket</div>
                <div class="card-body">
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
                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="category">Category <span class="text-danger small">*</span></label>
                                <select name="category" id="category" class="form-control">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="priority">Priority <span class="text-danger small">*</span></label>
                                <select name="priority" id="priority" class="form-control">
                                    @foreach($priorities as $priority)
                                        <option value="{{ $priority->id }}">{{ $priority->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label for="subject">Subject <span class="text-danger small">*</span></label>
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter subject here..." autocomplete="off">
                            </div>
                            <div class="form-group col-12">
                                <label for="body">Body <span class="text-danger small">*</span></label>
                                <textarea name="body" id="body" cols="30" rows="3" class="form-control" placeholder="Enter body here..."></textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-save"></i> Submit Ticket</button>
                                <button type="reset" class="btn btn-danger btn-lg"><i class="fas fa-eraser"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
