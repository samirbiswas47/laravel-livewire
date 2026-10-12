<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>
<div class="bg-white shadow-lg rounded-2xl p-8 ">

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Login to your account
        </h2>

        <form method="POST" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-600">
                    User
                </label>
                <input type="text" name="email" required
                    class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-600">
                    Password
                </label>
                <input type="password" name="password" required
                    class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Remember me -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" class="rounded">
                    <span>Remember me</span>
                </label>

                <a href="#" class="text-blue-500 hover:underline">
                    Forgot password?
                </a>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Login
            </button>
        </form>

                <div class="mb-4 px-4 py-2  text-red-500">
                    {{-- $message --}}
                </div>

        <!-- Signup link -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Don’t have an account?
            <a href="" class="text-blue-500 hover:underline">Sign up</a>
        </p>
<div>
    {{-- An unexamined life is not worth living. - Socrates --}}
    <h2 class="text-center text-red-100">Login Page {{dateFormat("d/m/Y", strtotime(date('d-m-Y')))}}</h2>
<br>
<button
            type="button"
            onclick="toggleTheme()"
            class="rounded-lg border border-border bg-surface
                p-2 text-heading transition
                hover:bg-gray-100 dark:hover:bg-slate-700"
        >
            <span id="theme-icon">🌙</span>
        </button>

</div>
    </div>

