<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RsvpController;
use App\Models\Event;
use App\Models\Rsvp;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $userId = auth()->id();

    $events = Event::withCount('rsvps')
        ->where('user_id', $userId)
        ->latest()
        ->take(5)
        ->get();

    $eventIds = Event::where('user_id', $userId)->pluck('id');

    return view('dashboard', [
        'events' => $events,
        'totalEvents' => $eventIds->count(),
        'totalResponses' => Rsvp::whereIn('event_id', $eventIds)->count(),
        'totalGuests' => Rsvp::whereIn('event_id', $eventIds)
            ->where('status_hadir', 'hadir')
            ->sum('jumlah_orang'),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/undangan/{slug}', [RsvpController::class, 'show'])->name('rsvp.show');
Route::post('/undangan/{slug}/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');
Route::get('/rsvp/edit/{token}', [RsvpController::class, 'edit'])->name('rsvp.edit');
Route::put('/rsvp/edit/{token}', [RsvpController::class, 'update'])->name('rsvp.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/{template}', [TemplateController::class, 'show'])->name('templates.show');

    Route::resource('events', EventController::class);
});

require __DIR__.'/auth.php';
