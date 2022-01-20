@extends('layouts.app', ['title' => 'Detail Order'])

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid mb-5">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fashopping-cart"></i> DETAIL ORDER</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td style="width: 25%">
                                NO. INVOICE
                            </td>
                            <td style="width: 1%">:</td>
                            <td>
                                {{ $invoice->invoice }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                NAMA LENGKAP
                            </td>
                            <td>:</td>
                            <td>
                                {{ $invoice->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                No. Handphone
                            </td>
                            <td>:</td>
                            <td>
                                {{ $invoice->no_h[] }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                KURIR / SERVICE / COST
                            </td>
                            <td>:</td>
                            <td>
                                {{ $invoice->kurir }} / {{ $invoice->service }} / {{ moneyFormat($invoice->ongkir) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ALAMAT LENGKAP
                            </td>
                            <td>:</td>
                            <td>
                                {{ $invoice->alamat }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                TOTAL PEMBELIAN
                            </td>
                            <td>:</td>
                            <td>
                                {{ moneyFormat($invoice->total) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                STATUS
                            </td>
                            <td>:</td>
                            <td>
                                {{ $invoice->status }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card border-0 rounded shadow mt-4">
                <div class="card-body">
                    <h5><i class="fa fa-shopping-cart"></i> DETAIL
                        ORDER</h5>
                    <hr>
                    <table class="table"
                        style="border-style: solid !important;bordercolor: rgb(198, 206, 214) !important;">
                        <tbody>
                            @foreach ($invoice->orders()->get() as $produks)
                            <tr style="background: #edf2f7;">
                                <td class="b-none" width="25%">
                                    <div class="wrapper-image-cart">
                                        <img src="{{ $produks->foto }}" style="width: 100%;border-radius: .5rem">
                                    </div>
                                </td>
                                <td class="b-none" width="50%">
                                    <h5><b>{{ $produks->nama }}</b></h5>
                                    <table class="table-borderless" style="font-size: 14px">
                                        <tr>
                                            <td style="padding: .20rem">QTY</td>
                                            <td style="padding: .20rem">:</td>
                                            <td style="padding: .20rem"><b>{{ $product->qty }}</b></td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="b-none text-right">
                                    <p class="m-0 font-weightbold">{{ moneyFormat($produks->harga) }}</p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
