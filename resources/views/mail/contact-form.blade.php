<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #1f2937; background: #f9fafb; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #78350f, #d97706); padding: 28px 32px; }
        .header h1 { color: #fff; margin: 0; font-size: 20px; font-weight: 700; }
        .header p { color: rgba(255,255,255,0.8); margin: 4px 0 0; font-size: 13px; }
        .body { padding: 32px; }
        .field { margin-bottom: 20px; }
        .label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #6b7280; margin-bottom: 4px; }
        .value { font-size: 15px; color: #111827; }
        .message-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; font-size: 14px; line-height: 1.6; color: #374151; white-space: pre-wrap; }
        .footer { padding: 16px 32px; background: #f3f4f6; font-size: 12px; color: #9ca3af; text-align: center; }
        .divider { border: none; border-top: 1px solid #f3f4f6; margin: 4px 0 20px; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <h1>Nuova richiesta di contatto</h1>
        <p>Ricevuta tramite il sito TicketFlow</p>
    </div>

    <div class="body">

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
            <div class="field">
                <div class="label">Nome</div>
                <div class="value">{{ $data['nome'] }}</div>
            </div>
            <div class="field">
                <div class="label">Cognome</div>
                <div class="value">{{ $data['cognome'] }}</div>
            </div>
        </div>

        <hr class="divider">

        <div class="field">
            <div class="label">Email aziendale</div>
            <div class="value"><a href="mailto:{{ $data['email'] }}" style="color:#d97706;">{{ $data['email'] }}</a></div>
        </div>

        @if(!empty($data['azienda']))
        <div class="field">
            <div class="label">Azienda</div>
            <div class="value">{{ $data['azienda'] }}</div>
        </div>
        @endif

        @if(!empty($data['telefono']))
        <div class="field">
            <div class="label">Telefono</div>
            <div class="value">{{ $data['telefono'] }}</div>
        </div>
        @endif

        <hr class="divider">

        <div class="field">
            <div class="label">Messaggio</div>
            <div class="message-box">{{ $data['messaggio'] }}</div>
        </div>

    </div>

    <div class="footer">
        Email generata automaticamente da TicketFlow &mdash; {{ now()->format('d/m/Y H:i') }}
    </div>

</div>
</body>
</html>
