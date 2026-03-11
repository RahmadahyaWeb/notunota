<div
    style="width: 210mm; min-height: 297mm; margin: 0 auto; padding: 40px; font-family: 'Courier New', Courier, monospace; font-size: 12px; color: #000; background: #fff;">

    {{-- TOP SECTION --}}
    <table style="width: 100%; border-bottom: 2px solid #000; margin-bottom: 30px;">
        <tr>
            <td style="vertical-align: bottom;">
                <div style="font-size: 24px; font-weight: bold; text-transform: uppercase;">
                    {{ $data['business']->name }}
                </div>
                <div style="margin-top: 5px;">{{ $data['business']->address }}</div>
                <div>{{ $data['business']->phone }}</div>
            </td>

            <td style="width:260px; vertical-align: bottom; text-align:right;">
                <div style="font-size: 28px; font-weight: bold; text-transform: uppercase;">
                    INVOICE
                </div>

                <table style="width:200px; margin-top:10px; margin-left:auto;">
                    <tr>
                        <td style="width:90px;">NO</td>
                        <td style="width:10px;">:</td>
                        <td>{{ $data['invoice_number'] }}</td>
                    </tr>
                    <tr>
                        <td>TANGGAL</td>
                        <td>:</td>
                        <td>{{ $data['invoice_date'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- CLIENT INFO --}}
    <div style="margin-bottom: 40px;">
        <div style="font-weight: bold; text-decoration: underline; margin-bottom: 5px;">BILL TO:</div>
        <div style="font-size: 14px; font-weight: bold;">{{ $data['customer']->name ?? '-' }}</div>
    </div>

    {{-- TABLE --}}
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
        <thead>
            <tr style="border-bottom: 2px solid #000;">
                <th style="text-align: left; padding: 10px 5px;">Description</th>
                <th style="text-align: center; padding: 10px 5px; width: 60px;">Qty</th>
                <th style="text-align: right; padding: 10px 5px; width: 120px;">Unit Price</th>
                <th style="text-align: right; padding: 10px 5px; width: 120px;">Amount</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data['items'] as $item)
                <tr style="border-bottom: 1px dotted #000;">
                    <td style="padding: 12px 5px;">{{ $item['description'] }}</td>
                    <td style="padding: 12px 5px; text-align: center;">{{ $item['qty'] }}</td>
                    <td style="padding: 12px 5px; text-align: right;">
                        {{ number_format($item['price'], 0, ',', '.') }}
                    </td>
                    <td style="padding: 12px 5px; text-align: right;">
                        {{ number_format($item['total'], 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- SUMMARY --}}
    <table style="width:100%;">
        <tr>

            {{-- PAYMENT INFO --}}
            <td style="width:60%; vertical-align:top;">
                <div style="font-weight:bold; margin-bottom:8px;">PAYMENT INFO</div>

                <table>
                    <tr>
                        <td style="width:40px;">BANK</td>
                        <td style="width:20px;">:</td>
                        <td>BCA</td>
                    </tr>
                    <tr>
                        <td>A/N</td>
                        <td>:</td>
                        <td>{{ $data['business']->name }}</td>
                    </tr>
                    <tr>
                        <td>ACC</td>
                        <td>:</td>
                        <td>1234567890</td>
                    </tr>
                </table>
            </td>

            {{-- TOTAL --}}
            <td style="width:40%; vertical-align:top;">
                <table style="width:100%;">
                    <tr>
                        <td style="padding:6px 0;">SUBTOTAL</td>
                        <td style="width:10px;">:</td>
                        <td style="text-align:right;">
                            Rp {{ number_format($data['total'], 0, ',', '.') }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:6px 0;">TAX</td>
                        <td>:</td>
                        <td style="text-align:right;">Rp 0</td>
                    </tr>

                    <tr style="border-top:1px solid #000; font-weight:bold; font-size:14px;">
                        <td style="padding:10px 0;">TOTAL</td>
                        <td>:</td>
                        <td style="text-align:right;">
                            Rp {{ number_format($data['total'], 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>

    <div style="margin-top: 100px; font-size: 10px; text-align: center; border-top: 1px solid #eee; padding-top: 10px;">
        * THIS IS A COMPUTER GENERATED DOCUMENT *
    </div>
</div>
