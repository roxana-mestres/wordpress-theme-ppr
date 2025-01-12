document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.getElementById('formulario-contacto');

    if (formulario) {
        formulario.addEventListener('submit', function (evento) {
            evento.preventDefault();

            const datos = new FormData(formulario);

            datos.append('action', 'procesar_formulario_contacto');

            fetch(ajaxurl, {
                method: 'POST',
                body: datos
            })
            .then(respuesta => {
                return respuesta.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Gracias por tu mensaje. Me pondré en contacto contigo a la brevedad.');
                    formulario.reset();
                } else {
                    alert('Hubo un error al enviar tu mensaje. Inténtalo nuevamente más tarde.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error inesperado. Por favor, inténtalo más tarde.');
            });
        });
    }
});
