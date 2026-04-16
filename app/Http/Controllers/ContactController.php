<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome'      => ['required', 'string', 'max:100'],
            'cognome'   => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email:rfc,dns', 'max:255'],
            'azienda'   => ['nullable', 'string', 'max:200'],
            'telefono'  => ['nullable', 'string', 'max:30'],
            'messaggio' => ['required', 'string', 'min:10', 'max:3000'],
            'privacy'   => ['accepted'],
        ], [
            'nome.required'      => 'Il nome è obbligatorio.',
            'cognome.required'   => 'Il cognome è obbligatorio.',
            'email.required'     => 'L\'email aziendale è obbligatoria.',
            'email.email'        => 'Inserisci un indirizzo email valido.',
            'messaggio.required' => 'Il messaggio è obbligatorio.',
            'messaggio.min'      => 'Il messaggio deve contenere almeno 10 caratteri.',
            'privacy.accepted'   => 'Devi accettare la Privacy Policy e i Termini e Condizioni per procedere.',
        ]);

        Mail::to(config('app.sys_email'))->send(new ContactFormMail($validated));

        return redirect()->route('contattaci')->with('success', true);
    }
}
