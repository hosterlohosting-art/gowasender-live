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
                    <a href="{{ route('user.flows.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create
                        New Flow</a>
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
                                                    <a href="{{ route('user.flows.edit', $flow->id) }}"
                                                        class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="{{ route('user.flows.delete', $flow->id) }}"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-6">
                                                    <div
                                                        class="empty-state d-flex flex-column align-items-center justify-content-center">
                                                        <div class="icon-shape bg-gradient-primary text-white rounded-circle shadow-lg mb-4"
                                                            style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-project-diagram fa-3x"></i>
                                                        </div>
                                                        <h4 class="text-dark font-weight-bold mb-2">No Automation Flows Yet</h4>
                                                        <p class="text-muted mb-4" style="max-width: 400px;">Create your first
                                                            automated flow to engage with your customers 24/7. It's easy!</p>
                                                        <a href="{{ route('user.flows.create') }}"
                                                            class="btn btn-primary btn-lg shadow-lg rounded-pill px-5"
                                                            style="background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important; border: none;">
                                                            <i class="fas fa-plus mr-2"></i> Create Your First Flow
                                                        </a>
                                                    </div>
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