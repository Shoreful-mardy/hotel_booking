@extends('frontend.main_master')
@section('main')

 <!-- Inner Banner -->
        <div class="inner-banner inner-bg3">
            <div class="container">
                <div class="inner-title">
                    <ul>
                        <li>
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>{{ $post->category->category_name}}</li>
                    </ul>
                    <h3>{{ $post->post_title}}</h3>
                </div>
            </div>
        </div>
        <!-- Inner Banner End -->

<!-- Blog Details Area -->
        <div class="blog-details-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="blog-article">
                            <div class="blog-article-img">
                                <img src="{{ asset($post->post_image)}}" alt="Images" style="width: 100%;">
                            </div>

                            <div class="blog-article-title">
                                <h2>{{ $post->post_title}}</h2>
                                <ul>
                                    
                                    <li>
                                        <i class='bx bx-user'></i>
                                        {{ $post->user->name}}
                                    </li>

                                    <li>
                                        <i class='bx bx-calendar'></i>
                                        {{ $post->created_at->format('M d,Y')}}
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="article-content">
                                <p>{!! $post->long_desc !!}</p>
                            </div>

                            <div class="comments-wrap">
								<h3 class="title">Comments</h3>
								<ul>



            @php
                $comment = App\Models\Comment::where('post_id',$post->id)->where('status',1)->get();
            @endphp
            @foreach($comment as $com)
					<li>
						<img src="{{ asset('/upload/user_images/'.$com->user->photo) }}" alt="Image" style="width:50px; height: 50px;">
						<h3>{{ $com->user->name }}</h3>
						<span>{{ $com->created_at->format('M d,Y, g:i A') }}</span>
						<p>
                            {!! $com->message !!} 
                        </p>
						 
                    </li>

            @endforeach 
								</ul>
                            </div>

                            <div class="comments-form">
                                <div class="contact-form">
                                    <h2>Leave A Comment</h2>

  @auth
      <form  action="{{ route('add.comment') }}" method="post">
        @csrf
        <div class="row">
            <input type="hidden" name="post_id" value="{{ $post->id }}">

            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <textarea name="message" class="form-control" id="message" cols="30" rows="8" required data-error="Write your message" placeholder="Your Message"></textarea>
                </div>
            </div>

           
            <div class="col-lg-12 col-md-12">
                <button type="submit" class="default-btn btn-bg-three">
                    Post A Comment
                </button>
            </div>
        </div>
    </form>

  @else
<p>Please <a href="{{ route('login')}}">Login</a> First For Add Comment</p>

  @endauth                                  

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="side-bar-wrap">
                            <div class="search-widget">
                                <form class="search-form">
                                    <input type="search" class="form-control" placeholder="Search...">
                                    <button type="submit">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="services-bar-widget">
                                <h3 class="title">Blog Category</h3>
                                <div class="side-bar-categories">
                                    <ul>

                                    	@foreach($blog_category as $category)

                                        <li>
                                            <a href="{{ route('cat_wise.post',$category->id)}}">{{ $category->category_name}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="side-bar-widget">
                                <h3 class="title">Recent Posts</h3>
                                <div class="widget-popular-post">
                                	@foreach($r_post as $post)
                                    <article class="item">
                                        <a href="{{ route('blog.details',$post->id)}}" class="thumb">
                                            <img src="{{ asset($post->post_image) }}" style="height: 80px; width: 80px;" >
                                        </a>
                                        <div class="info">
                                            <h4 class="title-text">
                                                <a href="{{ route('blog.details',$post->id)}}">
                                                    {{ $post->post_title}}
                                                </a>
                                            </h4>
                                            <ul>
                                                <li>
                                                    <i class='bx bx-user'></i>
                                                    29K
                                                </li>
                                                <li>
                                                    <i class='bx bx-message-square-detail'></i>
                                                    15K
                                                </li>
                                            </ul>
                                        </div>
                                    </article>
                                    @endforeach

                                </div>
                            </div>

                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog Details Area End -->


@endsection