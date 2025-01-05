/* INICIO - MENÚ TOGGLE */
function toggleMenu() {
  const menuNav = document.querySelector(".menu-nav");
  if (menuNav) {
    menuNav.classList.toggle("activo");
  } else {
    console.error("No se encontró el elemento .menu-nav");
  }
}

/* COPIAR TEXTO - MENÚ COMPARTIR */
function copiarEnlace(elemento) {
  const enlace = elemento.getAttribute("data-permalink");

  navigator.clipboard
    .writeText(enlace)
    .then(() => {
      alert("¡Enlace copiado al portapapeles!");
    })
    .catch((error) => {
      console.error("Error al copiar el enlace: ", error);
      alert("Hubo un error al copiar el enlace. Inténtalo de nuevo.");
    });
}

/* CARGAR MÁS ENTRADAS */
function cargarMasEntradas() {
  const boton = document.querySelector(".boton-cargar");
  const contenedor = document.querySelector(".ultimas-entradas");

  if (!contenedor) {
    console.error("No se encontró el contenedor '.ultimas-entradas'.");
    return;
  }

  if (!boton) {
    console.error("No se encontró el botón '.boton-cargar'.");
    return;
  }

  const paginaActual = parseInt(boton.getAttribute("data-page"));
  const maxPaginas = parseInt(boton.getAttribute("data-max-pages"));

  if (paginaActual >= maxPaginas) {
    alert("No se han encontrado más posts.");
    boton.style.display = "none";
    return;
  }

  const data = new FormData();
  data.append("action", "cargar_mas_entradas");
  data.append("page", paginaActual + 1);

  console.log("Datos enviados al servidor:", {
    action: "cargar_mas_entradas",
    page: paginaActual + 1,
  });

  fetch(ajax_object.ajax_url, {
    method: "POST",
    body: data,
  })
    .then((respuesta) => {
      if (!respuesta.ok) {
        throw new Error("Error en la respuesta del servidor");
      }
      return respuesta.text();
    })
    .then((html) => {
      if (html.trim()) {
        contenedor.insertAdjacentHTML("beforeend", html);
        boton.setAttribute("data-page", paginaActual + 1);
      } else {
        alert("No se han encontrado nuevos posts.");
        boton.style.display = "none";
      }
    })
    .catch((error) => console.error("Error cargando entradas:", error));
}

// ENLAZAR EVENTO AL BOTÓN "CARGAR MÁS ENTRADAS"
function enlazarEventoBotonCargar() {
  const boton = document.querySelector(".boton-cargar");
  if (boton) {
    boton.removeEventListener("click", cargarMasEntradas);
    boton.addEventListener("click", cargarMasEntradas);
  }
}

// RESTAURAR O BORRAR ESTADO AL CARGAR LA PÁGINA
if ("scrollRestoration" in history) {
  history.scrollRestoration = "manual";
}

window.addEventListener("pageshow", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const tieneFiltros = urlParams.has("letra") || urlParams.has("categoria");

  if (!tieneFiltros) {
    const scrollPosition = sessionStorage.getItem("scrollPosition");
    const entradasHTML = sessionStorage.getItem("entradasHTML");
    const paginaActual = sessionStorage.getItem("paginaActual");
    const contenedor = document.querySelector(".ultimas-entradas");

    if (contenedor && entradasHTML) {
      contenedor.innerHTML = entradasHTML;

      const boton = document.querySelector(".boton-cargar");
      if (boton && paginaActual) {
        boton.setAttribute("data-page", paginaActual);
      }

      if (scrollPosition) {
        requestAnimationFrame(() => {
          window.scrollTo(0, parseInt(scrollPosition));
        });
      }
    }
  }

  enlazarEventoBotonCargar();
});

// CARGA INICIAL
window.addEventListener("DOMContentLoaded", function () {
  const tipoNavegacion =
    performance.getEntriesByType("navigation")[0]?.type || "navigate";

  if (tipoNavegacion === "reload") {
    sessionStorage.clear();
    window.scrollTo(0, 0);
  }

  enlazarEventoBotonCargar();
});

// GUARDAR ESTADO ANTES DE SALIR
window.addEventListener("beforeunload", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const tieneFiltros = urlParams.has("letra") || urlParams.has("categoria");

  if (!tieneFiltros) {
    const contenedor = document.querySelector(".ultimas-entradas");
    if (contenedor) {
      const scrollY = window.scrollY;
      const entradasHTML = contenedor.innerHTML;
      const paginaActual = document
        .querySelector(".boton-cargar")
        ?.getAttribute("data-page");

      sessionStorage.setItem("scrollPosition", scrollY);
      sessionStorage.setItem("entradasHTML", entradasHTML);

      if (paginaActual) {
        sessionStorage.setItem("paginaActual", paginaActual);
      }
    }
  }
});

// FOOTER - COPIAR CORREO
function copiarCorreo() {
  const correo = "roxane.bravo.riv@gmail.com";
  navigator.clipboard
    .writeText(correo)
    .then(() => {
      alert("¡Correo electrónico copiado!");
    })
    .catch((error) => {
      console.error("Error al copiar el correo:", error);
      alert("Hubo un problema al copiar el correo.");
    });
}
