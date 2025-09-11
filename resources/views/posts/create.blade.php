@extends('layouts.app')

{{--// todo: Add option to delete and replace images also user can change to sepia b/w and add HDR processing --}}
{{--todo: click on the image title to update. a button should be at the far right and should be a pen.--}}
@section('content')
{{--    <link href="{{ asset('css/bnblistform.css') }}" rel="stylesheet">--}}
    {{--    <script  src="{{ asset('js/script.js') }}"></script>--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/css/intlTelInput.min.css"/>
    <style>
           /*@import url("https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/css/intlTelInput.min.css");*/
        .chip{
            cursor: pointer;
        }
        .chip.active {
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            padding: .3rem;
        }

        .house-type {
            border: 1px solid #ddd;
            padding: 10px;
            cursor: pointer;
            border-radius: 10px;
            text-align: center;
        }

        .house-type img {
            width: 100%;
            max-height: 120px;
            object-fit: cover;
            border-radius: 10px;
        }

        .house-type.active {
            border: 2px solid #007bff;
        }

        .hidden {
            display: none;
        }

        * {
            box-sizing: border-box;
        }

        img {
            vertical-align: middle;
        }

        /* Position the image container (needed to position the left and right arrows) */
        .container {
            position: relative;
        }

        /* Hide the images by default */
        .mySlides {
            display: none;
        }

        /* Add a pointer when hovering over the thumbnail images */
        .cursor {
            cursor: pointer;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 40%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            border-radius: 0 3px 3px 0;
            background-color: rgba(0, 0, 0, 0.8);
            user-select: none;
            -webkit-user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* Container for image text */
        .caption-container {
            text-align: center;
            background-color: #222;
            padding: 2px 16px;
            color: white;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Six columns side by side */
        .column {
            float: left;
            width: 16.66%;
        }

        /* Add a transparency effect for thumnbail images */
        .demo {
            opacity: 0.6;
        }

        .active,
        .demo:hover {
            opacity: 1;
        }

        .form-field {
            width: 400px;
            height: auto;
            min-height: 34px;
            border: 2px solid #737679;
            padding: 8px;
            margin: 8px;
            cursor: text;
            border-radius: 3px;

            box-shadow: 0 2px 6px rgba(25, 25, 25, 0.2);
        }

        .form-field .chips .chip {
            display: inline-block;
            width: auto;

            background-color: #0077b5;
            color: #fff;
            border-radius: 3px;
            margin: 2px;
            overflow: hidden;
        }

        .form-field .chips .chip {
            float: left;
        }

        .form-field .chips .chip .chip--button {
            padding: 8px;
            cursor: pointer;
            background-color: #004471;
            display: inline-block;
        }

        .form-field .chips .chip .chip--text {
            padding: 8px;
            cursor: none;
            display: inline-block;
            pointer-events: none
        }

        .form-field > input {
            padding: 15px;
            display: block;
            box-sizing: border-box;
            width: 100%;
            height: 34px;
            border: none;
            margin: 5px 0 0;
            display: inline-block;
            background-color: transparent;
        }

</style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <style>
        /*Overlay Leaflet OpenTreeMap
        Leaflet CSS */
        /*@import url("https://unpkg.com/leaflet/dist/leaflet.cs/");*/
        /*<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>*/
        #map {
            height: 100%;
        }

        /* Overlay styles */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            z-index: 1000;
            overflow: auto;
        }

        .overlay-content {
            margin-top: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 90%;
            max-width: 700px;
            text-align: center;
        }

        .close-btn {
            margin-top: 15px;
            padding: 5px 10px;
            background: #c00;
            color: white;
            border: none;
            cursor: pointer;
        }

        .close-btn:hover {
            background: #900;
        }

        .controls {
            margin-top: 10px;
            background: white;
            padding: 10px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .controls input, .controls button {
            margin: 5px 0;
            padding: 6px;
            width: 100%;
            box-sizing: border-box;
        }

        .banner {
            background: rgba(25, 118, 210, 0.95);
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        #map {
            height: 400px;
            width: 100%;
            margin-top: 10px;
            border-radius: 5px;
        }

        #toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1100;
        }

        #toast.visible {
            opacity: 1;
        }


    </style>
    <h2 style="text-align:center">{{$user->profile->title}}'s New Post</h2>

    <div class="container" style="width: 400px; height: 700px">

        {{--    todo: Dynamically generate the slides based on the number of uploaded images.--}}
        {{--    Make the first input field of the Image to be visible on page post load--}}

        @foreach($images as $post)

            <div class="mySlides">
                <div class="numbertext">{{$loop->index+1}} / {{$loop->count}}</div>
                <img src="/storage/{{$post->image}}" style="width:100%">
            </div>

        @endforeach
        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>


        <div class="caption-container">
            <p id="caption"></p>
        </div>


        <div class="row">
            @php
                $total_images = 0;
                $images_array = array();

            @endphp


            @foreach($images as $images)

                <span class="visually-hidden"> {{$total_images++}}</span>


                <div class="column">
                    <img id="image{{$loop->index+1}}" class="demo cursor" src="/storage/{{$images->image}}" style="width:100%"
                         onclick="ShowHideDiv();$('#reply{{$loop->index+1}}').toggle();$('#reply{{$loop->index+1}}').focus();currentSlide({{$loop->index+1}})"
                         alt="{{$images->description?? 'Add Image Description Below'}}">

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

                    <div id="replybutton" class="btn4 like py-2">
                        {{--                    <span class="btn reply" id="replyb" onClick="$('#reply').toggle();currentSlide({{$loop->index+1}})">Edit</span>--}}
                    </div>

                    <input type="text" name="reply{{$loop->index+1}}" id="reply{{$loop->index+1}}"
                           maxlength="20"
                           class="form-control pull-right col-3 "
                           placeholder="Write image{{$loop->index+1}} description..." style="display:none; width: 200px"
                           autofocus="autofocus" onblur="GrabImageDescriptions()"
                    />

                </div>

                <script>

                    function ShowHideDiv() {
                        for (let i = 1; i <= {{$total_images}}; i++) {
                            document.getElementById("reply" + i.toString()).style.display = "none";
                            // console.log("reply" + i.toString());
                        }
                    }
                </script>

            @endforeach
        </div>
        <h2 class="mb-4">BnB Listing Form (Add Image Descriptions above e.g. Bedroom, Livingroom, Bathroom)</h2>
        <form id="bnbForm" action="/p" enctype="multipart/form-data">
            {{--                    Posts Captions Description--}}
            <div class="row">
                {{--                    <label for="image" class="col-md-4 col-form-label" >Post Caption</label>--}}
                <input type="text" name="image_description" value="{{$images_list}}" id="image_description" tabindex="-1"
                       class="form-control-file visually-hidden">

                @if($errors->has('image_description'))

                    <strong class="alert-danger">{{$errors->first('image_description')}}</strong>

                @endif

            </div>
            {{--                    Posts Captions--}}
            <div class="row">
                {{--                    <label for="image" class="col-md-4 col-form-label" >Post Caption</label>--}}
                <input type="text" name="image" value="{{$images_list}}" id="image" tabindex="-1"
                       class="form-control-file visually-hidden">

                @if($errors->has('image'))

                    <strong class="alert-danger">{{$errors->first('image')}}</strong>

                @endif

            </div>
{{--            Post Home Name--}}
            <div class="mb-3">
                <label for="home_name" class="form-label">Home Name (e.g. Gianna Flats)</label>
                <input type="text" class="form-control" id="home_name"
                       name="home_name" class="form-control{{$errors->has('home_name') ? 'is-invalid':''}}"
                       value="{{old('home_name')}}"
                       autocomplete="home_name"
                       autofocus required/>
                @if($errors->has('home_name'))

                    <strong class="alert-danger">{{$errors->first('home_name')}}</strong>

                @endif

            </div>
{{--                Contact Number--}}
            <div class="mb-3">
                <label for="telephone" class="form-label">Caretaker Contact</label>
                <input type="tel" id="telephone" name="telephone"
                       class="form-control{{$errors->has('telephone') ? 'is-invalid':''}}"
                       value="{{old('telephone')}}"
                       autocomplete="telephone"
                       autofocus required />
                @if($errors->has('telephone'))

                    <strong class="alert-danger">{{$errors->first('telephone')}}</strong>

                @endif
            </div>
{{--                    House Type e.g. Apartment, Villa, Hotel--}}
            <div class="mb-3">
                <label class="form-label">Select House Type</label>
                <div class="row g-2" id="houseTypeContainer">
                    <!-- Dynamically inserted by JS -->
                </div>
            </div>

            <!-- Room Type e.g. Private Room, Entire Home-->
            <div class="mb-3">
                <label for="accommodation_type" class="form-label">Accommodation Type</label>
                <select name="accommodation_type" id="accommodation_type" class="form-select" required>
                    <option value="" selected disabled>Choose...</option>
                    <option>Private Room</option>
                    <option>Shared Room</option>
                    <option>Entire Home</option>
                    <option>Dormitory</option>
                    <option>Hostel</option>
                    <option>Hotel Room</option>
                </select>
            </div>
{{--                Number of Rooms--}}
            <div class="mb-3">
                <label class="form-label">Number of Rooms</label>
                <input type="number" min="1" id="numRooms" class="form-control" name="num_rooms" />
            </div>
            {{--                Number of Bathrooms--}}
            <div class="mb-3">
                <label class="form-label">Number of Bathrooms</label>
                <input type="number" min="1" id="numBaths" class="form-control" name="num_bathrooms" />
            </div>
{{--                        Location e.g. Westlands, Nairobi--}}
            <div class="mb-3">
                <label for="location" class="form-label">Location Name (e.g. Westlands, Nairobi)</label>
                <input type="text" class="form-control" id="location"
                       name="location" class="form-control{{$errors->has('location') ? 'is-invalid':''}}"
                       value="{{old('location')}}"
                       autocomplete="location"
                       autofocus required />
                @if($errors->has('location'))

                    <strong class="alert-danger">{{$errors->first('location')}}</strong>

                @endif
            </div>
{{--                Price priceType --}}
            <div class="mb-3">
                <label class="form-label">Price (in KES)</label>
                <input type="number" min="0" id="price" class="form-control" name="price"
                       class="form-control{{$errors->has('price') ? 'is-invalid':''}}"
                       value="{{old('price')}}"
                       autocomplete="price"
                       autofocus
                       required />
                @if($errors->has('price'))

                    <strong class="alert-danger">{{$errors->first('price')}}</strong>

                @endif
                <div class="mt-2" id="priceOptions">
                    <span class="chip active" data-value="per_night">Per Night</span>
                    <span class="chip" data-value="per_month">Per Month</span>
                </div>
                <input type="hidden" name="price_type" id="priceType" value="per_night" />
            </div>
{{--                latitude,longitude--}}
            <div class="mb-3">
                <label class="form-label">Latitude & Longitude</label>
                <div class="input-group mb-2">
                    <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Latitude" readonly />
                    @if($errors->has('latitude'))

                        <strong class="alert-danger">{{$errors->first('latitude')}}</strong>

                    @endif
                    <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Longitude" readonly />
                    @if($errors->has('longitude'))

                        <strong class="alert-danger">{{$errors->first('longitude')}}</strong>

                    @endif
                    <button type="button" id="setLocationBtn" class="btn btn-outline-primary">Set Location</button>
                </div>
            </div>

            <div class=" p-2 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" >Post</button>
            </div>
{{--            <button type="submit" class="btn btn-primary">Post</button>--}}
        </form>

    </div>
    <script>
        const image_descriptions = new Array({{$total_images}}).fill("");
        function GrabImageDescriptions() {
            for (let i = 1; i <= {{$total_images}}; i++) {

                // Initialize our constant array that we'll use to store the image description and are accessible via indexes

                // console.log( document.getElementById("reply" + i.toString()).value);

                if (document.getElementById("reply" + i.toString()).value.length != 0)
                {
                    //Update the Image Card Description text by replacing it with user's input
                    document.getElementById("image" + i.toString()).alt = document.getElementById("reply" + i.toString()).value;

                }
                //Update array content with non empty strings
                image_descriptions[i-1] = document.getElementById("reply" + i.toString()).value;
                //First check that all the fields have been input then commit

            }
            var div = document.getElementById('image_description');
            let json = JSON.stringify(image_descriptions); // Convert array to json so that it is possible to save to html values
            div.value = json; // Saving to html form value
            console.log(div.value);

        }

        document.getElementById("reply1").style.display = "block";


    </script>
    {{--todo: Improve the image qualities by applying HDR High Dynamic Range using OpenCV --}}
    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("demo");
            var captionText = document.getElementById("caption");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            captionText.innerHTML = dots[slideIndex - 1].alt;
        }
    </script>

{{--    Opentreemap location Selection Scripts--}}
    <!-- Overlay container -->
    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <div class="banner">SELECT YOUR HOME ON THE MAP THEN CLICK SAVE</div>

            <div class="controls">
                <button onclick="getCurrentLocation()">📍 Use My Location</button>
                <input type="text" id="searchInput" placeholder="Search location..." />
                <button onclick="searchLocation()">🔍 Search</button>
                <button onclick="saveManually(); hideOverlay()">💾 Save & Close</button>
            </div>

            <div id="map"></div>
            <button class="close-btn" onclick="hideOverlay()">Cancel </button>
            <button onclick="saveManually(); hideOverlay()">💾 Save & Close</button>
        </div>
    </div>
    <!-- Toast Message -->
    <div id="toast"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([-1.286389, 36.817223], 13);
        let userMarker = null;
        let gpsMarker = null;
        const toast = document.getElementById('toast');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add('visible');
            setTimeout(() => toast.classList.remove('visible'), 3000);
        }

        function reverseGeocode(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    const address = data.display_name || 'Unknown location';
                    showToast(`Saved: ${address}`);
                })
                .catch(() => showToast('Saved, but failed to get address.'));
        }

        function saveToServer(lat, lng) {
            fetch('/api/save-location', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ latitude: lat, longitude: lng })
            })
                .then(res => {
                    if (res.ok) reverseGeocode(lat, lng);
                    else showToast('Failed to save location.');
                })
                .catch(() => showToast('Network error while saving.'));
        }

        function handleMarker(lat, lng) {
            if (!userMarker) {
                userMarker = L.marker([lat, lng], { draggable: true }).addTo(map);
            } else {
                userMarker.setLatLng([lat, lng]);
            }
        }

        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            handleMarker(lat, lng);
        });

        function getCurrentLocation() {
            if (!navigator.geolocation) {
                showToast("Geolocation not supported by browser.");
                return;
            }

            navigator.geolocation.getCurrentPosition(
                position => {
                    const { latitude, longitude } = position.coords;
                    map.setView([latitude, longitude], 16);

                    if (!gpsMarker) {
                        gpsMarker = L.marker([latitude, longitude], {
                            icon: L.icon({
                                iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                                iconSize: [25, 25],
                                iconAnchor: [12, 25]
                            }),
                            title: "Your Location"
                        }).addTo(map);
                    } else {
                        gpsMarker.setLatLng([latitude, longitude]);
                    }

                    showToast("GPS located. Now click to mark your home.");
                },
                () => showToast("Unable to retrieve GPS."),
                { enableHighAccuracy: true, timeout: 5000 }
            );
        }

        function searchLocation() {
            const query = document.getElementById('searchInput').value.trim();
            if (!query) {
                showToast("Please enter a location.");
                return;
            }


            const proxy = 'https://corsproxy.io/?';

            const urldev = `${proxy}${encodeURIComponent(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)}`;
            const urlprod = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;



            fetch(`${urlprod}`)
                .then(res => res.json())
                .then(results => {
                    if (results.length === 0) {
                        showToast("No location found.");
                        return;
                    }

                    const { lat, lon } = results[0];
                    map.setView([lat, lon], 16);
                    showToast("Location found. Click to mark your home.");
                })
                .catch(() => showToast("Search failed."));
        }

        function saveManually() {
            if (!userMarker) {
                showToast("Please select your home on the map first.");
                return;
            }

            const pos = userMarker.getLatLng();
            // saveToServer(pos.lat, pos.lng);
            document.getElementById('latitude').value = pos.lat;
            document.getElementById('longitude').value = pos.lng;
            // document.getElementById('setlocation').innerHTML = "Saved Successfully. Click Again to Update";

        }

        function showOverlay() {
            document.getElementById('overlay').style.display = 'flex';
            setTimeout(() => map.invalidateSize(), 300);  // ensure Leaflet renders map correctly
        }

        function hideOverlay() {
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/js/intlTelInput.min.js"></script>
    <script>
    const houseTypes = [
      { name: 'Bedsitter', img: 'https://example.com/bedsitter.jpg' },
      { name: 'Single Room', img: 'https://example.com/single-room.jpg' },
      { name: 'Hostel', img: 'https://example.com/hostel.jpg' },
      { name: 'Apartment', img: 'https://example.com/apartment.jpg' },
      { name: 'Maisonette', img: 'https://example.com/maisonette.jpg' },
      { name: 'Bungalow', img: 'https://example.com/bungalow.jpg' },
      { name: 'Villa', img: 'https://example.com/villa.jpg' },
      { name: 'Hotel Room', img: 'https://example.com/hotel-room.jpg' }
    ];

    const container = document.getElementById("houseTypeContainer");
    const numRooms = document.getElementById("numRooms");
    const numBaths = document.getElementById("numBaths");

    houseTypes.forEach((type, i) => {
      const col = document.createElement("div");
      col.className = "col-6 col-md-3";
      col.innerHTML = `
        <div class="house-type" data-type="${type.name}">
          <img src="${type.img}" alt="${type.name}" />
          <p>${type.name}</p>
        </div>
      `;
      container.appendChild(col);
    });

    document.querySelectorAll(".house-type").forEach((el) => {
      el.addEventListener("click", () => {
        document.querySelectorAll(".house-type").forEach(e => e.classList.remove("active"));
        el.classList.add("active");
        const selected = el.dataset.type;
        if (["Bedsitter", "Single Room"].includes(selected)) {
          numRooms.value = "";
          numRooms.disabled = true;
          numBaths.value = "";
          numBaths.disabled = selected === "Single Room";
        } else {
          numRooms.disabled = false;
          numBaths.disabled = false;
        }
      });
    });

    const priceChips = document.querySelectorAll("#priceOptions .chip");
    const priceType = document.getElementById("priceType");
    priceChips.forEach(chip => {
      chip.addEventListener("click", () => {
        priceChips.forEach(c => c.classList.remove("active"));
        chip.classList.add("active");
        priceType.value = chip.dataset.value;
      });
    });

    const phoneInput = intlTelInput(document.getElementById("telephone"), {
      initialCountry: "auto",
      geoIpLookup: callback => {
        fetch("https://ipinfo.io/json?token=YOUR_TOKEN")
          .then(resp => resp.json())
          .then(data => callback(data.country))
          .catch(() => callback("KE"));
      },
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/js/utils.js",
    });

    document.getElementById("setLocationBtn").addEventListener("click", () => {
        // if (navigator.geolocation) {
        //     navigator.geolocation.getCurrentPosition(pos => {
        //         document.getElementById("latitude").value = pos.coords.latitude;
        //         document.getElementById("longitude").value = pos.coords.longitude;
        //     });
        // } else {
        //     alert("Geolocation is not supported");
        // }
          showOverlay()
    });


    document.getElementById("bnbForm").addEventListener("submit", async e => {
        e.preventDefault(); // Prevent default form submission

        const formData = new FormData(e.target);
        // Assuming 'phoneInput' is defined globally or accessible here
        formData.set("telephone", phoneInput.getNumber());

        const houseType = document.querySelector(".house-type.active")?.dataset.type;
        if (houseType) formData.set("home_type", houseType);
        // Send data to backend here
        console.log(Object.fromEntries(formData.entries()));
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrfToken) {
            formData.set('_token', csrfToken); // Laravel expects the token as '_token' in form data
        } else {
            console.error("CSRF token not found! Form submission might fail.");
            alert("Security token missing. Please refresh the page and try again.");
            return; // Stop submission if token is not found
        }
        // alert("Form submitted!");
        // Send data to backend here using fetch
        try {
            const response = await fetch('/p', {
                method: 'POST', // Most likely 'POST' for form submissions that create data
                body: formData, // FormData directly works with fetch and handles multipart/form-data
            });

            if (response.ok) {
                // Form submitted successfully
                const result = await response.json(); // If your backend returns JSON
                console.log("Form submission successful:", result);
                alert("Form submitted successfully!");
                // Optionally, redirect or clear the form
                // window.location.href = '/success-page';
                // e.target.reset(); // Resets the form fields
                if (result.redirect_url) {
                    window.location.href = result.redirect_url;
                } else {
                    // If no redirect_url, maybe just reset form or show a success message
                    e.target.reset();
                }
            } else {
                // Server responded with an error status (e.g., 400, 500)
                const errorData = await response.json(); // Assuming backend sends error details as JSON
                console.error("Form submission failed:", response.status, errorData);
                alert("Form submission failed: " + (errorData.message || "An error occurred."));
            }
        }
        catch (error) {
            // Network error or other issues
            console.error("Error during form submission:", error);
            alert("An error occurred while submitting the form. Please try again.");
        }
    });

  </script>
<script  src="{{ asset('js/bnblistform.js') }}"></script>
@endsection
