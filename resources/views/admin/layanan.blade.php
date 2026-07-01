@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    {{-- ================= STATS ================= --}}
    <section class="stats-grid" aria-label="Ringkasan booking">
        @foreach ($stats as $stat)
            <article class="stat-card">
                <div class="stat-icon">
                    <i class="bx {{ $stat['icon'] }}"></i>
                </div>
                <div class="stat-body">
                    <p>{{ $stat['label'] }}</p>
                    <strong>{{ $stat['value'] }}</strong>

                    @php
                        $isUp = $stat['change'] >= 0;
                    @endphp

                    <span style="color: {{ $isUp ? 'green' : 'red' }}">
                        <b>{{ $stat['change'] }}</b>
                        {{ $isUp ? 'naik' : 'turun' }}
                    </span>
                </div>
            </article>
        @endforeach
    </section>

    {{-- ================= TABLE ================= --}}
    <section class="booking-panel">
        <div class="panel-header">
            <div class="panel-title">
                <h3>Booking Terbaru</h3>
            </div>

            <a class="primary-button" href="{{ route('admin.bookings.index') }}">
                Lihat Semua Booking →
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode Referensi</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Layanan</th>
                        <th>Petugas</th>
                        <th>Tanggal & Waktu</th>
                        <th>Status</th>
                        <th>Meeting</th>
                        <th>Aksi</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            {{-- KODE REFERENSI --}}
                            <td>{{ $booking->kode_referensi }}</td>
    
                            {{-- NAMA --}}
                            <td>
                                <strong>{{ $booking->nama }}</strong>
                                <br>
                                <small style="color:#64748b">{{ $booking->instansi }}</small>
                            </td>

                            {{-- EMAIL --}}
                            <td>{{ $booking->email }}</td>

                            {{-- HP --}}
                            <td>{{ $booking->nomor_hp }}</td>

                            {{-- LAYANAN --}}
                            <td>
                                <strong>{{ $booking->layanan->nama ?? '-' }}</strong>
                                <br>
                                <small style="color:#64748b">
                                    {{ $booking->kategoriBooking->nama ?? '-' }}
                                </small>
                            </td>

                            {{-- PETUGAS --}}
                            <td>
                                @if($booking->status == 'pending')

                                    <select name="petugas_id" form="confirm-form-{{ $booking->id }}">

                                        <option value="">Pilih Petugas</option>

                                        @foreach($booking->layanan->petugas as $p)

                                            <option value="{{ $p->id }}">
                                                {{ $p->nama }}
                                            </option>

                                        @endforeach

                                    </select>

                                @else

                                    {{ $booking->petugas->nama ?? '-' }}

                                @endif
                            </td>

                            {{-- TANGGAL --}}
                            <td>
                                {{ $booking->tanggal }} <br>
                                <small>{{ $booking->jam }}</small>
                            </td>


                            {{-- STATUS --}}
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="status-badge warning">Pending</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="status-badge online">Confirmed</span>
                                @else
                                    <span class="status-badge offline">Cancelled</span>
                                @endif
                            </td>

                            {{-- LINK MEET --}}
                            <td>
                                @if($booking->link_meet)
                                    <a href="{{ $booking->link_meet }}" target="_blank">
                                        Join Meet
                                    </a>
                                @else
                                    -
                                @endif

                                <br>

                                @if($booking->link_meet)
                                <a href="{{$booking->link_meet}}" target="_blank">Link Meet</a>
                                    <small style="color:green;">Online</small>
                                @else
                                    <small style="color:gray;">Offline</small>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td>

                                {{-- CONFIRM & CANCEL --}}
                                @if($booking->status == 'pending')

                                    <form id="confirm-form-{{ $booking->id }}"
                                        action="{{ route('booking.confirm', $booking->id) }}"
                                        method="POST"
                                        style="display:inline;"
                                        >
                                        @csrf
                                        <input
                                        type="text"
                                        name="link_meet"
                                        placeholder="Paste link Google Meet"
                                        class="meet-input"
                                    >
                                        <button class="btn-success">✔</button>
                                    </form>

                                    <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn-danger">✖</button>
                                    </form>

                                @endif

                            </td>

                            {{-- MULAI --}}
                            <td>
                                @if($booking->mulai)

                                    {{ \Carbon\Carbon::parse($booking->mulai)->format('H:i') }}
                                
                                @elseif($booking->status == 'confirmed')

                                    <form action="{{ route('admin.booking.mulai', $booking->id) }}" method="POST">
                                        @csrf
                                        <button class="btn-mulai">▶Mulai</button>
                                    </form>

                                @else
                                    -
                                @endif
                            </td>
                            
                            {{-- SELESAI --}}
                            <td>
                                @if($booking->selesai)

                                    {{ \Carbon\Carbon::parse($booking->selesai)->format('H:i') }}

                                @elseif($booking->mulai)

                                    <form
                                        action="{{ route('admin.booking.selesai', $booking->id) }}"
                                        method="POST"
                                    >
                                        @csrf

                                        <button class="btn-selesai">
                                            ■Selesai
                                        </button>
                                    </form>

                                @else

                                    -

                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="11" style="text-align:center;">
                                Belum ada booking
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </section>

@endsection