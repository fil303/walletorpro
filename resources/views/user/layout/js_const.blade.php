<script>
    const dataTableOption = {
            processing: true,
            serverSide: true,
            paging: true,
            searching: true,
            ordering:  true,
            select: false,
            bDestroy: true,
            order: [0, 'asc'],
            responsive: true,
            autoWidth: false,
            language: {
                "decimal":        "",
                "emptyTable":     "{{__('No data available in table')}}",
                "info":           "{{__('Showing')}} _START_ to _END_ of _TOTAL_ {{__('entries')}}",
                "infoEmpty":      "{{__('Showing')}} 0 to 0 of 0 {{__('entries')}}",
                "infoFiltered":   "({{__('filtered from')}} _MAX_ {{__('total entries')}})",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "{{__('Show')}} _MENU_ {{__('entries')}}",
                "loadingRecords": "{{__('Loading...')}}",
                "processing":     "",
                "search":         "{{__('Search')}}:",
                "zeroRecords":    "{{__('No matching records found')}}",
                "paginate": {
                    "first":      "{{__('First')}}",
                    "last":       "{{__('Last')}}",
                    "next":       "{{__('Next')}} &#8250;",
                    "previous":   "&#8249; {{__('Previous')}}"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
        };

    const filePondOption = {
            labelIdle: '{{ _t("Drag & Drop your files") }} {{ _t("or") }} <span class="filepond--label-action"> {{ _t("Browse") }} </span>',
            labelFileWaitingForSize: '{{ _t("Waiting for size") }}',
            labelFileSizeNotAvailable: '{{ _t("Size not available") }}',
            labelFileLoading: '{{ _t("Loading") }}',
            labelFileLoadError: '{{ _t("Error during load") }}',
            labelFileProcessing: '{{ _t("Uploading") }}',
            labelFileProcessingComplete: '{{ _t("Upload complete") }}',
            labelFileProcessingAborted: '{{ _t("Upload cancelled") }}',
            labelFileProcessingError: '{{ _t("Error during upload") }}',
            labelFileProcessingRevertError: '{{ _t("Error during revert") }}',
            labelFileRemoveError: '{{ _t("Error during remove") }}',
            labelTapToCancel: '{{ _t("tap to cancel") }}',
            labelTapToRetry: '{{ _t("tap to retry") }}',
            labelTapToUndo: '{{ _t("tap to undo") }}',
            labelButtonRemoveItem: '{{ _t("Remove") }}',
            labelButtonAbortItemLoad: '{{ _t("Abort") }}',
            labelButtonRetryItemLoad: '{{ _t("Retry") }}',
            labelButtonAbortItemProcessing: '{{ _t("Cancel") }}',
            labelButtonUndoItemProcessing: '{{ _t("Undo") }}',
            labelButtonRetryItemProcessing: '{{ _t("Retry") }}',
            labelButtonProcessItem: '{{ _t("Upload") }}',
            credits: false,
            storeAsFile: true,
        };
</script>