document.addEventListener("DOMContentLoaded", function () {
  function limpiarLineaInicial(bloque) {
    if (!bloque || !bloque.firstChild) return;

    for (let i = 0; i < 2; i++) {
      if (
        bloque.firstChild &&
        bloque.firstChild.nodeName === "P" &&
        bloque.firstChild.textContent.trim() === ""
      ) {
        bloque.removeChild(bloque.firstChild);
      } else if (bloque.firstChild && bloque.firstChild.nodeName === "BR") {
        bloque.removeChild(bloque.firstChild);
      } else {
        break;
      }
    }
  }

  const contenido = document.querySelector(".js-columnas-dinamicas");
  if (!contenido) {
    console.log("No se encontró el elemento .js-columnas-dinamicas");
    return;
  }

  function procesarNodo(nodo) {
    if (nodo.nodeType === Node.TEXT_NODE) {
      const texto = nodo.textContent.trim();
      return texto !== "" ? texto : "";
    } else if (nodo.nodeName === "BR") {
      return "<br>";
    } else if (nodo.nodeName === "P") {
      const contenidoP = Array.from(nodo.childNodes).map(procesarNodo).join("");
      return `<p>${contenidoP}</p>`;
    } else if (nodo.nodeType === Node.ELEMENT_NODE) {
      return Array.from(nodo.childNodes).map(procesarNodo).join("");
    }
    return "";
  }

  const textoCompleto = Array.from(contenido.childNodes)
    .map(procesarNodo)
    .join("")
    .replace(/style="[^"]*"/g, "")
    .replace(/class="[^"]*"/g, "")
    .trim();

  console.log("Texto completo procesado:", textoCompleto);

  const totalPalabras = textoCompleto
    .replace(/<[^>]*>/g, "")
    .replace(/[.,!?]/g, " ")
    .split(/\s+/)
    .filter((palabra) => palabra !== "").length;

  console.log("Total de palabras:", totalPalabras);

  if (totalPalabras <= 200) {
    const imagenDestacada = document.querySelector(".imagen-destacada img");
    const entradaContenido = document.querySelector(".entrada-contenido");
    if (imagenDestacada) {
      imagenDestacada.style.maxWidth = "90%";
      entradaContenido.style.maxWidth = "80%";
    }
    contenido.innerHTML = textoCompleto;
    return;
  }

  const oraciones = textoCompleto.split(/(?<=[.!?—:;])/);
  contenido.innerHTML = "";

  let bloqueActual = document.createElement("div");
  bloqueActual.classList.add("bloque-uno");

  let contadorBloques = 0;
  let filaColumnas = null;
  let contadorPalabras = 0;

  oraciones.forEach((oracion) => {
    const palabrasEnOracion = oracion
      .split(/\s+/)
      .filter((palabra) => palabra !== "").length;

    if (contadorPalabras + palabrasEnOracion > 80) {
      if (contadorBloques === 0) {
        const bloqueImagen = document.createElement("div");
        bloqueImagen.classList.add("img-bloque");
        const imagenDestacada = document.querySelector(".imagen-destacada");
        if (imagenDestacada) {
          bloqueImagen.appendChild(imagenDestacada);
        }
        bloqueImagen.appendChild(bloqueActual);
        contenido.appendChild(bloqueImagen);
      } else {
        if (!filaColumnas || filaColumnas.childElementCount === 2) {
          filaColumnas = document.createElement("div");
          filaColumnas.classList.add("fila-columnas");
          contenido.appendChild(filaColumnas);
        }

        if (filaColumnas && bloqueActual.innerHTML.trim() !== "") {
          bloqueActual.classList.add("columna");
          limpiarLineaInicial(bloqueActual);
          filaColumnas.appendChild(bloqueActual);
        }
      }

      bloqueActual = document.createElement("div");
      bloqueActual.classList.add("bloque-texto");
      contadorPalabras = 0;
      contadorBloques++;
    }

    bloqueActual.innerHTML += oracion;
    contadorPalabras += palabrasEnOracion;
  });

  if (bloqueActual.innerHTML.trim() !== "") {
    if (!filaColumnas || filaColumnas.childElementCount === 2) {
      filaColumnas = document.createElement("div");
      filaColumnas.classList.add("fila-columnas");
      contenido.appendChild(filaColumnas);
    }
    bloqueActual.classList.add("columna");
    limpiarLineaInicial(bloqueActual);
    filaColumnas.appendChild(bloqueActual);
  }

  const filas = document.querySelectorAll(".fila-columnas, .img-bloque");
  filas.forEach((fila, indice) => {
    const separador = document.createElement("div");
    separador.classList.add("separador");
    separador.innerHTML = `<img src="${contenido.dataset.template}/assets/images/separador.svg" alt="Separador">`;
    fila.after(separador);
  });

  console.log("Finalizado el procesamiento de bloques.");
});
