<form id="commentaryForm" class="shadow rounded bg-body-tertiary p-4 pt-2">
    <div class="d-flex justify-content-center">
        <img class="img-fluid" src="/assets/image/logo.webp" alt="CECyTE Logo" style="max-width: 200px;">
    </div>

    <div>
        <label for="commentary" class="form-label">Comentarios</label>
        <textarea rows="7" class="form-control" placeholder="Deja tu comentario aqui" id="commentary" name="commentary" maxlength="4096" required autofocus></textarea>
    </div>

    <input class="btn btn-primary mt-4 w-100 p-3" type="submit" value="Enviar comentario">

    <div id="alert" class="alert mt-3 d-none" role="alert"></div>
</form>

<script src="/assets/lib/jquery.min.js"></script>
<script>
    $(() => {
        const commentaryForm = $("#commentaryForm");

        commentaryForm.submit((event) => {
            event.preventDefault();

            const button = $("#commentaryForm input[type=\"submit\"");
            const alert = $("#commentaryForm .alert");

            button.addClass("disabled");
            button.attr("value", "Enviando...");

            $.post({
                    url: "/api/commentary.php",
                    data: commentaryForm.serialize()
                })
                .done(() => {
                    alert.removeClass("alert-danger");
                    alert.removeClass("alert-success");

                    commentaryForm.trigger("reset");
                    alert.removeClass("d-none");
                    alert.addClass("alert-success");
                    alert.text("Gracias por tus comentarios.");
                })
                .catch((res) => {
                    const data = JSON.parse(res.responseText);

                    alert.removeClass("alert-danger");
                    alert.removeClass("alert-success");

                    alert.removeClass("d-none");
                    alert.addClass("alert-danger");
                    alert.text("Ocurrio un error al enviar el comentario: " + data.error);
                })
                .always(() => {
                    button.removeClass("disabled");
                    button.attr("value", "Enviar comentario");

                    location.hash = "";
                    location.hash = "#alert";

                    setTimeout(() => {
                        alert.addClass("d-none");
                        alert.removeClass("alert-danger");
                        alert.removeClass("alert-success");
                    }, 3 * 1000);
                });
        });
    });
</script>