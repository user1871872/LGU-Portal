@extends('layouts.user')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Selection</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <h2>Select Location</h2>

    <label for="province">Province:</label>
    <select id="province">
        <option value="">Select Province</option>
        @foreach($provinces as $province)
        <option value="{{ $province['code'] }}">{{ $province['name'] }}</option>
        @endforeach
    </select>

    <label for="municipality">Municipality:</label>
    <select id="municipality" disabled>
        <option value="">Select Municipality</option>
    </select>
    <label for="barangay">Barangay:</label>
    <select id="barangay" disabled>
        <option value="">Select Barangay</option>
    </select>
    <input type="text" id="street" placeholder="Enter Street">
    <input type="text" id="country" placeholder="Enter Country" value="Philippines">
    <input type="text" id="postal_code" placeholder="Enter Postal Code">

    <button id="saveAddress">Save Address</button>

    <script>
        $(document).ready(function() {
            // Fetch municipalities when province is selected
            $('#province').change(function() {
                let provinceCode = $(this).val();

                if (provinceCode) {
                    $.ajax({
                        url: '/get-municipalities',
                        type: 'GET',
                        data: {
                            province_code: provinceCode
                        },
                        success: function(data) {
                            if (!Array.isArray(data)) {
                                alert("Invalid response from server");
                                return;
                            }

                            $('#municipality').empty().append('<option value="">Select Municipality</option>');
                            data.forEach(municipality => {
                                $('#municipality').append(`<option value="${municipality.code}">${municipality.name}</option>`);
                            });

                            $('#municipality').prop('disabled', false);
                        },
                        error: function(xhr) {
                            alert("Error fetching municipalities: " + xhr.responseText);
                        }
                    });
                } else {
                    $('#municipality').empty().append('<option value="">Select Municipality</option>').prop('disabled', true);
                }
            });


            // Fetch barangays when municipality is selected
            $('#municipality').change(function() {
                let municipalityCode = $(this).val();

                if (municipalityCode) {
                    $.ajax({
                        url: '/get-barangays',
                        type: 'GET',
                        data: {
                            municipality_code: municipalityCode
                        },
                        success: function(data) {
                            if (!Array.isArray(data)) {
                                alert("Invalid response from server");
                                return;
                            }

                            $('#barangay').empty().append('<option value="">Select Barangay</option>');
                            data.forEach(barangay => {
                                $('#barangay').append(`<option value="${barangay.code}">${barangay.name}</option>`);
                            });

                            $('#barangay').prop('disabled', false);
                        },
                        error: function(xhr) {
                            alert("Error fetching barangays: " + xhr.responseText);
                        }
                    });
                } else {
                    $('#barangay').empty().append('<option value="">Select Barangay</option>').prop('disabled', true);
                }
            });

            $('#saveAddress').click(function() {
                let street = $('#street').val();
                let province = $('#province option:selected').text();
                let municipality = $('#municipality option:selected').text();
                let barangay = $('#barangay option:selected').text();
                let country = $('#country').val();
                let postal_code = $('#postal_code').val();

                if (!street || !province || !municipality || !barangay || !country || !postal_code) {
                    alert('Please fill out all fields.');
                    return;
                }

                $.ajax({
                    url: '/save-address',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        street: street,
                        province: province,
                        municipality: municipality,
                        barangay: barangay,
                        country: country,
                        postal_code: postal_code
                    },
                    success: function(response) {
                        alert(response.success);
                    },
                    error: function(xhr) {
                        alert('Error saving address: ' + xhr.responseText);
                    }
                });
            });

        });
        
    </script>

</body>

</html>

@endsection