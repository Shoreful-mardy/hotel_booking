
@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Site Setting</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Update Site Setting</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
<div class="col-lg-12">
    <div class="card">
        <form action="{{ route('update.site.setting')}}" method="post" enctype="multipart/form-data">
            @csrf
   <input type="hidden" name="id" value="{{ $site->id}}">
   <input type="hidden" name="oldimg" value="{{ $site->logo}}">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Phone</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" class="form-control" name="phone" value="{{$site->phone}}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Address</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" class="form-control" name="address" value="{{$site->address}}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Email</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" class="form-control" name="email" value="{{$site->email}}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Facebook</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" class="form-control" name="facebook" value="{{$site->facebook}}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Twitter</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" class="form-control" name="twitter" value="{{$site->twitter}}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Copyright Text</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" class="form-control" name="copyright" value="{{$site->copyright}}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Logo</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input id="image" type="file" class="form-control" name="logo" id="formFile" />
                </div>
            </div>

             <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0"></h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <img id="showImage" src="{{ (!empty($site->logo)) ? url($site->logo) : url('upload/no_image.jpg') }}
" alt="Admin" class="" width="80" height="50" >
                </div>
            </div>

           





            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9 text-secondary">
                    <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
						</div>
					</div>
				</div>
			</div>

<!-- Script For Image Show in Input Field -->

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
<!-- Script For Image Show in Input Field End -->

@endsection