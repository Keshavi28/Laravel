@extends('layouts.app')

@section('content')
<div class="container">
@php    
$rows = $users;
@endphp
    {{-- <div class="d-flex justify-content-end">
        <div>
            <a href="{{route('user_list')}}" class="btn btn-warning">User's List →</a>
        </div>
    </div> --}}
    <div class="row justify-content-center">
        
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User Form</div>
                <div class="card-body">
                    <div class="error" id="message" style="color: red;"></div>
                    <form class="form" method="POST" enctype="multipart/form-data" id="userForm">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" class="form-control" placeholder="Name" name="name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" class="form-control" placeholder="Email" name="email">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="phone">Phone</label>
                                    <input type="phone" id="phone" class="form-control" placeholder="Phone" name="phone">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description</label>
                                    <textarea id="description" class="form-control" name="description"></textarea>
                                    {{-- <script>CKEDITOR.replace( 'description' );</script> --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="issueinput6">Role</label>
                                    <select id="issueinput6" name="role" class="form-control">
                                        <option value="" selected>-- Select Role --</option>
                                        @foreach($roles as $row)
                                        <option value="{{$row->id}}">{{$row->role}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="profile_image">Profile Image</label>
                                    <input type="file" id="profile_image" class="form-control" name="profile_image">
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Status</label>
                                    <div class="form-check form-switch mt-1">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status" checked value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center mt-3">
                                    <button type="submit" id="submitButton" class="btn btn-primary">Save ✔</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="showMsg">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" style="text-align: center;">
                    <h4>Form submitted successfully!</h4>
                </div>
                <div class="modal-footer" style="border: none;">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- User's List --}}

    
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User's List</div>
                <div class="card-body">
                    <table class="table table-striped table-dark" id="userTable">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key=>$value)
                            <tr id="userRow{{$value->id}}">
                            <th scope="row">{{$value->id}}</th>
                            <td>{{$value->name}}</td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->phone}}</td>
                            <td>{{$value->role->role}}</td>
                            <td>{{$value->status == 1 ? 'Active' : 'Inactive'}}</td>
                            <td>
                                <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#userInfoModal{{$value->id}}">View</a>
                                |
                                <a href="{{route('user_delete', $value->id)}}" class="btn btn-danger">Delete</a>
                            </td>
                          </tr>
                          <div class="modal fade" id="userInfoModal{{$value->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$key}}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="exampleModalLabel{{$key}}">{{$value->name}}</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div>Email : {{$value->email}}</div>
                                  <div>Phone : {{$value->phone}}</div>
                                  <div>Role : {{$value->role->role}}</div>
                                  <div>Description : {!!$value->description!!}</div>
                                  <div>Profile Image : <img src="{{asset('/public/uploads/user_profile')}}/{{$value->profile_image}}" alt="" height="100px"></div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>

@vite(['resources/js/form.js'])
@endsection