@extends('layouts.reports')

@section('subtitle', __('report.monthly', ['year_month' => $currentMonthEndDate->isoFormat('MMMM Y')]))

@section('content-report')

<div class="page-header mt-0">
    <h1 class="page-title">{{ __('report.monthly', ['year_month' => $currentMonthEndDate->isoFormat('MMMM Y')]) }}</h1>
    <div class="page-options d-flex">
        {{ Form::open(['method' => 'get', 'class' => 'form-inline']) }}
        {{ Form::label('month', __('report.view_monthly_label'), ['class' => 'control-label mr-1']) }}
        {{ Form::select('month', get_months(), $month, ['class' => 'form-control mr-1']) }}
        {{ Form::select('year', get_years(), $year, ['class' => 'form-control mr-1']) }}
        <div class="form-group mt-4 mt-sm-0">
            {{ Form::submit(__('report.view_report'), ['class' => 'btn btn-info mr-1']) }}
            {{ link_to_route('reports.in_weeks', __('report.this_month'), [], ['class' => 'btn btn-secondary mr-1']) }}
        </div>
        <div class="form-group">
            {{ link_to_route('reports.in_weeks', __('report.prev_month'), ['month' => $prevMonthDate->format('m'), 'year' => $prevMonthDate->format('Y')], ['class' => 'btn btn-secondary mr-1']) }}
            {{ link_to_route('reports.in_weeks', __('report.next_month'), ['month' => $nextMonthDate->format('m'), 'year' => $nextMonthDate->format('Y')], ['class' => 'btn btn-secondary']) }}
        </div>
        {{ Form::close() }}
    </div>
</div>

@foreach($groupedTransactions as $weekNumber => $weekTransactions)
<div class="card table-responsive">
    <table class="table table-sm card-table table-hover table-bordered">
        <thead>
            <th class="text-center">{{ __('app.date') }}</th>
            <th>{{ __('transaction.transaction') }}</th>
            <th class="text-right">{{ __('transaction.income') }}</th>
            <th class="text-right">{{ __('transaction.spending') }}</th>
            <th class="text-right">{{ __('transaction.balance') }}</th>
        </thead>
        <tbody>
            @foreach ($weekTransactions as $dayName => $daysTransactions)
                @if ($dayName)
                    <tr><th class="text-center">{{ $dayName }}</th><th colspan="4">&nbsp;</th></tr>
                @endif
                @foreach ($daysTransactions as $transaction)
                <tr>
                    <td class="text-center">{{ $transaction->date }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td class="text-right text-nowrap">{{ $transaction->in_out ? number_format($transaction->amount) : '' }}</td>
                    <td class="text-right text-nowrap">{{ !$transaction->in_out ? number_format($transaction->amount) : '' }}</td>
                    <td class="text-center text-nowrap">&nbsp;</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endforeach
@endsection
