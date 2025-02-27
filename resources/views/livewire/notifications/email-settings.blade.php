<div>
    <dialog id="sendTestEmail" class="modal">
        <form method="dialog" class="flex flex-col gap-2 rounded modal-box" wire:submit='submit'>
            <x-forms.input placeholder="test@example.com" id="emails" label="Recepients" required />
            <x-forms.button onclick="sendTestEmail.close()" wire:click="sendTestNotification">
                Send Email
            </x-forms.button>
        </form>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <form wire:submit='submit' class="flex flex-col">
        <div class="flex items-center gap-2">
            <h2>Email</h2>
            <x-forms.button type="submit">
                Save
            </x-forms.button>
            @if (isInstanceAdmin() && !$team->use_instance_email_settings)
                <x-forms.button wire:click='copyFromInstanceSettings'>
                    Copy from Instance Settings
                </x-forms.button>
            @endif
            @if (isEmailEnabled($team) &&
                    auth()->user()->isAdminFromSession() &&
                    isTestEmailEnabled($team))
                <x-forms.button onclick="sendTestEmail.showModal()"
                    class="text-white normal-case btn btn-xs no-animation btn-primary">
                    Send Test Email
                </x-forms.button>
            @endif

        </div>
    </form>
    @if (isCloud())
        @if ($this->sharedEmailEnabled)
            <div class="w-64 pb-4">
                <x-forms.checkbox instantSave="instantSaveInstance" id="team.use_instance_email_settings"
                    label="Use Hosted Email Service" />
            </div>
        @else
            <div class="pb-4 w-96">
                <x-forms.checkbox disabled id="team.use_instance_email_settings"
                    label="Use Hosted Email Service (Pro+ subscription required)" />
            </div>
        @endif
    @else
        <div class="pb-4 w-96">
            <x-forms.checkbox instantSave="instantSaveInstance" id="team.use_instance_email_settings"
                label="Use system wide (transactional) email settings" />
        </div>
    @endif
    @if (!$team->use_instance_email_settings)
        <form class="flex flex-col items-end gap-2 pb-4 xl:flex-row" wire:submit='submitFromFields'>
            <x-forms.input required id="team.smtp_from_name" helper="Name used in emails." label="From Name" />
            <x-forms.input required id="team.smtp_from_address" helper="Email address used in emails."
                label="From Address" />
            <x-forms.button type="submit">
                Save
            </x-forms.button>
        </form>
        <div class="flex flex-col gap-4">
            <div class="p-4 border border-coolgray-500">
                <h3>SMTP Server</h3>
                <div class="w-32">
                    <x-forms.checkbox instantSave id="team.smtp_enabled" label="Enabled" />
                </div>
                <form wire:submit='submit' class="flex flex-col">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col w-full gap-2 xl:flex-row">
                            <x-forms.input required id="team.smtp_host" placeholder="smtp.mailgun.org" label="Host" />
                            <x-forms.input required id="team.smtp_port" placeholder="587" label="Port" />
                            <x-forms.input id="team.smtp_encryption" helper="If SMTP uses SSL, set it to 'tls'."
                                placeholder="tls" label="Encryption" />
                        </div>
                        <div class="flex flex-col w-full gap-2 xl:flex-row">
                            <x-forms.input id="team.smtp_username" label="SMTP Username" />
                            <x-forms.input id="team.smtp_password" type="password" label="SMTP Password" />
                            <x-forms.input id="team.smtp_timeout" helper="Timeout value for sending emails."
                                label="Timeout" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-4 pt-6">
                        <x-forms.button type="submit">
                            Save
                        </x-forms.button>
                    </div>
                </form>
            </div>
            <div class="p-4 border border-coolgray-500">
                <h3>Resend</h3>
                <div class="w-32">
                    <x-forms.checkbox instantSave='instantSaveResend' id="team.resend_enabled" label="Enabled" />
                </div>
                <form wire:submit='submitResend' class="flex flex-col">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col w-full gap-2 xl:flex-row">
                            <x-forms.input required type="password" id="team.resend_api_key" placeholder="API key"
                                label="API Key" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-4 pt-6">
                        <x-forms.button type="submit">
                            Save
                        </x-forms.button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if (isEmailEnabled($team) || data_get($team, 'use_instance_email_settings'))
        <h2 class="mt-4">Subscribe to events</h2>
        <div class="w-64">
            @if (isDev())
                <x-forms.checkbox instantSave="saveModel" id="team.smtp_notifications_test" label="Test" />
            @endif
            <x-forms.checkbox instantSave="saveModel" id="team.smtp_notifications_status_changes"
                label="Container Status Changes" />
            <x-forms.checkbox instantSave="saveModel" id="team.smtp_notifications_deployments"
                label="Application Deployments" />
            <x-forms.checkbox instantSave="saveModel" id="team.smtp_notifications_database_backups"
                label="Backup Status" />
        </div>
    @endif
</div>
