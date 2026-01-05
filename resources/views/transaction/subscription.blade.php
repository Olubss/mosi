@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Transaction List'))

@section('header-title')
    <h3 class="title">{{ __('Subscription Wise Transactions') }}</h3>
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
                            {{ __('Transaction') }}
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
                            <div class="d-flex flex-wrap gap-3 justify-content-end mb-4 align-items-center">

                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('transaction.subscriptions') }}" method="GET" class="w-100">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded ps-4"
                                                placeholder="🔍 Search ..." name="transaction_search"
                                                value="{{ request('transaction_search') }}">
                                            <button class="btn btn-primary rounded ms-2 shadow-sm" type="submit"
                                                style="width: 50px; height: 50px">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle modern-table">
                                    <thead>
                                        <tr>
                                            <th><strong>#</strong></th>
                                            <th><strong>{{ __('Enrollment ID') }}</strong></th>
                                            <th><strong>{{ __('Course') }}</strong></th>
                                            <th><strong>{{ __('Plan') }}</strong></th>
                                            <th><strong>{{ __('Subscription Expiry') }}</strong></th>
                                            <th><strong>{{ __('Payment Amount') }}</strong></th>
                                            <th><strong>{{ __('Payment Method') }}</strong></th>
                                            <th><strong>{{ __('Payment Status') }}</strong></th>
                                            <th><strong>{{ __('Paid At') }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($transactions as $transaction)
                                            <tr class="fade-in-row">
                                                <td class="tableId py-3">
                                                    {{ $transactions->firstItem() + $loop->index }}
                                                </td>
                                                <td class="tableId py-3">
                                                    {{ $transaction->enrollment_id ? '#' . $transaction->enrollment_id : 'N/A' }}
                                                </td>
                                                <td class="tableId py-3">{{ $transaction->course_title ?? 'N/A' }}</td>
                                                <td class="tableId py-3">{{ $transaction->plan?->title ?? 'N/A' }}</td>
                                                <td class="tableId py-3">
                                                    {{ \Carbon\Carbon::parse($transaction->subscriber?->ends_at)->format('d M, Y h:i A') }}
                                                </td>
                                                <td class="tableId py-3">
                                                    @if ($transaction->payment_amount != null || $transaction->payable_amount != null)
                                                        @if ($app_setting['currency_position'] == 'Left')
                                                            {{ $app_setting['currency_symbol'] }}{{ $transaction->payment_amount ? $transaction->payment_amount : $transaction->payable_amount }}
                                                        @else
                                                            {{ $transaction->payment_amount ? $transaction->payment_amount : $transaction->payable_amount }}{{ $app_setting['currency_symbol'] }}
                                                        @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="tableId py-3">{{ $transaction->payment_method }}</td>
                                                <td class="tableStatus">
                                                    @if ($transaction->is_paid == false)
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedPending"></div>
                                                            <div class="statusText">
                                                                <span class="stutsPanding">{{ __('Unpaid') }}</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedCompleted"></div>
                                                            <div class="statusText">
                                                                <span class="stutsCompleted">{{ __('Paid') }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="tableId py-3">
                                                    {{ \Carbon\Carbon::parse($transaction->paid_at)->format('d M, Y h:i A') ?? '-' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-danger">
                                                    {{ __('No data found') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection

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
    </script>
@endpush
