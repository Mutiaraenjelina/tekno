@extends('layouts.user.template')
@section('content')

<div class="user-page-header">
    <h1><i class="ti ti-credit-card"></i> Status Pembayaran</h1>
    <p class="subtitle">Ringkasan assignment tagihan dan status pembayarannya.</p>
</div>

<div class="user-card">
    @if($assignments->count() > 0)
        <div class="table-responsive">
            <div class="user-table">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tagihan</th>
                            <th>Bukti Admin</th>
                            <th>Nominal</th>
                            <th>Status Bayar</th>
                            <th>Payment ID</th>
                            <th>Gateway</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $row->nama_tagihan }}</div>
                                    <small class="text-muted">Jatuh tempo: {{ \Carbon\Carbon::parse($row->jatuh_tempo)->format('d M Y') }}</small><br>
                                    <small class="text-muted">Tipe: {{ strtoupper($row->tipe ?? '-') }}</small>
                                </td>
                                <td>
                                    <div><small class="text-muted">Assignment ID:</small> <span class="fw-semibold">#{{ $row->assignment_id }}</span></div>
                                    <div><small class="text-muted">Di-assign:</small> {{ $row->assignment_created_at ? \Carbon\Carbon::parse($row->assignment_created_at)->format('d M Y H:i') : '-' }}</div>
                                    <div><small class="text-muted">Dibuat Admin:</small> {{ $row->admin_creator_username ?? '-' }}</div>
                                </td>
                                <td>Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                                <td>
                                    @if($row->status === 'sudah')
                                        <span class="badge bg-success">Sudah Bayar</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Bayar</span>
                                    @endif
                                </td>
                                <td>{{ $row->payment_id ?? '-' }}</td>
                                <td>
                                    @if($row->transaksi_status)
                                        <span class="badge bg-info text-dark">{{ strtoupper($row->transaksi_status) }}</span><br>
                                        <small class="text-muted">{{ $row->order_id ?? '-' }}</small>
                                    @elseif($row->status === 'sudah')
                                        <small class="text-muted">Manual</small>
                                    @else
                                        <small class="text-muted">Belum ada</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('user.tagihan.show', $row->id) }}" class="btn btn-sm btn-outline-primary">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="empty-state">
            <i class="ti ti-inbox"></i>
            <h4>Belum Ada Assignment Tagihan</h4>
            <p>Tagihan dari admin akan tampil di halaman ini.</p>
        </div>
    @endif
</div>

@endsection
