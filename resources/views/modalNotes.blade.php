<main>
    <div class="container-fluid">
        <div class="form-floating">
            @if ($kriteria->notes == null)
                <form action="/save/notes/{{ $id }}" method="POST">
                    @csrf
                    <textarea name="notes" class="form-control border" style="height: 150px;" placeholder="Ketik Notes disini"
                        id="floatingTextarea"></textarea>
                    <button type="submit" class=" mt-2 btn btn-success"> Simpan</button>
                </form>
            @else
                <form action="/update/notes/{{ $id }}" method="POST">
                    @csrf
                    <textarea name="notes" class="form-control border" style="height: 150px;" placeholder="Ketik Notes disini"
                        id="floatingTextarea">{{ $kriteria->notes }}</textarea>
                    <button type="submit" class=" mt-2 btn btn-info"> Update</button>
                </form>
            @endif

        </div>
    </div>
</main>
