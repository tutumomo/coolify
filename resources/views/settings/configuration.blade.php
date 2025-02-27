<x-layout>
    <x-settings.navbar />
    <div x-data="{ activeTab: window.location.hash ? window.location.hash.substring(1) : 'general' }" class="flex h-full pt-1">
        <div class="flex flex-col gap-4 min-w-fit">
            <a :class="activeTab === 'general' && 'text-white'"
                @click.prevent="activeTab = 'general'; window.location.hash = 'general'" href="#">General</a>
            <a :class="activeTab === 'backup' && 'text-white'"
                @click.prevent="activeTab = 'backup'; window.location.hash = 'backup'" href="#">Instance Backup</a>
            <a :class="activeTab === 'smtp' && 'text-white'"
                @click.prevent="activeTab = 'smtp'; window.location.hash = 'smtp'" href="#">Transactional
                Email</a>
        </div>
        <div class="w-full pl-8">
            <div x-cloak x-show="activeTab === 'general'" class="h-full">
                <livewire:settings.configuration :settings="$settings" />
            </div>
            <div x-cloak x-show="activeTab === 'backup'" class="h-full">
                <livewire:settings.backup :settings="$settings" :database="$database" :s3s="$s3s" />
            </div>
            <div x-cloak x-show="activeTab === 'smtp'" class="h-full">
                <livewire:settings.email :settings="$settings" />
            </div>
        </div>
    </div>
</x-layout>
