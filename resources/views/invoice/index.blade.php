@extends($layout_path)

@section('title', $app_setting['name'] . ' | Invoices List')

@section('header-title')
    <h3 class="title">{{ __('Invoice Management') }}</h3>
@endsection

@section('content')
    <!-- ****Body-Section***** -->
    <div class="app-main-outer">
        <div class="app-main-inner">
            <div class="page-title-actions px-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
                <nav aria-label="breadcrumb" class="modern-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-house"></i>
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fa-solid fa-layer-group"></i>
                            {{ __('Invoice Management') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>

            <div class="row" id="deleteTableItem">
                <div class="col-md-12 my-3">
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">

                                <!-- Left Buttons -->
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('invoice.create') }}"
                                        class="btn btn-primary btn-sm px-4 py-2 shadow-sm rounded-pill">
                                        <i class="fa-solid fa-plus me-1"></i> {{ __('New Invoice') }}
                                    </a>
                                    <a href="{{ route('invoice.trash') }}"
                                        class="btn btn-outline-warning btn-sm px-4 py-2 shadow-sm rounded-pill">
                                        <i class="bi bi-arrow-clockwise me-1"></i> {{ __('Restore Invoice') }}
                                    </a>
                                </div>

                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('invoice.index') }}" method="GET" class="w-100">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded ps-4"
                                                placeholder="🔍 Search course..." name="cat_search"
                                                value="{{ request('cat_search') }}">
                                            <button class="btn btn-primary rounded ms-2 shadow-sm" type="submit"
                                                style="width: 50px; height: 50px">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="break"></div>

                            <form class="p-2 rounded-4 shadow-sm bg-white border border-light mb-3">
                                <div class="row g-2 align-items-center">
                                    <!-- Payment Date From -->
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm rounded-3">
                                            <div class="card-body">
                                                <label for="startDate" class="form-label fw-bold text-muted small mb-2">
                                                    <i class="bi bi-calendar-event me-1"></i> From Date
                                                </label>
                                                <input type="date" id="startDate" name="start_date"
                                                    class="form-control border-0 shadow-sm bg-light-subtle"
                                                    value="{{ request('start_date') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Date To -->
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm rounded-3">
                                            <div class="card-body">
                                                <label for="endDate" class="form-label fw-bold text-muted small mb-2">
                                                    <i class="bi bi-calendar-check me-1"></i> To Date
                                                </label>
                                                <input type="date" id="endDate" name="end_date"
                                                    class="form-control border-0 shadow-sm bg-light-subtle"
                                                    value="{{ request('end_date') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Status -->
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm rounded-3 h-100">
                                            <div class="card-body">
                                                <label class="form-label fw-bold text-muted small mb-2 d-block">
                                                    <i class="bi bi-cash-coin me-1"></i> Payment Status
                                                </label>
                                                <div class="btn-group w-100" role="group">
                                                    <input type="radio" class="btn-check" name="status" id="statusPaid"
                                                        value="1" autocomplete="off"
                                                        {{ request('status') === '1' ? 'checked' : '' }}>
                                                    <label class="btn btn-outline-success" for="statusPaid">Paid</label>

                                                    <input type="radio" class="btn-check" name="status" id="statusUnpaid"
                                                        value="0" autocomplete="off"
                                                        {{ request('status') === '0' ? 'checked' : '' }}>
                                                    <label class="btn btn-outline-danger" for="statusUnpaid">Unpaid</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Filter Button -->
                                <div class="d-flex justify-content-end mt-4 mb-2">
                                    <button type="submit" class="btn btn-dark px-5 py-2 rounded-pill">
                                        <i class="bi bi-funnel-fill me-2"></i> Filter Results
                                    </button>
                                </div>
                            </form>


                            <div class="table" id="tableContainer">
                                <table class="table table-striped align-middle modern-table">
                                    <thead>
                                        <tr>
                                            <th><strong>{{ __('Invoice') }}</strong></th>
                                            <th><strong>{{ __('Create Date') }}</strong></th>
                                            <th><strong>{{ __('Payment Date') }}</strong></th>
                                            <th><strong>{{ __('Course Title') }}</strong></th>
                                            <th><strong>{{ __('Student Name') }}</strong></th>
                                            <th><strong>{{ __('Status') }}</strong></th>
                                            <th><strong>{{ __('Total') }}</strong></th>
                                            <th><strong>{{ __('Action') }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoices as $invoice)
                                            <tr class="fade-in-row">
                                                <td class="tableId py-3" style="width: 10%;">
                                                    {{ $invoice->invoice_token }}
                                                </td>
                                                <td class="tableId py-3" style="width: 10%;">
                                                    {{ $invoice?->created_at ? \Carbon\Carbon::parse($invoice->created_at)->format('d M,Y') : 'N/A' }}
                                                </td>
                                                <td class="tableId py-3" style="width: 10%;">
                                                    {{ $invoice?->payment_at ? \Carbon\Carbon::parse($invoice->payment_at)->format('d M,Y') : 'N/A' }}
                                                </td>
                                                <td class="tableId py-3" style="width: 30%;">
                                                    {{ $invoice->courses->pluck('title')->map(fn($title) => Str::limit($title, 30))->implode(' && ') }}
                                                </td>
                                                <td class="tableId py-3">
                                                    {{ $invoice->user->name }}
                                                </td>
                                                <td>
                                                    @if ($invoice->payment_status == 0)
                                                        <div
                                                            class="statusItem d-flex justify-content-start align-items-center">
                                                            <div class="circleDot animatedPending"></div>
                                                            <div class="statusText">
                                                                <span class="stutsPanding">{{ __('unpaid') }}</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div
                                                            class="statusItem d-flex justify-content-start align-items-center">
                                                            <div class="circleDot animatedCompleted"></div>
                                                            <div class="statusText">
                                                                <span class="stutsCompleted">{{ __('paid') }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="tableId py-3">
                                                    @if ($invoice->total_price)
                                                        @if ($app_setting['currency_position'] == 'Left')
                                                            {{ $app_setting['currency_symbol'] }}{{ $invoice->total_price }}
                                                        @else
                                                            {{ $invoice->total_price }}{{ $app_setting['currency_symbol'] }}
                                                        @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($invoice->trashed())
                                                        <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                            onclick="restoreAction('{{ route('invoice.restore', $invoice->id) }}')">
                                                            <i class="fa-solid fa-rotate me-1 text-danger"></i>
                                                            <span class="tooltip-text">{{ __('Restore Invoice') }}</span>
                                                        </a>
                                                    @else
                                                        <a class="drop-item tooltip-custom"
                                                            href="{{ route('invoice.verify', $invoice->invoice_token) }}">
                                                            <i class="fa-regular fa-eye me-1 text-primary"></i>
                                                            <span class="tooltip-text">{{ __('View Invoice') }}</span>
                                                        </a>

                                                        <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                            onclick="copyToClipboard('{{ route('invoice.verify', $invoice->invoice_token) }}', this)">
                                                            <i class="fa-solid fa-copy me-1 text-info"></i>
                                                            <span class="tooltip-text">{{ __('Copy Invoice') }}</span>
                                                        </a>
                                                        <a class="drop-item tooltip-custom"
                                                            href="{{ route('invoice.download', $invoice->invoice_token) }}">
                                                            <i class="fa-solid fa-download me-1 text-primary"></i>
                                                            <span class="tooltip-text">{{ __('Download Invoice') }}</span>
                                                        </a>
                                                        <a class="drop-item tooltip-custom"
                                                            href="{{ route('invoice.edit', $invoice->id) }}"
                                                            target="_blank">
                                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i>
                                                            <span class="tooltip-text">{{ __('Edit Invoice') }}</span>
                                                        </a>
                                                        <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                            onclick="deleteAction('{{ route('invoice.delete', $invoice->id) }}')">
                                                            <i class="fa-solid fa-trash-can me-1 text-danger"></i>
                                                            <span class="tooltip-text">{{ __('Delete Invoice') }}</span>
                                                        </a>
                                                    @endif
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No data found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection

@push('styles')
    <style>
        .copyUrl {
            background-color: #213448;
            color: #ffffff;
        }

        .input-group .custom-btnCopy {
            background-color: #213448;
            color: #ffffff;
            border: 1px solid #213448;
            font-size: 12px;
            border-radius: 8px !important;
            padding: 0.2rem 0.5rem;
            cursor: pointer;
        }

        .reLink {
            background-color: #213448;
            color: #ffffff;
            border: 1px solid #213448;
            font-size: 12px;
            border-radius: 8px !important;
            padding: 0.2rem 0.5rem;
            cursor: pointer;
        }

        .break {
            border-top: 1px solid #f1f1f1;
            margin: 20px 0;
            width: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function printTable() {
            const table = document.querySelector('#deleteTableItem .table-responsive');
            const printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write(`
        <html>
            <head>
                <title>Print Table</title>
                <style>
                    /* Custom styles for the printed table */
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    table, th, td {
                        border: 1px solid black;
                    }
                    th, td {
                        padding: 10px;
                        text-align: left;
                    }
                    th {
                        background-color: #f4f4f4;
                    }
                </style>
            </head>
            <body>
                ${table.outerHTML}
            </body>
        </html>
    `);
            printWindow.document.close();
            printWindow.print();
            printWindow.onafterprint = function() {
                printWindow.close();
            };
        }

        function copyToClipboard(elementId, button) {
            navigator.clipboard.writeText(elementId).then(() => {
                // Optional feedback
                button.innerText = "Copied!";
                setTimeout(() => {
                    button.innerHTML = `
                    <i class="fa-solid fa-copy me-1 text-info"></i>
                    <span class="tooltip-text">{{ __('Copy Invoice') }}</span>
                    `;
                }, 1500);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
@endpush
