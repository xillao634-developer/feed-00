@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-6 py-8">

    <!-- Top Navigation -->
    <header class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-bold text-gray-800">Smart Feedback Portal</h1>

        <nav class="space-x-6 text-gray-700 font-semibold">
            <a href="/" class="hover:text-blue-600">Home</a>
            <a href="/dashboard" class="hover:text-blue-600">Dashboard</a>
            <a href="/feedback/create" class="hover:text-blue-600">Feedback</a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button class="px-4 py-2 bg-white border rounded-lg shadow hover:bg-gray-100">
                    Logout
                </button>
            </form>
        </nav>
    </header>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        <!-- Submit Feedback Form -->
        <div class="bg-white shadow-md rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4">Submit Feedback</h2>

            <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block font-medium text-gray-700">Category</label>
                    <select name="category" class="w-full border rounded-lg p-2">
                        <option>Course</option>
                        <option>Facility</option>
                        <option>Administration</option>
                        <option>Other</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Subject</label>
                    <input type="text" name="subject" class="w-full border p-2 rounded-lg" required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Message</label>
                    <textarea name="message" class="w-full border p-2 rounded-lg h-28" required></textarea>
                </div>

                <div>
                    <input type="file" name="attachment" class="block text-gray-600">
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="anonymous" value="1">
                    <span>Submit anonymously</span>
                </div>

                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Submit
                </button>
            </form>
        </div>


        <!-- Stats + Dashboard -->
        <div class="space-y-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white p-6 shadow rounded-xl text-center">
                    <div class="text-blue-600 text-3xl font-bold">15</div>
                    <div class="text-gray-700 font-semibold">Total Feedback</div>
                </div>

                <div class="bg-white p-6 shadow rounded-xl text-center">
                    <div class="text-green-600 text-3xl font-bold">8</div>
                    <div class="text-gray-700 font-semibold">Resolved</div>
                </div>

                <div class="bg-white p-6 shadow rounded-xl text-center">
                    <div class="text-yellow-500 text-3xl font-bold">4</div>
                    <div class="text-gray-700 font-semibold">Pending</div>
                </div>
            </div>


            <!-- Feedback Dashboard Table -->
            <div class="bg-white shadow rounded-xl p-6">
                <h2 class="text-lg font-semibold mb-4">Feedback Dashboard</h2>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left text-gray-600">
                            <th class="p-3">ID</th>
                            <th class="p-3">Category</th>
                            <th class="p-3">Subject</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="border-b">
                            <td class="p-3">1</td>
                            <td class="p-3">Course</td>
                            <td class="p-3">Suggestions for Improvement</td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded bg-green-100 text-green-700">Resolved</span>
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="p-3">2</td>
                            <td class="p-3">Facility</td>
                            <td class="p-3">Request for New Equipment</td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded bg-yellow-100 text-yellow-700">Pending</span>
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="p-3">3</td>
                            <td class="p-3">Course</td>
                            <td class="p-3">Feedback on Lecture</td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded bg-green-100 text-green-700">Resolved</span>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </div>

</div>
@endsection
  