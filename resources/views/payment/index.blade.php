@extends('layouts.dashboard')
@section('page-title', 'Payment Methods')

@section('dashboard-content')
    <div class="profile-content-card">
        <!-- Header -->
        <div class="profile-header">
            <h4 class="fw-bold mb-0">Add Payment Method</h4>
        </div>

        <hr class="my-3">

        <!-- Add Payment Method Form -->
        <form method="POST" action="{{ route('payment.store') }}">
            @csrf

            <div class="mb-3">
                <label for="card_name" class="form-label fw-semibold">Name on Card<span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('card_name') is-invalid @enderror"
                       id="card_name" name="card_name" placeholder="e.g. John" value="{{ old('card_name') }}" required>
                @error('card_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="card_number" class="form-label fw-semibold">Debit/Credit card number<span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('card_number') is-invalid @enderror"
                       id="card_number" name="card_number" placeholder="0000 0000 0000 0000"
                       value="{{ old('card_number') }}" maxlength="19" required>
                @error('card_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label for="expiry" class="form-label fw-semibold">Expiry Date <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('expiry') is-invalid @enderror"
                           id="expiry" name="expiry" placeholder="MM/YY" value="{{ old('expiry') }}" maxlength="7" required>
                    @error('expiry')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="cvv" class="form-label fw-semibold">CVV <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('cvv') is-invalid @enderror"
                           id="cvv" name="cvv" placeholder="e.g. Smith" value="{{ old('cvv') }}" maxlength="4" required>
                    @error('cvv')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" id="text_alerts" name="text_alerts" value="1"
                       {{ old('text_alerts') ? 'checked' : '' }}>
                <label class="form-check-label small" for="text_alerts">
                    Receive text alerts about this trip. Message and data rates may apply.
                </label>
            </div>

            <button type="submit" class="btn btn-dark w-100 rounded-pill py-2 fw-semibold">Add</button>
        </form>

        <!-- Saved Payment Methods -->
        @if($paymentMethods->count())
            <hr class="my-4">
            <h5 class="fw-bold mb-3">Saved Cards</h5>

            @foreach($paymentMethods as $method)
                <div class="d-flex justify-content-between align-items-center border rounded-3 p-3 mb-2">
                    <div>
                        <div class="fw-semibold">
                            <span class="text-uppercase">{{ $method->card_brand }}</span>
                            &middot; {{ $method->masked_card_number }}
                        </div>
                        <small class="text-muted">{{ $method->card_name }} &middot; Expires {{ $method->formatted_expiry }}</small>
                    </div>
                    <form method="POST" action="{{ route('payment.destroy', $method) }}"
                          onsubmit="return confirm('Remove this card?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Remove">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>
@endsection

@push('scripts')
<script>
    // Format card number input with spaces (0000 0000 0000 0000)
    document.getElementById('card_number').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '').substring(0, 16);
        e.target.value = value.replace(/(.{4})/g, '$1 ').trim();
    });

    // Format expiry input (MM/YY)
    document.getElementById('expiry').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '').substring(0, 4);
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        e.target.value = value;
    });

    // CVV: numbers only
    document.getElementById('cvv').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
    });
</script>
@endpush
