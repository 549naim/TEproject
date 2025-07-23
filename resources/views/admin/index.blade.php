@extends('layouts.master')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Admin List</h1>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_admin">
                    <i class="fas fa-plus-circle"></i> Create
                </button>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="admin_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $admin)
                                    <tr>
                                        <td>{{ $admin->id }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>
                                            @if (!empty($admin->getRoleNames()))
                                                @foreach ($admin->getRoleNames() as $r)
                                                    <label class="badge bg-success">{{ $r }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <a href="{{ route('admin.edit', $admin->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('admin.destroy', $admin->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('admin.create')
    @include('layouts.datatablecdn')
    <script>
        $('#admin_table').DataTable();
    </script>

    <script>
        $(document).ready(function() {
           
            $('#create_admin_form').ajaxForm({
                beforeSubmit: function() {
                    $('#create_admin_form')[0].reset();
                    $('#create_admin').modal('hide');
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    // Reload the DataTable to fetch new data
                    $('#admin_table').DataTable().draw();
                    // $('#admin_table').DataTable().rows.add(res.data).draw();
                }
            });
        });
    </script>
@endsection
