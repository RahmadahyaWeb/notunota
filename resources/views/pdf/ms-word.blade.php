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
        style="margin: 0 auto; padding: 30mm; font-family: 'Garamond', 'Georgia', serif; color: #1a1a1a; background: #fff; line-height: 1.5;">

        {{-- HEADER: REFINED CLASSIC --}}
        <table style="width: 100%; border-bottom: 1px solid #000; padding-bottom: 20px; margin-bottom: 30px;">
            <tr>
                <td style="vertical-align: middle;">
                    <div
                        style="font-size: 26px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #000;">
                        {{ $data['business']->name }}
                    </div>
                    <div style="font-size: 12px; font-style: italic; color: #555; margin-top: 5px;">
                        {{ $data['business']->address }} | Telp: {{ $data['business']->phone }}
                    </div>
                </td>
                <td style="text-align: right; vertical-align: middle;">
                    <div style="font-size: 32px; font-weight: 100; font-style: italic; color: #999;">Faktur</div>
                </td>
            </tr>
        </table>

        {{-- INFO SECTION --}}
        <table style="width: 100%; margin-bottom: 50px;">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <div
                        style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 10px;">
                        Ditujukan Kepada:</div>
                    <div style="font-size: 18px; font-weight: bold; border-left: 2px solid #000; padding-left: 15px;">
                        {{ $data['customer']->name ?? '-' }}
                    </div>
                </td>
                <td style="width: 40%; vertical-align: top; text-align: right;">
                    <div style="display: inline-block; text-align: left;">
                        <table style="font-size: 13px;">
                            <tr>
                                <td style="padding: 2px 10px 2px 0; color: #888;">No. Invoice</td>
                                <td style="font-weight: bold;">: {{ $data['invoice_number'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 2px 10px 2px 0; color: #888;">Tanggal</td>
                                <td>: {{ $data['invoice_date'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 2px 10px 2px 0; color: #888;">Jatuh Tempo</td>
                                <td style="color: #c00;">: {{ $data['due_date'] }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        {{-- TABLE: MINIMALIST LINE STYLE --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
            <thead>
                <tr style="border-top: 2px solid #000; border-bottom: 1px solid #000;">
                    <th
                        style="text-align: left; padding: 12px 10px; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">
                        Deskripsi Pekerjaan</th>
                    <th
                        style="text-align: center; padding: 12px 10px; font-size: 12px; text-transform: uppercase; width: 60px;">
                        Kuantitas</th>
                    <th
                        style="text-align: right; padding: 12px 10px; font-size: 12px; text-transform: uppercase; width: 120px;">
                        Harga Satuan</th>
                    <th
                        style="text-align: right; padding: 12px 10px; font-size: 12px; text-transform: uppercase; width: 130px;">
                        Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['items'] as $item)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px 10px; font-size: 14px;">{{ $item['description'] }}</td>
                        <td style="padding: 15px 10px; text-align: center; color: #666;">{{ $item['qty'] }}</td>
                        <td style="padding: 15px 10px; text-align: right; color: #666;">
                            {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td style="padding: 15px 10px; text-align: right; font-weight: bold;">
                            {{ number_format($item['total'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- SUMMARY --}}
        <table style="width: 100%;">
            <tr>
                <td
                    style="width: 50%; vertical-align: top; font-size: 12px; font-style: italic; color: #888; padding-top: 10px;">
                    * Pembayaran melalui transfer bank paling lambat pada tanggal jatuh tempo.
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px 10px; text-align: right; color: #888;">Subtotal</td>
                            <td style="padding: 8px 10px; text-align: right; width: 130px;">Rp
                                {{ number_format($data['total'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 10px; text-align: right; color: #888;">Pajak (0%)</td>
                            <td style="padding: 8px 10px; text-align: right;">Rp 0</td>
                        </tr>
                        <tr style="border-top: 2px solid #000; font-size: 16px; font-weight: bold;">
                            <td style="padding: 15px 10px; text-align: right; text-transform: uppercase;">Total Tagihan
                            </td>
                            <td style="padding: 15px 10px; text-align: right;">Rp
                                {{ number_format($data['total'], 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- SIGNATURE & BANK --}}
        <table style="width: 100%; margin-top: 60px;">
            <tr>
                <td style="width: 60%; vertical-align: bottom;">
                    <div style="font-size: 11px; text-transform: uppercase; color: #888; margin-bottom: 5px;">Informasi
                        Rekening:</div>
                    <div style="font-size: 13px;">
                        <strong>Bank BCA</strong><br>
                        No. Rek: 1234 567 890<br>
                        A/N: {{ $data['business']->name }}
                    </div>
                </td>
                <td style="width: 40%; text-align: center;">
                    <div style="font-size: 13px; margin-bottom: 60px;">Hormat kami,</div>
                    <div style="font-size: 14px; font-weight: bold; text-decoration: underline;">
                        {{ $data['business']->name }}</div>
                </td>
            </tr>
        </table>

    </div>

</body>

</html>
