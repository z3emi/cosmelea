@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-5xl mx-auto flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-1/4 bg-white p-4 shadow rounded-lg">
            <h2 class="font-bold text-lg mb-4">ACCOUNT INFORMATION</h2>
            <ul class="space-y-2">
                <li><a href="#personal" class="text-sm font-semibold text-pink-700">Personal Details</a></li>
                <li><a href="#address" class="text-sm font-semibold text-gray-600">Address Information</a></li>
                <li><a href="#contact" class="text-sm font-semibold text-gray-600">Contact Information</a></li>
            </ul>
        </div>

        <div class="w-full md:w-3/4 bg-white p-6 shadow rounded-lg">
            <div class="mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gray-300 rounded-full"></div>
                    <div>
                        <h1 class="text-xl font-bold uppercase">{{ $user->first_name }} {{ $user->last_name }}</h1>
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf

                <div id="personal">
                    <h3 class="font-bold text-lg border-b pb-2 mb-2">PERSONAL DETAILS</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-input label="First Name" name="first_name" value="{{ $user->first_name }}" />
                        <x-input label="Middle Name" name="middle_name" value="{{ $user->middle_name }}" />
                        <x-input label="Last Name" name="last_name" value="{{ $user->last_name }}" />
                        <x-input label="Date of Birth" name="date_of_birth" type="date" value="{{ $user->date_of_birth }}" />
                        <x-select label="Gender" name="gender" :options="['Male'=>'Male','Female'=>'Female']" :selected="$user->gender" />
                        <x-input label="Country of Birth" name="country_of_birth" value="{{ $user->country_of_birth }}" />
                    </div>
                </div>

                <div id="address">
                    <h3 class="font-bold text-lg border-b pb-2 mb-2">ADDRESS INFORMATION</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-input label="Country of Residence" name="country_of_residence" value="{{ $user->country_of_residence }}" />
                        <x-input label="City of Residence" name="city_of_residence" value="{{ $user->city_of_residence }}" />
                        <x-input label="Street Address" name="street_address" value="{{ $user->street_address }}" />
                        <x-input label="Zip/Postal Code" name="zip_code" value="{{ $user->zip_code }}" />
                    </div>
                </div>

                <div id="contact">
                    <h3 class="font-bold text-lg border-b pb-2 mb-2">CONTACT INFORMATION</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-input label="Phone Number" name="phone" value="{{ $user->phone }}" />
                        <x-input label="Email (read only)" name="email" :value="$user->email" disabled />
                    </div>
                </div>

                <button type="submit" class="mt-4 bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection