@extends('backend.layout.app')
@section('title', 'Section Entry | ' . (Helper::getSettings('application_name') ?? 'LDS'))
@section('content')
<style>
    @keyframes secFlash {
        0% { background-color: #d1f4e0; }
        100% { background-color: transparent; }
    }
    .flash-sec td { animation: secFlash 1.2s ease-out; }
</style>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-2 mb-3 flex-wrap gap-2">
        <h4 class="m-0"><i class="fa-solid fa-file-invoice-dollar text-success"></i> Section Entry</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sectionModal" id="openCreateBtn">
            <i class="fa-solid fa-plus"></i> Add Section
        </button>
    </div>

    <div class="card my-2">
        <div class="card-header">
            <h5 class="m-0">Sections (Daily Report e select korlei % auto-fill hobe)</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width:60px">#</th>
                        <th>Section Name</th>
                        <th style="width:200px">Default Profit %</th>
                        <th style="width:120px" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="sectionBody">
                    @forelse ($sections as $section)
                        <tr data-id="{{ $section->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td class="sec-name fw-semibold">{{ $section->name }}</td>
                            <td class="sec-percent">{{ $section->profit_percent }}%</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary edit-sec" data-id="{{ $section->id }}"
                                    data-name="{{ $section->name }}" data-percent="{{ $section->profit_percent }}">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mx-1 delete-sec" data-id="{{ $section->id }}" data-name="{{ $section->name }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="sec-empty"><td colspan="4" class="text-center text-muted py-4">Kono section nei — "Add Section" theke Photocopy, Print, Stationary... add korun</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Create / Edit Modal --}}
<div class="modal fade" id="sectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sectionModalTitle">Add Section</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                </button>
            </div>
            <form id="sectionForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="sectionId" value="">
                    <div class="mb-3">
                        <label class="form-label">Section Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sectionName" placeholder="e.g. Photocopy" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Default Profit % <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="sectionPercent" step="0.01" min="0" max="100" placeholder="e.g. 30">
                        <div class="form-text">Daily Report e section select korle ei % auto-fill hobe (oser khetre change kora jabe)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveSectionBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('footer')
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var SECTION_URLS = {
        store: "{{ route('admin.report.section.store') }}",
        update: "{{ route('admin.report.section.update', ['id' => ':id']) }}",
        delete: "{{ route('admin.report.section.delete', ['id' => ':id']) }}",
    };

    function showToast(type, msg) {
        toastr.options = { positionClass: 'toast-bottom-right', timeOut: 2000 };
        toastr[type](msg);
    }

    // Create modal open
    $('#openCreateBtn').on('click', function () {
        $('#sectionForm')[0].reset();
        $('#sectionId').val('');
        $('#sectionModalTitle').text('Add Section');
    });

    function hideModal() {
        var inst = bootstrap.Modal.getInstance(document.getElementById('sectionModal'));
        if (inst) { inst.hide(); }
    }

    function renumberSections() {
        var i = 0;
        $('#sectionBody tr:not(.sec-empty)').each(function () {
            $(this).find('td:first-child').text(++i);
        });
    }

    function addSectionRow(sec) {
        $('.sec-empty').remove();
        var $tr = $(
            '<tr data-id="' + sec.id + '">' +
            '<td></td>' +
            '<td class="sec-name fw-semibold"></td>' +
            '<td class="sec-percent"></td>' +
            '<td class="text-center">' +
            '<button type="button" class="btn btn-sm btn-primary edit-sec"><i class="fa-solid fa-pencil"></i></button>' +
            '<button type="button" class="btn btn-sm btn-danger mx-1 delete-sec"><i class="fa fa-trash"></i></button>' +
            '</td></tr>'
        );
        $tr.find('.sec-name').text(sec.name);
        $tr.find('.sec-percent').text(sec.profit_percent + '%');
        $tr.find('.edit-sec').attr('data-id', sec.id).data('name', sec.name).data('percent', sec.profit_percent);
        $tr.find('.delete-sec').attr('data-id', sec.id).attr('data-name', sec.name);
        $tr.addClass('flash-sec');
        $('#sectionBody').append($tr);
        renumberSections();
    }

    // Edit button
    $(document).on('click', '.edit-sec', function () {
        $('#sectionId').val($(this).data('id'));
        $('#sectionName').val($(this).data('name'));
        $('#sectionPercent').val($(this).data('percent'));
        $('#sectionModalTitle').text('Edit Section');
        new bootstrap.Modal($('#sectionModal')).show();
    });

    // Save (create/update)
    $('#sectionForm').on('submit', function (e) {
        e.preventDefault();

        var name = $('#sectionName').val().trim();
        var percent = $('#sectionPercent').val();
        if (!name) { showToast('warning', 'Section name din'); return; }
        if (percent === '' || isNaN(percent)) { showToast('warning', 'Profit % din'); return; }

        var id = $('#sectionId').val();
        var url = id ? SECTION_URLS.update.replace(':id', id) : SECTION_URLS.store;
        var $btn = $('#saveSectionBtn').prop('disabled', true);

        $.ajax({
            url: url,
            type: 'POST',
            data: { _token: CSRF_TOKEN, name: name, profit_percent: percent },
            success: function (res) {
                $btn.prop('disabled', false);
                if (res.type === 'success') {
                    if (id) {
                        // update: row live update, reload nei
                        var $tr = $('#sectionBody tr[data-id="' + id + '"]');
                        $tr.find('.sec-name').text(name);
                        $tr.find('.sec-percent').text(parseFloat(percent) + '%');
                        $tr.find('.edit-sec').data('name', name).data('percent', percent);
                        $tr.find('.delete-sec').attr('data-name', name);
                        $tr.addClass('flash-sec');
                    } else if (res.section) {
                        // create: notun row instantly add
                        addSectionRow(res.section);
                    }
                    $('#sectionForm')[0].reset();
                    $('#sectionId').val('');
                    $('#sectionModalTitle').text('Add Section');
                    hideModal();
                    showToast('success', res.message);
                } else {
                    showToast('error', res.message || 'Error');
                }
            },
            error: function (xhr) {
                $btn.prop('disabled', false);
                var msg = 'Error saving';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                showToast('error', msg);
            }
        });
    });

    // Delete
    $(document).on('click', '.delete-sec', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        Swal.fire({
            title: 'Delete section?',
            text: '"' + name + '" section ta muchhe jabe. Daily Report er purano entry kono khoti hobe na.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: SECTION_URLS.delete.replace(':id', id),
                    type: 'GET',
                    success: function (res) {
                        if (res.success) {
                            // instant remove, reload nei
                            var $tr = $('#sectionBody tr[data-id="' + id + '"]');
                            $tr.css('transition', 'all .25s ease').css({ opacity: 0, transform: 'translateX(24px)' });
                            setTimeout(function () {
                                $tr.remove();
                                if ($('#sectionBody tr:not(.sec-empty)').length === 0) {
                                    $('#sectionBody').html('<tr class="sec-empty"><td colspan="4" class="text-center text-muted py-4">Kono section nei — "Add Section" theke Photocopy, Print, Stationary... add korun</td></tr>');
                                }
                                renumberSections();
                            }, 250);
                            showToast('success', res.success);
                        } else {
                            showToast('error', res.error || 'Error');
                        }
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection
