@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Transaction List'))

@section('content')
    <!-- ****Body-Section***** -->
    <div class="app-main-outer">
        <div class="app-main-inner">
            <div class="page-title-actions px-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
                <nav aria-label="breadcrumb" class="modern-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-solid fa-house"></i>
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fas fa-solid fa-layer-group"></i>
                            {{ __('Transaction') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fas fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>

            <div class="row" id="deleteTableItem">
                <div class="col-md-12 my-3">
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 justify-content-between mb-3 align-items-center">
                                <div class="d-flex justify-content-start">
                                    <button class="btn btn-outline-primary btn-sm px-4 py-2" type="submit"
                                        onclick="printTable()"><i class="bi bi-printer-fill"></i>
                                        {{ __('Print') }}</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle modern-table">
                                    <thead>
                                        <tr>
                                            <th><strong>#</strong></th>
                                            <th><strong>{{ __('Organization') }}</strong></th>
                                            <th><strong>{{ __('Subscribed Plan Name') }}</strong></th>
                                            <th><strong>{{ __('Subscribed Plan Type') }}</strong></th>
                                            <th><strong>{{ __('Subscribed Plan Duration') }}</strong></th>
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
                                                    {{ generateID($loop->iteration) }}
                                                </td>
                                                <td class="tableId py-3">
                                                    {{ $transaction->organization ? $transaction->organization->name : 'N/A' }}
                                                </td>
                                                <td class="tableId py-3">
                                                    {{ $transaction->organizationPlan->title }}
                                                </td>
                                                <td class="tableId py-3">
                                                    <span class="badge bg-success">
                                                        {{ $transaction->organizationPlan->plan_type }}
                                                    </span>
                                                </td>
                                                <td class="tableId py-3">
                                                    {{ $transaction->organizationPlan->plan_type == 'yearly' ? $transaction->organizationPlan->duration . ' ' . 'Yearly' : $transaction->organizationPlan->duration . ' ' . 'Days' }}
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
                                                    @if (!$transaction->is_paid)
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
                                                </td>
                                                <td class="tableId py-3">
                                                    {{ \Carbon\Carbon::parse($transaction->paid_at)->format('d m, Y h:i A') ?? '-' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">{{ __('No data found') }}</td>
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
