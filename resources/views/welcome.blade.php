@extends('components.master')

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="{{ route('index') }}">Photo Uploader</a>
</nav>

<div class="container mt-2">
    <div class="row">
        <div class="col-sm-3">
            <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input id="image" type="file" name="image" class="@error('image') is-invalid @enderror" required>
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <p>Date: <input type="text" id="datepicker" name="date"  class="@error('date') is-invalid @enderror" required></p>
                    @error('date')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <div class="col-sm-6">
            <div class="jumbotron" style="padding: 20px;">
                <h4>Upload API</h4>
                <p>In case you would like to upload an image using api, just call <kbd>[server_path]/public/api/photos/store?url={path to file}&date={image date}</kbd></p>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($images as $image)
        <div class="card ml-2 mt-2" style="width:300px;">
            <img src="{{ url('storage/'.$image) }}" height="300">
            <div class="card-body">
                <h4 class="card-title" style="text-align:center;">{{ substr($image, 15, -4) }}</h4>
            </div>
        </div>
            
        @endforeach
    </div>
</div>
@include('components.datepicker')