@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    You are logged in!
                </div>
            </div>
            <h1 class="h1">File Upload</h1>
            <div class="d-flex justify-content-around">
				<form action="{{ URL::to('upload') }}" method="post" enctype="multipart/form-data">
					<label>Select image to upload:</label>
				    <input type="file" name="file" id="file">
				    <input type="submit" value="Upload" name="submit">
					<input type="hidden" value="{{ csrf_token() }}" name="_token">
				</form>
            </div>    
        </div>
    </div>
</div>
@endsection
