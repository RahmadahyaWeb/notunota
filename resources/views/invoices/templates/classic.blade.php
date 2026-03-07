<div
    style="width: 210mm; min-height: 297mm; margin: 0 auto; padding: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; color: #334155; box-sizing: border-box; background: #fff; line-height: 1.5;">

    {{-- HEADER SECTION --}}
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 40px;">
        <tr>
            <td style="vertical-align: top;">
                <div style="font-size: 28px; font-weight: 800; color: #1e293b; letter-spacing: -0.5px;">
                    {{ $data['business']->name }}
                </div>
                <div style="margin-top: 8px; color: #64748b; font-size: 12px; max-width: 250px;">
                    <div style="margin-bottom: 2px;">{{ $data['business']->address }}</div>
                    <div>Telp: {{ $data['business']->phone }}</div>
                </div>
            </td>
            <td style="vertical-align: top; text-align: right;">
                <div
                    style="font-size: 32px; font-weight: 300; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px;">
                    Invoice
                </div>
                <div style="margin-top: 10px;">
                    <table style="margin-left: auto; border-collapse: collapse;">
                        <tr>
                            <td
                                style="text-align: right; color: #94a3b8; padding: 2px 10px; font-size: 11px; text-transform: uppercase;">
                                Nomor</td>
                            <td style="text-align: right; font-weight: bold; color: #1e293b;">
                                #{{ $data['invoice_number'] }}</td>
                        </tr>
                        <tr>
                            <td
                                style="text-align: right; color: #94a3b8; padding: 2px 10px; font-size: 11px; text-transform: uppercase;">
                                Tanggal</td>
                            <td style="text-align: right; color: #1e293b;">{{ $data['invoice_date'] }}</td>
                        </tr>
                        <tr>
                            <td
                                style="text-align: right; color: #94a3b8; padding: 2px 10px; font-size: 11px; text-transform: uppercase;">
                                Jatuh Tempo</td>
                            <td style="text-align: right; color: #e11d48; font-weight: 600;">{{ $data['due_date'] }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div style="margin-bottom: 40px; border-left: 4px solid #334155; padding-left: 15px;">
        <div
            style="text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; font-size: 11px; font-weight: bold; margin-bottom: 4px;">
            Ditujukan Kepada
        </div>
        <div style="font-size: 16px; font-weight: bold; color: #1e293b;">
            {{ $data['customer']->name ?? '-' }}
        </div>
    </div>

    {{-- ITEMS TABLE --}}
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
        <thead>
            <tr style="background-color: #1e293b;">
                <th
                    style="text-align: left; padding: 12px 15px; color: #ffffff; font-size: 11px; text-transform: uppercase; border-top-left-radius: 4px;">
                    Deskripsi</th>
                <th
                    style="text-align: center; padding: 12px 15px; color: #ffffff; font-size: 11px; text-transform: uppercase; width: 80px;">
                    Qty</th>
                <th
                    style="text-align: right; padding: 12px 15px; color: #ffffff; font-size: 11px; text-transform: uppercase; width: 120px;">
                    Harga Satuan</th>
                <th
                    style="text-align: right; padding: 12px 15px; color: #ffffff; font-size: 11px; text-transform: uppercase; width: 140px; border-top-right-radius: 4px;">
                    Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['items'] as $item)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 15px; vertical-align: top;">
                        <div style="font-weight: 600; color: #334155;">{{ $item['description'] }}</div>
                    </td>
                    <td style="padding: 15px; text-align: center; vertical-align: top; color: #64748b;">
                        {{ $item['qty'] }}</td>
                    <td style="padding: 15px; text-align: right; vertical-align: top; color: #64748b;">
                        {{ number_format($item['price'], 0, ',', '.') }}
                    </td>
                    <td
                        style="padding: 15px; text-align: right; vertical-align: top; font-weight: bold; color: #1e293b;">
                        {{ number_format($item['total'], 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- SUMMARY SECTION --}}
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 55%; vertical-align: top; padding-right: 40px;">
                <div style="background: #f8fafc; padding: 15px; border-radius: 8px;">
                    <div
                        style="text-transform: uppercase; font-size: 10px; font-weight: bold; color: #94a3b8; margin-bottom: 8px;">
                        Instruksi Pembayaran</div>
                    <table style="width: 100%; font-size: 12px; color: #475569;">
                        <tr>
                            <td style="padding: 2px 0;">Bank</td>
                            <td style="padding: 2px 0; font-weight: bold; text-align: right;">BCA</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0;">No. Rekening</td>
                            <td style="padding: 2px 0; font-weight: bold; text-align: right;">1234 567 890</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0;">Atas Nama</td>
                            <td style="padding: 2px 0; font-weight: bold; text-align: right;">
                                {{ $data['business']->name }}</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="width: 45%; vertical-align: top;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #64748b;">Subtotal</td>
                        <td style="padding: 8px 0; text-align: right; color: #1e293b;">Rp
                            {{ number_format($data['total'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b;">Pajak (0%)</td>
                        <td style="padding: 8px 0; text-align: right; color: #1e293b;">Rp 0</td>
                    </tr>
                    <tr style="border-top: 2px solid #1e293b;">
                        <td style="padding: 15px 0; font-size: 16px; font-weight: bold; color: #1e293b;">GRAND TOTAL
                        </td>
                        <td
                            style="padding: 15px 0; font-size: 18px; font-weight: 800; text-align: right; color: #1e293b;">
                            Rp {{ number_format($data['total'], 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- FOOTER --}}
    <div style="margin-top: 60px; padding-top: 20px; border-top: 1px solid #f1f5f9; text-align: center;">
        <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">Terima kasih atas kepercayaan Anda.</div>
        <div style="color: #94a3b8; font-size: 10px; font-style: italic;">
            Invoice ini diterbitkan secara elektronik dan sah tanpa memerlukan tanda tangan basah.
        </div>
    </div>

</div>
