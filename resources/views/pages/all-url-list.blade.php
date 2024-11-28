@extends('layouts.master')

@section('title', 'All Short URL List')

@section('content')
    <div class="container">
        <h2 class="text-center">All Short URL List</h2>

        <div class="mt-5 row">
            <div class="col-12">
                <table id="dataTable" class="table">
                    <thead>
                        <tr>
                            <th>Short Links</th>
                            <th class="text-center">Total Clicks</th>
                            <th class="text-center">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($urlData as $item)
                            <tr>
                                <td><a href="{{ $item->short_url }}" target="__blank">{{ $item->short_url }}</a></td>
                                <td class="text-center">{{ $item->click_count }}</td>
                                <td class="text-center">{{ $item->created }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td></td>
                                <td class="text-danger">No Data Found</td>
                                <td></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [
                    [2, "asc"]
                ],
                "columnDefs": [{
                    "targets": [2],
                    "orderable": true
                }]
            });
        });
    </script>
@endpush
