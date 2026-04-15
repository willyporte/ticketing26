<?php

use App\Models\TicketAttachment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', fn () => view('front.home'))->name('home');

Route::get('/come-funziona', fn () => view('front.home'))->name('come-funziona');
Route::get('/contattaci', fn () => view('front.home'))->name('contattaci');
Route::get('/privacy-policy', fn () => view('front.home'))->name('privacy-policy');
Route::get('/termini', fn () => view('front.home'))->name('termini');

// ─── Download allegato (protetto da autenticazione e Policy) ─────────────────
Route::middleware('auth')->get('/attachments/{attachment}/download', function (TicketAttachment $attachment) {
    $ticket = $attachment->ticket ?? $attachment->reply?->ticket;

    abort_unless($ticket && auth()->user()->can('downloadAttachment', $ticket), 403);

    abort_unless(Storage::disk('local')->exists($attachment->path), 404);

    return Storage::disk('local')->download($attachment->path, $attachment->filename);
})->name('attachments.download');
