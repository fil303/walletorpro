@extends("layout.app", [ "menu" => "support" ])
@section('title', __("Open New ticket"))

@use(App\Enums\SupportTicketPriority)

@section("content")

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h4 class="card-title">{{ _("Open a new ticket") }}</h4>
                <a href="{{ route('supportPage') }}" class="btn">
                    <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 14 4 9l5-5" />
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                    </svg>
                    {{ __("Button") }}
                </a>
            </div>

            <div class="grid sm:block">
                <div class="grid grid-cols-1 gap-1 sm:block sm:w-full mr-1  overflow-hidden">
                    <form action="{{ route('submitNewSupportTicketPage') }}" method="post" enctype="multipart/form-data"> @csrf

                    <label class="form-control p-1">
                        <div class="label">
                            <span class="label-text">{{ __("Subject") }}
                                <span class="text-error">*</span>
                            </span>
                        </div>
                        <input name="subject" type="text" value="{{ $item->subject ?? old('subject') }}" class="input input-bordered" />
                    </label>

                    <label class="form-control p-1">
                        <div class="label">
                            <span class="label-text">{{ __("Priority") }}
                                <span class="text-error">*</span>
                            </span>
                        </div>
                        <select name="priority" class="select select-bordered">
                            {{!! SupportTicketPriority::renderOption($item->priority ?? '') !!}}
                        </select>
                    </label>

                    <label class="fiat_type_field form-control p-1">
                        <div class="label">
                            <span class="label-text">{{ __("Message") }}
                                <span class="text-error">*</span>
                            </span>
                        </div>
                        <textarea name="message" class="textarea textarea-bordered" autocomplete="off" rows="5"></textarea>
                    </label>

                    <div class="flex w-full text-center flex-col gap-1">
                        <span class="w-fit pl-0.5 text-sm text-slate-700 dark:text-slate-300">{{ __("Attachments") }}</span>
                        <div class="flex w-full flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-slate-300 p-8 text-slate-700 dark:border-slate-700 dark:text-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor" class="w-12 h-12 opacity-75">
                                <path fill-rule="evenodd" d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd"/>
                            </svg>
                            <div class="group">
                                <label for="fileInputDragDrop" class="cursor-pointer font-medium text-blue-700 group-focus-within:underline dark:text-blue-600">
                                    <input name="attachment[]" id="fileInputDragDrop" type="file" class="sr-only" aria-describedby="validFileFormats" multiple />
                                    Browse
                                </label>
                                or drag and drop here
                            </div>
                            <small id="validFileFormats">PNG, JPG, WebP - Max 5MB</small>
                        </div>
                    </div>
                    <div class="grid grid-cols-3  gap-1 w-[60%] mx-auto" id="attachments"></div>

                    <label class="form-control p-1">
                        <input class="btn btn-primary" type="submit" value="{{ __('Create Ticket') }}" />
                    </label>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('downjs')
    <script>
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
                attachmentItem.classList.add('flex', 'items-centerr', 'justify-betweenn', 'p-2', 'rounded-lg', 'border', 'border-gray-300', 'dark:border-gray-700');
                
                const fileName = document.createElement('span');
                fileName.classList.add('text-sm', 'text-gray-700', 'dark:text-gray-300');

                const fileIcon = document.createElement('i');
                fileIcon.classList.add('fas', 'fa-file', 'mr-2', 'text-gray-500', 'dark:text-gray-400');

                fileName.appendChild(fileIcon);
                fileName.textContent = file.name;

                const removeButton = document.createElement('button');
                removeButton.classList.add('text-red-500', 'hover:text-red-700', 'focus:outline-none', 'focus:ring-2', 'focus:ring-red-500', 'focus:ring-opacity-50', 'p-1');
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