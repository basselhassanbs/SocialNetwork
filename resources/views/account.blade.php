@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                  <div class="card-header">
                    
                    <div class="row">
                      <div class="col-6 align-self-center">
                        <h3 class="">Your Account</h3>
                      </div>
                      <div class="col-6">
                        @if (is_null($user->image))
                          <img class="float-right rounded-circle" src="{{ asset('avatar.jpg') }}" width="90px" height="90px" alt="image">
                        @else
                          <img class="float-right rounded-circle" width="90px" height="90px" src="data:image/jpg;charset=utf8;base64,{{base64_encode($user->image)}}"/>
                        @endif
                      </div>
                      {{-- <div class="col align-self-center">
                        <h3 class="float-left my-auto">Your Account</h3>
                        
                      </div> --}}
                    </div>
                </div>  
                  <div class="card-body">
                    <form action="{{ route('account.update',$user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text"
                            class="form-control @error('name') border-danger @enderror" name="name" id="name" value="{{$user->name}}" required>
                            @error('name')
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                          <label for="file">Image</label>
                          <input type="file" class="form-control-file border rounded @error('file') border-danger @enderror" name="file" id="file" placeholder="">
                          @error('file')
                              <p class="text-danger">{{ $errors->first('file') }}</p>
                          @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save Account</button>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection