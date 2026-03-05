<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['invoice_number'] }}</title>

    @include('partials.head')
</head>

<body>
    <div
        style="margin: 0 auto; padding: 20mm; font-family: Arial, sans-serif; font-size: 12px; color: #333; box-sizing: border-box; background: #fff;">

        {{-- HEADER --}}
        <div style="border-bottom: 1px solid #ccc; padding-bottom: 20px; margin-bottom: 20px;">
            <table style="width: 100%;">
                <tr>
                    {{-- BUSINESS INFO --}}
                    <td style="width: 50%; vertical-align: top;">
                        <div style="font-size: 20px; font-weight: bold;">
                            {{ $data['business']->name }}
                        </div>
                        <div style="margin-top: 5px; font-size: 12px; color: #555; line-height: 1.4;">
                            <div>{{ $data['business']->address }}</div>
                            <div>{{ $data['business']->phone }}</div>
                        </div>
                    </td>

                    {{-- INVOICE META --}}
                    <td style="width: 50%; vertical-align: top; text-align: right;">
                        <div style="font-size: 24px; font-weight: bold; text-transform: uppercase;">
                            Invoice
                        </div>
                        <div style="margin-top: 15px; font-size: 12px;">
                            <div style="margin-bottom: 5px;"><strong>No:</strong> {{ $data['invoice_number'] }}</div>
                            <div style="margin-bottom: 5px;"><strong>Tanggal:</strong> {{ $data['invoice_date'] }}</div>
                            <div><strong>Jatuh Tempo:</strong> {{ $data['due_date'] }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- BILL TO --}}
        <div style="margin-bottom: 20px;">
            <div
                style="text-transform: uppercase; letter-spacing: 1px; color: #888; font-size: 10px; margin-bottom: 5px;">
                Bill To
            </div>
            <div style="font-weight: bold;">
                {{ $data['customer']->name ?? '-' }}
            </div>
        </div>

        {{-- TABLE --}}
        <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <tr>
                        <th
                            style="text-align: left; padding: 12px 8px; width: 60%; font-size: 12px; text-transform: uppercase; color: #4b5563;">
                            Description</th>
                        <th
                            style="text-align: right; padding: 12px 8px; width: 10%; font-size: 12px; text-transform: uppercase; color: #4b5563;">
                            Qty</th>
                        <th
                            style="text-align: right; padding: 12px 8px; width: 15%; font-size: 12px; text-transform: uppercase; color: #4b5563;">
                            Price</th>
                        <th
                            style="text-align: right; padding: 12px 8px; width: 15%; font-size: 12px; text-transform: uppercase; color: #4b5563;">
                            Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['items'] as $index => $item)
                        <tr>
                            {{-- Menambahkan border-bottom pada setiap TD --}}
                            {{-- Periksa apakah ini baris terakhir untuk estetika yang lebih baik --}}
                            @php
                                $isLast = $loop->last;
                                $borderStyle = $isLast ? '' : 'border-bottom: 1px solid #eeeeee;';
                            @endphp

                            <td style="padding: 12px 8px; {{ $borderStyle }}">{{ $item['description'] }}</td>
                            <td style="padding: 12px 8px; text-align: right; {{ $borderStyle }}">{{ $item['qty'] }}
                            </td>
                            <td style="padding: 12px 8px; text-align: right; {{ $borderStyle }}">Rp
                                {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td style="padding: 12px 8px; text-align: right; font-weight: bold; {{ $borderStyle }}">Rp
                                {{ number_format($item['total'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- SUMMARY --}}
        <div style="margin-top: 20px; width: 50%; margin-left: auto;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 5px; color: #555;">
                <span>Subtotal</span>
                <span>Rp {{ number_format($data['total'], 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 5px; color: #555;">
                <span>Pajak</span>
                <span>Rp 0</span>
            </div>
            <div
                style="border-top: 1px solid #ccc; padding-top: 5px; display: flex; justify-content: space-between; font-weight: bold; font-size: 14px;">
                <span>Total</span>
                <span>Rp {{ number_format($data['total'], 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- NOTES & PAYMENT --}}
        <div style="margin-top: 30px; border-top: 1px solid #ccc; padding-top: 15px; font-size: 12px; color: #555;">
            <table style="width: 100%; table-layout: fixed;">
                <tr>
                    {{-- TERMS --}}
                    <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                        <div
                            style="text-transform: uppercase; letter-spacing: 1px; font-size: 10px; color: #888; margin-bottom: 5px;">
                            Terms & Conditions
                        </div>
                        <div>Pembayaran wajib dilakukan sebelum tanggal jatuh tempo yang tertera.</div>
                    </td>

                    {{-- PAYMENT INFO --}}
                    <td style="width: 50%; vertical-align: top; padding-left: 10px;">
                        <div
                            style="text-transform: uppercase; letter-spacing: 1px; font-size: 10px; color: #888; margin-bottom: 5px;">
                            Payment Information
                        </div>
                        <div style="line-height: 1.5;">
                            <div style="display: flex; justify-content: space-between;">
                                <span>Bank</span>
                                <span style="font-weight: bold;">BCA</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>No. Rekening</span>
                                <span style="font-weight: bold;">1234567890</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Atas Nama</span>
                                <span style="font-weight: bold;">{{ $data['business']->name }}</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 40px; text-align: center; color: #999; font-size: 10px;">
            Terima kasih atas kepercayaan Anda bertransaksi dengan {{ $data['business']->name }}.<br>
            Invoice ini sah dihasilkan secara elektronik oleh sistem <strong>Notunota</strong>.
        </div>
    </div>

</body>

</html>
