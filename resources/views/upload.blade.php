<h1>Upload File</h1>
<form action="http://localhost:8000/api/class/1/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file"> <br> <br>
    <button type="submit">Upload File</button>

</form>