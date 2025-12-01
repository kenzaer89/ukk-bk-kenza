@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
	<div class="min-h-screen bg-brand-dark p-6">
		<div class="mb-6">
			<h1 class="text-2xl font-bold text-brand-light">Notifikasi Saya</h1>
			<p class="text-sm text-brand-light/60">Daftar notifikasi terbaru</p>
		</div>

		<div class="space-y-4">
			@if($unreadNotifications->count() > 0)
				<h3 class="text-sm font-semibold text-brand-light/80 mb-2">Belum dibaca</h3>
				@foreach($unreadNotifications as $notif)
					<div class="bg-brand-gray p-4 rounded-lg border border-brand-light/10">
						<div class="flex justify-between items-center">
							<div>
								<p class="text-sm text-brand-light">{{ $notif->message }}</p>
								<p class="text-xs text-brand-light/60">{{ $notif->created_at->diffForHumans() }}</p>
							</div>
							<div class="flex items-center gap-2">
								<form action="{{ route('admin.notifications.markRead') }}" method="POST">
									@csrf
									<input type="hidden" name="id" value="{{ $notif->id }}">
									<button type="submit" class="px-3 py-1 bg-brand-teal text-white rounded">Tandai sudah dibaca</button>
								</form>
								<form action="{{ route('admin.notifications.destroy') }}" method="POST">
									@csrf
									@method('DELETE')
									<input type="hidden" name="id" value="{{ $notif->id }}">
									<button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
								</form>
							</div>
						</div>
					</div>
				@endforeach
			@endif

			@if($notifications->count() > 0)
				<h3 class="text-sm font-semibold text-brand-light/80 mt-4 mb-2">Terbaca</h3>
				@foreach($notifications as $notif)
					@if($notif->status === 'read')
					<div class="bg-brand-dark/60 p-4 rounded-lg border border-brand-light/10">
						<div class="flex justify-between items-center">
							<div>
								<p class="text-sm text-brand-light">{{ $notif->message }}</p>
								<p class="text-xs text-brand-light/60">{{ $notif->created_at->diffForHumans() }}</p>
							</div>
							<div class="flex items-center gap-2">
								<form action="{{ route('admin.notifications.destroy') }}" method="POST">
									@csrf
									@method('DELETE')
									<input type="hidden" name="id" value="{{ $notif->id }}">
									<button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
								</form>
							</div>
						</div>
					</div>
					@endif
				@endforeach
			@endif
		</div>
	</div>
@endsection

