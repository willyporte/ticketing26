<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class TicketAttachmentSeeder extends Seeder
{
    /**
     * Seed allegati demo: crea i record DB e il file fisico reale per ogni tipo.
     *
     * PNG  → immagine 1×1 pixel valida (apre in qualsiasi visualizzatore)
     * DOCX → ZIP Office Open XML minimale (apre in Word / LibreOffice)
     * XLSX → ZIP SpreadsheetML minimale (apre in Excel / LibreOffice Calc)
     * PDF  → generato programmaticamente senza dipendenze esterne
     *
     * Viene ricreato ad ogni demo:reset tramite migrate:fresh --seed.
     */
    public function run(): void
    {
        $acme = Company::where('vat_number', 'IT01234567890')->first();

        $cliente1 = User::where('email', 'cliente1@demo.com')->first();
        $cliente2 = User::where('email', 'cliente2@demo.com')->first();

        // ── Ticket 1: screenshot errore allegato alla reply di cliente1 ─────────
        // La reply dice "Ho allegato uno screenshot dell'errore" — l'allegato
        // deve apparire inline in quel messaggio, non come allegato generico del ticket.
        $ticket1 = Ticket::where('title', 'Impossibile accedere al pannello di controllo')->first();
        if ($ticket1) {
            $reply = $ticket1->replies()->where('user_id', $cliente1->id)->first();
            if ($reply && $reply->attachments()->count() === 0) {
                $this->createAttachment(
                    ticketId:   $ticket1->id,
                    replyId:    $reply->id,
                    uploadedBy: $cliente1->id,
                    companyId:  $acme->id,
                    filename:   'screenshot-errore-500.png',
                    extension:  'png',
                    mimeType:   'image/png',
                    size:       245_760,
                );
            }
        }

        // ── Ticket 2: documento specifiche allegato a una reply ───────────────
        $ticket2 = Ticket::where('title', 'Richiesta nuova funzionalità: esportazione PDF')->first();
        if ($ticket2) {
            $reply = $ticket2->replies()->where('user_id', $cliente2->id)->first();
            if ($reply && $reply->attachments()->count() === 0) {
                $this->createAttachment(
                    ticketId:   $ticket2->id,
                    replyId:    $reply->id,
                    uploadedBy: $cliente2->id,
                    companyId:  $acme->id,
                    filename:   'specifiche-esportazione.docx',
                    extension:  'docx',
                    mimeType:   'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    size:       87_040,
                );
            }
        }

        // ── Ticket 3: file Excel voci fattura allegato a una reply ────────────
        $ticket3 = Ticket::where('title', 'Errore nel calcolo delle fatture di marzo')->first();
        if ($ticket3) {
            $reply = $ticket3->replies()->where('user_id', $cliente1->id)->first();
            if ($reply && $reply->attachments()->count() === 0) {
                $this->createAttachment(
                    ticketId:   $ticket3->id,
                    replyId:    $reply->id,
                    uploadedBy: $cliente1->id,
                    companyId:  $acme->id,
                    filename:   'fatture-marzo-voci-errate.xlsx',
                    extension:  'xlsx',
                    mimeType:   'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    size:       512_000,
                );
            }
        }
    }

    private function createAttachment(
        int     $ticketId,
        ?int    $replyId,
        int     $uploadedBy,
        int     $companyId,
        string  $filename,
        string  $extension,
        string  $mimeType,
        int     $size,
    ): void {
        $uuid = Str::uuid();
        $path = "attachments/{$companyId}/{$ticketId}/{$uuid}.{$extension}";

        Storage::disk('local')->put($path, $this->generateFile($filename, $extension));

        TicketAttachment::create([
            'ticket_id'   => $replyId ? null : $ticketId,
            'reply_id'    => $replyId,
            'uploaded_by' => $uploadedBy,
            'filename'    => $filename,
            'path'        => $path,
            'mime_type'   => $mimeType,
            'size'        => $size,
        ]);
    }

    // ─── Router per tipo ─────────────────────────────────────────────────────

    private function generateFile(string $filename, string $extension): string
    {
        return match ($extension) {
            'png', 'jpg', 'jpeg', 'gif', 'webp' => $this->generatePng(),
            'pdf'                                => $this->generatePdf($filename),
            'docx', 'doc'                        => $this->generateDocx($filename),
            'xlsx', 'xls'                        => $this->generateXlsx($filename),
            'txt'                                => $this->generateTxt($filename),
            'zip'                                => $this->generateZip($filename),
            default                              => $this->generatePdf($filename),
        };
    }

    // ─── Generatori ──────────────────────────────────────────────────────────

    /**
     * PNG 1×1 pixel (amber #f59e0b) — apre in qualsiasi visualizzatore immagini.
     */
    private function generatePng(): string
    {
        // PNG minimale 1×1 pixel, colore amber, generato con GD e hardcodato.
        // Ricrearlo in GD richiede l'estensione gd — questo è self-contained.
        return base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQI12Ng' .
            'AAQAAQACAQABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' .
            'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' .
            'AAAAAAAAAAAAAAAAAAAAAAAAP///////wAAAABJRU5ErkJggg=='
        );
    }

    /**
     * DOCX minimale (Office Open XML) — ZIP con i 4 file richiesti da Word.
     */
    private function generateDocx(string $filename): string
    {
        $tmp = tempnam(sys_get_temp_dir(), 'docx_');

        $zip = new ZipArchive();
        $zip->open($tmp, ZipArchive::OVERWRITE);

        $zip->addFromString('[Content_Types].xml', implode('', [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>',
            '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">',
            '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>',
            '<Default Extension="xml" ContentType="application/xml"/>',
            '<Override PartName="/word/document.xml"',
            ' ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>',
            '</Types>',
        ]));

        $zip->addFromString('_rels/.rels', implode('', [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>',
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">',
            '<Relationship Id="rId1"',
            ' Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument"',
            ' Target="word/document.xml"/>',
            '</Relationships>',
        ]));

        $zip->addFromString('word/_rels/document.xml.rels', implode('', [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>',
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"/>',
        ]));

        $safeFilename = htmlspecialchars($filename, ENT_XML1, 'UTF-8');
        $zip->addFromString('word/document.xml', implode('', [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>',
            '<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">',
            '<w:body>',
            '<w:p><w:pPr><w:jc w:val="center"/></w:pPr>',
            '<w:r><w:rPr><w:b/><w:sz w:val="32"/></w:rPr>',
            '<w:t>FILE DEMO &#x2014; TicketFlow</w:t></w:r></w:p>',
            '<w:p><w:r><w:t></w:t></w:r></w:p>',
            "<w:p><w:r><w:t>Nome file: {$safeFilename}</w:t></w:r></w:p>",
            '<w:p><w:r><w:t>Ambiente: Dimostrativo</w:t></w:r></w:p>',
            '<w:p><w:r><w:t></w:t></w:r></w:p>',
            '<w:p><w:r><w:t>Questo documento e&#39; un segnaposto generato automaticamente</w:t></w:r></w:p>',
            '<w:p><w:r><w:t>dal seeder demo. Non contiene dati reali.</w:t></w:r></w:p>',
            '</w:body>',
            '</w:document>',
        ]));

        $zip->close();

        $content = file_get_contents($tmp);
        unlink($tmp);

        return $content;
    }

    /**
     * XLSX minimale (SpreadsheetML) — ZIP con i file richiesti da Excel.
     */
    private function generateXlsx(string $filename): string
    {
        $tmp = tempnam(sys_get_temp_dir(), 'xlsx_');

        $zip = new ZipArchive();
        $zip->open($tmp, ZipArchive::OVERWRITE);

        $zip->addFromString('[Content_Types].xml', implode('', [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>',
            '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">',
            '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>',
            '<Default Extension="xml" ContentType="application/xml"/>',
            '<Override PartName="/xl/workbook.xml"',
            ' ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>',
            '<Override PartName="/xl/worksheets/sheet1.xml"',
            ' ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>',
            '</Types>',
        ]));

        $zip->addFromString('_rels/.rels', implode('', [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>',
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">',
            '<Relationship Id="rId1"',
            ' Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument"',
            ' Target="xl/workbook.xml"/>',
            '</Relationships>',
        ]));

        $zip->addFromString('xl/_rels/workbook.xml.rels', implode('', [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>',
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">',
            '<Relationship Id="rId1"',
            ' Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet"',
            ' Target="worksheets/sheet1.xml"/>',
            '</Relationships>',
        ]));

        $zip->addFromString('xl/workbook.xml', implode('', [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>',
            '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"',
            ' xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">',
            '<sheets><sheet name="Demo" sheetId="1" r:id="rId1"/></sheets>',
            '</workbook>',
        ]));

        $safeFilename = htmlspecialchars($filename, ENT_XML1, 'UTF-8');
        $zip->addFromString('xl/worksheets/sheet1.xml', implode('', [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>',
            '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">',
            '<sheetData>',
            '<row r="1"><c r="A1" t="inlineStr"><is><t>FILE DEMO &#x2014; TicketFlow</t></is></c></row>',
            "<row r=\"2\"><c r=\"A2\" t=\"inlineStr\"><is><t>Nome file: {$safeFilename}</t></is></c></row>",
            '<row r="3"><c r="A3" t="inlineStr"><is><t>Ambiente: Dimostrativo</t></is></c></row>',
            '<row r="4"><c r="A4" t="inlineStr"><is><t></t></is></c></row>',
            '<row r="5"><c r="A5" t="inlineStr"><is><t>Questo foglio e\' un segnaposto generato automaticamente dal seeder demo.</t></is></c></row>',
            '<row r="6"><c r="A6" t="inlineStr"><is><t>Non contiene dati reali.</t></is></c></row>',
            '</sheetData>',
            '</worksheet>',
        ]));

        $zip->close();

        $content = file_get_contents($tmp);
        unlink($tmp);

        return $content;
    }

    /**
     * PDF valido (PDF 1.4, Courier built-in) — nessuna dipendenza esterna.
     */
    private function generatePdf(string $filename): string
    {
        $lines = [
            '================================================',
            '   FILE DEMO  -  TicketFlow',
            '================================================',
            '',
            "   Nome file  : {$filename}",
            '   Ambiente   : Dimostrativo',
            '',
            '   Questo e un file segnaposto generato',
            '   automaticamente dal seeder demo.',
            '   Non contiene dati reali.',
            '',
            '================================================',
        ];

        $stream = "BT\n/F1 10 Tf\n50 750 Td\n";
        foreach ($lines as $i => $line) {
            $escaped = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $line);
            $stream .= ($i === 0 ? '' : "0 -16 Td\n") . "({$escaped}) Tj\n";
        }
        $stream .= "ET\n";

        $streamLen = \strlen($stream);
        $body      = "%PDF-1.4\n";
        $off       = [];

        $off[1] = \strlen($body);
        $body .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";

        $off[2] = \strlen($body);
        $body .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";

        $off[3] = \strlen($body);
        $body .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792]"
              .  " /Contents 5 0 R /Resources << /Font << /F1 4 0 R >> >> >>\nendobj\n";

        $off[4] = \strlen($body);
        $body .= "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Courier >>\nendobj\n";

        $off[5] = \strlen($body);
        $body .= "5 0 obj\n<< /Length {$streamLen} >>\nstream\n{$stream}endstream\nendobj\n";

        $xrefPos = \strlen($body);
        $body .= "xref\n0 6\n0000000000 65535 f \n";
        foreach ($off as $offset) {
            $body .= \sprintf("%010d 00000 n \n", $offset);
        }
        $body .= "trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n{$xrefPos}\n%%EOF\n";

        return $body;
    }

    /**
     * TXT — testo semplice leggibile in qualsiasi editor.
     */
    private function generateTxt(string $filename): string
    {
        return implode(PHP_EOL, [
            '================================================',
            '  FILE DEMO — TicketFlow',
            '================================================',
            '',
            "  Nome file : {$filename}",
            '  Ambiente  : Dimostrativo',
            '',
            '  Questo e un file segnaposto generato automaticamente',
            '  dal seeder demo. Non contiene dati reali.',
            '================================================',
        ]);
    }

    /**
     * ZIP minimale contenente un file README.txt.
     */
    private function generateZip(string $filename): string
    {
        $tmp = tempnam(sys_get_temp_dir(), 'zip_');

        $zip = new ZipArchive();
        $zip->open($tmp, ZipArchive::OVERWRITE);
        $zip->addFromString('README.txt', $this->generateTxt($filename));
        $zip->close();

        $content = file_get_contents($tmp);
        unlink($tmp);

        return $content;
    }
}
