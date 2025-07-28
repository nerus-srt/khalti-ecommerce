@extends('admin.layout')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/upload.css')}}" />
@endsection
@section('content')
  <div class="card">
    <div class="card-body row">
      <div class="col-md-6 col-12">
        <form action="{{ route('categorySave') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div id="file-upload-form" class="uploader @error('path') is-invalid @enderror">
            <input id="file-upload" type="file" name="path" accept="image/*" required/>
            <label for="file-upload" id="file-drag">
              <img id="file-image" src="#" alt="Preview" class="hidden">
              <div id="start">
              <i class="fa fa-download" aria-hidden="true"></i>
              <div>Upload image category</div>
              @error('path')
                <span class="text-danger">{{ $message }}</span><br>
              @enderror
              <div id="notimage" class="hidden">Please select an image            
              </div>
              <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
              </div><br>
              @if(session('errorUpload'))
                <span class="text-danger">You must use button</span><br>
              @enderror
              <div id="response" class="hidden">
              <span class="text-danger" id="max-file"></span>
              <div id="messages">
              
              </div>
              <progress class="progress" id="file-progress" value="0">
                <span>0</span>%
              </progress>
              </div>
            </label>
          </div>

          <div class="form-group">
            <label for="name">Category name</label>
            <input type="text" name="name" id="name" class="form-control " placeholder="Suren" value="{{old('name')}}" required autofocus>
            
          </div>

          <button type="submit" class="btn btn-primary float-end">Create</button>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('js')
<script src="{{ asset('assets/js/upload.js') }}"></script>
<script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>

@endsection