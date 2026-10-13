<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StreamController;

Route::get('/', function () {
    return view('welcome');
});
Route::livewire('/login', 'pages::login');
Route::livewire('/dashboard', 'pages::dashboard');
Route::livewire('/chat', 'pages::chat');

Route::post('/chat/stream', StreamController::class)->name('chat.stream');

Route::livewire('/chat/{conversationId?}', 'pages::chat')->name('chat');
Route::livewire('/user', 'pages::administrations.user')->name('user');
Route::livewire('/role', 'pages::administrations.role')->name('role');
Route::livewire('/settings', 'pages::systems.settings')->name('settings');
