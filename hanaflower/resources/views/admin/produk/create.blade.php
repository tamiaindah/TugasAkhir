@extends('layouts.app', ['title' => 'Tambah Produk'])

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-shopping-bag"></i> TAMBAH PRODUK</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>GAMBAR</label>
                            <input type="file" name="foto" class="form-control @error('image') is-invalid @enderror">
                            @error('foto')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NAMA PRODUK</label>
                                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama Produk"
                                        class="form-control @error('nama') is-invalid @enderror">

                                    @error('nama')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>WARNA PRODUK</label>
                                    <input type="text" name="warna" value="{{ old('warna') }}" placeholder="Masukkan Warna Produk"
                                        class="form-control @error('warna') is-invalid @enderror">

                                    @error('warna')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>KATEGORI</label>
                                    <select name="kategori_id" class="form-control">
                                        <option value="">-- PILIH KATEGORI --</option>
                                        @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>

                                    @error('kategori_id')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>BERAT (gram)</label>
                                    <input type="number" name="berat" class="form-control @error('berat') is-invalid @enderror"
                                        value="{{ old('berat') }}" placeholder="Berat Produk (gram)">

                                    @error('berat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>DESKRIPSI</label>
                            <textarea class="form-control content @error('konten') is-invalid @enderror" name="konten" rows="6"
                                placeholder="Deskripsi Produk">{{ old('konten') }}</textarea>

                            @error('konten')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>HARGA</label>
                                    <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                                        value="{{ old('harga') }}" placeholder="Harga Produk">

                                    @error('harga')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>DISKON (%)</label>
                                    <input type="number" name="diskon" class="form-control @error('diskon') is-invalid @enderror"
                                        value="{{ old('diskon') }}" placeholder="Diskon Produk (%)">

                                    @error('diskon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            SIMPAN</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    var editor_config = {
        selector: "textarea.konten",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
    };

    tinymce.init(editor_config);
</script>
@endsection