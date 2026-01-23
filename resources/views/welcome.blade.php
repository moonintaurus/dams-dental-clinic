<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAMS Dental Clinic - Sta. Mesa, Manila</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes pageFadeUp {
            0% {
                opacity: 0;
                transform: translateY(6px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-enter {
            position: relative;
            opacity: 0;
            transform: translateY(6px);
            animation: pageFadeUp 0.35s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="page-enter">
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo_no_name.svg') }}" alt="DAMS Dental" class="h-12 w-12">
                        <span class="text-2xl font-bold text-blue-600">DAMS Dental Clinic</span>
                    </div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Dashboard
                        </a>
                    @else
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Login</a>
                            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Welcome to DAMS Dental Clinic</h1>
                <p class="text-xl text-gray-600 mb-8">Your Trusted Dental Care Partner in Sta. Mesa, Manila</p>
                @auth
                    <a href="{{ route('appointments.create') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition shadow-lg">
                        Book an Appointment
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition shadow-lg">
                        Book an Appointment
                    </a>
                @endauth
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                    <div class="text-blue-600 mb-4">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">24/7 Online Booking</h3>
                    <p class="text-gray-600">Book appointments anytime, anywhere with our easy online system</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                    <div class="text-blue-600 mb-4">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Expert Dentists</h3>
                    <p class="text-gray-600">Experienced professionals dedicated to your oral health</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                    <div class="text-blue-600 mb-4">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Digital Records</h3>
                    <p class="text-gray-600">Access your treatment history and records anytime</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Our Services</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="border-l-4 border-blue-600 pl-4">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">General Cleaning</h4>
                        <p class="text-gray-600 text-sm">Professional teeth cleaning - ₱800</p>
                    </div>
                    <div class="border-l-4 border-blue-600 pl-4">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Tooth Extraction</h4>
                        <p class="text-gray-600 text-sm">Safe tooth removal - ₱1,500</p>
                    </div>
                    <div class="border-l-4 border-blue-600 pl-4">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Root Canal</h4>
                        <p class="text-gray-600 text-sm">Root canal treatment - ₱5,000</p>
                    </div>
                    <div class="border-l-4 border-blue-600 pl-4">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Braces Consultation</h4>
                        <p class="text-gray-600 text-sm">Initial braces assessment - ₱500</p>
                    </div>
                    <div class="border-l-4 border-blue-600 pl-4">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Teeth Whitening</h4>
                        <p class="text-gray-600 text-sm">Professional whitening - ₱3,000</p>
                    </div>
                    <div class="border-l-4 border-blue-600 pl-4">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Dental Filling</h4>
                        <p class="text-gray-600 text-sm">Cavity filling - ₱1,200</p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="bg-gray-900 text-white py-8 mt-16">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="mb-2">&copy; 2025 DAMS Dental Clinic. All rights reserved.</p>
                <p class="text-gray-400">Sta. Mesa, Manila | Phone: (02) 1234-5678</p>
                <p class="text-white-400"> BSIT 3-1 Balasbas | Bruno | Kais | Monterola</p>
            </div>
        </footer>
    </div>

    <script>
        window.addEventListener('load', () => {
            window.scrollTo(0, 0);
        });
    </script>
</body>
</html>
