@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Room Type</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Room Type</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<a href="{{ route('add.room.type')}}"><button type="button" class="btn btn-outline-primary px-5 radius-30">Add Room Type</button>
							</a>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">All Room Type List</h6>
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
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($allData as $key=> $item)

									@php
									   $rooms = App\Models\Room::where('roomtype_id', $item->id)->get();
									@endphp
									<tr>
										<td>{{ $key+1}}</td>
										<td><img src="{{ (!empty($item->room->image)) ? url('upload/rooming/'.$item->room->image) : url('upload/no_image.jpg') }}" alt="Image" style="width:40px; height: 50px;"></td>
										<td>{{ $item->name}}</td>
										<td>

						@foreach($rooms as $row)
						<a href="{{ route('edit.room',$row->id)}}" class="btn btn-warning px-3 radius-30">Edit</a>
						<a href="{{ route('delete.room',$row->id)}}" id="delete" class="btn btn-danger px-3 radius-30">Delete</a>
						@endforeach
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