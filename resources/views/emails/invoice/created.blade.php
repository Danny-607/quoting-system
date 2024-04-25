<x-mail::message>
    # Invoice for Project

    Thank you for choosing us. Here are the details of your invoice.
    
    **Invoice Number:** {{ $invoice->id }}
    **Total Amount:** ${{ number_format($invoice->amount, 2) }}
    
    @if($services->isNotEmpty())
        **Services:**
        @foreach ($services as $service)
            - {{ $service->name }} at ${{ number_format($service->price, 2) }}
        @endforeach
    @endif
    **Custom request:**
    {{$quote->description}}
**Total:** ${{ number_format($total, 2) }} <br>
Thanks,<br>
BrightByte
</x-mail::message>
