@extends('layout.app', [ 'open_support_menu' => true, 'menu' => 'support' ])

@section('title', __('Support Center'))
@use(App\Enums\SupportTicketStatus)
@section('content')

    <div class="container mx-auto p-6 space-y-6 bg-base-200 rounded-lg shadow-md">

        <!-- Ticket Status and Information -->
        <div class="flex justify-between items-center bg-base-100 p-4 rounded-lg shadow">
            <div>
                <h2 class="text-2xl font-semibold">{{ __('Ticket') }} #{{ $ticket->ticket }} - "{{ $ticket->subject }}"</h2>
                <p class="text-sm">{{ __('Created on') }}: {{ date('M d, Y', strtotime($ticket->created_at ?? '')) }} |
                    {{ __('Status') }}: <span class="text-warning">{{ $ticket->status->value() }}</span></p>
            </div>
            <div class="flex justify-between">
                <div class="mr-2">
                    @if ($ticket->status == SupportTicketStatus::OPEN || $ticket->status == SupportTicketStatus::ANSWERED)
                        <a href="#" onclick="closeTicket()" class="btn btn-primary">{{ __('Close Ticket') }}</a>
                    @endif
                    <a href="{{ route('adminTicketsIndex') }}" class="btn">
                        <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M9 14 4 9l5-5" />
                            <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                        </svg>
                        {{ __("Button") }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="bg-base-100 p-4 rounded-lg shadow space-y-4">
            <h3 class="text-xl font-semibold">{{ __('Messages') }}</h3>

            @if (filled($replies))
                @foreach ($replies as $replay)
                    <div class="flex items-start space-x-4 border-success border-b-2 ">
                        <img src="{{ $replay->sender_user->getImage() ?? '' }}" loading="lazy" alt="Admin Image" class="w-10 h-10 rounded-full" />
                        <div class="p-4 rounded-lg w-full">
                            <div class="flex justify-between items-center">
                                <p class="font-semibold underline">
                                    {{ $replay->sender_user->name ?? 'User' }}
                                    {{ $replay->sender_user->role->isAdmin() ? ' - ' . __('Support Team') : '' }}
                                </p>
                                <span
                                    class="text-xs">{{ date('M d, Y, h:i A', strtotime($replay->created_at ?? '')) }}</span>
                            </div>
                            <p class="mt-2">{{ $replay->message }}</p>
                            <br><br>
                            @if (isset($replay->attachmentData[0]))
                                @foreach ($replay->attachmentData as $attachment)
                                    <a class="btn btn-sm btn-info mb-1"
                                        href="{{ route('supportTicketAttachmentDownload', ['replay' => $replay->id, 'index' => $loop->index]) }}">
                                        {{ __('Attachment') . ' ' . ++$loop->index }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        @if ($ticket->status !== SupportTicketStatus::CLOSED)
            <!-- Reply Form -->
            <form action="{{ route('adminTicketsReply') }}" method="post" enctype="multipart/form-data">@csrf
                <input type="hidden" name="ticket" value="{{ $ticket->ticket }}" />
                <div class="bg-base-100 p-4 rounded-lg shadow space-y-4">
                    <h3 class="text-xl font-semibold">{{ __('Send a Reply') }}</h3>
                    <textarea name="message" class="textarea textarea-bordered w-full" rows="4"
                        placeholder="{{ __('Type your reply here') }}"></textarea>

                    <label class="form-control p-1">
                        <div class="label">
                            <span class="label-text">{{ __('Status Change To') }}
                                <span class="text-error">*</span>
                            </span>
                        </div>
                        <select name="status" class="select select-bordered"
                            onchange="setFormForSelectedCurrencyType(this.value)">
                            @foreach (SupportTicketStatus::setReplayStatus() as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </label>


                    <!-- Attachments -->
                    <div class="space-y-2">
                        <div
                            class="flex w-full flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-slate-300 p-8 text-slate-700 dark:border-slate-700 dark:text-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                                fill="currentColor" class="w-12 h-12 opacity-75">
                                <path fill-rule="evenodd"
                                    d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="group">
                                <label for="fileInputDragDrop"
                                    class="cursor-pointer font-medium text-blue-700 group-focus-within:underline dark:text-blue-600">
                                    <input name="attachment[]" id="fileInputDragDrop" type="file" class="sr-only"
                                        aria-describedby="validFileFormats" multiple />
                                    Browse
                                </label>
                                or drag and drop here
                            </div>
                            <small id="validFileFormats">PNG, JPG, WebP - Max 5MB</small>
                        </div>
                        <div class="grid grid-cols-3  gap-1 w-[60%] mx-auto" id="attachments"></div>
                    </div>

                    <!-- Send Button -->
                    <div class="flex justify-between items-center">
                        <button class="btn btn-primary">{{ __('Send Reply') }}</button>
                    </div>
                </div>
            </form>
        @endif
    </div>

@endsection
@section('downjs')
    <script>
        function closeTicket() {
            Notiflix.Confirm.show(
                '{{ __('Close This Ticket') }}',
                '{{ __('Are you sure you want to close this ticket ?') }}',
                '{{ __('Yes, Close') }}',
                '{{ __('No') }}',
                () => {
                    window.location.href = '{{ route('closeTicket', $ticket->ticket) }}'
                }
            );
        }

        let count_attachment = 1;

        const fileInput = document.getElementById('fileInputDragDrop');
        const attachmentsContainer = document.getElementById('attachments');

        fileInput.addEventListener('change', handleFileSelection);

        function handleFileSelection(event) {
            attachmentsContainer.innerHTML = '';
            const files = event.target.files;
            for (const file of files) {

                if (file.size > 5 * 1024 * 1024) {
                    alert(`File "${file.name}" exceeds the maximum size of 5MB. Please select smaller files.`);
                    continue;
                }

                const allowedExtensions = ['png', 'jpg', 'webp'];
                const extension = file.name.split('.').pop().toLowerCase();
                if (!allowedExtensions.includes(extension)) {
                    alert(`File "${file.name}" has an invalid file type. Only PNG, JPG, and WebP files are allowed.`);
                    continue;
                }


                // const hiddenInput = document.createElement('input');
                // hiddenInput.type  = 'file';
                //hiddenInput.name  = 'attachment[]';

                const attachmentItem = document.createElement('div');
                attachmentItem.classList.add('flex', 'items-centerr', 'justify-betweenn', 'p-2', 'rounded-lg', 'border',
                    'border-gray-300', 'dark:border-gray-700');

                const fileName = document.createElement('span');
                fileName.classList.add('text-sm', 'text-gray-700', 'dark:text-gray-300');

                const fileIcon = document.createElement('i');
                fileIcon.classList.add('fas', 'fa-file', 'mr-2', 'text-gray-500', 'dark:text-gray-400');

                fileName.appendChild(fileIcon);
                fileName.textContent = file.name;

                const removeButton = document.createElement('button');
                removeButton.classList.add('text-red-500', 'hover:text-red-700', 'focus:outline-none', 'focus:ring-2',
                    'focus:ring-red-500', 'focus:ring-opacity-50', 'p-1');
                removeButton.textContent = '×';

                removeButton.addEventListener('click', () => {
                    attachmentsContainer.removeChild(attachmentItem);
                });

                attachmentItem.appendChild(fileName);
                // attachmentItem.appendChild(removeButton);
                attachmentsContainer.appendChild(attachmentItem);
            }
        }
    </script>
@endsection
