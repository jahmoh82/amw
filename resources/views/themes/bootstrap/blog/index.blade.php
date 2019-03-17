{{-- Updated for Bootstrap --}}
@extends('theme::layouts.app')

@section('content')

	{{--@if(!Request::is('blog'))--}}
		{{--<div class="breadcrumb-nav">--}}
			{{--<div class="container">--}}
				{{--<ol class="breadcrumb">--}}
					{{--<li class="breadcrumb-item"><a href="{{ route('wave.blog') }}">Blog</a></li>--}}
					{{--@if(isset($category))--}}
						{{--<li class="breadcrumb-item"><span>{{ $category->name }}</span></li>--}}
					{{--@endif--}}
				{{--</ol>--}}
			{{--</div>--}}
		{{--</div>--}}
	{{--@endif--}}

	<div class="jumbotron mb-4">
		<div class="container">
			<h1 class="display-3">Our Awesome Blog</h1>
			<p>Blog tagline goes here</p>
		</div>
	</div>

	<div class="container">
		<div class="row row-lg-eq-height">
			<!-- Main Content -->
			<div class="col-lg-4">
				<div class="col-lg-11 p-0">
					<div class="card card-default card-nav mb-4">
						<div class="card-header">
							<h5>Category</h5>
						</div>
						<div class="card-body">
							<ul class="settings-links">
								@foreach($categories as $cat)
									<li class=" tablink"><a href="{{ route('wave.blog.category', $cat->slug) }}">{{ $cat->name }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Main Content -->
			<div class="col-lg-8">

				<div class="row">
					<div class="card-columns cols-2">
						@foreach($posts as $post)
							<article id="post-{{ $post->id }}" typeof="Article" class="card card-default">
								<meta property="name" content="{{ $post->title }}">
								<meta property="author" typeof="Person" content="admin">
								<meta property="dateModified" content="{{ Carbon\Carbon::parse($post->updated_at)->toIso8601String() }}">
								<meta class="uk-margin-remove-adjacent" property="datePublished" content="{{ Carbon\Carbon::parse($post->created_at)->toIso8601String() }}">

								@if($post->image())
									<a href="{{ $post->link() }}"><img class="card-img-top" src="{{ $post->image() }}" alt="{{ $post->title }}"></a>
								@endif

								<div class="card-body">
									<h5 class="card-title text-truncate mb-1"><a href="{{ $post->link() }}">{{ $post->title }}</a></h5>
									<small>
										<time datetime="{{ Carbon\Carbon::parse($post->created_at)->toIso8601String() }}">{{ Carbon\Carbon::parse($post->created_at)->toFormattedDateString() }}</time>. Posted in <a href="{{ route('wave.blog.category', $post->category->slug) }}" rel="category">{{ $post->category->name }}</a> By:
										<a href="{{ route('wave.profile', $post->author->username) }}" rel="Author">{{ $post->author->name }}</a>.
									</small>
									<p class="card-text mt-2">{{ substr(strip_tags($post->body), 0, 80) }}@if(strlen(strip_tags($post->body)) > 200){{ '...' }}@endif</p>
								</div>
							</article>
						@endforeach
					</div>
				</div>

				{{ $posts->links() }}
			</div>
		</div>
	</div>

@endsection