@extends('frontend.layout')

@section('title', 'إتمام عملية الشراء')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map { height: 300px; z-index: 1; }
    </style>
@endpush

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-5">إتمام عملية الشراء</h2>
    <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="brand-text">سلتك</span>
                <span class="badge brand-gradient rounded-pill text-white">{{ count($cartItems) }}</span>
            </h4>
            <ul class="list-group mb-3">
                @php $total = 0 @endphp
                @foreach($cartItems as $item)
                    @php $total += $item['price'] * $item['quantity'] @endphp
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">{{ $item['name'] }}</h6>
                            <small class="text-muted">الكمية: {{ $item['quantity'] }}</small>
                        </div>
                        <span class="text-muted">{{ number_format($item['price'] * $item['quantity'], 0) }} د.ع</span>
                    </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between">
                    <span>المجموع (د.ع)</span>
                    <strong>{{ number_format($total, 0) }}</strong>
                </li>
            </ul>
        </div>

        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3">عنوان التوصيل</h4>
            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="governorate" class="form-label">المحافظة</label>
                        <input type="text" class="form-control" id="governorate" name="governorate" value="{{ old('governorate') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="city" class="form-label">المدينة / القضاء</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                    </div>
                    <div class="col-12">
                        <label for="nearest_landmark" class="form-label">أقرب نقطة دالة</label>
                        <input type="text" class="form-control" id="nearest_landmark" name="nearest_landmark" value="{{ old('nearest_landmark') }}" required>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="mb-0">تحديد الموقع على الخريطة</h4>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="get_location_btn">
                        <i class="bi bi-geo-alt"></i> تحديد موقعي الحالي
                    </button>
                </div>
                <div id="map" class="border rounded shadow-sm"></div>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <hr class="my-4">
                
                <h4 class="mb-3">طريقة الدفع</h4>
                <div class="my-3">
                    <div class="form-check">
                        <input id="cash" name="payment_method" type="radio" class="form-check-input" checked required>
                        <label class="form-check-label" for="cash">الدفع عند الاستلام</label>
                    </div>
                </div>

                <hr class="my-4">
                <button class="w-100 btn brand-gradient text-white btn-lg" type="submit">تأكيد الطلب</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let defaultLat = 33.3152;
            let defaultLng = 44.3661;
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const map = L.map('map').setView([defaultLat, defaultLng], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
            function updateCoordinates(lat, lng) {
                latInput.value = lat;
                lngInput.value = lng;
                marker.setLatLng([lat, lng]);
            }
            marker.on('dragend', (e) => updateCoordinates(e.target.getLatLng().lat, e.target.getLatLng().lng));
            map.on('click', (e) => updateCoordinates(e.latlng.lat, e.latlng.lng));
            document.getElementById('get_location_btn').addEventListener('click', () => {
                if ('geolocation' in navigator) {
                    navigator.geolocation.getCurrentPosition(position => {
                        const { latitude, longitude } = position.coords;
                        map.setView([latitude, longitude], 15);
                        updateCoordinates(latitude, longitude);
                    }, () => alert('لم نتمكن من الوصول إلى موقعك.'));
                } else {
                    alert('المتصفح لا يدعم خدمة تحديد المواقع.');
                }
            });
             updateCoordinates(defaultLat, defaultLng);
        });
    </script>
@endpush
