@extends('layouts.app')
@section('title', 'Activity Log')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h4>Riwayat Aktivitas</h4>
                @if (session('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                @endif
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Target</th>
                            <th>Properti</th>
                            <th>Restore</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                            <tr>
                                <td>{{ $activity->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $activity->causer->name ?? '-' }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ class_basename($activity->subject_type) }}</td>
                                <td>
                                    @if ($activity->properties)
                                        <pre style="font-size: 12px">{{ json_encode($activity->properties->toArray(), JSON_PRETTY_PRINT) }}</pre>
                                    @endif
                                </td>
                                <td>
                                    @if (isset($activity->properties['old']) && $activity->subject_type === \App\Models\Article::class)
                                        <form action="{{ route('activity.restore', $activity->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin restore perubahan ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Restore</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $activities->links() }}
                </div>
            </div>
        </section>
    </div>
@endsection
