<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $invoice, $quote, $services;
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->quote = $invoice->quote;
        $this->services = $invoice->quote->services; // Assuming the quote is not null
    }
    public function build()
    {
        return $this->subject('Invoice Details for Your Project')
                    ->markdown('emails.invoices.email')
                    ->with([
                        'total' => $this->invoice->amount,
                        'services' => $this->services
                    ]);
    
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invoice.created',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
