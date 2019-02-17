{{-- Updated for Bootstrap --}}
@extends('theme::layouts.app')

@section('content')

	<div class="jumbotron pb-4">
		<div class="container">
			<h1 class="display-3">Our Awesome Blog</h1>
			<p>Blog tagline goes here</p>
			<p>
				@foreach($categories as $cat)
					<a href="{{ route('wave.blog.category', $cat->slug) }}" class="btn btn-secondary btn-sm">{{ $cat->name }}</a>
				@endforeach
			</p>

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
		</div>
	</div>
	<div class="container">
		<div class="row row-lg-eq-height">

			<!-- Main Content -->
			<div class="col-lg-12">

				<div class="row">
					<div class="card-columns cols-2">
						@foreach($posts as $post)
							{{ $post->users }}
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
									<small><time datetime="{{ Carbon\Carbon::parse($post->created_at)->toIso8601String() }}">{{ Carbon\Carbon::parse($post->created_at)->toFormattedDateString() }}</time>. Posted in <a href="{{ route('wave.blog.category', $post->category->slug) }}" rel="category">{{ $post->category->name }}</a>.</small>
									<p class="card-text mt-2">{{ substr(strip_tags($post->body), 0, 80) }}@if(strlen(strip_tags($post->body)) > 200){{ '...' }}@endif</p>
								</div>
							</article>
						@endforeach
					</div>
				</div>
			</div>

			<!-- Main Content -->
			<!--<div class="col-lg-4 pt-5 right-sidebar-blog">
                ee
            </div>-->
		</div>

		<ul class="uk-pagination uk-margin-large uk-flex-center">
			{{ $posts->links() }}
		</ul>
	</div>

@endsection