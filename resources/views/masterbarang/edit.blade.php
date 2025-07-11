@extends('layout.admin')

@section('content')


<!-- Required meta tags -->
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

<title>Master Data Barang</title>


<body>
    <div class="container-fluid">
        <div class="card" style="border-radius: 15px;">
          <div class="card-body">
              <h1 class="text-center mb-4">Edit Data Barang</h1>
              <div class="container">
                  <div class="row justify-content-center">
                      <div class="col-8">
                          <div class="card" style="border-radius: 10px;">
                              <div class="card-body">
                                  <form method="POST" action="{{ route('masterbarang.update', $item->id) }}" enctype="multipart/form-data">
                                      @csrf
                                      @method('PUT')
                                      <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input value="{{ $item->nama }}" type="text" name="nama" class="form-control"
                                            id="exampleInputPassword1" placeholder="Masukan Nama barang" required>
                                     </div>
                                      <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input value="{{ $item->harga }}" type="number" name="harga" class="form-control"
                                            id="exampleInputPassword1" placeholder="Masukan Harga" required>
                                     </div>
                                      <div class="form-group">
                                        <label for="qty">Qty</label>
                                        <input value="{{ $item->qty }}" type="number" name="qty" class="form-control"
                                            id="exampleInputPassword1" placeholder="Masukan Qty" required>
                                     </div>
                                      <div class="form-group">
                                        <label for="kategori">Kategori</label>
                                        <input value="{{ $item->kategori }}" type="text" name="kategori" class="form-control"
                                            id="exampleInputPassword1" placeholder="Masukan Kategori" required>
                                     </div>
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
</body>

























<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
@endsection
