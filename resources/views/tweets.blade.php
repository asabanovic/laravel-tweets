<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Listing Tweets</title>
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">
	<script src="{{ mix('js/app.js') }}"></script>
</head>
<body>
	<div class="container">
		<h2>List of tweets</h2>
		@if (Session::has('success'))
			<div class="alert alert-success">
  				<strong>Updating Cache with a new set of tweets from the API ...</strong>
			</div>
		@endif
		@if (Session::has('warning'))
			<div class="alert alert-warning">
  				<strong>Pulling data from cache ...</strong>
			</div>
		@endif
		<table class="table">
			<thead>
				<tr>
					<th class="col-md-2 text-center">Publisher</th>
					<th class="col-md-10">Tweet</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($tweets as $tweet)
					<tr>
						<td class="col-md-2 text-center">
							<div>
								@if (!empty($tweet->user->profile_image_url))
									<a href="http://twitter.com/{{ $tweet->user->screen_name }}"><img src="{{ $tweet->user->profile_image_url }}" alt="Profile Image"></a>
								@endif
							</div>
							<div><strong><a href="http://twitter.com/{{ $tweet->user->screen_name }}">{{ $tweet->user->screen_name }}</strong></a></div>
							<div><?php $dt = Carbon\Carbon::parse($tweet->created_at); echo $dt->diffForHumans(); ?></div>
						</td>
						<td class="col-md-10"><a href="http://twitter.com/{{$tweet->user->screen_name}}/status/{{$tweet->id}}"><strong>{{ $tweet->text }}</strong></a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="container text-center">
		{{ $tweets->render() }}
	</div>
	
</body>
</html>