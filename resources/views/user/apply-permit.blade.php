@extends('layouts.user')

@section('content')

<div class="container py-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center fw-bold mb-4 text-primary">Apply for Business Permit</h2>

        <!-- Success & Error Alerts -->
        @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <form id="permitForm" action="{{ route('apply-permit.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf

            <!-- Proprietor's Information -->
            <div class="card shadow-sm p-4 mb-4 border-0">
                <h4 class="mb-3 fw-bold">Proprietor's Information</h4>
                <div class="row g-3">
                    @foreach(['First Name' => 'first_name', 'Middle Name' => 'middle_name', 'Last Name' => 'last_name'] as $label => $name)
                    <div class="col-md-4">
                        <label class="form-label">{{ $label }}</label>
                        <input type="text" name="{{ $name }}" class="form-control" value="{{ old($name, Auth::user()->$name ?? '') }}" required>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Business Information -->
            <div class="card shadow-sm p-4 mb-4 border-0">
                <h4 class="mb-3 fw-bold">Business Information</h4>
                <div class="row g-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Business Name</label>
                            <input type="text" name="business_name" class="form-control" value="{{ old('business_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Business Type</label>
                            <select name="business_type" class="form-control" required>
                                <option value="" disabled selected>Select Business Type</option>
                                @foreach($businessTypes as $type)
                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- <div class="col-md-6">
                        <label class="form-label">Line of Business</label>
                        <input type="text" name="line_of_business" class="form-control" value="{{ old('line_of_business') }}" required>
                    </div> -->

                    <!-- Address Selection -->
                    <div class="col-md-6">
                        <label class="form-label">Province</label>
                        <select name="province" id="province" class="form-select">
                            <option value="">Select Province</option>
                            @foreach ($provinces as $province)
                            <option value="{{ $province['name'] }}" data-code="{{ $province['code'] }}">{{ $province['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Town</label>
                        <select name="town" id="town" class="form-select">
                            <option value="">Select Town</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Barangay</label>
                        <select name="barangay" id="barangay" class="form-select">
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                    <input type="hidden" name="province" id="selected_province">
                    <input type="hidden" name="town" id="selected_town">
                    <input type="hidden" name="barangay" id="selected_barangay">
                    <div class="col-md-6">
                        <label class="form-label">Street</label>
                        <input type="text" class="form-control" name="street">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control" name="postal_code">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control" name="country" value="Philippines">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Official Receipt (OR) Number</label>
                        <input type="number" name="or_number" class="form-control" value="{{ old('or_number') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Amount Paid</label>
                        <input type="number" name="amount_paid" class="form-control" value="{{ old('amount_paid') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}" required>
                    </div>
                </div>
            </div>

            <!-- Upload Required Documents -->
            <div class="card shadow-sm p-4 mb-4 border-0">
                <h4 class="mb-3 fw-bold">Upload Required Documents</h4>
                <div class="row g-3">
                    @foreach([
                    'Sanitary Permit' => 'sanitary_permit',
                    'Barangay Permit' => 'barangay_permit',
                    'DTI Certificate' => 'dti_certificate',
                    'Official Receipt' => 'official_receipt',
                    'Police Clearance' => 'police_clearance',
                    'Tourism Compliance Certificate' => 'tourism_compliance_certificate'
                    ] as $label => $name)
                    <div class="col-md-6">
                        <label class="form-label">{{ $label }}</label>
                        <input type="file" name="{{ $name }}" class="form-control">
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" id="submitBtn" class="btn btn-primary px-5 py-2 fw-bold">Submit Application</button>
                <button type="button" id="clearBtn" class="btn btn-secondary px-4 py-2 fw-bold ms-2">Clear</button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h4 class="mt-3">Checking...</h4>
            </div>
        </div>
    </div>
</div>


<!-- Confirmation Modal -->
<div id="confirmationModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Submission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to submit this application?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmSubmit" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('clearBtn').addEventListener('click', function() {
        document.getElementById('permitForm').reset();
    });
</script>
<script>
    document.getElementById("submitBtn").addEventListener("click", function(event) {
        event.preventDefault();
        var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        confirmationModal.show();
    });

    document.getElementById("confirmSubmit").addEventListener("click", function() {
        var confirmationModalEl = document.getElementById('confirmationModal');
        var confirmationModal = bootstrap.Modal.getInstance(confirmationModalEl);
        confirmationModal.hide(); // Close confirmation modal

        setTimeout(() => {
            var loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'), {
                backdrop: 'static',
                keyboard: false
            });
            loadingModal.show();

            document.getElementById("submitBtn").disabled = true;

            setTimeout(() => {
                document.getElementById("permitForm").submit();
            }, 2000);
        }, 300); // Small delay to ensure smooth transition
    });
</script>
<script>
    document.getElementById('province').addEventListener('change', function() {
        let provinceCode = this.options[this.selectedIndex].getAttribute('data-code'); // Get the PSGC code
        let provinceName = this.value; // Get the name
        let townSelect = document.getElementById('town');

        document.getElementById('selected_province').value = provinceName; // Store name

        townSelect.innerHTML = '<option value="">Loading...</option>'; // Show loading text

        fetch(`/get-municipalities?province_code=${provinceCode}`)
            .then(response => response.json())
            .then(data => {
                townSelect.innerHTML = '<option value="">Select Town</option>'; // Reset dropdown

                data.forEach(municipality => {
                    townSelect.innerHTML += `<option value="${municipality.name}" data-code="${municipality.code}">${municipality.name}</option>`;
                });
            })
            .catch(error => console.error('Error fetching municipalities:', error));
    });

    document.getElementById('town').addEventListener('change', function() {
        let townCode = this.options[this.selectedIndex].getAttribute('data-code'); // Get PSGC code
        let townName = this.value; // Get name
        let barangaySelect = document.getElementById('barangay');

        document.getElementById('selected_town').value = townName; // Store name

        barangaySelect.innerHTML = '<option value="">Loading...</option>';

        fetch(`/get-barangays?municipality_code=${townCode}`)
            .then(response => response.json())
            .then(data => {
                barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

                data.forEach(barangay => {
                    barangaySelect.innerHTML += `<option value="${barangay.name}">${barangay.name}</option>`;
                });
            })
            .catch(error => console.error('Error fetching barangays:', error));
    });

    document.getElementById('barangay').addEventListener('change', function() {
        document.getElementById('selected_barangay').value = this.value; // Store barangay name
    });
</script>



@endsection