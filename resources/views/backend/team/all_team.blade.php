@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Team</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Team</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-outline-primary px-5 radius-30">Add Team</button>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">All Team</h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Sl</th>
										<th>Image</th>
										<th>Name</th>
										<th>Position</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($team as $key=> $item)
									<tr>
										<td>{{ $key+1}}</td>
										<td><img src="{{ asset($item->image) }}" alt="team" style="width:70px; height: 40px;"></td>
										<td>{{ $item->name}}</td>
										<td>{{ $item->position }}</td>
										<td>
						<a href="" class="btn btn-warning px-3 radius-30">Edit</a>
						<a href="" class="btn btn-danger px-3 radius-30">Delete</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<hr/>
			</div>



@endsection