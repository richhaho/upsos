<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>{{$gs->title}}</title>
    <link rel="stylesheet" href="{{asset('assets/user/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/user/css/summernote-lite.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/user/css/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/user/css/all.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/user/css/lightbox.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/user/css/odometer.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/user/css/owl.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/user/css/main.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/user/css/toastr.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="shortcut icon" href="{{asset('assets/images/'.$gs->favicon)}}">
    @stack('css')
    <style>
        .select2-container--default .select2-selection--multiple {
            background-color: transparent;
            border: 1px solid #283c40;
            border-radius: 4px;
            cursor: text;
            padding-bottom: 5px;
            padding-right: 5px;
            position: relative;
            color: black;
        }.select2-results__option--selectable {
             cursor: pointer;
             color: black ;
         }

    </style>
</head>

<body>
    <!-- Overlayer -->
    <span class="toTopBtn">
        <i class="fas fa-angle-up"></i>
    </span>
    <div class="overlayer"></div>
    <div class="loader"></div>
    <!-- Overlayer -->

    <!-- User Dashboard -->
    <main class="dashboard-section">

		@if (Auth::user()->is_seller == 0)
		@include('includes.buyer.sidebar')
		@else
		@include('includes.user.sidebar')
		@endif


        <article class="main--content">
			@include('includes.user.topbar')
            <div class="dashborad--content">
				@yield('contents')
				@include('includes.user.footer')
            </div>
        </article>
    </main>
    <!-- User Dashboard -->

	<script>
		let mainurl = '{{ url('/') }}';
	</script>
    <script src="{{asset('assets/user/js/jquery-3.6.0.min.js')}}"></script>

    <script src="{{asset('assets/user/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/user/js/viewport.jquery.js')}}"></script>
    <script src="{{asset('assets/user/js/odometer.min.js')}}"></script>
    <script src="{{asset('assets/user/js/lightbox.min.js')}}"></script>
    <script src="{{asset('assets/user/js/owl.min.js')}}"></script>
	<script src="{{asset('assets/user/js/notify.js')}}"></script>
	<script src="{{ asset('assets/user/js/summernote-lite.min.js') }}"></script>
    <script src="{{asset('assets/user/js/main.js')}}"></script>
	<script src="{{asset('assets/user/js/toastr.min.js')}}"></script>
    <script src="{{asset('assets/user/js/custom.js')}}"></script>

	<script type="text/javascript">
		"use strict";
        var mercadogateway = null;


         @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        @if(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif



		@if(Session::has('message'))
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
			toastr.success("{{ session('message') }}");
		@endif

		@if(Session::has('error'))
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
			toastr.error("{{ session('error') }}");
		@endif

		@if(Session::has('info'))
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
			toastr.info("{{ session('info') }}");
		@endif

		@if(Session::has('warning'))
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
			toastr.warning("{{ session('warning') }}");
		@endif
	</script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        $(document).ready(function() {
            $('.js-example-basic-multiple2').select2();
        });
    </script>

    <script>
        // Wait for the document to be ready
        $(document).ready(function () {
            // Function to remove &nbsp; from the text content
            function removeNbsp() {
                // Iterate through each element with the specified class
                $('.select2-selection__choice__display').each(function () {
                    // Get the text content of the element
                    let textContent = $(this).text();

                    // Trim leading and trailing spaces, including &nbsp;
                    let updatedText = textContent.trim();

                    // Update the text content of the element
                    $(this).text(updatedText);
                });
            }

            // Call the function initially
            removeNbsp();

            // Attach a change event to the select2 element
            $('#subcategory').on('change', function () {
                // Call the function when the select2 dropdown changes
                removeNbsp();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#subcategory').on('select2:select', function (e) {
                var maxSelections = 3; // Replace with your desired limit
                var selectedOptions = $(this).val();

                if (selectedOptions && selectedOptions.length > maxSelections) {
                    alert('You can only select up to ' + maxSelections + ' options.');
                    // Remove the last selected options beyond the limit
                    $(this).val(selectedOptions.slice(0, maxSelections)).trigger('change.select2');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            const unreadMessageIndicator = $('#unread_messages_indicator');
            if (unreadMessageIndicator.length) {
                $.ajax({
                    url: "{{ route('user.hasUnreadMessages') }}",
                    method: 'GET',
                    success: (res) => {
                        if (res == true) {
                            unreadMessageIndicator.css({backgroundColor: '#ff5555'});
                        }
                    }
                })
            }
        });
    </script>


    @stack('js')
</body>

</html>


