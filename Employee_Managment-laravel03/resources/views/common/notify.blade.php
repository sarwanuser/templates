@if(@$errors)
@if(count($errors) > 0)
    <div class="card-alert card card-alert card gradient-45deg-red-pink ensober_alert"> 
        <button type="button" class="close" data-dismiss="alert">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:#fff;"><i class="material-icons">clear</i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endif

@if(Session::has('flash_error'))
	<div class="card-alert card card-alert card gradient-45deg-red-pink ensober_alert"> 
		<div class="card-content white-text">
			<p><i class="material-icons">check</i> {{ Session::get('flash_error') }}.</p>
		</div>
		<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
	</div>
@endif


@if(Session::has('flash_success')) 
	<div class="card-alert card card-alert card gradient-45deg-green-teal ensober_alert"> 
		<div class="card-content white-text">
			<p><i class="material-icons">check</i> {!! Session::get('flash_success') !!}.</p>
		</div>
		<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
	</div>
@endif