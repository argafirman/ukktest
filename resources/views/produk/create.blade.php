<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="NamaProduk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="NamaProduk" name="NamaProduk" required>
                    </div>
                    <div class="mb-3">
                        <label for="Harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="Harga" name="Harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="Stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="Stok" name="Stok" required>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" id="img" name="img" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('createForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        fetch("{{ route('produk.store') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        }).then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload();
        }).catch(error => console.error(error));
    });
</script>
