<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form method="post" action="/ajax/game/load">
                <div class="form-group">
                    <label for="loadFileGame">Выберите файл</label>
                    <input type="file" class="form-control-file" id="loadFileGame" name="file">
                </div>
                <button type="submit" class="btn btn-success">Загрузить</button>
            </form>
        </div>
    </div>
</div>

<script>
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        // var file_data = $('#loadFileGame').prop('files')[0];
        // console.log(file_data);
        loadGame();
    });

    function loadGame()
    {
        var file_data = $('#loadFileGame').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file_path', file_data);
        $.ajax({
            url: form.action,
            type: 'post',
            contentType: false,
            processData: false,
            dataType: 'json',
            data: form_data,
            success: function (data) {
                console.log(data);
            }
        });
    }
</script>
