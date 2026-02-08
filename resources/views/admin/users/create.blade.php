@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px 30px; border: none;">
                    <h4 class="mb-0" style="font-weight: 600;">Create User</h4>
                </div>
                <div class="card-body" style="padding: 40px;">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Name</label>
                                    <input type="text" name="name" class="form-control" style="border-radius: 15px; padding: 15px;" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control" style="border-radius: 15px; padding: 15px;" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" style="border-radius: 15px; padding: 15px;" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Role</label>
                            <select name="role" class="form-control" style="border-radius: 15px; padding: 15px;" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Designation</label>
                                    <input type="text" name="designation" class="form-control" style="border-radius: 15px; padding: 15px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Mobile</label>
                                    <input type="text" name="mobile" class="form-control" style="border-radius: 15px; padding: 15px;">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary" style="border-radius: 25px; padding: 12px 30px;">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 25px; padding: 12px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection