<form action="{{ route('importOtherCategories') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="excel">
    <button type="submit">send</button>
</form>
