@extends('layouts.app')

@section('content')
    <div class="row">
      <form method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
        <input type="file" name="image_upload">
            <input type="submit" value="UPLOAD" class="btn btn-primary">
            <small class="error">{{$errors->first('image_upload')}}</small>
        </form>
      </div>
    </div>
@endsection