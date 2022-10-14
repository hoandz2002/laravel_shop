@extends('layout.master-client')
@section('title', 'san pham')
@section('conten-title', 'san pham')
@section('content')

   <!-- search area -->
	<form action="{{route('client.shop')}}">
		<div class="search-area">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<span class="close-btn"><i class="fas fa-window-close"></i></span>
						<div class="search-bar">
							<div class="search-bar-tablecell">
								<h3>Search For:</h3>
								<input type="text" name="search" placeholder="Keywords">
								<button type="submit">Search <i class="fas fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- end search area -->

    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Get 24/7 Support</p>
                        <h1>Contact us</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- contact form -->
    <div class="contact-from-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="form-title">
                        <h2>Have you any question?</h2>
                        <div>
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div id="form_status"></div>
                    <div class="contact-form">
                        <form method="POST" action="{{ route('client.storeContact') }}" id="fruitkha-contact"
                            {{-- onSubmit="return valid_datas( this );" --}}>
                            @csrf
                            <p>
                                <input type="text" placeholder="Tên khách hàng" name="name" id="name">
                                <input type="email" placeholder="Email" name="email" id="email">
                            </p>
                            <p>
                                {{-- <input type="tel" placeholder="Phone" name="phone" id="phone"> --}}
                                <input type="text" name="action" value="1" hidden id="">
                                <input type="text" placeholder="Tiêu đề" name="title" id="title">
                            </p>
                            <p>
                                <textarea name="content" id="content" cols="30" rows="10" placeholder="Phản hồi khách hàng"></textarea>
                            </p>
                            {{-- <input type="hidden" name="token" value="FsWga4&@f6aw" /> --}}
                            {{-- <p><input type="submit" value="Submit"></p> --}}
                            <button class="btn btn-warning">Submit</button>
                            <div> 
                                @if ($errors->any())
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li style="color: red">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-form-wrap">
                        <div class="contact-form-box">
                            <h4><i class="fas fa-map"></i> Shop Address</h4>
                            <p>34/8, East Hukupara <br> Gifirtok, Sadan. <br> Country Name</p>
                        </div>
                        <div class="contact-form-box">
                            <h4><i class="far fa-clock"></i> Shop Hours</h4>
                            <p>MON - FRIDAY: 8 to 9 PM <br> SAT - SUN: 10 to 8 PM </p>
                        </div>
                        <div class="contact-form-box">
                            <h4><i class="fas fa-address-book"></i> Contact</h4>
                            <p>Phone: +00 111 222 3333 <br> Email: support@fruitkha.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end contact form -->

    <!-- find our location -->
    <div class="find-location blue-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p> <i class="fas fa-map-marker-alt"></i> Find Our Location</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end find our location -->
    <!-- google map section -->
    <div class="embed-responsive embed-responsive-21by9">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.158449512148!2d105.85406501538485!3d20.986284694601917!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ad652c457473%3A0x94c426f363a13d27!2zUGjhuqduIG3hu4FtIHF14bqjbiBsw70ga2jDoWNoIHPhuqFuLCByZXNvcnQsIGdvbGYgTmV3d2F5IFBNUw!5e0!3m2!1sen!2s!4v1662977111649!5m2!1sen!2s"
            width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""
            class="embed-responsive-item"></iframe>
    </div>
    <!-- end google map section -->

@endsection
