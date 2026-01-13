@extends('layouts.main.app')

@section('head')
<title>My Automation Flows | Digioverse</title>
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Automation Flows</h1>
            <div class="section-header-button">
                <a href="{{ route('user.flows.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create New Flow</a>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>My Flows</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                    
                                    @forelse($flows as $flow)
                                    <tr>
                                        <td>{{ $flow->name }}</td>
                                        <td>
                                            @if($flow->status)
                                                <div class="badge badge-success">Active</div>
                                            @else
                                                <div class="badge badge-danger">Inactive</div>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($flow->updated_at)->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('user.flows.edit', $flow->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ route('user.flows.delete', $flow->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <i class="fas fa-robot fa-3x text-gray-300 mb-3"></i>
                                            <p>No flows created yet.</p>
                                            <a href="{{ route('user.flows.create') }}" class="btn btn-primary mt-2">Create Your First Flow</a>
                                        </td>
                                    </tr>
                                    @endforelse
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection