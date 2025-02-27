<div>
    <div class="flex flex-wrap gap-2">
        @forelse($database->scheduledBackups as $backup)
            @if ($type === 'database')
                <a class="flex flex-col box"
                    href="{{ route('project.database.backups.executions', [...$parameters, 'backup_uuid' => $backup->uuid]) }}">
                    <div>Frequency: {{ $backup->frequency }}</div>
                    <div>Last backup: {{ data_get($backup->latest_log, 'status', 'No backup yet') }}</div>
                    <div>Number of backups to keep (locally): {{ $backup->number_of_backups_locally }}</div>
                </a>
            @else
                <div @class([
                    'border-coollabs' =>
                        data_get($backup, 'id') === data_get($selectedBackup, 'id'),
                    'flex flex-col box border-l-2 border-transparent',
                ]) wire:click="setSelectedBackup('{{ data_get($backup, 'id') }}')">
                    <div>Frequency: {{ $backup->frequency }}</div>
                    <div>Last backup: {{ data_get($backup->latest_log, 'status', 'No backup yet') }}</div>
                    <div>Number of backups to keep (locally): {{ $backup->number_of_backups_locally }}</div>
                </div>
            @endif
        @empty
            <div>No scheduled backups configured.</div>
        @endforelse
    </div>
    @if ($type === 'service-database' && $selectedBackup)
        <div class="pt-10">
            <livewire:project.database.backup-edit key="{{ $selectedBackup->id }}" :backup="$selectedBackup" :s3s="$s3s"
                :status="data_get($database, 'status')" />
            <h3 class="py-4">Executions</h3>
            <livewire:project.database.backup-executions key="{{ $selectedBackup->id }}" :backup="$selectedBackup"
                :executions="$selectedBackup->executions" />
        </div>
    @endif
</div>
